import { inject } from 'vue';
import { Store } from 'vuex';
import config from './../../config';

export class AuthService {
    private store: Store<any>;
    private url: string;

    constructor() {
        this.store = inject('store') as Store<any>;
        this.url = config.apiUrl;
    }

    public async login(email: string, password: string) {
        await fetch(this.url + 'api/auth/login', {
            method: 'POST',
            body: JSON.stringify({
                'email': email,
                'password': password
            })
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            localStorage.setItem('token', data.access_token);
            this.getMe();
        })
        .catch((error) => {
            console.log(error);
        });
    }

    public async registration(email: string, password: string, name: string) {
        let success = false;
        
        await fetch(this.url + 'api/auth/registrate', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json'
            }), 
            body: JSON.stringify({
                'email': email,
                'password': password,
                'name': name
            })
        })
        .then((response) => {
            return response.json();
        })
        .then(() => {
            success = true;
        })
        .catch((error) => {
            console.log(error);
        });

        return success;
    }

    public logout() {
        const token = localStorage.getItem('token');
        if (token === null) {
            localStorage.removeItem('token');
            return;
        }

        fetch(this.url + 'api/auth/logout', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            })
        })
        .then((response) => {
            return response.json();
        })
        .then(() => {
            localStorage.removeItem('token');
        })
        .catch((error) => {
            localStorage.removeItem('token');
            console.log(error);
        });
    }

    public async getMe() {
        const token = localStorage.getItem('token');
        if (token === null) {
            localStorage.removeItem('token');
            return;
        }

        await fetch(this.url + 'api/auth/me', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            })
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            this.store.commit('setUser', {
                id: data.id,
                name: data.name,
                email: data.email
            });

            this.store.commit('setToken', data.access_token);
        })
        .catch((error) => {
            localStorage.removeItem('token');
            console.log(error);
        });
    }

    public async isLoggedIn(): Promise<boolean> {
        await this.getMe();
        return this.store.getters.isLoggedIn;
    }
}
