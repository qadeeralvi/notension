
import Login from '../views/auth/userLogin.vue';
import ProviderLogin from '../views/auth/providerLogin.vue';
import SignUp from '../views/auth/userRegister.vue';
import ProviderSignUp from '../views/auth/providerRegister.vue';
import Forget from '../views/auth/forget.vue';

const routes = [
    {
        name:'Login',
        component: Login,
        path:"/login",
        meta:{title:'Login'},
    },
    {
        name:'SignUp',
        component: SignUp,
        path:"/signUp",
        meta:{title:'SignUp'},
    },
    {
        name:'Forget',
        component: Forget,
        path:"/forget",
        meta:{title:'Forget'},
    },
    {
        name:'ProviderLogin',
        component: ProviderLogin,
        path:"/provider/login",
        meta:{title:'ProviderLogin'},
    },
    {
        name:'ProviderSignUp',
        component: ProviderSignUp,
        path:"/provider/signUp",
        meta:{title:'ProviderSignUp'},
    }
]

export default routes;  