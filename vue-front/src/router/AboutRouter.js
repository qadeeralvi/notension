
import About from '../views/fronted/about.vue';
import ProviderAbout from '../views/provider/about.vue';
const routes = [
    {
        name:'About',
        component: About,
        path:"/about",
        meta:{title:'About'},
    },
    {
        name:'ProviderAbout',
        component: ProviderAbout,
        path:"/provider/about",
        meta:{title:'About'},
    }
]

export default routes;  