<template>
	<div id="default-layout-component">
		<div id="default-layout-wrapper">
			<div class="row m-0 d-flex justify-content-center align-items-center h-100">
				<div class="col-md-4">
					<router-view></router-view>
				</div>
			</div>
			
		</div>
		
	</div>
</template>
<style type="text/css">
	#default-layout-wrapper {
		width: 100vw; 
		height: 100vh; 
		overflow-y: hidden;
	}
</style>
<script type="text/javascript">

</script>