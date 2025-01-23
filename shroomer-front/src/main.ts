import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)
app.config.globalProperties.$hostname = 'https://localhost:443'
app.provide('host', 'https://localhost:443')

app.use(createPinia())
app.use(router)

app.mount('#app')
