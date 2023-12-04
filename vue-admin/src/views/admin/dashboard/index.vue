<template >
<body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <Header></Header>
            <Sidebar></Sidebar>


        <div class="main-content">

                        <div class="page-content">
                            <div class="container-fluid">

                                <!-- start page title -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="page-title-box d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0 font-size-18">Dashboard</h4>

                                            <div class="page-title-right">
                                                <ol class="breadcrumb m-0">
                                                    <li class="breadcrumb-item active">Welcome to Dashboard</li>
                                                </ol>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end page title -->

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Jobs</p>
                                                                <h4 class="mb-0">{{ jobCount }}</h4>
                                                            </div>

                                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                                <span class="avatar-title">
                                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Active Jobs</p>
                                                                <h4 class="mb-0">{{ activeJobCount }}</h4>
                                                            </div>

                                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                                <span class="avatar-title">
                                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Pending Jobs</p>
                                                                <h4 class="mb-0">{{ pendingJobCount }}</h4>
                                                            </div>

                                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                                <span class="avatar-title">
                                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Revenue</p>
                                                                <h4 class="mb-0">Rs{{ totalPayment }}</h4>
                                                            </div>

                                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                                <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="bx bx-archive-in font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Average Price</p>
                                                                <h4 class="mb-0">Rs5</h4>
                                                            </div>

                                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                                <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Total Provider</p>
                                                                <h4 class="mb-0">{{ total_provider }}</h4>
                                                            </div>

                                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                                <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="fa fa-users font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Active Provider</p>
                                                                <h4 class="mb-0">{{ provider_active }}</h4>
                                                            </div>

                                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                                <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="fa fa-users font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Active inactive</p>
                                                                <h4 class="mb-0">{{ provider_inactive }}</h4>
                                                            </div>

                                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                                <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="fa fa-users font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Total Admin</p>
                                                                <h4 class="mb-0">{{ total_admin }}</h4>
                                                            </div>

                                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                                <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="fa fa-users font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="card mini-stats-wid">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p class="text-muted font-weight-medium">Total User</p>
                                                                <h4 class="mb-0">{{ total_user }}</h4>
                                                            </div>

                                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                                <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="fa fa-users font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">Latest Transaction</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-centered table-nowrap mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th >S.no</th>
                                                                <th>Provider Name</th>
                                                                <th>Payment Type</th>
                                                                <th>Reference ID </th>
                                                                <th>Account Title</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Image</th>
                                                                <th >Status</th>
                                                                <th >Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(item,index) in result" :key="index">
                                                                <td >{{index+1}}</td>
                                                                <td>{{item.provider_name}}</td>
                                                                <td>{{item.payment_type}}</td>
                                                                <td>{{item.reference_id}}</td>
                                                                <td>{{item.account_title}}</td>
                                                                <td>{{item.amount}}</td>
                                                                <td>{{item.date}}</td>
                                                                <td>{{item.time}}</td>
                                                                <td @click="showImage('https://payment.notension.pk/images/' + item.image,item.reference_id)"><img  v-bind:src="'https://payment.notension.pk/images/' + item.image" width="150" height="150" alt="no"/></td>
                                                                <td ><span :class="getStatusClass(item.status)">{{item.status}}</span></td>
                                                                <td >
                                                                    <button type="button"  @click="showPaymentModal(item.status,item.id)" v-if="this.hasActionPermission(12,'update')" class="btn btn-info btn-sm waves-effect waves-light"  ><i class="bx bx-bullseye"></i></button>
                                                                </td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end table-responsive -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- container-fluid -->
                        </div>


                        <Footer></Footer>
            </div>
             </div>
             </body> 
       <!--Add Model start-->

