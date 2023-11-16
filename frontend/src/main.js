import { createApp } from 'vue';
import App from './App.vue';
import ElementPlus from 'element-plus';
import 'element-plus/theme-chalk/index.css';
import router from './router'; // Import your router instance

const app = createApp(App);

app.use(ElementPlus);
app.use(router); // Use the router

app.mount('#app');
