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
                                                <button @click="this.exportToExcel()" class="btn btn-success">Export to Excel</button>&nbsp
                                                <button @click="this.exportToPDF()" class="btn btn-success">Export to PDF</button>&nbsp
                                                <button @click="this.print()" class="btn btn-success">Print</button>&nbsp
                                            </div>
                                            <div class="col-md-1">
                                            </div>
                                        </div>
                                        <div >
                                        </div>
                                    </div>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="nameSearch" placeholder="Search by Name...">
                                                </th>
                                                <th>
                                                        <select class="form-control" v-model="typeSearch">
                                                            <option value="">All</option>
                                                            <option value="bank">bank</option>
                                                            <option value="jazzcash">Jazzcash</option>
                                                            <option value="easyPaisa">EasyPaisa</option>
                                                        </select>
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="referenceSearch" placeholder="Search by Reference ID...">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="accountTitleSearch" placeholder="Search by Accout Title...">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="amountSearch" placeholder="Search by Amount...">
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                        <select class="form-control" v-model="statusSearch">
                                                            <option value="">All</option>
                                                            <option value="pending">Pending</option>
                                                            <option value="accept">Accept</option>
                                                        </select>
                                                </th>
                                            </tr>
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

                                            <tr v-for="(item,index) in filteredResult" :key="index">
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
                                                <td v-if="this.hasActionPermission(12,'update')">
                                                    <button type="button"  @click="showPaymentModal(item.status,item.id)"  class="btn btn-info btn-sm waves-effect waves-light"  ><i class="bx bx-bullseye"></i></button>
                                                </td>
                                                <td v-else>
                                                    <button type="button" class="btn btn-info btn-sm waves-effect waves-light"  ><i class="bx bx-bullseye"></i></button>
                                                </td>
                                                
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
                <div class="modal-body">
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
                                <span class="form-control input-color">{{ form.ref }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Account Title</label>
                            <div class="col-md-3">
                               <span class="form-control input-color">{{  form.account_title }}  </span> 
                            </div>

                            <label for="example-text-input" class="col-md-2 col-form-label">Payment Type</label>
                            <div class="col-md-3">
                                <span class="form-control input-color">{{  form.payment_type }}  </span> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Date</label>
                            <div class="col-md-3">
                                <span class="form-control input-color">{{  form.date }}  </span> 
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Time</label>
                            <div class="col-md-3">
                                <span class="form-control input-color">{{  form.time }}  </span> 
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
                this.hasParentPermission(12);
            },

        computed: {
                    filteredResult() {
                            const filteredCats = this.result.filter(res => {
                                const nameMatch = res.provider_name.toLowerCase().includes(this.nameSearch.toLowerCase());
                                const typeMatch = res.payment_type.toLowerCase().includes(this.typeSearch.toLowerCase());
                                const referenceMatch = res.reference_id.toLowerCase().includes(this.referenceSearch.toLowerCase());
                                const titleMatch = res.account_title.toLowerCase().includes(this.accountTitleSearch.toLowerCase());
                                const amountMatch = res.amount.toLowerCase().includes(this.amountSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return nameMatch && typeMatch && referenceMatch && titleMatch && amountMatch && statusMatch;
                            });
                            return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },

                    pageCount() {
                            const filteredCats = this.result.filter(res => {
                                const nameMatch = res.provider_name.toLowerCase().includes(this.nameSearch.toLowerCase());
                                const typeMatch = res.payment_type.toLowerCase().includes(this.typeSearch.toLowerCase());
                                const referenceMatch = res.reference_id.toLowerCase().includes(this.referenceSearch.toLowerCase());
                                const titleMatch = res.account_title.toLowerCase().includes(this.accountTitleSearch.toLowerCase());
                                const amountMatch = res.amount.toLowerCase().includes(this.amountSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return nameMatch && typeMatch && referenceMatch && titleMatch && amountMatch && statusMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);
                    },

                },

        data() {

                return {
                    nameSearch:'',
                    typeSearch:'',
                    referenceSearch:'',
                    accountTitleSearch:'',
                    amountSearch:'',
                    statusSearch:'',
                    currentPage: 1,
                    pageSize: 10,

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
                   
                    ref: '',
                    url: '',
                    result:[]
                }
            },

        methods: {

                async getResult(page=1) {
                        
                        const data =  await this.api('POST',this.$payment+'payments',this.form,false,false)
                            if(data.status===200){
                                this.isLoggedIn = localStorage.getItem('admin_info');
                                const admin = JSON.parse(this.isLoggedIn);  
                                if(admin.id!=1){
                                this.result = data.data.filter(res => res.provider_location.toLowerCase() === admin.location.toLowerCase());
                                }
                                else{
                                    this.result = data.data;
                                }
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
                },
                print() {
                        const printContent = document.getElementById('datatable').querySelector('tbody').innerHTML;
                        const popupWin = window.open('', '_blank', '${screen.width},height=600');
                        popupWin.document.open();
                        popupWin.document.write(`
                            <html>
                            <head>
                                <style>
                                    /* Custom styles for the printed table */
                                    table {
                                        font-size: 12px;
                                        margin: 0 auto;
                                        width: 100%;
                                        border-collapse: collapse;
                                    }
                                    th, td {
                                        padding: 0.5rem;
                                        text-align: left;
                                        border: 1px solid #dee2e6;
                                        text-align: center !important;
                                    }
                                   
                                </style>
                            </head>
                            <table>
                                <thead>
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
                                    </tr>
                                </thead>
                                <body>
                                    ${printContent}
                                </body>
                            </table>
                            </html>
                        `);
                        popupWin.document.close();
                        popupWin.focus();
                        popupWin.print();
                        popupWin.close();
                    },

               

                exportToPDF() {
                        // Define the exportToPDF method
                        const filteredData = this.filteredResult;
                        const pdf = new jsPDF();
                        const columns = ['Provider Name', 'Provider Type', 'Reference ID', 'Account Title','Amount', 'Date','Time','Status'];
                        const data = filteredData.map(item => [item.provider_name, item.payment_type, item.reference_id,item.account_title,item.amount,item.date,item.time, item.status]);
                        pdf.autoTable(columns, data);
                        pdf.save('data.pdf');
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