
import Coupen from '../../views/admin/coupen/index.vue';
import AuthMiddleware from '../../middleware/Auth';
const routes = [
    {
        name:'Coupen',
        component: Coupen,
        path:"/coupen",
        meta:{title:'Coupen List'},
        props: {
            page: 'Coupen',
          }
    }
]

export default routes;  