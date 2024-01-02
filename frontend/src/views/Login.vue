<template>
    <div class="flex-container-center">
        <div class="flex-container">
            <label>email</label>
            <div>
                <input type="text" v-model="email">
            </div>
        </div>
        <div class="flex-container">
            <label>password</label>
            <div>
                <input type="password" v-model="password">
            </div>
        </div>
        <div>
            <button class="btn" @click="login">войти</button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { AuthService } from './../services/AuthService';

export default defineComponent({
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            authService: new AuthService()
        }
    },
    methods: {
        async login() {
            await this.authService.login(this.email, this.password);
            if (await this.authService.isLoggedIn()) {
                this.$router.push('/');
            }
        }
    }
})
</script>

<style scoped>
</style>
