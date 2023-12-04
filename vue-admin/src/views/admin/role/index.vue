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
                                                <button @click="exportToExcel()" class="btn btn-success">Export to Excel</button>&nbsp
                                                <button @click="exportToPDF()" class="btn btn-success">Export to PDF</button>&nbsp
                                                <button @click="print()" class="btn btn-success">Print</button>&nbsp
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary waves-effect waves-light" v-if="this.hasActionPermission(15,'create')" data-toggle="modal" data-target=".addModal">Add</button>
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
                                                        <select class="form-control" v-model="statusSearch">
                                                            <option value="">All</option>
                                                            <option value="active">Active</option>
                                                            <option value="disable">Disable</option>
                                                        </select>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th >S.no</th>
                                                <th>Coupen Title</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,index) in filteredResult" :key="index">
                                                <td >{{index+1}}</td>
                                                <td>{{item.name}}</td>
                                                <td v-if="this.hasActionPermission(15,'update')"><span :class="getStatusClass(item.status)"  @click="showStatus(item.status,item.id)">{{item.status.toUpperCase()}}</span></td>
                                                <td v-else><span :class="getStatusClass(item.status)">{{item.status}}</span></td>
                                                <td><button style="margin-left: 2px;" class="btn btn-warning btn-sm"  @click="fetchRole(item.id)"><i class="bx bx-edit"></i></button></td>
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
                           
                            <label for="example-text-input" class="col-md-2 col-form-label">Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" v-model="form.name" required/>
                            </div>

                        </div>

                        <div style="float:right">
                            <button type="submit" :disabled="v$.form.$invalid" v-on:click="save"  class="btn btn-primary waves-effect waves-light" >Save</button>
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
                                        <option value="disable">Disable</option>
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


     <!--Status Modal start-->

     <div class="modal fade updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Update Role</h5>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="modalStatusID">
                        
                        <div class="form-group row">
                           
                           <label for="example-text-input" class="col-md-2 col-form-label">Title</label>
                           <div class="col-md-10">
                               <input class="form-control" type="text" v-model="updateForm.name" required/>
                           </div>

                        </div>

                        <div style="float:right">
                            <button type="submit"  :disabled="v$.updateForm.$invalid" v-on:click="updateRole"  class="btn btn-primary waves-effect waves-light" >Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Status Modal end-->


</template>
<style>

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
    import * as XLSX from 'xlsx';
    import * as FileSaver from 'file-saver';
    import jsPDF from 'jspdf';
    import 'jspdf-autotable';

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
            },

            computed: {
                    filteredResult() {
                            const filteredCats = this.result.filter(res => {
                                const titleMatch = res.name.toLowerCase().includes(this.titleSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return titleMatch && statusMatch;
                            });
                            return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },

                    pageCount() {
                            const filteredCats = this.result.filter(res => {
                                const titleMatch = res.name.toLowerCase().includes(this.titleSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return titleMatch && statusMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);
                    },

                },


            data() {
                        return {

                            titleSearch:'',
                            statusSearch:'',
                            currentPage: 1,
                            pageSize: 10,

                            previewImage: null,
                            form: {
                                name: '',
                                },
                            updateForm: {
                                name: '',
                                roleId: '',
                                },
                            modalStatus:'',
                            modalStatusID:'',
                            result:[],
                        }
                    },  

            validations() {

                        return {

                            form: {

                                name: {required  },
                            },
                            updateForm: {

                                name: {required },
                            }
                        }
                    },

        methods: {

                async getResult(page=1) {

                        const data =  await this.api('POST',this.$authentication+'roles',this.form,false,false)
                            if(data.status===200){
                                this.result =  data.data
                            }
                },

                getStatusClass(status) {
                        if (status === 'disable') return 'btn btn-danger'
                        if (status === 'active') return 'btn btn-success'
                        return 'btn btn-danger'
                },
                
                async save() {

                        const data =  await this.api('POST',this.$authentication+'roleSave',this.form,false,true)
                        if(data.status===200){
                            
                            location.reload();
                        }
                },

                async fetchRole(id) {
                        const data = await this.api('POST',this.$authentication+'fetchRole',{roleId:id},false,false)
                        if(data.status===200){
                            $('.updateModal').modal('show');
                            this.updateForm.name=data.data.name;
                            this.updateForm.roleId=data.data.id;
                        }
                },


                async updateRole(id) {
                        const data = await this.api('POST',this.$authentication+'updateRole',{name:this.updateForm.name,roleId:this.updateForm.roleId},true,true)
                        if(data.status===200){
                            this.getResult();  
                            $('.updateModal').modal('hide');                     
                        }
                },

                async saveStatus(page=1) {
                        const data =  await this.api('POST',this.$authentication+'changeRoleStatus',{status:this.modalStatus,id:this.modalStatusID},true,true)
                       this.getResult();
                       $('.statusModal').modal('hide')
                },

                showStatus(modalStatus,modalStatusID){
                    $('.statusModal').modal('show')
                    this.modalStatus=modalStatus;
                    this.modalStatusID=modalStatusID;
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
                                        <tr>
                                            <th>S.no</th>
                                            <th>Title</th>
                                            <th>Status</th>
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
                        const columns = ['Title','Status'];
                        const data = filteredData.map(item => [item.name,item.status]);
                        pdf.autoTable(columns, data);
                        pdf.save('data.pdf');
                    },
            }
        }


</script>

