
import ComplainList from '../views/user/Complaint/index.vue';
import ProviderComplainList from '../views/provider/Complaint/index.vue';

const routes = [
    {
        name:'ComplainList',
        component: ComplainList,
        path:"/complaint-list",
        meta:{title:'ComplainList'},
    },
    {
        name:'ProviderComplainList',
        component: ProviderComplainList,
        path:"/provider/complaint-list",
        meta:{title:'ProviderComplainList'},
    },
    
]

export default routes;  