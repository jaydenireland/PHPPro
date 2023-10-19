import { createApp } from 'vue'
import App from './App.vue'

const app = createApp(App)

console.log(window.api)

app.mount('#app')
