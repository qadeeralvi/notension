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
                                                <button @click="exportToExcel()" class="btn btn-success">Export to Excel</button>&nbsp
                                                <button @click="exportToPDF()" class="btn btn-success">Export to PDF</button>&nbsp
                                                <button @click="print()" class="btn btn-success">Print</button>&nbsp
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
                                                    <input class="form-control" type="text" v-model="nameSearch" placeholder="Search by Provider Name...">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="emailSearch" placeholder="Search by Provider Email...">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="phoneSearch" placeholder="Search by Provider Phone...">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" v-model="amountSearch" placeholder="Search by Amount...">
                                                </th>
                                                <th>
                                                        <select class="form-control" v-model="statusSearch">
                                                            <option value="">All</option>
                                                            <option value="pending">Pending</option>
                                                            <option value="active">Active</option>
                                                        </select>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>S.no</th>
                                                <th>Provider Name</th>
                                                <th>Provider Email</th>
                                                <th>Provider Phone</th>
                                                <th>Amount</th>
                                                <th >Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in filteredResult" :key="index">
                                                <td >{{index+1}}</td>
                                                <td>{{item.providerName}}</td>
                                                <td>{{item.providerEmail}}</td>
                                                <td>{{item.providerPhone}}</td>
                                                <td>{{item.amount}}</td>
                                                <td ><span :class="getStatusClass(item.status)">{{item.status}}</span></td>
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
    


</template>
<script>

    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';
    import Footer from '../layout/common/Footer.vue';
    import * as XLSX from 'xlsx';
    import * as FileSaver from 'file-saver';
    import jsPDF from 'jspdf';
    import 'jspdf-autotable';

    export default {
        props: ['page'],

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
                                const nameMatch = res.providerName.toLowerCase().includes(this.nameSearch.toLowerCase());
                                const emailMatch = res.providerEmail.toLowerCase().includes(this.emailSearch.toLowerCase());
                                const phoneMatch = res.providerPhone.toLowerCase().includes(this.phoneSearch.toLowerCase());
                                const amountMatch = res.amount.toLowerCase().includes(this.amountSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return nameMatch && emailMatch && phoneMatch  && amountMatch && statusMatch;
                            });
                            return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },

                    pageCount() {
                            const filteredCats = this.result.filter(res => {
                                const nameMatch = res.providerName.toLowerCase().includes(this.nameSearch.toLowerCase());
                                const emailMatch = res.providerEmail.toLowerCase().includes(this.emailSearch.toLowerCase());
                                const phoneMatch = res.providerPhone.toLowerCase().includes(this.phoneSearch.toLowerCase());
                                const amountMatch = res.amount.toLowerCase().includes(this.amountSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.statusSearch.toLowerCase());
                                return nameMatch && emailMatch && phoneMatch  && amountMatch && statusMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);
                    },

                   

                    

                },

        data() {

                return {
                    nameSearch:'',
                    emailSearch:'',
                    phoneSearch:'',
                    amountSearch:'',
                    statusSearch:'',
                    currentPage: 1,
                    pageSize: 10,

                    result:[]
                }
            },

        methods: {

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
                                        <th>S.no</th>
                                        <th>Provider Name</th>
                                        <th>Provider Email</th>
                                        <th>Provider Phone</th>
                                        <th>Amount</th>
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
                        const columns = ['Provider Name', 'Provider Email', 'Provider Phone', 'Amount', 'Status'];
                        const data = filteredData.map(item => [item.providerName, item.providerEmail, item.providerPhone, item.amount, item.status]);
                        pdf.autoTable(columns, data);
                        pdf.save('data.pdf');
                    },

                async getResult(page=1) {
                        
                        const data =  await this.api('POST',this.$payment+'providerWallet',this.form,false,false)
                            if(data.status===200){
                                this.result =  data.data
                            }
                },

                getStatusClass(status) {
                        if (status === 'pending') return 'btn btn-info'
                        if (status === 'accept') return 'btn btn-success'
                        return 'btn btn-danger'
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