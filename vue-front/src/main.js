import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index'
import $ from 'jquery'
import {request} from '@/mixins/request'

const app = createApp(App)
app.config.globalProperties.$ = $
app.mixin(request)
  
app.use(router).mount('#app');
app.config.globalProperties.$main = 'http://localhost:5173/'
app.config.globalProperties.$service = 'https://services.notension.pk/api/'
app.config.globalProperties.$authentication = 'https://authentication.notension.pk/api/'
app.config.globalProperties.$payment = 'https://payment.notension.pk/api/'
app.config.globalProperties.$chat = 'https://chat.notension.pk/api/'
app.config.globalProperties.$website = 'https://website.notension.pk/api/'