
import User from '../../views/admin/management/user/index.vue';
import Provider from '../../views/admin/management/provider/index.vue';
import Admin from '../../views/admin/management/admin/index.vue';


const routes = [

    {
        name:'User',
        component: User,
        path:"/users",
        meta:{title:'User List'},
        props: {
            page: 'User'
          }
    },
    {
        name:'Provider',
        component: Provider,
        path:"/providers",
        meta:{title:'Provider List'},
        props: {
            page: 'Provider'
          }
    },
    {
        name:'Provider',
        component: Provider,
        path:"/providers",
        meta:{title:'Provider List'},
        props: {
            page: 'Provider'
          }
    },
    {
        name:'Admin',
        component: Admin,
        path:"/admins",
        meta:{title:'Admin List'},
        props: {
            page: 'Admin'
        }
    },
   
]

export default routes;  
