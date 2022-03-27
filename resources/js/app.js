import Vue from 'vue';
import { createApp } from 'vue';
import { createStore } from 'vuex';
import App from './App.vue';
import router from './router';

require('./bootstrap');
const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);

const store = createStore({
    state() {
        return {
            loggedIn: null
        }
    },
    mutations: {
        setLoggedIn(state, loggedIn) {
            this.state.loggedIn = loggedIn;
        }
    }
});

app.use(store);
app.mount('#app');