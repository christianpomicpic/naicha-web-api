export default {
	state: {
		loadingMessage: 'Page is loading. Please wait...',
		isLoading: true,
	},
	mutations: {
		loaderMutator(state, payload){
			state.loadingMessage = payload.message;
			state.isLoading = payload.display;
		}
	},
	getters: {
		getLoadingMessage(state){
			return state.loadingMessage;
		},
		isLoading(state){
			return state.isLoading;
		}
	},
	actions: {
		async pageLoader({ commit }, payload){
			commit('loaderMutator', payload);
		}
	}
}