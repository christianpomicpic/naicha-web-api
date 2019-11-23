<template>
	<div id="branches-page-component">
		<h5>Branch Management</h5>
		<hr>
	</div>
</template>
<script type="text/javascript">
	export default {
		created(){
			this.$store.dispatch('pageLoader', { display: false, message: '' });
		}
	}
</script>