
import Home from '../views/fronted/home.vue';
import UserHome from '../views/user/afterLogIn/home.vue';
import ProviderHome from '../views/provider/home.vue';
import OTP from '../views/otp.vue';

const routes = [
    {
        name:'Home',
        component: Home,
        path:"/home",
        meta:{title:'Home'},
    },
    {
        name:'/',
        component: Home,
        path:"/",
        meta:{title:'Home'},
    },
    {
        name:'UserHome',
        component: UserHome,
        path:"/userHome",
        meta:{title:'UserHome'},
    },

    {
        name:'ProviderHome',
        component: ProviderHome,
        path:"/provider/home",
        meta:{title:'ProviderHome'},
    },
    {
        name:'/ProviderHome',
        component: ProviderHome,
        path:"/provider",
        meta:{title:'Home'},
    },
    {
        name:'/OTP',
        component: OTP,
        path:"/otp",
        meta:{title:'OTP'},
    }
]

export default routes;  