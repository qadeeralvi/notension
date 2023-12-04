
import Complaint from '../../views/admin/complaint/index.vue';
import ComplaintDetail from '../../views/admin/complaint/detail.vue';

const routes = [

    {
        name:'Complaint',
        component: Complaint,
        path:"/complain",
        meta:{title:'Complaints List'},
        props: {
            page: 'Complaint',
            img_url:'http://chat.notension.pk/uploads/'
          }
    },
    {
        name:'ComplaintDetail',
        component: ComplaintDetail,
        path:"/complaint_detail/:id",
        meta:{title:'Complaints Details'},
        props: {
            page: 'Complaint Details',
            img_url:'http://chat.notension.pk/uploads/'
          }
    },

]


export default routes;  
