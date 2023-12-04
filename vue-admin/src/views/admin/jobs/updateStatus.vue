<template>
    <body data-sidebar="dark">

        <Header></Header>
        <Sidebar></Sidebar>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <form @submit.prevent="onSubmit">
                        <input type="hidden" v-model="v$.form.job_id.$model" >
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Update Job</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Job</a></li>
                                            <li class="breadcrumb-item active">Update Status</li>
                                        </ol>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4 main_lable_color">Update Job Status</h4>
                                            <div  class="outer">
                                                <div data-repeater-item class="outer">
                                                    <div class="form-group row mb-4">
                                                        <label class="col-md-1 col-form-label priority_lable_color">Status</label>
                                                        <div class="col-md-2">
                                                            <input type="text" v-if="form.status=='done'"  readonly value="Completed" class="btn btn-success">
                                                            <select  v-else class="form-control" v-model="form.status">
                                                                <option value="pending" >Pending</option>
                                                                <option value="active" >Active</option>
                                                                <option value="assigned" >Assigned</option>
                                                                <option value="cancelled" >Cancelled</option>
                                                            </select>
                                                        </div>
                                                    
                                                        <label class="col-md-1 col-form-label priority_lable_color">End Date</label>
                                                        <div class="col-md-2">
                                                                <input type="date"  v-model="form.end_date" class="inner form-control"   />
                                                        </div>
                                                        <label class="col-md-1 col-form-label priority_lable_color">End time</label>
                                                        <div class="col-md-2">
                                                                <input type="time" v-model="form.end_time" class="inner form-control"  placeholder="Enter end date" />
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
                                        <h4 class="card-title mb-4 main_lable_color">Minimum/Maximum Service Provider that Assign by system</h4>
                                    
                                            <div  class="outer">
                                                <div data-repeater-item class="outer">
                                                
                                                    <div class="form-group row mb-4">
                                                            <label class="col-md-1 col-form-label priority_lable_color">Minimum</label>
                                                            <div class="col-md-2">
                                                                <input type="number" v-model="form.minimum" class="inner form-control" name="minimum" placeholder="Mimimum ..." >
                                                            </div>
                                                            <label class="col-md-1 col-form-label priority_lable_color">Maximum</label>
                                                            <div class="col-md-2">
                                                                <input type="number" v-model="form.maximum" class="inner form-control" name="maximum" placeholder="Maximum..." />
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

                        <div class="row" v-if="result">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4 main_lable_color">Set Priority with Number</h4>
                                            <div  class="outer">
                                                    <div class="form-group row mb-4">
                                                        <label class="col-md-1 col-form-label priority_lable_color ">Location</label>
                                                        <div class="col-md-1">
                                                            <input type="checkbox" v-model="form.location" :checked="(result.location)?true:false"  class="inner form-control" name="location" >
                                                        </div>
                                                    
                                                        <label class="col-md-2 col-form-label priority_lable_color ">Less Job Assign Providers</label>
                                                        <div class="col-md-1">
                                                            <input type="checkbox"  class="inner form-control" v-model="form.less_assign" :checked="(result.less_assign)?true:false" >
                                                        </div>

                                                        <label class="col-md-2 col-form-label priority_lable_color ">Last Job Assigned Providers</label>
                                                        <div class="col-md-1">
                                                            <input type="checkbox"  class="inner form-control" v-model="form.last_assign" :checked="(result.last_assign)?true:false" >
                                                        </div>

                                                        <label class="col-md-2 col-form-label priority_lable_color">Maximum Rating</label>
                                                        <div class="col-md-1">
                                                            <input type="checkbox"  class="inner form-control" v-model="form.maximum_rating" :checked="(result.maximum_rating)?true:false" >
                                                        </div>
                                                    </div> 
                                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="form.status!='done'">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4 main_lable_color">Service Provider ID</h4>
                                            <div  class="outer original"  v-for="(input, k) in form.provider" :key="k">
                                                <div  class="outer">
                                                    <div class="inner-repeater mb-4">
                                                        <div data-repeater-list="inner-group" class="inner form-group">
                                                            <div class="inner mb-3 mt-2 row userdiv1">
                                                                <div class="col-md-2 col-8">
                                                                    <input type="text" name="" v-model="input.id" class="inner form-control provider_id" placeholder="Enter ID..."/>
                                                                </div>
                                                                <div class="col-md-2 col-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-4">
                                                                            <input type="button" @click="showProviderInfo(key,input)" class="btn btn-primary btn-block inner"  value="show"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <label class="col-md-1 col-form-label priority_lable_color" >Name</label>
                                                                <div class="col-md-2">
                                                                        <input type="text" class="inner form-control" id="provider_name" v-model="input.name"  readonly/>
                                                                </div>
                                                                <label class="col-md-1 col-form-label priority_lable_color">Email</label>
                                                                <div class="col-md-3">
                                                                        <input type="text" class="inner form-control" id="provider_email" v-model="input.email" readonly/>
                                                                </div>
                                                                <span>
                                                                <i
                                                                class="fas fa-minus-circle btn-danger btn-sm"
                                                                @click="remove(k)"
                                                                v-show="k || (!k && form.provider.length > 1)"
                                                                ></i>
                                                                <i
                                                                class="fas fa-plus-circle btn-success ml-2 btn-sm"
                                                                @click="add(k)"
                                                                v-show="k == form.provider.length - 1"
                                                                ></i>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-12">
                                <center>
                                    <button type="submit"   v-on:click="save" v-if="form.status!='done'" class="btn btn-lg btn-primary waves-effect waves-light" >Update</button>
                                </center>
                            </div>
                        </div>

                    </form>

                    <div class="row" v-if="Array.isArray(this.providerList) && this.providerList.length > 0">
                        <div class="col-lg-12">
                            <div class="card" style="background-color: deepskyblue;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4 main_lable_color">Assigned Provider</h4>
                                        <div  class="outer">
                                            <div data-repeater-item class="outer">
                                                <div class="form-group row mb-4"  v-for="(item,index) in providerList" :key="index">
                                                    <label class="col-md-1 col-form-label priority_lable_color">Name</label>
                                                    <div class="col-md-2">
                                                            <input type="text"  readonly v-model="item.provider_name"  class="inner form-control"   />
                                                    </div>

                                                    <label class="col-md-1 col-form-label priority_lable_color">Email</label>
                                                    <div class="col-md-2">
                                                            <input type="text"  readonly v-model="item.provider_email"  class="inner form-control"   />
                                                    </div>

                                                    <label class="col-md-1 col-form-label priority_lable_color">Phone</label>
                                                    <div class="col-md-2">
                                                            <input type="text"  readonly v-model="item.provider_phone_no"  class="inner form-control"   />
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
        </div>

        

