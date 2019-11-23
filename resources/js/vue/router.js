import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);
const router = new VueRouter({
	mode: 'history',
	// base: 'weaver',
	routes: [
		{
			path: '/',
			component: require('./pages/auth/login/index.vue').default,
			name: 'login',
			meta: { 
				layout: 'default',
				allowedUsers: ['guest']
			}
		},
		{
			path: '/forgot-password',
			component: require('./pages/auth/forgot-password/index.vue').default,
			name: 'forgot-password',
			meta: { 
				layout: 'default',
				allowedUsers: ['guest']
			}
		},
		{
			path: '/reset-password/:token',
			component: require('./pages/auth/reset-password/index.vue').default,
			name: 'reset-password',
			meta: { 
				layout: 'default',
				allowedUsers: ['guest']
			}
		},


		{
			path: '/dashboard',
			component: require('./pages/dashboard/home/index.vue').default,
			name: 'dashboard-home',
			meta: {
				layout: 'dashboard',
				allowedUsers: ['authenticated']
			}
		},
		{
			path: '/dashboard/accounts',
			component: require('./pages/dashboard/accounts/index.vue').default,
			name: 'dashboard-accounts',
			meta: {
				layout: 'dashboard',
				allowedUsers: ['authenticated']
			}
		},
		{
			path: '/dashboard/inventory-items',
			component: require('./pages/dashboard/inventory-items/index.vue').default,
			name: 'dashboard-inventory-items',
			meta: {
				layout: 'dashboard',
				allowedUsers: ['authenticated']
			}
		},
		{
			path: '/dashboard/branches',
			component: require('./pages/dashboard/branches/index.vue').default,
			name: 'dashboard-branches',
			meta: {
				layout: 'dashboard',
				allowedUsers: ['authenticated']
			}
		},
	]
});

export default router