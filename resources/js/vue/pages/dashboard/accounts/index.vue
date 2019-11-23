<template>
	<div id="dashboard-accounts-page-component">
		<h5>User Management</h5>
		<hr>

		<div class="mb-3">
			<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#create-user-modal" v-on:click="resetNewUserForm()">
				Create New User
			</button>
		</div>

		<responsive-table 
			:tabledata="userList" 
			:columns="responsiveTableData.columns" 
			:listname="'user-management-list-table'"
		>	
		</responsive-table>


		<div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog" aria-labelledby="create-user-modal-label" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<form v-on:submit.prevent="handleSubmission()" class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="create-user-modal-label">Create New User Form</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="create-user-modal-closer">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<label><small>First Name</small></label>
						<input type="text" class="form-control form-control-sm" name="" autocomplete="disabled" placeholder="Enter First Name Here..." v-model="newUserForm.first_name">
						<p class="text-danger"><small>{{ apiValidators.first_name }}</small></p>

						<label><small>Last Name</small></label>
						<input type="text" class="form-control form-control-sm" name="" autocomplete="disabled" placeholder="Enter Last Name Here..." v-model="newUserForm.last_name">
						<p class="text-danger"><small>{{ apiValidators.last_name }}</small></p>

						<label><small>Email Address</small></label>
						<input type="email" class="form-control form-control-sm" name="" autocomplete="disabled" placeholder="Enter Email Address Here..." v-model="newUserForm.email">
						<p class="text-danger"><small>{{ apiValidators.email }}</small></p>

						<label><small>Role</small></label>
						<select class="form-control form-control-sm" v-model="newUserForm.role">
							<option value="">-- Select Role Here --</option>
							<option value="1">Administrator</option>
							<option value="2">Employee</option>
						</select>
						<p class="text-danger"><small>{{ apiValidators.role }}</small></p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-primary">Save User</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				newUserForm: {
					first_name: '',
					last_name: '',
					email: '',
					role: ''
				},
				apiValidators: {
					first_name: '',
					last_name: '',
					email: '',
					role: ''
				},

				responsiveTableData: {
					columns: [
						{
							class: 'col-10 col-lg-3 px-0 text-truncate',
							label: 'Full Name',
							name: 'fullname',
							filterable: true,
							searchable: true
						},
						{
							class: 'col-lg-3 px-0 d-none d-lg-block',
							label: 'Email Address',
							name: 'email',
							filterable: true,
							searchable: false
						},
						{
							class: 'col-lg-2 px-0 d-none d-lg-block',
							label: 'Role',
							name: 'role',
							filterable: true,
							searchable: false
						},
						{
							class: 'col-lg-2 px-0 d-none d-lg-block',
							label: 'Status',
							name: 'status',
							filterable: true,
							searchable: false
						},
					]
				},

				userList: []
			}
		},
		created(){
			this.$axios.get('/api/get-all-users', {}).then((response) => {
				for(let counter = 0; counter < response.data.users.length; counter++){
					let userInfo = this.setUserObject(response.data.users[counter]);
					this.userList.push(userInfo);
				}
				
				this.$store.dispatch('pageLoader', { display: false, message: '' });
			}).catch((errorResponse) => {
				this.$store.dispatch('pageLoader', { display: false, message: '' });
			});
		},

		methods: {
			setUserObject(userInfo){	
				let userObject = {};
				userObject['id'] = userInfo.id;
				userObject['fullname'] = userInfo.profile.first_name + ' ' + userInfo.profile.last_name;
				userObject['email'] = userInfo.email;
				userObject['role'] = userInfo.user_role.role.display_name;
				userObject['status'] = 'Enabled';
				userObject['props'] = userInfo;

				return userObject;
			},

			handleSubmission(){
				this.$store.dispatch('pageLoader', { display: true, message: 'Creating new user. Please wait...' });
				this.resetApiValidators();

				this.$axios.post('/api/create-new-user', this.newUserForm).then((response) => {
					let userInfo = this.setUserObject(response.data.userInfo);
					this.userList.push(userInfo);

					this.$store.dispatch('pageLoader', { display: false, message: '' });
					document.getElementById('create-user-modal-closer').click();
				}).catch((errorResponse) => {
					if(errorResponse.response){
						if(errorResponse.response.status == 422){
							for(let key in errorResponse.response.data.errors){
								this.apiValidators[key] = errorResponse.response.data.errors[key][0];
							}
						}
					}

					console.log("API VALIDATORS: ", this.apiValidators);
					this.$store.dispatch('pageLoader', { display: false, message: '' });
				});
			},


			resetNewUserForm(){
				for(let key in this.newUserForm){
					this.newUserForm[key] = '';
				}

				this.resetApiValidators();
			},

			resetApiValidators(){
				for(let key in this.apiValidators){
					this.apiValidators[key] = '';
				}
			}
		}
	}
</script>