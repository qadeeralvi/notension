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
                                <h4 class="mb-0 font-size-18">{{ page }} List</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">{{ page }} List</li>
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
                                                <button @click="exportToExcel()" class="btn btn-success">Export to Excel</button>&nbsp
                                                <button @click="exportToPDF()" class="btn btn-success">Export to PDF</button>&nbsp
                                                <button @click="print()" class="btn btn-success">Print</button>&nbsp
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" v-if="this.hasActionPermission(9,'create')" class="btn btn-primary waves-effect waves-light" @click="addModal()">Add</button>
                                            </div>
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
                                                    <input class="form-control" type="text" v-model="emailSearch" placeholder="Search by Email...">
                                                </th>
                                                
                                                <th>
                                                    <input class="form-control" type="text" v-model="phoneSearch" placeholder="Search by Phone...">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="locationSearch" placeholder="Search by Location...">
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                        <select class="form-control" v-model="statusSearch">
                                                            <option value="">All</option>
                                                            <option value="active">Active</option>
                                                            <option value="inactive">InActive</option>
                                                            <option value="Suspend">Suspend</option>
                                                        </select>
                                                </th>
                                            </tr>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Location</th>
                                            <th>Role</th>
                                            <th>Date of Joining</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in filteredResult" :key="index">
                                                <td>{{index+1}}</td>
                                                <td>{{item.name}}</td>
                                                <td>{{item.email}}</td>
                                                <td>{{item.phone}}</td>
                                                <td>{{item.location}}</td>
                                                <td v-if="item.role">{{item.role.name}}</td>
                                                <td v-else>-</td>
                                                <td>{{ formatDate(item.created_at) }}</td>
                                                <td class="toCapitalFirst" ><span :class="getStatusClass(item.status)" @click="statusModel(item.status,item.id)" v-if="this.hasActionPermission(9,'update')">{{item.status}}</span></td>
                                                <td style="display:flex; justify-content: space-around; align-items: center;">
                                                        <button style="margin-right: 2px;" class="btn btn-warning btn-sm" v-if="this.hasActionPermission(9,'update')" @click="fetchInfo(item.id)"><i class="bx bx-edit"></i></button>
                                                        <button style="margin-left: 2px;" class="btn btn-danger btn-sm" @click="delete_id(item.id)" v-if="this.hasActionPermission(9,'delete')"><i class="bx bx-bx bx-trash"></i></button>
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
<!--Add StatusModel start-->

<div class="modal fade status_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">{{ page }} Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="adminId">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <select class="form-control" v-model="adminStatus" @change="statusValue">
                                    <option value="active">Active</option>
                                    <option value="block">Block</option>
                                </select>
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

<!--Add Status Model end-->

<!--Add Model start-->

<div class="modal fade addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Add {{ page }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" required v-model="v$.form.name.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" required v-model="v$.form.email.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Phone</label>
                            <div class="col-md-10">
                                <input class="form-control phone"  type="text" required v-model="v$.form.phone.$model" placeholder="3000000000">
                                <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Location</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" required v-model="v$.form.location.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.location.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>     
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <input class="form-control" type="password" required v-model="v$.form.password.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Role</label>
                            <div class="col-md-10">
                                <select class="form-control"  required v-model="v$.form.role.$model">
                                    <option v-for="(item,index) in roleResult" :key="index" :value="item.id">{{ item.name }}</option>
                                </select>

                                <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
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

<!--Add Model end-->

<!--Update Model start-->

<div class="modal fade updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Update {{ page }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="updateForm.signupmethod">
                        <input type="hidden" v-model="updateForm.adminId">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" required v-model="v$.updateForm.name.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.name.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" required v-model="v$.updateForm.email.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.email.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <label for="example-text-input" class="col-md-2 col-form-label">Phone</label>
                            <div class="col-md-10">
                                <input class="form-control phone" type="text" required v-model="v$.updateForm.phone_no.$model" placeholder="+923000000000">
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.phone_no.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <label for="example-text-input" class="col-md-2 col-form-label">Location</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"  v-model="v$.updateForm.location.$model" autocomplete="off" placeholder="Enter Location">
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.location.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Role</label>
                            <div class="col-md-10">
                                <select class="form-control"  required v-model="v$.updateForm.role.$model">
                                    <option v-for="(item,index) in roleResult" :key="index" :value="item.id">{{ item.name }}</option>
                                </select>

                                <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>
                        

                        <div style="float:right">
                            <button type="submit"  v-on:click="updateSave"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<!--Update Model end-->


