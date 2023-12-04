
import Chat from '../views/user/chat/index.vue';
import Providerchat from '../views/provider/chat/index.vue';
const routes = [
    {
        name:'Chat',
        component: Chat,
        path:"/chat",
        meta:{title:'Chat'},
    },

    {
        name:'Providerchat',
        component: Providerchat,
        path:"/provider/chat",
        meta:{title:'Providerchat'},
    },
   
]

export default routes;  