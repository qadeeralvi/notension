import axios from "./interceptor";
import router from "../router";
import Vue from 'vue';
import Swal from 'sweetalert2';
import * as XLSX from 'xlsx';
import * as FileSaver from 'file-saver';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

export const request = 
{
    data() {
        return {
            parentPermissions:'',
        }
    },
    
    created() {
        const sessionData = sessionStorage.getItem('parentPermissions');
        if (sessionData === null || sessionData === '') {
          this.checkPermission();
        }
      },
      
    methods: 
    {
        loadJS(scripts) {
            scripts.forEach((script) => {
              // if(!this.isScriptAlreadyIncluded(script,'script','src')){//check script alread load or not
                let tag = document.createElement("script");
                tag.setAttribute('type','text/javascript');
                tag.setAttribute("src", script);
                tag.async = true;
                document.body.appendChild(tag);
              // }
            });
          },

        async api(requestType = "POST", url, data = {}, loader = false, showToast = false) 
        {
            let request = null;
            let response = {};
            
            switch (requestType) 
            {
                case "GET":
                    request = axios.get(url, data);
                    break;
                case "POST":
                    request = axios.post(url, data);
                    break;
                default:
                    request = axios.post(url, data);
            }
            
            await request
            .then((resp) =>
            {   
                if( resp.data.code == 401 )
                {   
                    router.push("/admin/login");
                    response = { data:{ data: null, paginationData: null }, status: 0 };
                   
                }
                else if( resp.data.code == 400 )
                {
                    response = { data:{ data: null, paginationData: null }, status: 1 };
                }
                else if( resp.data.code == 404 )
                {
                    response = { data:{ data: null, paginationData: null }, status: 1 };
                }
                else
                {   
                    if(showToast && resp.data.status===200)
                    {   
                        this.onSuccess(resp.data);
                    }

                    else if(showToast && resp.data.status===400)
                    {   
                        this.onFailure(resp.data);
                    }
                    else if(showToast && resp.data.status===201)
                    {   
                        this.onFailure(resp.data);
                    }
                    else if(showToast && resp.data.status===422)
                    {   
                        this.onFailure(resp.data);
                    }

                    else if(showToast && resp.data.status===404)
                    {   
                        this.onFailure(resp.data);
                    }
                        response = { ...resp.data};
                    
                }
               
            })
            .catch((error) => 
            {   
                response = { data:{ data: null, paginationData: null }, status: 0 };
            })
            .finally(() => 
            {
                // globalHelpers.methods.setIsLoading(false);
            });
            return response;
            
        },

        onSuccess(data) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: data.message || 'Action  Successfully',
                showConfirmButton: false,
                timer: 1500
            });

        },

        // onFailure(data){

        //     this.hide_error =false;
        //             Swal.fire({
        //                 position: 'top-end',
        //                 icon: 'error',
        //                 title: data.message || 'something Wrong',
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             });

        // },
        

        onFailure(data) {
            this.hide_error = false;
          
            if (data.status === 422) {
              // Display Laravel validation errors
              const errorMessages = Object.values(data.message).flat();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: errorMessages[0] || 'Validation error',
                showConfirmButton: false,
                timer: 1500
              });
            } else {
              // Display other errors
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: data.message || 'Something went wrong',
                showConfirmButton: false,
                timer: 1500
              });
            }
          },
          
        
        
        
        
        
        
        
        
        
        


        adminDetail(){
            this.isLoggedIn = localStorage.getItem('admin_info');
            const admin = JSON.parse(this.isLoggedIn);   
            return admin;
        },

        async checkPermission() {

            const admin = this.adminDetail();

            if (admin.role !== 1) {
                const data = await  this.api('POST', this.$authentication + 'fetchPermisison', { roleId: admin.role }, false, false);

                if (data.status === 200) {

                    const moduleAction = [];

                    data.data.forEach(item => {
                        moduleAction.push({ moduleId: item.moduleId, action: item.action });
                    });
                    
                    sessionStorage.setItem('moduleActionPermissions', JSON.stringify(moduleAction));
                    sessionStorage.setItem('parentPermissions',  data.parentId);
                    sessionStorage.setItem('modulePermissions',  data.moduleId);
                }
            }

        },

        hasParentPermission(permission) {
            const admin = this.adminDetail();
            const sessionData = sessionStorage.getItem('parentPermissions');
            if (admin.role !== 1) {
                const check = sessionData.includes(permission);
                if(check==false){
                    router.push("/dashboard");
                }
            }
            else{
                return true;
            }
        },

        hasModulePermission(module) {
            const admin = this.adminDetail();
            const sessionData = sessionStorage.getItem('modulePermissions');
            if (admin.role !== 1) {
                const check = sessionData.includes(module);
                if(check==false){
                    router.push("/dashboard");
                }
            }
            else{
                return true;
            }
        },

        hasActionPermission(moduleId, action) {
            const admin = this.adminDetail();
            const sessionData = sessionStorage.getItem('moduleActionPermissions');
            const moduleAction = JSON.parse(sessionData);
          
            if (admin.role === 1) {
              return true;
            }
          
            if (moduleAction) {
              const matchingModuleAction = moduleAction.find(
                item => item.moduleId === moduleId && item.action === action
              );
              return Boolean(matchingModuleAction);
            }
          
            return false;
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

        exportToPDF(data, labelParameter, dataParameter) {
            const filteredData = data[0];
            const dataArray = Object.values(filteredData);
            const result = [dataArray.map(item => {
              const row = [];
              dataParameter.forEach(key => {
                row.push(item[key]);
              });
              return row;
            })];
            // const pdf = new jsPDF();
            // const columns = labelParameter;
           
            // pdf.autoTable(columns, result[0]);
            // pdf.save('data.pdf');
          }
          

    },

    
};
