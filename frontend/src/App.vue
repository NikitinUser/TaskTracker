<script setup lang="ts">
import LoadingSpinner from './components/LoadingSpinner.vue'
</script>

<template>
	<LoadingSpinner/>

	<div class="flex-container">
		<router-link to="/">home</router-link>
		<router-link to="/login">login</router-link>
		<router-link to="/register">register</router-link>
	</div>

	<router-view></router-view>
</template>

<style scoped>
</style>
