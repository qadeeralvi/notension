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
app.config.globalProperties.$authentication = 'https://authentication.notension.pk/api/'
app.config.globalProperties.$service = 'https://services.notension.pk/api/'
app.config.globalProperties.$services = 'https://services.notension.pk/'
app.config.globalProperties.$payment = 'https://payment.notension.pk/api/'
app.config.globalProperties.$chat = 'https://chat.notension.pk/api/'
app.config.globalProperties.$website = 'https://website.notension.pk/api/'
app.use(router).mount('#app');