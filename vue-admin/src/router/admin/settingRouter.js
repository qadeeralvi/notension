
import Setting from '../../views/admin/setting/webSetting.vue';
import Banner from '../../views/admin/setting/banner/banner.vue';
import AddBanner from '../../views/admin/setting/banner/addBanner.vue';

const routes = [

    {
        name:'Setting',
        component: Setting,
        path:"/webStting",
        meta:{title:'Setting'},
        props: {
            page: 'Setting',
          }
    },
    {
        name:'Banner',
        component: Banner,
        path:"/banner",
        meta:{title:'Banner'},
        props: {
            page: 'Banner',
          }
    },
    {
        name:'AddBanner',
        component: AddBanner,
        path:"/addBanner",
        meta:{title:'AddBanner'},
        props: {
            page: 'AddBanner',
          }
    },

]


export default routes;  
