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
                                <h4 class="mb-0 font-size-18">Jobs List</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Jobs List</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Job Management</h4>

                                            <button @click="exportToExcel()" class="btn btn-success">Export to Excel</button>&nbsp
                                            <button @click="exportToPDF()" class="btn btn-success">Export to PDF</button>&nbsp
                                            <button @click="print()" class="btn btn-success">Print</button>&nbsp

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                            <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>
                                                        <input class="form-control" type="text" v-model="title" placeholder="Search by Title...">
                                                    </th>
                                                    <th>
                                                        <input class="form-control" type="text" v-model="categorySearch" placeholder="Search by Category...">
                                                    </th>
                                                    <th>
                                                        <select class="form-control" v-model="jobStart">
                                                            <option value="">All</option>
                                                            <option value="any time">Any Time</option>
                                                            <option value="As soon as possible">As soon as possible	</option>
                                                        </select>
                                                    </th>
                                                    <th></th>
                                                    <th>
                                                        <select class="form-control" v-model="status">
                                                            <option value="">All</option>
                                                            <option value="active">Active</option>
                                                            <option value="pending">Pending</option>
                                                            <option value="done">Complete</option>
                                                        </select>
                                                    </th>
                                            </tr>
                                            <tr>
                                                <th>S.no</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Job Start</th>
                                                <th>Location</th>
                                               
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in filteredResult" :key="index">
                                                <td>{{index+1}}</td>
                                                <td>{{item.date}}</td>
                                                <td>{{item.time}}</td>
                                                <td>{{item.title}}</td>
                                                <td>{{item.category_title}}</td>
                                                <td>{{item.job_start}}</td>
                                                <td>{{item.address}}</td>

                                                <td><span :class="statusColor(item.status)">{{item.status}}</span></td>
                                                <td style="display:flex; justify-content: space-around; align-items: center;">
                                                    <router-link  :to="{name:'Job Status Change',params:{id:item.id}}" v-if="this.hasActionPermission(2,'update')" title="Update Status" class="btn btn-warning btn-sm">
                                                        <i class="bx bx-edit"></i>
                                                    </router-link>
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

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

        created() {
                this.getResult()
                this.hasParentPermission(1);
            },

        computed: {

                    filteredResult() {
                            const filteredCats = this.result.filter(res => {
                                const titleMatch = res.title.toLowerCase().includes(this.title.toLowerCase());
                                const categoryMatch = res.category_title.toLowerCase().includes(this.categorySearch.toLowerCase());
                                const jobStartMatch = res.job_start.toLowerCase().includes(this.jobStart.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.status.toLowerCase());
                                return categoryMatch && jobStartMatch && statusMatch && titleMatch;
                            });
                            return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },
                    pageCount() {
                            const filteredCats = this.result.filter(res => {
                                const titleMatch = res.title.toLowerCase().includes(this.title.toLowerCase());
                                const categoryMatch = res.category_title.toLowerCase().includes(this.categorySearch.toLowerCase());
                                const jobStartMatch = res.job_start.toLowerCase().includes(this.jobStart.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.status.toLowerCase());
                                return categoryMatch && jobStartMatch && statusMatch && titleMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);
                    },

                },

        data() {

                return {

                    result:[],
                    title: '',
                    subCategorySearch: '',
                    categorySearch: '',
                    jobStart:'',
                    status:'',
                    currentPage: 1,
                    pageSize: 10,
                }
            },

        methods: {


                async getResult(page=1) {

                        const data =  await this.api('POST',this.$service+'all_job_list','',false,false)
                        if(data.status===200){

                            this.isLoggedIn = localStorage.getItem('admin_info');
                            const admin = JSON.parse(this.isLoggedIn);  
                            if(admin.id!=1){
                                this.result = data.data.filter(job => job.address.toLowerCase() === admin.location.toLowerCase());
                            }
                            else{
                                this.result = data.data;
                            }
                        }
                },

                statusColor(status){
                    if(status=='done'){
                        return 'btn btn-success';
                    }
                    else if(status=='pending'){
                        return 'btn btn-primary';
                    }
                    else if(status=='active'){
                        return 'btn btn-warning';
                    }


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
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Job Start</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th></th>
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
                        const columns = ['Title', 'Category', 'Sub Category', 'Job Start','Date','Time','Status'];
                        const data = filteredData.map(item => [item.title,item.category_title, item.sub_category_title, item.job_start,item.date,item.time,item.status]);
                        pdf.autoTable(columns, data);
                        pdf.save('data.pdf');
                    },

                    
            }
    }
</script>
<style lang="">
    
</style>