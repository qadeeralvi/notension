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
                                <h4 class="mb-0 font-size-18">Update Job</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Update Job</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>  


                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Update Job Status</h4>
                                            <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtFirstNameBilling" class="col-lg-3 col-form-label">Title</label>
                                                            <div class="col-lg-9">
                                                                <input   v-model="result[0].title"   type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Category</label>
                                                            <div class="col-lg-9">
                                                                <input v-model="result[0].category_title" readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Sub Category</label>
                                                            <div class="col-lg-9">
                                                                <input  v-model="result[0].sub_category_title" readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtFirstNameBilling" class="col-lg-3 col-form-label">Name</label>
                                                            <div class="col-lg-9">
                                                                <input   v-model="result[0].name"  readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Phone</label>
                                                            <div class="col-lg-9">
                                                                <input v-model="result[0].phone" readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Email</label>
                                                            <div class="col-lg-9">
                                                                <input  v-model="result[0].email" readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtFirstNameBilling" class="col-lg-3 col-form-label">City</label>
                                                            <div class="col-lg-9">
                                                                <input   v-model="result[0].city"  readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Address</label>
                                                            <div class="col-lg-9">
                                                                <input v-model="result[0].address" readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Postal Code </label>
                                                            <div class="col-lg-9">
                                                                <input  v-model="result[0].postal_code" readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtFirstNameBilling" class="col-lg-3 col-form-label">Date</label>
                                                            <div class="col-lg-9">
                                                                <input   v-model="result[0].date"  readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Time</label>
                                                            <div class="col-lg-9">
                                                                <input v-model="result[0].time" readonly type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label for="txtLastNameBilling" class="col-lg-1 col-form-label">description </label>
                                                            <div class="col-lg-11">
                                                                <textarea  cols="30" rows="10" class="form-control">{{ result[0].description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </body>
</template>
<script>
    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';
    import Footer from '../layout/common/Footer.vue';

    export default {

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

        created() {
                this.getResult()
            },

        data() {
                return {
                    form: {
                        job_id: this.$route.params.id,
                    },
                    result:{}
                };
            },

        methods: {
            async getResult(page=1) {

                    const data =  await this.api('POST','http://127.0.0.1:8000/api/single_job',this.form,false,false)
                    if(data.status===200){
                            this.result =  data.data
                    }
                },

            async save_job() {

                    const data =  await this.api('POST','http://127.0.0.1:8000/api/status_update',this.form,false,true)

                    if(data.status===200){

                    this.$router.push({name:"JobList"});
                    
                    }
                },
                    
            }
    }
</script>
<style lang="">
    
</style>