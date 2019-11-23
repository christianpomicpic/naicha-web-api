<template>
	<div id="dashboard-layout-component">
		<nav class="navbar navbar-expand-lg navbar-dark bg-info">
			<div class="container">
				<a class="navbar-brand" href="#">Naicha Web App</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-dropdown-options" aria-controls="navbar-dropdown-options" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbar-dropdown-options">
					<ul class="navbar-nav">
						<li class="nav-item" v-bind:class="{
							'active': $route.name == 'dashboard-home'
						}">
							<router-link :to="{ name: 'dashboard-home' }" class="nav-link">
								Home
							</router-link>
						</li>
						<li class="nav-item" v-bind:class="{
							'active': $route.name == 'dashboard-accounts'
						}">
							<router-link :to="{ name: 'dashboard-accounts' }" class="nav-link">
								Accounts
							</router-link>
						</li>
						<li class="nav-item" v-bind:class="{
							'active': $route.name == 'dashboard-inventory-items'
						}">
							<router-link :to="{ name: 'dashboard-inventory-items' }" class="nav-link">
								Inventory Items
							</router-link>
						</li>
						<li class="nav-item" v-bind:class="{
							'active': $route.name == 'dashboard-branches'
						}">
							<router-link :to="{ name: 'dashboard-branches' }" class="nav-link">
								Branches
							</router-link>
						</li>
					</ul>

					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dashboard-navbar-dropdown-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								My Account
							</a>
							<div class="dropdown-menu" aria-labelledby="dashboard-navbar-dropdown-link">
								<a class="dropdown-item" href="#">Settings</a>
								<a href="javascript:void(0)" class="dropdown-item" v-on:click="logout()">
									Logout
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container pt-5">
			<router-view></router-view>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		created(){
			console.log("CURRENT ROUTE: ", this.$route);
		},

		methods: {
			logout(){
				this.$store.dispatch('pageLoader', { display: true, message: 'Logging out. Please wait...' });

				this.$axios.post('/api/authentication/user/logout', {}).then((response) => {
					localStorage.removeItem('token');
					localStorage.removeItem('user_info');
					localStorage.removeItem('checking_if_auth');
					
					this.$router.push({ name: 'login' });
				}).catch((errorResponse) => {
					console.log("ERROR RESPONSE: ", errorResponse);
				});
			}
		}
	}
</script>