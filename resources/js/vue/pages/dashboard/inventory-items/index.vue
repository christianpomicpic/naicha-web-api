<template>
	<div id="dashoard-inventory-page-component">
		<h5>Inventory Items Management</h5>
		<hr>

		<div class="mb-3">
			<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#create-item-modal" v-on:click="resetNewItemForm()">
				Create New Item
			</button>
		</div>

		<responsive-table 
			:tabledata="itemList" 
			:columns="responsiveTableData.columns" 
			:listname="'inventory-items-management-list-table'"
		>	
			<template slot="datapreview" slot-scope="props">
				<div class="text-right px-3 pt-3">
					<button class="btn btn-sm btn-primary" v-on:click="handleSelectDataToUpdate(props.record)"  data-toggle="modal" data-target="#update-item-modal">
						Update Item
					</button>
				</div>

				<div class="px-3">
					<hr>

					<small class="d-block font-weight-bold">{{ props.record.name }}</small>
					<small class="d-block text-secondary">ITEM NAME</small>

					<!-- {{ props.record.information }} -->
					<hr>
					<h6>Units Selected For This Item</h6>
					<ul>
						<li v-for="unit in props.record.information.units">
							<small>{{ unit }}</small>
						</li>
					</ul>
				</div>
			</template>
		</responsive-table>


		<!-- -------------------------------------------------------------------------------------------------- -->
		<!-- CREATE NEW ITEM MODAL -->
		<!-- -------------------------------------------------------------------------------------------------- -->
		<div class="modal fade" id="create-item-modal" tabindex="-1" role="dialog" aria-labelledby="create-item-modal-label" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<form v-on:submit.prevent="handleSubmission('/api/create-new-item', newItem)" class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="create-item-modal-label">Create New Item Form</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="create-item-modal-closer">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<label><small><strong>ITEM NAME</strong></small></label>
						<input type="text" class="form-control form-control-sm" name="" v-model="newItem.itemName">
						<p class="text-danger"><small>{{ apiValidators.itemName }}</small></p>

						<label><small><strong>ADD UNIT FOR THIS ITEM</strong></small></label>
						<select class="form-control form-control-sm" v-on:change="handleChangeUnit()" v-model="newItem.unitInput">
							<option value="">-- Select Unit Here --</option>
							<option value="Pack">Pack</option>
							<option value="Piece">Piece</option>
							<option value="Bag">Bag</option>
							<option value="Gram">Gram</option>
							<option value="Box">Box</option>
						</select>
						<p class="text-danger"><small></small></p>


						<div class="mt-4">
							<h6>Units Selected For This Item</h6>
							<p class="text-danger"><small>{{ apiValidators.units }}</small></p>
							<hr>
							<ul class="mb-0" style="list-style: none;">
								<li v-for="unit in newItem.units">
									<small>
										<a href="javascript:void(0)" class="text-danger" v-on:click="newItem.units.splice(newItem.units.indexOf(unit), 1);">
											<i class="fas fa-fw fa-times"></i>
										</a>
										{{ unit }}
									</small>
								</li>
							</ul>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-primary">Save Item</button>
					</div>
				</form>
			</div>
		</div>
		<!-- -------------------------------------------------------------------------------------------------- -->









		<!-- -------------------------------------------------------------------------------------------------- -->
		<!-- CREATE NEW ITEM MODAL -->
		<!-- -------------------------------------------------------------------------------------------------- -->
		<div class="modal fade" id="update-item-modal" tabindex="-1" role="dialog" aria-labelledby="update-item-modal-label" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<form v-on:submit.prevent="handleSubmission('/api/update-item', updateItem)" class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="update-item-modal-label">Update Item Form</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="update-item-modal-closer">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<label><small><strong>ITEM NAME</strong></small></label>
						<input type="text" class="form-control form-control-sm" name="" v-model="updateItem.itemName">
						<p class="text-danger"><small>{{ apiValidators.itemName }}</small></p>

						<label><small><strong>ADD UNIT FOR THIS ITEM</strong></small></label>
						<select class="form-control form-control-sm" v-on:change="handleChangeUnit(true)" v-model="updateItem.unitInput">
							<option value="">-- Select Unit Here --</option>
							<option value="Pack">Pack</option>
							<option value="Piece">Piece</option>
							<option value="Bag">Bag</option>
							<option value="Gram">Gram</option>
							<option value="Box">Box</option>
						</select>
						<p class="text-danger"><small></small></p>


						<div class="mt-4">
							<h6>Units Selected For This Item</h6>
							<p class="text-danger"><small>{{ apiValidators.units }}</small></p>
							<hr>
							<ul class="mb-0" style="list-style: none;">
								<li v-for="unit in updateItem.units">
									<small>
										<a href="javascript:void(0)" class="text-danger" v-on:click="updateItem.units.splice(updateItem.units.indexOf(unit), 1);">
											<i class="fas fa-fw fa-times"></i>
										</a>
										{{ unit }}
									</small>
								</li>
							</ul>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-primary">Save Item</button>
					</div>
				</form>
			</div>
		</div>
		<!-- -------------------------------------------------------------------------------------------------- -->
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				responsiveTableData: {
					columns: [
						{
							class: 'col-10 col-lg-5 px-0 text-truncate',
							label: 'Item Name',
							name: 'itemname',
							filterable: true,
							searchable: true
						},
						{
							class: 'col-lg-5 px-0 d-none d-lg-block',
							label: 'Creator',
							name: 'creator',
							filterable: true,
							searchable: false
						}
					]
				},

				itemList: [],

				newItem: {
					itemName: '',
					unitInput: '',
					units: []
				},
				updateItem: {
					id: '',
					itemName: '',
					unitInput: '',
					units: []
				},

				apiValidators: {
					itemName: '',
					units: ''
				}
			}
		},
		created(){
			this.$axios.get('/api/get-all-items', {}).then((response) => {
				this.$store.dispatch('pageLoader', { display: false, message: '' });
				for(let counter = 0; counter < response.data.items.length; counter++){
					let itemObject = this.setItemObject(response.data.items[counter]);
					this.itemList.push(itemObject);
				}
			}).catch((errorResponse) => {
				this.$store.dispatch('pageLoader', { display: false, message: '' });
			});
		},

		methods: {
			setItemObject(itemInfo){
				let itemObject = {};
				itemObject['id'] = itemInfo.id;
				itemObject['itemname'] = itemInfo.name;
				itemObject['creator'] = itemInfo.creator.profile.first_name + ' ' + itemInfo.creator.profile.last_name;
				itemObject['props'] = itemInfo;

				return itemObject;
			},

			handleSubmission(uri, dataToSend){
				if(dataToSend != null && dataToSend != null){
					this.$store.dispatch('pageLoader', { display: true, message: 'Creating new item. Please wait...' });
					this.resetApiValidators();

					this.$axios.post(uri, dataToSend).then((response) => {
						if(uri == '/api/create-new-item'){
							let itemInfo = this.setItemObject(response.data.item);
							this.itemList.push(itemInfo);
							document.getElementById('create-item-modal-closer').click();
						}
						else{
							for(let counter = 0; counter < this.itemList.length; counter++){
								if(this.itemList[counter]['id'] == dataToSend.id){
									this.itemList[counter]['itemname'] = response.data.item.name;
									this.itemList[counter]['props'] = response.data.item;

									document.getElementById('update-item-modal-closer').click();
									break;
								}
							}
						}
						this.$store.dispatch('pageLoader', { display: false, message: '' });
					}).catch((errorResponse) => {
						console.log("ERROR RESPONSE: ", errorResponse);

						if(errorResponse.response){
							if(errorResponse.response.status == 422){
								for(let key in errorResponse.response.data.errors){
									this.apiValidators[key] = errorResponse.response.data.errors[key][0];
								}
							}
						}
						this.$store.dispatch('pageLoader', { display: false, message: '' });
					});
				}
			},


			handleSelectDataToUpdate(data){
				this.updateItem.id = data.id;
				this.updateItem.itemName = data.name;
				this.updateItem.unitInput = '';

				let newUnitContainer = [];
				for(let counter = 0; counter < data.information.units.length; counter++){
					newUnitContainer.push(data.information.units[counter]);
				}

				this.updateItem.units = newUnitContainer;
			},


			handleChangeUnit(isUpdate = false){
				if(!isUpdate){
					if(!this.newItem.units.includes(this.newItem.unitInput)){
						this.newItem.units.push(this.newItem.unitInput);
					}
					else{
						console.log('Already Exists!');
					}

					this.newItem.unitInput = '';
				}
				else{
					if(!this.updateItem.units.includes(this.updateItem.unitInput)){
						this.updateItem.units.push(this.updateItem.unitInput);
					}
					else{
						console.log('Already Exists!');
					}

					this.updateItem.unitInput = '';
				}
			},
			resetNewItemForm(){
				for(let key in this.newItem){
					if(key == 'units'){
						this.newItem[key] = [];
					}
					else{
						this.newItem[key] = '';
					}
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