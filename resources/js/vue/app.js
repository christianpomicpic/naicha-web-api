import Vue from 'vue';
import App from './app.vue';
import Router from './router.js';

import AxiosPlugin from './plugins/axios.js';
Vue.use(AxiosPlugin);

import Vuex from 'vuex';
import StoreIndex from './store/index.js';
Vue.use(Vuex);
const store = new Vuex.Store(StoreIndex);

Vue.component('responsive-table', require('./components/tables/responsive-table.vue').default);

// ---------------------------------------------------------------------------------------
// ROUTE GUARDS
// ---------------------------------------------------------------------------------------
Router.beforeEach(
	(to, from, next) => {	
		console.log("TO: ", to);
		store.dispatch('pageLoader', { display: true, message: 'Page is loading. Please wait...' });

		if(to.meta.allowedUsers.includes('guest')){
			let currentToken = localStorage.getItem('token');
			let checkAuth = JSON.parse(localStorage.getItem('checking_if_auth'));
			if(checkAuth){
				localStorage.removeItem('checking_if_auth');
				localStorage.removeItem('token');
				localStorage.removeItem('user_info');
				next();
			}
			else{
				if(currentToken){
					localStorage.setItem('checking_if_auth', true);
					next({ name: 'dashboard-home' });
				}
				else{
					next();
				}
			}
		}
		else {
			Vue.axios.post('/api/authentication-check', {}).then((response) => {
				let checkAuth = JSON.parse(localStorage.getItem('checking_if_auth'));
				if(checkAuth){
					localStorage.removeItem('checking_if_auth');
				}
				next();
			}).catch((errorResponse) => {
				next({ name: 'login' });
			});	
		}
	}
);
// ---------------------------------------------------------------------------------------

let app = new Vue({
	el: '#vue-app',
	render: h => h(App),
	router: Router,
	store
});