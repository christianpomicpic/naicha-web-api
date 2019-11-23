<template>
	<div id="vue-main-app-component">
		<div v-bind:class="{
			'd-none': !$store.getters.isLoading
		}">
			<div style="position: fixed; height: 100vh; width: 100vw; background: rgba(0, 0, 0, 0.8); z-index: 3000;">
				<div class="row m-0 d-flex justify-content-center align-items-center h-100">
					<div class="col-md-6 text-center text-info">
						<span class="d-block text-center">
							<i class="fas fa-fw fa-spinner fa-pulse fa-3x mb-3"></i>
						</span>
						<h5 class="mb-0">
							{{ $store.getters.getLoadingMessage }}
						</h5>
					</div>
				</div>
			</div>
		</div>
		<default-layout v-if="layout == 'default'"></default-layout>
		<dashboard-layout v-if="layout == 'dashboard'"></dashboard-layout>
	</div>
</template>
<script type="text/javascript">
	export default {
		components: {
			'default-layout': require('./layouts/default.vue').default,
			'dashboard-layout': require('./layouts/dashboard.vue').default
		},
		computed: {
			layout(){
				return this.$route.meta.layout;
			}
		},
	}
</script>