</body>
</template>
<script>
    import useVuelidate from '@vuelidate/core'
    import { required } from '@vuelidate/validators'
    import Swal from 'sweetalert2'
    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';
    import Footer from '../layout/common/Footer.vue';

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
                this.getResult();
                this.fetchProviders();
                this.valueFromDb = this.location;
            },
       

        data() {
            
                return {
                    form: {
                        job_id: this.$route.params.id,
                        end_date: '',
                        end_time: '',
                        status: '',
                        minimum: '',
                        maximum: '',
                        less_assign: '',
                        location: '',
                        last_assign: '',
                        maximum_rating: '',
                        provider:[
                        {
                                id:'',
                                email:'',
                                name:""
                            }
                        ]
                    },
                    result:[],
                    providerList:[],
                    isChecked: false,
                    valueFromDb: null
                };
            },
        validations() {

                        return {

                            form: {
                                
                                job_id: {
                                    required 
                                },
                                end_date: {
                                    required 
                                },
                                end_time: {
                                    required 
                                },
                            }
                        }
                },

        methods: {
            async getResult(page=1) {

                    const data =  await this.api('POST',this.$service+'job_status',this.form,false,false)
                    if(data.status===200){
                            this.result =  data.data
                            this.form.end_time =  this.result.end_time
                            this.form.end_date =  this.result.end_date
                            this.form.minimum =  this.result.minimum
                            this.form.maximum =  this.result.maximum
                            this.form.location =  this.result.location
                            this.form.less_assign =  this.result.less_assign
                            this.form.last_assign =  this.result.last_assign
                            this.form.maximum_rating =  this.result.maximum_rating
                            this.form.status = this.result.user_job.status
                    }
                },
                duplicateDiv() {

                        const originalDiv = document.querySelector('.original');
                        const newDiv = document.createElement('div');
                        newDiv.innerHTML = originalDiv.innerHTML;
                        originalDiv.parentNode.insertBefore(newDiv, originalDiv.nextSibling);
                    },

                async save() {

                        const data =  await this.api('POST',this.$service+'save_job_status',this.form,false,true)
                        if(data.status===200){

                        }
                    },

                async fetchProviders() {

                        const data =  await this.api('POST',this.$service+'provider_jobs',this.form,false,false)
                        if(data.status===200){
                            this.providerList =  data.data
                        }
                    },
                    
                    add() {
                        this.form.provider.push(
                            {
                                id:'',
                                email:'',
                                name:""
                            }
                        );
                    },
                    remove(index) {
                        this.form.provider.splice(index, 1);
                    },

                    async showProviderInfo(key,info) {

                        const data =  await this.api('POST',this.$authentication+'provider_info/',{id:info.id},false,true)
                        if(data.status===200){
                            info.name = data.provider.name || '';
                            info.email = data.provider.email ||'';
                        }
                        else{
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.message || 'something Wrong',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        
                    }
            },
            
    }
</script>
<style lang="">
    
</style>