<template>
	<div id="reset-password-page-component">
		<h4 class="mb-0">Reset Password</h4>
		<small>Fill up the form below in order for you to reset your account's password.</small>
		<hr>
		<label>Email Address</label>
		<input type="email" class="form-control form-control-sm" name="" placeholder="Enter Email Address Here...">
		<p class="text-danger"></p>

		<label>New Password</label>
		<input type="email" class="form-control form-control-sm" name="" placeholder="Enter New Password Here...">
		<p class="text-danger"></p>

		<label>Confirm New Password</label>
		<input type="email" class="form-control form-control-sm" name="" placeholder="Confirm New Password Here...">
		<p class="text-danger"></p>
		

		<div class="text-right mt-5">
			<button class="btn btn-sm btn-block btn-success">
				Reset Account's Password
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