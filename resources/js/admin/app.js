import '../uikit';
import '../uikit-icons'
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import axios from 'axios';

window.axios = axios;
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'
axios.defaults.withCredentials = true;

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)
app.use(router)
app.mount('#app');