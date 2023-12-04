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
                                                <h4 class="card-title">{{page}} Management</h4>
                                            </div>
                                            <div class="col-md-1">
                                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" v-if="this.hasActionPermission(5,'create')" data-toggle="modal" data-target=".bs-example-modal-lg">Add</button> -->
                                            </div>
                                        </div>
                                        <div >
                                        </div>
                                    </div>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                        <tr>
                                            <th >S.no</th>
                                            <th>Reviews</th>
                                            <th>Rate</th>
                                            <th>User</th>
                                            <th>Service</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in result" :key="index">
                                                <td >{{index+1}}</td>
                                                <td>{{item.comment}}</td>
                                                <td>{{item.stars}}</td>
                                                <td>{{item.user}}</td>
                                                <td>{{ item.category }}</td>
                                                <td>{{ new Date(item.comment_at).toLocaleDateString('en-US', {day: 'numeric', month: 'short', year: 'numeric'}) }}</td>
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
    
    


<div class="modal fade job_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Job Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-1 col-form-label">Title</label>
                            <div class="col-md-7">
                                <span class="form-control input-color">{{ jobForm.title }}</span>
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Status</label>
                            <div class="col-md-3">
                                <span class="form-control input-color">{{ jobForm.status }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-1 col-form-label">Category</label>
                            <div class="col-md-5">
                                <span class="form-control input-color">{{ jobForm.category_title }}</span>
                            </div>

                            <label for="example-text-input" class="col-md-2 col-form-label">Sub Category</label>
                            <div class="col-md-4">
                                <span class="form-control input-color">{{ jobForm.sub_category_title }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-1 col-form-label">Name</label>
                            <div class="col-md-3">
                                <span class="form-control input-color">{{ jobForm.name }}</span>
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Email</label>
                            <div class="col-md-3">
                                <span class="form-control input-color">{{ jobForm.email }}</span>
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Phone</label>
                            <div class="col-md-3">
                                <span class="form-control input-color">{{ jobForm.phone }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-1 col-form-label">City</label>
                            <div class="col-md-11">
                                <span class="form-control input-color">{{ jobForm.city }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-1 col-form-label">Address</label>
                            <div class="col-md-11">
                                <span class="form-control input-color">{{ jobForm.address }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-1 col-form-label">Date</label>
                            <div class="col-md-5">
                                <span class="form-control input-color">{{ jobForm.date }}</span>
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Time</label>
                            <div class="col-md-5">
                                <span class="form-control input-color">{{ jobForm.time }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Description</label>
                            <div class="col-md-11">
                                <textarea class="form-control input-color" rows="5"  column="5" readonly>  {{ jobForm.description }}</textarea>
                            </div>
                        </div>


                </div>
            </div>
        </div>
    </div>


<!--Add Model start-->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Add Rating</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="ratingForm.comment_given_by" >
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Job ID</label>
                            <div class="col-md-5">
                                <input class="form-control" type="number" v-model="ratingForm.job_id"  >
                            </div>
                            <div class="col-md-5">
                                <button class="btn btn-success">Fetch</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Job Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" readonly  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Provider ID</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" v-model="ratingForm.provider_id"  >
                                
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Stars</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" v-model="ratingForm.stars">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Comment</label>
                            <div class="col-md-10">
                               <textarea class="form-control" rows="5" v-model="ratingForm.comment"></textarea>
                            </div>
                        </div>
                        
                        <div style="float:right">
                            <button type="submit"  v-on:click="saveRating"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<!--Add Model end-->


</template>
<script>

    import Header from '../../layout/common/Header.vue';
    import Sidebar from '../../layout/common/Sidebar.vue';
    import Footer from '../../layout/common/Footer.vue';

    export default {
        props: ['page'],

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

        created() {
                this.getResult(),
                this.hasModulePermission(5);
            },

        data() {

                return {
                    form: {
                        status:'',
                    },
                    jobForm: {
                        job_id:'',
                        title:'',
                        name:'',
                        email:'',
                        phone:'',
                        category_title:'',
                        sub_category_title:'',
                        address:'',
                        city:'',
                        date:'',
                        time:'',
                        description:'',
                    },
                    ratingForm: {
                        job_id:'',
                        provider_id:'',
                        stars:'',
                        comment:'',
                        comment_given_by:'admin',
                    },
                  
                    result:[]
                }
            },

        methods: {

                async getResult(page=1) {

                        const data =  await this.api('POST',this.$service+'ratings',this.form,false,false)
                            if(data.status===200){
                                this.result =  data.data
                            }
                },
                async showJobModal(id){

                        const data =  await this.api('POST',this.$service+'single_job',{job_id:id},false,false)
                            if(data.status===200){
                                $('.job_model').modal('show')
                                this.res =  data.data[0]
                                this.jobForm.job_id= this.res.id;
                                this.jobForm.title= this.res.title;
                                this.jobForm.name= this.res.name;
                                this.jobForm.email= this.res.email;
                                this.jobForm.phone= this.res.phone;
                                this.jobForm.category_title= this.res.category_title;
                                this.jobForm.sub_category_title= this.res.sub_category_title;
                                this.jobForm.city= this.res.city;
                                this.jobForm.address= this.res.address;
                                this.jobForm.date= this.res.date;
                                this.jobForm.time= this.res.time;
                                this.jobForm.description= this.res.description;
                                this.jobForm.status= this.res.status;

                            }
                },
                async saveRating() {

                    const data =  await this.api('POST',this.$service+'save_rating',this.ratingForm,false,true)

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

      
</style>