<template>
    <body data-sidebar="dark">

        <Header></Header>
        <Sidebar></Sidebar>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <form @submit.prevent="onSubmit">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">CMS Setting</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">CMS Setting</li>
                                        </ol>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                            <div  class="outer">
                                                <div data-repeater-item class="outer">
                                                    <div class="form-group row mb-4">
                                                        <label class="col-md-1 col-form-label priority_lable_color">Number</label>
                                                        <div class="col-md-2">
                                                                <input type="text"  v-model="form.number" class="inner form-control"   />
                                                        </div>
                                                        <label class="col-md-1 col-form-label priority_lable_color">Email</label>
                                                        <div class="col-md-2">
                                                                <input type="email"  v-model="form.email" class="inner form-control"   />
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
                                        <h4 class="card-title mb-4 main_lable_color">Social Profile Links</h4>
                                            <div  class="outer">
                                                <div data-repeater-item class="outer">
                                                
                                                    <div class="form-group row mb-4">
                                                            <label class="col-md-1 col-form-label priority_lable_color">Facebook</label>
                                                            <div class="col-md-3">
                                                                <input type="text" v-model="form.facebook" class="inner form-control"  placeholder="Url of facebook profile" >
                                                            </div>
                                                            <label class="col-md-1 col-form-label priority_lable_color">Instagram</label>
                                                            <div class="col-md-3">
                                                                <input type="text" v-model="form.instagram" class="inner form-control"  placeholder="Url of facebook profile" />
                                                            </div>
                                                            <label class="col-md-1 col-form-label priority_lable_color">Linkdin</label>
                                                            <div class="col-md-3">
                                                                <input type="text" v-model="form.linkdin" class="inner form-control" placeholder="Url of facebook profile" />
                                                            </div>
                                                    </div>
                                                    <div class="form-group row mb-4">
                                                            
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
                                            <div  class="outer">
                                                <div data-repeater-item class="outer">
                                                    <div class="form-group row mb-4">
                                                        <img v-bind:src="form.logo" width="200" height="70" alt="" />
                                                       
                                                        <label class="col-md-1 col-form-label priority_lable_color">upload logo</label>
                                                        <div class="col-md-2">
                                                            <input ref="fileInput" type="file" @input="pickFile" v-on:change="pickFile">
                                                        </div>

                                                        <div class="col-md-5">
                                                            <div class="form-group row" v-if!="previewImage">
                                                                <div class="col-md-4 imagePreviewWrapper"
                                                                    :style="{ 'background-image': `url(${previewImage})` }"
                                                                    @click="selectImage">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <div style="float:right">
                            <button type="submit"   v-on:click="save"  class="btn btn-primary waves-effect waves-light" v-if="this.hasActionPermission(20,'update')">Save</button>
                        </div>

                    </form>
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

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

        created() {
                this.getResult();
            },

        data() {
            
                return {
                    previewImage: null,
                    form: {
                            number: '',
                            email: '',
                            facebook:'',
                            instagram:'',
                            linkdin:'',
                            image: this.previewImage,
                            previewImage: '',
                        
                        },

                    result:[],
                };
            },

        methods: {
            
                        async getResult(page=1) {

                            const data =  await this.api('POST',this.$website+'webSetting',this.form,false,false)
                            if(data.status===200){
                                    this.result =  data.data
                                    this.form.number =  this.result.number
                                    this.form.email =  this.result.email
                                    this.form.facebook =  this.result.facebook
                                    this.form.instagram =  this.result.instagram
                                    this.form.linkdin =  this.result.linkdin
                                    this.form.logo =  this.result.logo
                            }
                        },

                        async save() {

                            const formData = new FormData();
                            formData.append('number', this.form.number);
                            formData.append('email', this.form.email);
                            formData.append('facebook', this.form.facebook);
                            formData.append('instagram', this.form.instagram);
                            formData.append('linkdin', this.form.linkdin);
                            formData.append('logo', this.previewImage);

                            const data =  await this.api('POST',this.$website+'addWebSetting',formData,false,true)
                            if(data.status===200){

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
                    
            },
            
    }
</script>
<style lang="">
    
</style>