
import Job from '../../views/admin/jobs/index.vue';
import JobView from '../../views/admin/jobs/view.vue';
import JobStatusChange from '../../views/admin/jobs/updateStatus.vue';
import Catgory from '../../views/admin/jobs/category/index.vue';
import Sub_Catgory from '../../views/admin/jobs/sub_category/index.vue';
import Rating from '../../views/admin/jobs/rating/index.vue';


const routes = [

    {
        name:'Job',
        component: Job,
        path:"/jobs",
        meta:{title:'Job List'}
    },
    {
        name:'Job View',
        component: JobView,
        path:"/jobview/:id",
        meta:{title:'Job View'}
    },
    {
        name:'Job Status Change',
        component: JobStatusChange,
        path:"/jobstatuschange/:id",
        meta:{title:'Job Status change'}
    },
    {
        name:'Catgory',
        component: Catgory,
        path:"/category",
        meta:{title:'Category'}
    },
    {
        name:'Sub_Catgory',
        component: Sub_Catgory,
        path:"/sub_category",
        meta:{title:'Sub Catgory'}
    },
    {
        name:'Rating',
        component: Rating,
        path:"/rating",
        meta:{title:'Rating'},
        props: {
            page: 'Rating',
          }
    },
    
]

export default routes;  
