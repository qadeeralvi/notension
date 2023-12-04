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
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".addBanner">Add</button>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in result" :key="index">
                                                <td>{{index+1}}</td>
                                                <td>{{item.title}}</td>
                                                <td>{{item.description}}</td>
                                                <td>
                                                    <img  v-bind:src="item.image" width="150" height="150" alt="no"/>
                                                </td>
                                                <td>{{ item.status === 1 ? 'Active' : 'Disable' }}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" @click="delete_id(item.id)"><i class="bx bx-bx bx-trash"></i></button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </body>


     <!--Add Model start-->

     <div class="modal fade addBanner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Add {{page}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" required v-model="form.title" >
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Description</label>
                            <div class="col-md-10">
                                <textarea name="" class="inner form-control" v-model="form.description" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>    
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Image</label>
                            <div class="col-md-10">
                                <input ref="fileInput" type="file" @input="pickFile" v-on:change="pickFile">

                            </div>
                        </div>  
                        
                        <div class="form-group row" v-if!="previewImage">
                            <div class="col-md-4 imagePreviewWrapper"
                                :style="{ 'background-image': `url(${previewImage})` }"
                                @click="selectImage">
                            </div>
                        </div>


                        <div style="float:right">
                            <button type="submit"  v-on:click="saveBanner"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<!--Add Model end-->


</template>
<script>

    import Header from '../../layout/common/Header.vue';
    import Sidebar from '../../layout/common/Sidebar.vue';
    import Footer from '../../layout/common/Footer.vue';

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
                    previewImage: null,
                    form: {
                        title: '',
                        description: '',
                        jb:'a',
                        image: this.previewImage,
                        previewImage: '',
                    },
                    result:[]
                }
            },

        methods: {

                async getResult(page=1) {

                        const data =  await this.api('POST',this.$website+'banner',this.form,false,false)
                        if(data.status===200){
                            this.result =  data.data
                        }
                },

                async saveBanner(page=1) {
                  
                    const formData = new FormData();
                    formData.append('title', this.form.title);
                    formData.append('description', this.form.description);
                    formData.append('image', this.previewImage);

                        const data =  await this.api('POST',this.$website+'addBanner',formData,false,true)
                        if(data.status===200){
                            location.reload();
                        }
                },

                async  delete_id(id) {
                            const parameter = {
                                id: id
                            }
                            const data =  await this.api('POST',this.$website+'delete_banner',parameter,false,true)
                            if(data.status===200){
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                },

                selectImage () {
                        this.$refs.fileInput.click()
                    },

                pickFile () {
                        let input = this.$refs.fileInput
                        let file = input.files
                        if (file && file[0]) {
                        let reader = new FileReader
                        reader.onload = e => {
                            this.previewImage = e.target.result
                        }
                        reader.readAsDataURL(file[0])
                        this.$emit('input', file[0])
                        }
                    },

            }
        }
</script>
<style >
    .error-msg{
            color:red;
        }
</style>