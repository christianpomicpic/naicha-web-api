<template>
	<div id="dashboard-home-component">
		<h3>Welcome To Naicha Dashboard!</h3>
	</div>
</template>
<script type="text/javascript">
	export default {
		created(){
			this.$store.dispatch('pageLoader', { display: false, message: '' });
		}
	}
</script>