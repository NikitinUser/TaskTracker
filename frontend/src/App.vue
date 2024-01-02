<template>
	<LoadingSpinner v-if="loading"/>

	<div class="menu">
		<div><router-link to="/">home</router-link></div>
		<div class="menu">
			<a v-if="isLoggedIn" href="#" @click="logout">logout</a>
			<div v-else>
				<router-link to="/login" style="margin-right: 10px;">login</router-link>
				<router-link to="/register">register</router-link>
			</div>
		</div>
	</div>

	<div class="content">
		<router-view
			@loadingStart="loadingStart"
			@loadingStop="loadingStop"	
		></router-view>
	</div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import LoadingSpinner from './components/LoadingSpinner.vue'
import { AuthService } from './services/AuthService';

export default defineComponent({
    name: 'App',
	components: {
		LoadingSpinner
	},
	data() {
		return {
			loading: false,
			user: null,
			authService: new AuthService(),
			isLoggedIn: false
		}
	},
	async created() {
		this.isLoggedIn = await this.authService.isLoggedIn();
	},
	methods: {
		loadingStart() {
			console.log(1, 'loadingStart');
			this.loading = true;
		},
		loadingStop() {
			console.log(2, 'loadingStop');
			this.loading = false;
		},
		logout() {
			this.authService.logout();
			this.isLoggedIn = false;
		}
	}
})
</script>

<style scoped>
.menu {
	display: flex;
	justify-content: space-between;
	align-items: center;
}

.content {
	margin-top: 50px;
}
</style>
