import Homee from './HomeRouter'
import About from './AboutRouter'
import Job from './JobRouter'
import Auth from './AuthRouter'
import Profile from './ProfileRouter'
import ProviderPrice from './provider/PriceRouter'
import Payment from './provider/PaymentRouter'
import Chat from './Chat'
import Category from './Category'
import Fronted from './Fronted'
import Complain from './ComplainRouter'
import { createRouter, createWebHistory} from 'vue-router';


const routes = [
    ...Homee,
    ...About,
    ...Job,
    ...Auth,
    ...Profile,
    ...ProviderPrice,
    ...Payment,
    ...Chat,
    ...Category,
    ...Fronted,
    ...Complain,
]

const router = createRouter({
    history:createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next();
  });

export default router;  