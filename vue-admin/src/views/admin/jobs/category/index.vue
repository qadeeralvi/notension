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
                                <h4 class="mb-0 font-size-18">Category List</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Category List</li>
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
                                                <h4 class="card-title">Category Management</h4>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" v-if="this.hasActionPermission(3,'create')"  class="btn btn-primary waves-effect waves-light" @click="addModal()">Add</button>
                                            </div>
                                        </div>
                                    </div>

                                
                                    <table  ref="table"  id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th >
                                                    <div>
                                                    <input class="form-control" type="text" v-model="searchTerm" placeholder="Search by Title...">
                                                    </div>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th>S.no</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,index) in filteredResult" :key="index">
                                                <td>{{index+1}}</td>
                                                <td>{{item.name}}</td>
                                                <td>{{item.status}}</td>
                                                <td>
                                                    <img v-bind:src="item.image" width="100" height="70" alt="">
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" v-if="this.hasActionPermission(3,'update')" @click="fetchInfo(item.id)"><i class="bx bx-edit"></i></button>
                                                        &nbsp
                                                    <button v-if="this.hasActionPermission(3,'delete')"  class="btn btn-danger btn-sm" @click="delete_cat(item.id)"><i class="bx bx-bx bx-trash"></i></button>
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

    <div class="modal fade addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Category Title</label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" required v-model="v$.form.name.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Price</label>
                            <div class="col-md-3">
                                <input class="form-control" type="text" required v-model="v$.form.price.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.price.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Days</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" required v-model="v$.form.days.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.days.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Time</label>
                            <div class="col-md-4">
                                <input class="form-control" type="time" required v-model="v$.form.end_time.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.end_time.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>     
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Minimum</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" required v-model="v$.form.minimum.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.minimum.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Maximum</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" required v-model="v$.form.maximum.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.form.maximum.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>     

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Less Assign</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox"  v-model="form.less_assign" >
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Location</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox"  v-model="form.location" >
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Last Assign</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox"  v-model="form.last_assign" >
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Maximum Rating</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox"  v-model="form.maximum_rating" >
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Upload image</label>
                            <div class="col-md-10">
                                <input class="form-control" ref="fileInput" type="file" @input="pickFile" @change="handleFileUpload">
                            </div>
                        </div>

                        <div class="form-group row" v-if="previewImage">
                            <label for="example-text-input" class="col-md-2 col-form-label">Upload image</label>
                            <div class="col-md-10">
                                <img :src="previewImage"  alt="Uploaded Image" width="200" height="200"/>
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
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Update Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="updateForm.id" >
                        <input type="hidden" v-model="updateForm.imageDisplay" >
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Category Title</label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" required v-model="v$.updateForm.name.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.name.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <label for="example-text-input" class="col-md-1 col-form-label">Price</label>
                            <div class="col-md-3">
                                <input class="form-control" type="text" required v-model="v$.updateForm.price.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.price.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Days</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" required v-model="v$.updateForm.days.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.days.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Time</label>
                            <div class="col-md-4">
                                <input class="form-control" type="time" required v-model="v$.updateForm.end_time.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.end_time.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>     
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Minimum</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" required v-model="v$.updateForm.minimum.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.minimum.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Maximum</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" required v-model="v$.updateForm.maximum.$model" >
                                <div class="input-errors" v-for="(error, index) of v$.updateForm.maximum.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Less Assign</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox" :checked="updateForm.less_assign==1" v-model="updateForm.less_assign" >
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Location</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox" :checked="updateForm.location==1" v-model="updateForm.location" >
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Last Assign</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox" :checked="updateForm.last_assign==1" v-model="updateForm.last_assign" >
                            </div>
                            <label for="example-text-input" class="col-md-2 col-form-label">Maximum Rating</label>
                            <div class="col-md-1">
                                <input class="form-control" type="checkbox" :checked="updateForm.maximum_rating==1" v-model="updateForm.maximum_rating" >
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Upload image</label>
                            <div class="col-md-10">
                                <input class="form-control" ref="fileInput" type="file" @input="pickFile" @change="handleFileUpload">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6" v-if="!previewImage">
                                <img :src="this.$services+'images/'+updateForm.imageDisplay" width="150" height="150">
                            </div>
                            <div class="col-md-6" v-if="previewImage">
                                <img :src="previewImage"  alt="Uploaded Image" width="200" height="200"/>
                            </div>
                        </div>
                        
                        <div style="float:right">
                            <button type="submit" :disabled="v$.updateForm.$invalid"  v-on:click="updateSave"  class="btn btn-primary waves-effect waves-light" >Save</button>
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
    import { required } from '@vuelidate/validators'
    import Header from '../../layout/common/Header.vue';
    import Sidebar from '../../layout/common/Sidebar.vue';
    import Footer from '../../layout/common/Footer.vue';



    // import axios from "axios";

    export default {

        setup () {
                return { v$: useVuelidate() }
        },

        components: {

                    Header,
                    Sidebar,    
                    Footer,
                },

        created() {
                this.getResult(),
                this.hasModulePermission(3);
            },

        computed: {

                filteredResult() {
                        const filteredCats = this.result.filter(cat => {
                        return cat.name.toLowerCase().includes(this.searchTerm.toLowerCase())
                        });
                        return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },
                pageCount() {
                        const filteredCats = this.result.filter(cat => {
                        return cat.name.toLowerCase().includes(this.searchTerm.toLowerCase())
                        });
                        return Math.ceil(filteredCats.length / this.pageSize);
                    }
            },
        
        data() {

                return {
                    searchTerm: '',
                    currentPage: 1,
                    pageSize: 5,
                    previewImage: null,
                    form: {
                            name: '',
                            days: '',
                            end_time: '',
                            minimum: '',
                            maximum: '',
                            price: '',
                            less_assign: '',
                            location: '',
                            last_assign: '',
                            maximum_rating: '',
                        },
                    updateForm: {
                            id: '',
                            name: '',
                            days: '',
                            end_time: '',
                            minimum: '',
                            maximum: '',
                            price: '',
                            less_assign: '',
                            location: '',
                            last_assign: '',
                            maximum_rating: '',
                            imageDisplay:'',
                        },
                    result:[]
                }
            },
        validations() {

                    return {

                        form: {
                            
                            name: {
                                required 
                            },
                            days: {
                                required 
                            },
                            end_time: {
                                required 
                            },
                            minimum: {
                                required 
                            },
                            maximum: {
                                required 
                            },
                            price: {
                                required 
                            },
                            location: {
                                 
                            },
                            less_assign: {
                                 
                            },
                            last_assign: {
                                 
                            },
                            maximum_rating: {
                                 
                            },
                        },
                    updateForm: {
                            
                            name: {
                                required 
                            },
                            days: {
                                required 
                            },
                            end_time: {
                                required 
                            },
                            minimum: {
                                required 
                            },
                            maximum: {
                                required 
                            },
                            price: {
                                required 
                            },
                        }
                    }
                },

        methods: {

                async getResult(page = 1) {
                    
                        try {
                            const data =  await this.api('GET',this.$service+'category','',false,true)
                            if (data.status_code === 200) {
                                this.result = data.data;
                            }
                        } catch (error) {
                            console.error(error);
                        }
                },

                async save() {

                            const formData = new FormData();
                            formData.append('name', this.form.name);
                            formData.append('days', this.form.days);
                            formData.append('facebook', this.form.facebook);
                            formData.append('end_time', this.form.end_time);
                            formData.append('minimum', this.form.minimum);
                            formData.append('maximum', this.form.maximum);
                            formData.append('price', this.form.price);
                            formData.append('location', this.form.location);
                            formData.append('less_assign', this.form.less_assign);
                            formData.append('last_assign', this.form.last_assign);
                            formData.append('maximum_rating', this.form.maximum_rating);
                            formData.append('image', this.previewImage);

                            const data =  await this.api('POST',this.$service+'save_category',formData,false,true)
                            if(data.status===200){

                                $('.bs-example-modal-lg').modal('hide');

                            }
                },

                async updateSave(page=1) {


                        const formData = new FormData();
                        formData.append('id', this.updateForm.id);
                        formData.append('name', this.updateForm.name);
                        formData.append('days', this.updateForm.days);
                        formData.append('end_time', this.updateForm.end_time);
                        formData.append('minimum', this.updateForm.minimum);
                        formData.append('maximum', this.updateForm.maximum);
                        formData.append('price', this.updateForm.price);
                        formData.append('location', this.updateForm.location);
                        formData.append('less_assign', this.updateForm.less_assign);
                        formData.append('last_assign', this.updateForm.last_assign);
                        formData.append('maximum_rating', this.updateForm.maximum_rating);
                        formData.append('imageDisplay', this.updateForm.imageDisplay);
                        formData.append('image', this.previewImage);

                        const data =  await this.api('POST',this.$service+'updateCategory',formData,false,true)

                        if(data.status===200){
                            $('.updateModal').modal('hide');
                            this.getResult();
                        }
                        else{
                            swal("Oops!", response.message, "error");
                        }
                },

                addModal(){
                    $('.addModal').modal('show');
                },

                async fetchInfo(id) {

                    const data = await this.api('POST',this.$service+'singleCategory',{id:id},false,false)
                    if(data.status===200){
                        $('.updateModal').modal('show');
                        this.updateForm.id = data.data.id;
                        this.updateForm.name = data.data.name;
                        this.updateForm.price = data.data.price;
                        this.updateForm.days = data.data.days;
                        this.updateForm.end_time = data.data.end_time;
                        this.updateForm.minimum = data.data.minimum;
                        this.updateForm.maximum = data.data.maximum;
                        this.updateForm.less_assign = data.data.less_assign;
                        this.updateForm.location = data.data.location;
                        this.updateForm.last_assign = data.data.last_assign;
                        this.updateForm.maximum_rating = data.data.maximum_rating;
                        this.updateForm.imageDisplay = data.data.image;
                    }

                },


                async  delete_cat(id) {

                            const data1 = {
                                id: id
                            }
                            const data =  await this.api('POST',this.$service+'delete_category',data1,false,true)

                            if(data.status===200){
                                
                                location.reload();
                            }
                    },

                handleFileUpload(event) {

                    const file = event.target.files[0];
                    this.convertToBase64(file);       

                },

                convertToBase64(file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.previewImage = event.target.result;
                    };
                    reader.readAsDataURL(file);
                },


              
            }
            }
</script>
<style >
    .error-msg{
            color:red;
        }
</style>