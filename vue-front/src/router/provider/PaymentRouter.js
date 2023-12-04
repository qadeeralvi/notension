
import Payment from '../../views/provider/payment/payment.vue'
import AddPayment from '../../views/provider/payment/add_payment.vue'
const routes = [
    {
        name:'Payment',
        component: Payment,
        path:"/provider/payment",
        meta:{title:'Payment'},
    },
    {
        name:'AddPayment',
        component: AddPayment,
        path:"/provider/add-payment",
        meta:{title:'Payment'},
    },
    
]

export default routes;  