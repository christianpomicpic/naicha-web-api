<template>
	<div id="login-page-component">
		<form v-on:submit.prevent="handleSubmission()">
			<h4 class="mb-0">Login Account</h4>
			<small>Enter your credentials below in order to access the Naicha Dashboard.</small>
			<hr>

			<div class="alert alert-danger" v-if="hasErrors">
				<small>{{ errorMessage }}</small>
			</div>

			<label>Email Address</label>
			<input type="email" class="form-control form-control-sm" name="" placeholder="Enter Email Address Here..." v-model="form.email">
			<p class="text-danger"></p>

			<label>Password</label>
			<input type="password" class="form-control form-control-sm" name="" placeholder="Enter Password Here..." v-model="form.password">
			<router-link :to="{ name: 'forgot-password' }" class="text-danger text-right d-block">
				<small>Forgot Password?</small>
			</router-link>

			<div class="text-right mt-5">
				<button class="btn btn-sm btn-block btn-success" :disabled="form.submitting">
					Login Account
				</button>
			</div>
		</form>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				form: {
					email: '',
					password: '',
					submitting: false,
				},
				hasErrors: false,
				errorMessage: '',
			}
		},
		created(){
			this.$store.dispatch('pageLoader', { display: false, message: '' });
		},
		methods: {
			handleSubmission(){
				this.form.submitting = true;
				this.hasErrors = false;

				console.log("FORM TO SEND: ", this.form);
				this.$axios.post('/api/authentication/login', this.form).then((response) => {
					localStorage.setItem('token', response.data.token);
					localStorage.setItem('user_info', JSON.stringify(response.data.user_info));
					this.$router.push({ name: 'dashboard-home' });
				}).catch((errorResponse) => {
					if(errorResponse.response.status == 403){
						this.errorMessage = errorResponse.response.data.errorMsg;
					}
					else{
						this.errorMessage = 'Something went wrong. Please refresh the page and try again.'
					}

					this.hasErrors = true;
					this.form.submitting = false;
				});
			}
		}
	}
</script>