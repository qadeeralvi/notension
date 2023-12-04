
import Role from '../../views/admin/role/index.vue';
import Permission from '../../views/admin/role/permission.vue';

const routes = [
    {
        name:'Role',
        component: Role,
        path:"/role",
        meta:{title:'Role List'},
        props: {
            page: 'Role',
          }
    },
    {
        name:'Permission',
        component: Permission,
        path:"/permission",
        meta:{title:'Permission List'},
        props: {
            page: 'Permission',
          }
    },
    
]

export default routes;  