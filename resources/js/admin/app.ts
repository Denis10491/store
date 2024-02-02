import { createApp } from 'vue';
import { createPinia } from 'pinia';
import axios from 'axios';

import '../../assets/scripts/uikit';
import '../../assets/scripts/uikit-icons'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
axios.defaults.withCredentials = true;

import App from './App.vue';
import router from './router';

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)
app.use(router)
app.mount('#app');