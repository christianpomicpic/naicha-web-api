<template>
	<div id="forgot-password-page-componet">
		<h4 class="mb-0">Forgot Password</h4>
		<small>Forgot your password? Don't worry, just enter your email address below and we'll send you a password reset link.</small>
		<hr>
		<label>Email Address</label>
		<input type="email" class="form-control form-control-sm" name="" placeholder="Enter Email Address Here...">
		<router-link :to="{ name: 'login' }" class="text-danger text-right d-block">
			<small>Remembered Your Password?</small>
		</router-link>
		

		<div class="text-right mt-5">
			<button class="btn btn-sm btn-success btn-block">
				Send Reset Link
			</button>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		created(){
			this.$store.dispatch('pageLoader', { display: false, message: '' });
		},
	}
</script>