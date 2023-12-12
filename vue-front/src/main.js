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
app.config.globalProperties.$authentication = 'http://127.0.0.1:4000/api/'
app.config.globalProperties.$chat = 'http://127.0.0.1:4010/api/'
app.config.globalProperties.$chat = 'http://127.0.0.1:4010/api/'
app.config.globalProperties.$service = 'http://127.0.0.1:4020/api/'
app.config.globalProperties.$paymentApi = 'http://127.0.0.1:4030/api/'
app.config.globalProperties.$website = 'http://127.0.0.1:4040/api/'

app.config.globalProperties.$payment = 'http://127.0.0.1:4030/'