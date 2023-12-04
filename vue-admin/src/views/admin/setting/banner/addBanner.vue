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
                                    <h4 class="mb-0 font-size-18">Banner</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Banner</li>
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
                                                        <label class="col-md-1 col-form-label priority_lable_color">Title</label>
                                                        <div class="col-md-6">
                                                                <input type="text"  v-model="form.number" class="inner form-control"   />
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
                                        <h4 class="card-title mb-4 main_lable_color">Banner Text</h4>
                                            <div  class="outer">
                                                <div data-repeater-item class="outer">
                                                    <div class="form-group row mb-4">
                                                        <label class="col-md-1 col-form-label priority_lable_color">Title</label>
                                                        <div class="col-md-9">
                                                                <textarea name="" class="inner form-control" id="" cols="30" rows="10"></textarea>
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
                                            <div  class="outer">
                                                <div data-repeater-item class="outer">
                                                    <div class="form-group row mb-4">
                                                        <img src="http://localhost:8080/assets/images/users/avatar-1.jpg" width="150" height="150" alt="">
                                                       
                                                        <label class="col-md-1 col-form-label priority_lable_color">upload logo</label>
                                                        <div class="col-md-2">
                                                                <input type="file"  class="inner form-control"   />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div style="float:right">
                            <button type="submit"   v-on:click="save"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div> 
            </div>
        </div>

</body>
</template>
<script>
    import Header from '../../layout/common/Header.vue';
    import Sidebar from '../../layout/common/Sidebar.vue';
    import Footer from '../../layout/common/Footer.vue';

    export default {

        props: ['page'],

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
                    form: {
                            number: '',
                            email: '',
                            facebook:'',
                            instagram:'',
                            linkdin:'',
                            logo:''
                        
                        },

                    result:[],
                };
            },

        methods: {
                async getResult(page=1) {

                        const data =  await this.api('POST',this.$service+'job_status',this.form,false,false)
                        if(data.status===200){
                                this.result =  data.data
                                this.form.number =  this.result.number
                                this.form.email =  this.result.email
                                this.form.facebook =  this.result.facebook
                                this.form.instagram =  this.result.instagram
                                this.form.linkdin =  this.result.linkdin
                        }
                    },
                

                async save() {

                        const data =  await this.api('POST',this.$service+'save_job_status',this.form,false,true)
                        if(data.status===200){

                            // alert()
                        }
                    },
                    
            },
            
    }
</script>
<style lang="">
    
</style>