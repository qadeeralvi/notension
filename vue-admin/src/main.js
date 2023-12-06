import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index'

//** AXIOS */
import {request} from '@/mixins/request'
const app = createApp(App)
app.mixin(request)
// app.use(VueCookie)
// app.provide('cookies', app.config.globalProperties.$cookies)
//app.config.globalProperties.$authentication = 'https://authentication.notension.pk/api/'
app.config.globalProperties.$main = 'http://localhost:8080/'
app.config.globalProperties.$authentication = 'http://127.0.0.1:4000/api/'
app.config.globalProperties.$chat = 'http://127.0.0.1:4010/api/'
app.config.globalProperties.$service = 'http://127.0.0.1:4020/api/'
app.config.globalProperties.$payment = 'http://127.0.0.1:4030/api/'
app.config.globalProperties.$website = 'http://127.0.0.1:4040/api/'
app.use(router).mount('#app');
