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
                                <h4 class="mb-0 font-size-18">{{page}} 
                                </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">{{page}} </li>
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
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="txtFirstNameBilling" class="col-lg-3 col-form-label">Complaint Type</label>
                                                    <div class="col-lg-3">
                                                        <input   v-model="result[0].complaint_type" readonly  type="text" class="form-control">
                                                    </div>
                                                    <label for="txtLastNameBilling" class="col-lg-4 col-form-label">Complaint Against Type</label>
                                                    <div class="col-lg-2">
                                                        <input v-model="result[0].complaint_against_type" readonly type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="txtLastNameBilling" class="col-lg-2 col-form-label">Status</label>
                                                    <div class="col-lg-3">
                                                        <input v-model="result[0].status" readonly type="text" class="form-control">
                                                    </div>
                                                    <label for="txtLastNameBilling" class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                        <input v-model="result[0].created_at" readonly type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="txtLastNameBilling" class="col-lg-2 col-form-label">Description</label>
                                                    <div class="col-lg-12">
                                                        <textarea  readonly class="form-control" rows="8"> {{ result[0].complaint_detail }}</textarea>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                    </div>

                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Complainer Details</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <label for="txtLastNameBilling" class="col-lg-1 col-form-label">Type</label>
                                                    <div class="col-lg-1">
                                                        <button class="btn btn-success">{{result[0].userType  }}</button>
                                                    </div>
                                                    <label for="txtFirstNameBilling" class="col-lg-1 col-form-label">Name</label>
                                                    <div class="col-lg-2">
                                                        <input   v-model="result[0].complainerDetails.name" readonly  type="text" class="form-control">
                                                    </div>
                                                    <label for="txtLastNameBilling" class="col-lg-1 col-form-label">Email</label>
                                                    <div class="col-lg-2">
                                                        <input v-model="result[0].complainerDetails.email" readonly type="text" class="form-control">
                                                    </div>
                                                    <label for="txtLastNameBilling" class="col-lg-1 col-form-label">Phone</label>
                                                    <div class="col-lg-2">
                                                        <input v-model="result[0].complainerDetails.phone_no" readonly type="text" class="form-control">
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                    </div>

                    <div class="row" v-if="result[0].complainAgainstDetails!=''">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Complaint Against Details</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <label for="txtLastNameBilling" class="col-lg-1 col-form-label">Type</label>
                                                    <div class="col-lg-1">
                                                        <button class="btn btn-success">{{result[0].userAgainstType  }}</button>
                                                    </div>
                                                    <label for="txtFirstNameBilling" class="col-lg-1 col-form-label">Name</label>
                                                    <div class="col-lg-2">
                                                        <input   v-model="result[0].complainAgainstDetails.name" readonly  type="text" class="form-control">
                                                    </div>
                                                    <label for="txtLastNameBilling" class="col-lg-1 col-form-label">Email</label>
                                                    <div class="col-lg-2">
                                                        <input v-model="result[0].complainAgainstDetails.email" readonly type="text" class="form-control">
                                                    </div>
                                                    <label for="txtLastNameBilling" class="col-lg-1 col-form-label">Phone</label>
                                                    <div class="col-lg-2">
                                                        <input v-model="result[0].complainAgainstDetails.phone_no" readonly type="text" class="form-control">
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
        props: ['page','img_url'],

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
                        complain_id: this.$route.params.id,
                    },
                    result:{}
                };
            },

        methods: {
            async getResult(page=1) {

                    const data =  await this.api('POST',this.$chat+'single_complain',this.form,false,false)
                    if(data.status===200){
                            this.result =  data.data
                    }
                },

            async save_job() {

                    const data =  await this.api('POST',this.$chat+'status_update',this.form,false,true)

                    if(data.status===200){

                    this.$router.push({name:"JobList"});
                    
                    }
                },
                    
            }
    }
</script>
<style lang="">
    
</style>