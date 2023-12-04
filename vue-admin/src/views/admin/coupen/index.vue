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
                                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".addModal">Add</button>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="titleSearch" placeholder="Search by Title...">
                                                </th>
                                               
                                                <th>
                                                    <input class="form-control" type="text" v-model="coupenSearch" placeholder="Search by Coupen...">
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                        <select class="form-control" v-model="statusSearch">
                                                            <option value="">All</option>
                                                            <option value="pending">Pending</option>
                                                            <option value="active">Active</option>
                                                        </select>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th >S.no</th>
                                                <th>Coupen Title</th>
                                                <th>Coupen</th>
                                                <th>Amount</th>
                                                <th>Is Percentage</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,index) in filteredResult" :key="index">
                                                <td >{{index+1}}</td>
                                                <td>{{item.title}}</td>
                                                <td>{{item.code}}</td>
                                                <td>{{item.amount}}</td>
                                                <td v-if="item.isPercentage==1">Yes</td>
                                                <td v-else>No</td>
                                                <td>{{item.start_date}}</td>
                                                <td>{{item.end_date}}</td>
                                                <td ><span :class="getStatusClass(item.status)" v-if="this.hasActionPermission(19,'read')" @click="showStatus(item.status,item.id)">{{item.status}}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div style="display: flex; align-items: center;">
                                        <button class="btn btn-success" :disabled="currentPage === 1" @click="currentPage--">Prev</button>
                                        <div v-for="page in pageCount" :key="page" style="margin: 0 5px;">
                                        <button class="btn btn-info"
                                            @click="currentPage = page"
                                            :class="{ 'selected': currentPage === page }"
                                        >
                                            {{ page }}
                                        </button>
                                        </div>
                                        <button class="btn btn-success" :disabled="currentPage === pageCount" @click="currentPage++">Next</button>
                                    </div>

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
                           
                            <label for="example-text-input" class="col-md-2 col-form-label">Coupen Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" v-model="v$.form.title.$model" required/>
                                <div class="input-errors" v-for="(error, index) of v$.form.title.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Coupen</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" v-model="v$.form.code.$model" required/>
                                <div class="input-errors" v-for="(error, index) of v$.form.code.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="example-text-input" class="col-md-2 col-form-label">Start Date</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" v-model="v$.form.start_date.$model" required/>
                                <div class="input-errors" v-for="(error, index) of v$.form.start_date.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <label for="example-text-input" class="col-md-2 col-form-label">End Date</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" v-model="form.end_date"/>
                            </div>
                            
                        </div>

                        <div class="form-group row">


                            <label for="example-text-input" class="col-md-2 col-form-label">Is Percentage</label>
                            <div class="col-md-4">
                                <input class="form-control" type="checkbox" @click="checkPercentage($event.target.checked ? 'yes' : '')" v-model="form.isPercentage" required/>
                            </div>

                            <label for="example-text-input" class="col-md-2 col-form-label">{{ amount_type }}</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" v-model="v$.form.amount.$model" @keyup="checkAmount($event.target.value)" :placeholder="amount_lable" required/>
                                <div class="input-errors" v-for="(error, index) of v$.form.amount.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                                <span v-if="amount_greater" class="error-msg">Enter less then 100</span>
                            </div>


                          

                        </div>

                        <!-- <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Category</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <select name="select" class="select form-control" multiple multiselect-search="true" multiselect-select-all="true">
                                        <option v-for="res in catResult" :key="res.name" :value="res.name" >{{ res.name }}</option>
                                    </select>
                                </div>	

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Provider</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <select name="select" class="select form-control" multiple multiselect-search="true" multiselect-select-all="true">
                                        <option v-for="(item,index) in providerResult" :key="index">{{ item.name }}</option>
                                    </select>
                                </div>	

                            </div>
                        </div> -->

                        <div style="float:right">
                            <button type="submit"  :disabled="v$.form.$invalid" v-on:click="save"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Add Modal end-->


    <!--Status Modal start-->

    <div class="modal fade statusModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Status</h5>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="modalStatusID">
                        
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-12">
                                    <select  class="form-control" v-model="modalStatus">
                                        <option value="active">Active</option>
                                        <option value="inactive">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="float:right">
                            <button type="submit"   v-on:click="saveStatus"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Status Modal end-->


