import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios';

const app = createApp(App)
axios.defaults.baseURL = 'http://127.0.0.1:8001/api/';
app.config.globalProperties.$axios = axios;

app.use(router)

app.mount('#app')
