
import Login from '../../views/admin/auth/pages/login.vue';
import Forget from '../../views/admin/auth/pages/forget.vue';
import Signup from '../../views/admin/auth/pages/signup.vue';

const routes = [

    
    {
        name:'Login',
        component: Login,
        path:"/login",
        meta:{title:'Admin Panel'}
    },
    {
        name:'Login',
        component: Login,
        path:"/",
        meta:{title:'Admin Panel'}
    },
    
    {
        name:'Forget',
        component: Forget,
        path:"/forget",
        meta:{title:'Admin Forget'}
    },
    {
        name:'Signup',
        component: Signup,
        path:"/signup",
        meta:{title:'Admin Signup'}
    },
    
]



export default routes;  
