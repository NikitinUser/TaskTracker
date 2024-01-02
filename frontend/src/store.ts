import { createStore } from 'vuex';

interface User {
    id: number;
    name: string;
    email: string;
}

interface AuthState {
    user: User | null;
    token: string | null;
}

interface State {
    user: User | null;
    token: string | null;
}

const store = createStore<AuthState>({
    state: {
        user: null,
        token: null
    },
    mutations: {
        setUser(state: State, user: User) {
            state.user = user;
        },
        setToken(state: State, token: string) {
            state.token = token;
        },
        logout(state: State) {
            state.user = null;
            state.token = null;
        }
    },
    actions: {
        login({ commit }, { user, token }: { user: User; token: string }) {
            commit('setUser', user);
            commit('setToken', token);
        },
        logout({ commit }) {
            commit('logout');
        }
    },
    getters: {
        isLoggedIn: (state: State) => !!state.user,
        token: (state: State) => state.token,
        user: (state: State) => state.user
    }
});

export default store;
