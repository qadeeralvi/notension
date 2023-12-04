
import Contact from '../views/fronted/contact.vue';
import Term from '../views/fronted/term.vue';
import Privacy from '../views/fronted/privacy.vue';
const routes = [
    {
        name:'Contact',
        component: Contact,
        path:"/contact",
        meta:{title:'Contact'},
    },
    {
        name:'Term',
        component: Term,
        path:"/term",
        meta:{title:'Term'},
    },
    {
        name:'Privacy',
        component: Privacy,
        path:"/privacy",
        meta:{title:'Privacy'},
    },

]

export default routes;  