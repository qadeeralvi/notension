
import JobAssigned from '../../views/admin/reports/job_assigned.vue'

const routes = [

    {
        name:'JobAssigned',
        component: JobAssigned,
        path:"/reportJObAssigned",
        meta:{title:'Job Assigned List'},
        props: {
            page: 'Job Assigned',
          }
    },

]


export default routes;  
