<template>
    <body data-sidebar="dark">

        <Header></Header>
        <Sidebar></Sidebar>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">{{page}} List</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">{{page}} List</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>     
                    <div class="row" style="background-color: #cfcfcf;">
                        <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Edit Permission </h4>
                        </div>
                    </div>
                   
                    <div class="panel-body">
                        <form  @submit.prevent="onSubmit">
                            <div class="form-group row">
                                <label for="type" class="offset-sm-2 col-sm-1 col-form-label">Roles <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <select class="form-control select-role" style="height: 50px;" v-model="form.roleId">
                                        <option>Choose Role</option>
                                        <option v-for="(itemRole, indexRole) in roleResult" :value="itemRole.id">{{ itemRole.name }}</option>
                                    </select>
                                </div>
                            </div>

                                <span  v-for="(item,index) in moduleResult" :key="index">
                                    <h2 class="hidetable" v-if="item.isParent==1">{{ item.name }} </h2>
                                    <table class="table table-bordered hidetable" v-if="item.isParent!=0">
                                            <thead >
                                                <tr>
                                                    <th>Sl No </th>
                                                    <th>Menu Name</th>
                                                    <th>Create (<label for="checkAllcreate"><input type="checkbox" @click="checkallcreate(index)" :id="`checkAllcreate${index}`" name=""> All)</label></th>
                                                    <th>Read (<input type="checkbox" @click="checkallread(index)" :id="`checkAllread${index}`" name=""> all)</th>
                                                    <th>Update (<input type="checkbox" @click="checkallupdate(index)" :id="`checkAllupdate${index}`" name=""> all)</th>
                                                    <th>Delete (<input type="checkbox" @click="checkalldelete(index)" :id="`checkAlldelete${index}`" name=""> all)</th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(subItem, subIndex) in moduleResult.filter(subItem => subItem.isParent==0 && subItem.parentId==item.id)" :key="subIndex" >
                                                <tr>
                                                    <td>{{subIndex+1}}</td>
                                                    <td>
                                                        {{ subItem.name }}                 
                                                        <input type="hidden" name="fk_module_id[0][0][]" value="1" id="id_1"  >
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-success text-center">
                                                            <input type="checkbox"  value="1" :id="`create[${subItem.id}]`" :class="`create${index}`" >
                                                            <label for="create[0]0"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-success text-center">
                                                            <input type="checkbox"  value="1" :id="`read[${subItem.id}]`" :class="`read${index}`">
                                                            <label for="read[0]0"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-success text-center">
                                                            <input type="checkbox" value="1" :id="`update[${subItem.id}]`" :class="`update${index}`">
                                                            <label for="update[0]0"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-success text-center">
                                                            <input type="checkbox" value="1" :id="`delete[${subItem.id}]`" :class="`delete${index}`">
                                                            <label for="update[0]0"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                    </table>
                                </span>

                                    
            
                            <div class="form-group text-right">
                                <button type="reset" class="btn btn-primary w-md m-b-5"  @click="resetAllCheckBoxs" :style="{ display: isButtonHidden ? 'none' : 'block' }">Reset</button>&nbsp
                                <button type="button"  v-on:click="savePermission"  class="btn  submit-btn btn-success w-md m-b-5">Save</button>
                            </div>
                        </form>                   
                     </div>
                   
                </div>
            </div>
                    </div> <!-- end row -->

                </div>
            </div>
        </div>
    </body>
    

</template>


<script>

    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';
    import Footer from '../layout/common/Footer.vue';
    import $ from 'jquery';
    import 'select2/dist/css/select2.min.css';
    import 'select2/dist/js/select2.min.js';

    export default {

            props: ['page'],

            components: {

                    Header,
                    Sidebar,
                    Footer,
                },

            mounted() {

                $('.select-role').on('change', (event) => {
                    this.adminPermission(event.target.value);
                });

              
            
            },


            created() {
                    this.getModules();
                    this.getRoles();
            },

            data() {
                        return {
                            
                            form: {
                                name: '',
                                roleId: null,
                                },
                            moduleResult:[],
                            roleResult:[],
                            adminPermissonResult:[],
                            isButtonHidden: true
                        }
                    },  

            validations() {

                        return {

                            form: {

                                name: {
                                    required 
                                },
                            }
                        }
                    },

        methods: {

                async savePermission(){

                        var regex = /^(create|update|delete|read)\[\d+\]$/;
                        var checkedIds = [];
                        // Fetch all checked checkboxes with IDs matching the regular expression
                        $('input[type="checkbox"]').filter(function() {
                            return this.id && regex.test(this.id) && this.checked;
                        }).each(function() {
                            var id = $(this).attr('id');
                            checkedIds.push(id); 
                        });

                        const data =  await this.api('POST',this.$authentication+'savePermission',{ids:checkedIds,roleId:this.form.roleId},false,true)

                },

                async getModules(page=1) {

                        const data =  await this.api('POST',this.$authentication+'modules','',false,false)
                            if(data.status===200){
                                this.moduleResult =  data.data
                            }
                },

                async getRoles(page=1) {

                        const data =  await this.api('POST',this.$authentication+'roles','',false,false)
                            if(data.status===200){
                                this.roleResult =  data.data
                            }
                },

                async adminPermission(roleId){

                    !this.isButtonHidden;

                    this.resetAllCheckBoxs();

                    const data =  await this.api('POST',this.$authentication+'fetchPermisison',{roleId:roleId},false,false)
                            if(data.status===200){

                                this.adminPermissonResult =  data.data

                                for (const permission of this.adminPermissonResult) {
                                    const checkbox = document.getElementById(`${permission.action}[${permission.moduleId}]`)
                                    if (checkbox) {
                                        checkbox.checked = true
                                    }
                                }
                            }
                },

                checkallcreate(moduleid) {
                    var checked_status = $('#checkAllcreate'+moduleid).prop('checked');
                    $('.create'+moduleid).each(function() {
                        $(this).prop('checked', checked_status);
                    });
                },

                checkallread(moduleid) {
                    var checked_status = $('#checkAllread'+moduleid).prop('checked');
                    $('.read'+moduleid).each(function() {
                        $(this).prop('checked', checked_status);
                    });
                },

                checkallupdate(moduleid) {
                    var checked_status = $('#checkAllupdate'+moduleid).prop('checked');
                    $('.update'+moduleid).each(function() {
                        $(this).prop('checked', checked_status);
                    });
                },

                checkalldelete(moduleid) {
                    var checked_status = $('#checkAlldelete'+moduleid).prop('checked');
                    $('.delete'+moduleid).each(function() {
                        $(this).prop('checked', checked_status);
                    });
                },

                resetAllCheckBoxs(){
                    const checkboxes = document.querySelectorAll('input[type="checkbox"]')
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = false
                        })
                }

            }
        }


</script>



<style>

    th,td{
        text-align: center;
        font-size: 15px;
        }
    .input-color{
            background-color: aquamarine;
        }
    .modal-header{
            background-color: #c5c5c5;
        }
    .modal-body{
            background-color: #c7c7c794;
        }
    .col-form-label{
        font-size: 15px !important;
    }
    .imagePreviewWrapper {
            width: 250px;
            height: 250px;
            display: block;
            cursor: pointer;
            margin: 0 auto 30px;
            background-size: cover;
            background-position: center center;
        }

    .select2-large .select2-selection__rendered {
        font-size: 16px;
        height: 70px !important;
    }
        
</style>