</template>
<style>

    .select{
         width:30em;
      }
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
<script>

    import useVuelidate from '@vuelidate/core'
    import { required } from '@vuelidate/validators'
    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';
    import Footer from '../layout/common/Footer.vue';

    export default {

        props: ['page'],

        setup () {
                return { v$: useVuelidate() }
        },

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

            created() {
                    this.getResult()
                    this.getCategory()
                    this.getProvider()
                    this.hasParentPermission(19);
            },

            computed: {
                    filteredResult() {
                            const filteredCats = this.result.filter(res => {
                                const titleMatch = res.title.toLowerCase().includes(this.titleSearch.toLowerCase());
                                const coupenMatch = res.code.toLowerCase().includes(this.coupenSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return titleMatch && coupenMatch && statusMatch;
                            });
                            return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },

                    pageCount() {
                            const filteredCats = this.result.filter(res => {
                                const titleMatch = res.title.toLowerCase().includes(this.titleSearch.toLowerCase());
                                const coupenMatch = res.code.toLowerCase().includes(this.coupenSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return titleMatch && coupenMatch && statusMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);
                    },

                },


            data() {
                        return {

                            titleSearch:'',
                            coupenSearch:'',
                            statusSearch:'',
                            currentPage: 1,
                            pageSize: 10,

                            previewImage: null,
                            amount_type:'Amount',
                            amount_lable:'Rs',
                            amount_greater:false,
                            form: {
                                title: '',
                                code: '',
                                start_date: '',
                                end_date: '',
                                amount: '',
                                isPercentage: '',
                                },
                            modalStatus:'',
                            modalStatusID:'',
                            result:[],
                            catResult:[],
                            providerResult:[],
                        }
                    },  

            validations() {

                        return {

                            form: {

                                title: {required},
                                code: {required},
                                start_date: {required},
                                amount: {required},
                            }
                        }
                    },

        methods: {

                async getResult(page=1) {

                        const data =  await this.api('POST',this.$payment+'coupen',this.form,false,false)
                            if(data.status===200){
                                this.result =  data.data
                            }
                },

                getStatusClass(status) {
                        if (status === 'inactive') return 'btn btn-info'
                        if (status === 'active') return 'btn btn-success'
                        return 'btn btn-danger'
                },
                
                async getCategory(page = 1) {
                    try {
                            const data = await this.api('GET', this.$service + 'category', '', false, false);
                            if (data.status_code === 200) {
                                this.catResult = data.data;
                            }
                        } catch (error) {
                            console.error(error);
                        }
                },

                async getProvider(page = 1) {
                    try {
                            const data = await this.api('POST', this.$authentication + 'provider_list', '', false, false);
                            if (data.status=== 200) {
                                this.providerResult = data.data;
                            }
                        } catch (error) {
                            console.error(error);
                        }
                },

                async save() {

                        const data =  await this.api('POST',this.$payment+'coupenSave',this.form,false,true)
                        if(data.status===200){
                            
                            location.reload();
                        }
                },

                async saveStatus(page=1) {
                        const data =  await this.api('POST',this.$payment+'coupenChangeStatus',this.form,true,true)
                        location.reload();
                },

                showStatus(modalStatus,modalStatusID){
                    $('.statusModal').modal('show')
                    this.modalStatus=modalStatus;
                    this.modalStatusID=modalStatusID;
                },

                checkPercentage(value){
                    if (value === 'yes') {
                        this.amount_type='Percentage';
                        this.amount_lable='%'
                        this.form.amount='';
                    } else {
                        this.amount_type='Amount';
                        this.amount_lable='Rs'
                        this.form.amount='';
                    }
                },

                checkAmount(amount){
                    if(this.amount_type=='Percentage'){
                        if(amount>=100){
                            this.amount_greater=true;
                            this.form.amount='';
                        }else{
                            this.amount_greater=false;
                        }
                    }
               }
            
        }

    }



</script>

