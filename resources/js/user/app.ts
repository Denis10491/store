import { createApp } from 'vue';
import { createPinia } from 'pinia';

import '../../assets/scripts/uikit';
import '../../assets/scripts/uikit-icons'

import App from './App.vue';
import router from './router';

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)
app.use(router)
app.mount('#app');