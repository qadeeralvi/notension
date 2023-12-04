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
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="card-header mb-2">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <h4 class="card-title">{{ page }} Management</h4>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".addModal" v-if="this.hasActionPermission(18,'create')">Add</button>
                                            </div>
                                        </div>
                                    </div>


                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                        <tr>
                                            <th >S.no</th>
                                            <th>Account Type</th>
                                            <th>Account Title</th>
                                            <th>Account No </th>
                                            <th>Image</th>
                                            <th >Status</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in result" :key="index">
                                                <td >{{index+1}}</td>
                                                <td>{{item.account_type}}</td>
                                                <td>{{item.title}}</td>
                                                <td>{{item.number}}</td>
                                                <td @click="showImage( item.image,item.id)"><img  v-bind:src="item.image" width="150" height="150" alt="no"/></td>
                                                <td ><span :class="getStatusClass(item.status)">{{item.status}}</span></td>
                                                <td >
                                                    <button type="button"  @click="showPaymentModal(item.status,item.id)"  class="btn btn-info btn-sm waves-effect waves-light"  ><i class="bx bx-bullseye"></i></button>
                                                </td>
                                                
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div>
            </div>
        </div>
    </body>
    
<!--Add Image Model start-->

<div class="modal fade addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add {{ page }}</h5>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Account Type</label>
                            <div class="col-md-3">
                                <select class="form-control" v-model="v$.form.account_type.$model">
                                    <option value="easypaisa">Easypaisa</option>
                                    <option value="jazzcash">Jazzcash</option>
                                    <option value="bank">Bank</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Account Title</label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" required v-model="v$.form.title.$model"  >
                                <div class="input-errors" v-for="(error, index) of v$.form.title.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Account No</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" required v-model="v$.form.number.$model"  >
                                <div class="input-errors" v-for="(error, index) of v$.form.number.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Image</label>
                            <div class="col-md-4">
                                <input
                                ref="fileInput"
                                type="file"
                                @input="pickFile" v-on:change="pickFile">
                            </div>
                           
                        </div>
                        <div class="form-group row" v-if!="previewImage">
                            <div class="col-md-4 imagePreviewWrapper"
                                :style="{ 'background-image': `url(${previewImage})` }"
                                @click="selectImage">
                            </div>
                        </div>


                        <div style="float:right">
                            <button type="submit" :disabled="v$.form.$invalid"  v-on:click="save"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<!--Add Image Model end-->


</template>
<script>
    import useVuelidate from '@vuelidate/core'
    import { required } from '@vuelidate/validators'
    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';

    export default {

        setup () {
                return { v$: useVuelidate() }
        },

        components: {

                    Header,
                    Sidebar,
                },

        created() {
                this.getResult()
            },

            data() {
                        return {
                            previewImage: null,
                            form: {
                                account_type: '',
                                title: '',
                                number: '',
                                },
                            result:[],
                        }
                    },  
            validations() {

                        return {

                            form: {

                                account_type: {
                                    required 
                                },
                                title: {
                                    required 
                                },
                                number: {
                                    required 
                                }
                            }
                        }
                    },

        methods: {

                async getResult(page=1) {

                        const data =  await this.api('POST',this.$payment+'accounts',this.form,false,false)
                            if(data.status===200){
                                this.result =  data.data
                            }
                },

                getStatusClass(status) {
                        if (status === 'inactive') return 'btn btn-info'
                        if (status === 'active') return 'btn btn-success'
                        return 'btn btn-danger'
                },
                selectImage () {
                        this.$refs.fileInput.click()
                    },
                pickFile () {
                        let input = this.$refs.fileInput
                        let file = input.files
                        if (file && file[0]) {
                        let reader = new FileReader
                        reader.onload = e => {
                            this.previewImage = e.target.result
                        }
                        reader.readAsDataURL(file[0])
                        this.$emit('input', file[0])
                        }
                    },

                async save() {

                    const data =  await this.api('POST',this.$payment+'saveAccount',this.form,false,true)
                    if(data.status===200){
                        
                        location.reload();
                    }
                    },
            }
        }
</script>
<style >
    .error-msg{
            color:red;
        }

    th,td{
        text-align: center;
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

    .imagePreviewWrapper {
            width: 250px;
            height: 250px;
            display: block;
            cursor: pointer;
            margin: 0 auto 30px;
            background-size: cover;
            background-position: center center;
        }
</style>