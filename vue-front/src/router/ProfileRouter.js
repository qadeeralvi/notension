
import UserProfile from '../views/profile/UserProfile.vue';
import ProviderProfile from '../views/provider/profile.vue';
const routes = [
    {
        name:'UserProfile',
        component: UserProfile,
        path:"/user/profile",
        meta:{title:'User Profile'},
    },
    {
        name:'ProviderProfile',
        component: ProviderProfile,
        path:"/provider/Profile",
        meta:{title:'Provider Profile'},
    }
]

export default routes;  