<template >
   <div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li class="main_li" >
                    <router-link to="/dashboard">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                   </router-link>
                </li>
                
                <li  class="main_li" data-parent-id="1" v-if="hasParentPermission(1)">
                    <a  class="has-arrow waves-effect" aria-expanded="false">
                        <i class="bx bx-briefcase"></i>
                        <span>Jobs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="sub_li" data-sub-id="2"><router-link to="/jobs" v-if="hasModulePermission(2)">Jobs Manage</router-link> </li>
                        <li class="sub_li" data-sub-id="3"><router-link to="/category" v-if="hasModulePermission(3)">Category</router-link> </li>
                        <li class="sub_li" data-sub-id="4"><router-link to="/sub_category" v-if="hasModulePermission(4)">Sub Category</router-link> </li>
                        <li class="sub_li" data-sub-id="5"><router-link to="/rating" v-if="hasModulePermission(5)">Ratings</router-link> </li>
                    </ul>
                </li>
                <li class="main_li" data-parent-id="6" v-if="hasParentPermission(6)">
                    <a  class="has-arrow waves-effect">
                        <i class="bx bx-compass"></i>
                        <span>Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="sub_li" data-sub-id="7"><router-link to="/users" v-if="hasModulePermission(7)">User</router-link></li>
                        <li class="sub_li" data-sub-id="8"><router-link to="/providers" v-if="hasModulePermission(8)">Provider</router-link></li>
                        <li class="sub_li" data-sub-id="9"><router-link to="/admins" v-if="hasModulePermission(9)">Admin</router-link></li>
                    </ul>
                </li>

                <li class="main_li" data-parent-id="10" v-if="hasParentPermission(10)"> 
                    <a  class="has-arrow waves-effect">
                        <i class="bx bx-comment"></i>
                        <span>Complaint</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="sub_li" data-sub-id="11 "><router-link to="/complain" v-if="hasModulePermission(11)">All Complaints</router-link> </li>
                    </ul>
                </li>
                
                <li class="main_li" data-parent-id="12" v-if="hasParentPermission(12)">
                    <a  class="has-arrow waves-effect">
                        <i class="bx bx-money"></i>
                        <span>Payment Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="sub_li" data-sub-id="13"><router-link to="/payment" v-if="hasModulePermission(13)">All Payment</router-link> </li>
                    </ul>
                </li>

                <li class="main_li" data-parent-id="14" v-if="hasParentPermission(14)">
                    <a  class="has-arrow waves-effect">
                        <i class="bx bx-money"></i>
                        <span>Role Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="sub_li" data-sub-id="15"><router-link to="/role" v-if="hasModulePermission(15)">Roles</router-link></li>
                        <li class="sub_li" data-sub-id="16"><router-link to="/permission" v-if="hasModulePermission(16)">Permission</router-link></li>
                    </ul>
                </li>

                <li class="main_li" data-parent-id="0" v-if="hasParentPermission(0)">
                    <a  class="has-arrow waves-effect">
                        <i class="bx bx-briefcase"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><router-link to="/reportJObAssigned">Job Assigned</router-link> </li>
                        <li><router-link to="/wallet">Provider Payment</router-link> </li>
                    </ul>
                </li>

                <li class="main_li" data-parent-id="17" v-if="hasParentPermission(17)">
                    <a  class="has-arrow waves-effect">
                        <i class="bx bx-briefcase"></i>
                        <span>Setting</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="sub_li" data-sub-id="18"><router-link to="/account" v-if="hasModulePermission(18)">Accounts</router-link> </li>
                        <li class="sub_li" data-sub-id="19"><router-link to="/coupen" v-if="hasModulePermission(19)">Coupen</router-link> </li>
                        <li class="sub_li" data-sub-id="20"><router-link to="/webStting" v-if="hasModulePermission(20)">Cms setting</router-link> </li>
                        <!-- <li><router-link to="/banner">Banner</router-link> </li> -->
                       
                    </ul>
                </li>

            </ul>
            
            
        </div>
        <!-- Sidebar -->
    </div>
</div>
</template>
<script>

    export default {

        mounted() {
            this.loadJS(['./assets/libs/jquery/jquery.min.js','./assets/libs/bootstrap/js/bootstrap.bundle.min.js','./assets/libs/metismenu/metisMenu.min.js','./assets/libs/simplebar/simplebar.min.js','./assets/js/app.js'])
        },
        
        created() {
                    // this.getResult();
                    this.checkPermission();
            },
        data(){
                return {
                    result:[],
                    parentPermissions:'',
                    modulePermissions:'',
                }
        },
        methods: {

                    async checkPermission() {

                        const admin = this.adminDetail();  
                        if (admin.role !== 1) {
                            const data = await  this.api('POST', this.$authentication + 'fetchPermisison', { roleId: admin.role }, false, false);

                            if (data.status === 200) {
                                this.parentPermissions = data.parentId;
                                this.modulePermissions = data.moduleId;
                            }
                        }

                    },

                    hasParentPermission(permission) {
                        const admin = this.adminDetail(); 
                        if (admin.role !== 1) {
                            return this.parentPermissions.includes(permission);
                        }
                        else{
                            return true;
                        }
                    },

                    hasModulePermission(module) {
                        const admin = this.adminDetail();
                        if (admin.role !== 1) {
                         return this.modulePermissions.includes(module);
                        }
                        else{
                            return true;
                        }
                    },

                    // async getResult(page=1) {

                    //     this.isLoggedIn = localStorage.getItem('admin_info');
                    //     const admin = JSON.parse(this.isLoggedIn); 

                    //     if(admin.role!=1){

                    //         const data =  await this.api('POST',this.$authentication+'fetchPermisison',{ roleId: admin.role},false,false)
                    //             if(data.status===200){

                    //                 this.result =  data.data

                    //                 const parentIds = new Set( this.result.map(obj => obj.parentId));

                    //                 document.querySelectorAll('li.main_li').forEach(liElement => {
                    //                     const parentId = parseInt(liElement.getAttribute('data-parent-id'));
                    //                     const ulElement = liElement;
                    //                     if (parentIds.has(parentId)) {
                    //                         ulElement.style.display = 'block';
                    //                     } else {
                    //                         ulElement.style.display = 'none';
                    //                     }
                    //                 });

                    //                 const subIds = new Set( this.result.map(obj => obj.moduleId));
                    //                 document.querySelectorAll('li.sub_li').forEach(subLiElement => {
                    //                     const subId = parseInt(subLiElement.getAttribute('data-sub-id'));
                    //                     const subUlElement = subLiElement;
                    //                     if (subIds.has(subId)) {
                    //                         subUlElement.style.display = 'block';
                    //                     } else {
                    //                         subUlElement.style.display = 'none';
                    //                     }
                    //                 });
                    //             }

                    //             else{

                    //                 document.querySelectorAll('li.main_li').forEach(liElement => {
                    //                     liElement.style.display = 'none';
                    //                 });

                    //             }
                    //     }
                    // },
                }
        
    }

</script>