
import Job from '../views/user/job/jobForm.vue';
import JobList from '../views/user/job/JobList.vue';
import JobUpdate from '../views/user/job/update.vue';
import Rating from '../views/user/job/rating.vue';
import ProviderJob from '../views/provider/job/index.vue';
import JobPosted from '../views/user/job/jobPosted.vue';
const routes = [
    {
        name:'Job',
        component: Job,
        path:"/job",
        meta:{title:'Job'},
    },
    {
        name:'JobList',
        component: JobList,
        path:"/job-list",
        meta:{title:'JobList'},
    },
    {
        name:'JobUpdate',
        component: JobUpdate,
        path:"/job-update",
        meta:{title:'JobUpdate'},
    },
    {
        name:'Rating',
        component: Rating,
        path:"/rating",
        meta:{title:'Rating'},
    },
    {
        name:'ProviderJob',
        component: ProviderJob,
        path:"/provider/job",
        meta:{title:'ProviderJob'},
    },
    {
        name:'JobPosted',
        component: JobPosted,
        path:"/job-posted",
        meta:{title:'JobPosted'},
    }
]

export default routes;  