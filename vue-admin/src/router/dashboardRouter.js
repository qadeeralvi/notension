
import Dashboard from '../views/admin/dashboard/index.vue';
import AuthMiddleware from '../middleware/Auth';

const routes = [

    {
        name:'Dashboard',
        component: Dashboard,
        path:"/dashboard",
        meta:{title:'Dashboad'}
      
    },

   
    
]



export default routes;  