</template>
<script>

    import useVuelidate from '@vuelidate/core'
    import { required, minLength,maxLength,email,sameAs   } from '@vuelidate/validators'

    import Header from '../../layout/common/Header.vue';
    import Sidebar from '../../layout/common/Sidebar.vue';
    import Footer from '../../layout/common/Footer.vue';
    import * as XLSX from 'xlsx';
    import * as FileSaver from 'file-saver';
    import jsPDF from 'jspdf';
    import 'jspdf-autotable';

    export default {

        props: ['page'],
        setup () {
                return { v$: useVuelidate() }
        },

        mounted(){

            const phoneInputFields = document.querySelectorAll(".phone");
                phoneInputFields.forEach(phoneInputField => {
                window.intlTelInput(phoneInputField, {
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                    initialCountry: "pk",
                });
                });

                let elements = document.querySelectorAll('.iti--allow-dropdown');
                elements.forEach(element => {
                    element.style.display = 'block';
                });

        },

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

        created() {
                this.getResult()
                this.fetchRoles()
                this.hasModulePermission(9);
            },

        computed: {
                    filteredResult() {
                            const filteredCats = this.result.filter(res => {
                                const nameMatch = res.name.toLowerCase().includes(this.nameSearch.toLowerCase());
                                const emailMatch = res.email.toLowerCase().includes(this.emailSearch.toLowerCase());
                                const phoneMatch = res.phone.toLowerCase().includes(this.phoneSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                const locationMatch = res.location.toLowerCase().includes(this.locationSearch.toLowerCase());
                                return nameMatch && emailMatch && phoneMatch && statusMatch && locationMatch;
                            });
                            return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },

                    pageCount() {
                            const filteredCats = this.result.filter(res => {
                                const nameMatch = res.name.toLowerCase().includes(this.nameSearch.toLowerCase());
                                const emailMatch = res.email.toLowerCase().includes(this.emailSearch.toLowerCase());
                                const phoneMatch = res.phone.toLowerCase().includes(this.phoneSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                const locationMatch = res.location.toLowerCase().includes(this.locationSearch.toLowerCase());
                                return nameMatch && emailMatch  && phoneMatch && statusMatch && locationMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);
                    },

                },

        data() {

                return {

                    nameSearch:'',
                    emailSearch:'',
                    phoneSearch:'',
                    statusSearch:'',
                    locationSearch:'',
                    currentPage: 1,
                    pageSize: 10,
                    form: {
                        name: '',
                        email:'',
                        password:'',
                        phone:'',
                        location:'',
                        role:'',
                    },
                    updateForm: {
                            adminId: '',
                            name: '',
                            email:'',
                            phone_no:'',
                            location:'',
                            role:'',
                            
                        },
                    adminStatus:'',
                    adminId:'',
                    result:[],
                    roleResult:[]
                }
            },
        validations() {
                    return {
                        form: {
                            name: {
                                required 
                            },
                            email: {
                                required ,
                                email
                            },
                            password: {
                                required 
                            },
                            phone: {
                                required,
                                minLength: minLength(10),
                                maxLength: maxLength(11),
                            },
                            location: {
                                required 
                            },
                            role: {
                                required 
                            },
                        },
                        updateForm: {
                            
                            name: {
                                required 
                            },
                            email: {
                                required ,
                                email
                            },
                            phone_no: {
                                required,
                                minLength: minLength(10),
                                maxLength: maxLength(11),
                            },
                            location: {
                                required 
                            },
                            role: {
                                required 
                            },
                        }
                    }
                },

        methods: {
                async getResult(page=1) {
                        const data =  await this.api('POST',this.$authentication+'admins',this.form,false,false)
                        if(data.status===200){
                            this.result =  data.data
                        }
                },

                async save() {
                    const data =  await this.api('POST',this.$authentication+'saveAdmin',this.form,true,true)
                    if(data.status===200){
                        $('.addModal').modal('hide')
                        this.getResult();
                    }
                    else{
                            swal("Oops!", response.data, "error");
                        }
                    
                },

                async saveStatus(page=1) {
                        const data =  await this.api('POST',this.$authentication+'changeAdminStatus',{status:this.adminStatus,id:this.adminId},true,true)
                        $('.status_model').modal('hide')
                        this.getResult();
                },

                async updateSave(page=1) {

                    const data =  await this.api('POST',this.$authentication+'admin_update',{
                            adminId:this.updateForm.adminId,
                            name:this.updateForm.name,
                            email:this.updateForm.email,
                            phone:this.updateForm.phone_no,
                            location:this.updateForm.location,
                            role:this.updateForm.role,
                        },true,true)

                    if(data.status===200){
                        $('.updateModal').modal('hide');
                        this.getResult();
                    }
                    },

                addModal(){
                    $('.addModal').modal('show');
                },

                async fetchInfo(id) {
                        const data = await this.api('POST',this.$authentication+'admin_info',{adminId:id},false,false)
                        if(data.status===200){
                                $('.updateModal').modal('show');
                            this.updateForm.adminId = data.data.id;
                            this.updateForm.name = data.data.name;
                            this.updateForm.email = data.data.email;
                            this.updateForm.phone_no = data.data.phone;
                            this.updateForm.location = data.data.location;
                            this.updateForm.role = data.data.role.id;
                        }
                },


                async fetchRoles(page=1) {
                        const data =  await this.api('POST',this.$authentication+'roles','')
                        if(data.status===200){
                            this.roleResult =  data.data
                        }
                },

                async  delete_id(id) {
                        const data1 = {
                            id: id
                        }
                        const data =  await this.api('POST',this.$authentication+'delete_provider',data1,false,true)
                        if(data.status===200){
                            
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                },

                getStatusClass(status) {
                        if (status === 'block') return 'btn btn-danger'
                        if (status === 'active') return 'btn btn-success'
                        return 'btn btn-info'
                },

                statusModel(status,id){
                    $('.status_model').modal('show')
                    this.adminStatus=status;
                    this.adminId=id;
                },

                formatDate(dateString) {
                    const date = new Date(dateString);
                    const options = { year: 'numeric', month: 'long', day: 'numeric',  timeZone: 'Asia/Karachi' };
                    return date.toLocaleDateString('en-US', options);
                },

                print() {
                        const printContent = document.getElementById('datatable').querySelector('tbody').innerHTML;
                        const popupWin = window.open('', '_blank', '${screen.width},height=600');
                        popupWin.document.open();
                        popupWin.document.write(`
                            <html>
                            <head>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
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
                                    }
                                    th {
                                        background-color: #f7f7f7;
                                    }
                                    .text-center {
                                        text-align: center !important;
                                    }
                                    .bg-success {
                                        background-color: #28a745 !important;
                                    }
                                    .bg-warning {
                                        background-color: #ffc107 !important;
                                    }
                                    .bg-danger {
                                        background-color: #dc3545 !important;
                                    }
                                </style>
                            </head>
                            <table>
                                <thead>
                                    <tr>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Location</th>
                                            <th>Date of Joining</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
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
                exportToExcel() {
                            const filteredData = this.filteredResult;
                            const worksheet = XLSX.utils.json_to_sheet(filteredData);
                            const workbook = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
                            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
                            const excelBlob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8' });
                            FileSaver.saveAs(excelBlob, 'data.xlsx');
                        },
                exportToPDF() {
                        // Define the exportToPDF method
                        const filteredData = this.filteredResult;
                        const pdf = new jsPDF();
                        const columns = ['Name', 'Email', 'Phone Number','Location','Status'];
                        const data = filteredData.map(item => [item.name, item.email,item.phone,item.location,item.status]);
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
        .toCapitalFirst {
            text-transform: capitalize;
        }
</style>