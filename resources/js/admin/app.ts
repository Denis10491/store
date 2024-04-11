import {createApp} from 'vue';
import {createPinia} from 'pinia';
import App from './App.vue';
import router from './router';
import {bootstrap} from "@admin/bootstrap/app";

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)
bootstrap()

app.use(router)
app.mount('#app');
