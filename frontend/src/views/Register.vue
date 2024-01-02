<template>
    <div>
        <div class="flex-container">
            <label>name</label>
            <div>
                <input type="text" v-model="name">
            </div>
        </div>
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
            <button class="btn" @click="registration">зарегистрироваться</button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { AuthService } from './../services/AuthService';

export default defineComponent({
    name: 'Register',
    data() {
        return {
            email: '',
            password: '',
            name: '',
            authService: new AuthService()
        }
    },
    methods: {
        async registration() {
            const success = await this.authService.registration(this.email, this.password, this.name);
            if (success) {
                this.$router.push('/login');
            }
        }
    }
})
</script>

<style scoped>
</style>

