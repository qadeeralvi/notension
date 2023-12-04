
import Payment from '../../views/admin/payment/index.vue';
import Account from '../../views/admin/payment/account.vue';
import Wallet from '../../views/admin/payment/wallet.vue';


const routes = [

    {
        name:'Payment',
        component: Payment,
        path:"/payment",
        meta:{title:'Payment List'},
        props: {
            page: 'Payment',
          }
    },
    {
        name:'Account',
        component: Account,
        path:"/account",
        meta:{title:'Account List'},
        props: {
            page: 'Account',
          }
    },
    {
        name:'Wallet',
        component: Wallet,
        path:"/Wallet",
        meta:{title:'Wallet List'},
        props: {
            page: 'Wallew',
          }
    },

]


export default routes;  
