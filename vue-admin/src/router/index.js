import VueRouteMiddleware from "vue-route-middleware"
import AuthMiddleware from "../middleware/Auth"
import adminRoutes from './admin/authRouter'
import Dashboard from './dashboardRouter'
import Job from './admin/jobRouter'
import Manage from './admin/managementRouter'
import Complaint from './admin/complaintRouter'
import Payment from './admin/paymentRouter'
import Coupen from './admin/coupenRouter'
import Setting from './admin/settingRouter'
import Report from './admin/reportRouter'
import Role from './admin/rolesPermissionRouter'
import { createRouter, createWebHistory} from 'vue-router';

const routes = [
    ...adminRoutes,
    ...Dashboard,
    ...Job,
    ...Manage,
    ...Complaint,
    ...Payment,
    ...Coupen,
    ...Setting,
    ...Report,
    ...Role,
]

const router = createRouter({
    history:createWebHistory(),
    routes
 
});


router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next();      

  });

    // router.beforeEach(AuthMiddleware);

    // router.beforeEach(VueRouteMiddleware({ AuthMiddleware }));

export default router;  