<div class="modal fade detail_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">{{ page }} Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color:#e5e5e594 !important;">
                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="form.payment_id">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-2">
                                <select class="form-control" v-model="form.status">
                                    <option value="pending">Pending</option>
                                    <option value="accept">Accept</option>
                                    <option value="reject">Reject</option>
                                </select>
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Amount</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" v-model="form.amount">
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Ref ID</label>
                            <div class="col-md-3">
                                <span class="form-control readonly-color">{{ form.ref }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Account Title</label>
                            <div class="col-md-3">
                               <span class="form-control readonly-color">{{  form.account_title }}  </span> 
                            </div>

                            <label for="example-text-input" class="col-md-2 col-form-label">Payment Type</label>
                            <div class="col-md-3">
                                <span class="form-control readonly-color">{{  form.payment_type }}  </span> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Date</label>
                            <div class="col-md-3">
                                <span class="form-control readonly-color">{{  form.date }}  </span> 
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Time</label>
                            <div class="col-md-3">
                                <span class="form-control readonly-color">{{  form.time }}  </span> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Note</label>
                            <div class="col-md-10">
                                <textarea name="" id="" cols="90" rows="5" v-model="form.note"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Image</label>
                            <div class="col-md-10">
                                <img v-bind:src="'https://payment.notension.pk/images/' + form.image" width="300" height="300">
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

<!--Add Model end-->

<!--Add Image Model start-->

<div class="modal fade img_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel"> Reference no ={{ref}}</h5>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <img v-bind:src="url" width="760" height="500">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

<!--Add Image Model end-->

        
</template>

<script>

    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';
    import Footer from '../layout/common/Footer.vue';

    export default {
        props: ['page'],

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

        created() {
                this.getResult()
                this.getJob()
                this.getCounter()
            },

        data() {

                return {
                    form: {
                        status:'',
                        payment_id: '',
                        account_title:'',
                        payment_type:'',
                        amount:'',
                        note:'',
                        date:'',
                        time:'',
                        note:'',
                    },
                   
                    jobCount:0,
                    activeJobCount:0,
                    pendingJobCount:0,
                    totalPayment:'',
                    ref: '',
                    url: '',
                    result:[],
                    total_provider:'',
                    provider_active:'',
                    provider_inactive:'',
                    provider_suspended:'',
                    total_user:'',
                    total_admin:'',
                }
            },

        methods: {

                async getResult(page = 1) {
                            try {

                                const data = await this.api('POST', this.$payment + 'payments', this.form, false, false);
                                if (data.status === 200) {

                                    this.result = data.data;
                                    let totalPayment = 0;

                                    for (const entry of this.result) {
                                        if(entry.status=='accept'){
                                            const amount = Number(entry.amount);
                                            if (!isNaN(amount)) {
                                                totalPayment += amount;
                                            }
                                        }
                                    }
                                    this.totalPayment = totalPayment;
                                } 

                            } catch (error) {
                                console.error('Failed to fetch payments:', error);
                            }
                        },

                    async getJob(page = 1) {
                                try {
                                        const data = await this.api('POST', this.$service + 'all_job_list', '', false, false);
                                        if (data.status === 200) {
                                            this.jobs = data.data;
                                            let  jobCount = this.jobs.length;
                                            this.jobCount = jobCount;
                                            const active = data.data.filter(res => res.status.toLowerCase() === 'active'.toLowerCase());
                                            this.activeJobCount = active.length;
                                            const pending = data.data.filter(res => res.status.toLowerCase() === 'pending'.toLowerCase());
                                            this.pendingJobCount = pending.length;
                                        } else {
                                            console.error('Failed to fetch jobs:', data.status);
                                        }

                                    } catch (error) {
                                        console.error('Failed to fetch jobs:', error);
                                    }
                            },


                        async getCounter(page = 1) {
                                try {
                                        const data = await this.api('POST', this.$authentication + 'fetchCounter', '', false, false);
                                        if (data.status === 200) {
                                            this.count = data.data;
                                            console.log(this.count[0][0])
                                            this.total_provider = this.count[0].total_provider;
                                            this.provider_active = this.count[0].provider_active;
                                            this.provider_inactive = this.count[0].provider_inactive;
                                            this.provider_suspended = this.count[0].provider_suspended;
                                            this.total_user = this.count[0].total_user;
                                            this.total_admin = this.count[0].total_admin;
                                        } else {
                                            console.error('Failed to fetch jobs:', data.status);
                                        }

                                    } catch (error) {
                                        console.error('Failed to fetch jobs:', error);
                                    }
                            },


                async saveStatus(page=1) {
                        const data =  await this.api('POST',this.$payment+'change_status',this.form,true,true)
                        location.reload();
                    },

                getStatusClass(status) {
                        if (status === 'pending') return 'btn btn-info'
                        if (status === 'accept') return 'btn btn-success'
                        return 'btn btn-danger'
                    },

                async showPaymentModal(status,id){

                        const data =  await this.api('POST',this.$payment+'single_payment',{id:id},false,false)
                            if(data.status===200){
                                $('.detail_model').modal('show')
                                this.res =  data.data
                                this.form.status=status;
                                this.form.payment_id= this.res.id;
                                this.form.note= this.res.note;
                                this.form.account_title= this.res.account_title;
                                this.form.amount= this.res.amount;
                                this.form.payment_type= this.res.payment_type;
                                this.form.ref= this.res.reference_id;
                                this.form.date= this.res.date;
                                this.form.time= this.res.time;
                                this.form.image= this.res.image;
                            }
                    },

                showImage(url,ref){
                        $('.img_model').modal('show')
                        this.url=url;
                        this.ref=ref;
                    }

            }
        }
</script>


<style>
.readonly-color{
    background-color: #c5c5c5;
}

.modal.body{
    background-color: #e5e5e594;
}
</style>