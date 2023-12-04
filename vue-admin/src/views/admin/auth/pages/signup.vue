<template>

    <body>
       
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-soft-primary">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Free Register</h5>
                                            <p>Get your free Notension account now.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div>
                                    <router-link to="/signup">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </router-link>
                                </div>
                                <div class="p-2">
                                   <form @submit.prevent="onSubmit" name="service_provider_signup">
            
                                        <div class="form-group" :class="{ error: v$.form.email.$errors.length }">
                                            <label for="useremail">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="v$.form.email.$model">        

                                            <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                            </div>

                                        </div>
                
                                        <div class="form-group" :class="{ error: v$.form.name.$errors.length }" >
                                            <label for="username">Company Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="Enter Company Name" v-model="v$.form.name.$model" > 
                                              
                                            <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                            </div>

                                        </div>

                                         <div class="form-group" :class="{ error: v$.form.category.$errors.length }" >
                                            <label for="username">Category</label>
                                              <select class="form-control select2" id="category" v-model="v$.form.category.$model">
                                                    <option disabled selected>Select</option>
                                                    <option value="shades">shades</option>
                                                    <option value="jb">jb</option>
                                            </select>

                                            <div class="input-errors" v-for="(error, index) of v$.form.category.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group" :class="{ error: v$.form.sub_category.$errors.length }">
                                            <label for="username">Sub Category</label>
                                              <select class="form-control select2" id="sub_category" v-model="v$.form.sub_category.$model">
                                                    <option disabled selected>Select</option>
                                                    <option value="sub shades">shades</option>
                                                    <option value="sub jb">jb</option>
                                            </select>

                                            <div class="input-errors" v-for="(error, index) of v$.form.sub_category.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group" :class="{ error: v$.form.total_employees.$errors.length }" >
                                            <label for="username">Total Employees</label>
                                            <input type="number"  class="form-control"  id="total_employees" placeholder="Total Employees"  v-model="v$.form.total_employees.$model" >

                                            <div class="input-errors" v-for="(error, index) of v$.form.total_employees.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                            </div>

                                        </div>

                                        <div class="form-group" :class="{ error: v$.form.phone.$errors.length }" >
                                            <label for="username">Phone Number</label>
                                            <input type="number" class="form-control input-mask" id="phone" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" placeholder=" Phone Number"  v-model="v$.form.phone.$model">
                                            
                                            <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                            </div>
                                          
                                        </div>

                                        <div class="form-group" :class="{ error: v$.form.address.$errors.length }">
                                            <label for="username">Address</label>
                                            <textarea class="form-control" id="address" placeholder="Address" v-model="v$.form.address.$model"></textarea>
                                            <div class="input-errors" v-for="(error, index) of v$.form.address.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                            </div>
                                            
                                        </div>

                
                                       <div class="mt-3">
                                            <button :disabled="v$.form.$invalid" v-on:click="signup" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Register</button>
                                        </div>

                                        <div class="mt-3">
                                            <a href="http://127.0.0.1:8000/facebook/auth"  class="btn btn-primary btn-block waves-effect waves-light">
                                               Register with Facebook
                                            </a>
                                        </div>

                                        <div class="mt-1">
                                            <a href="http://127.0.0.1:8000/google/auth"  class="btn btn-success btn-block waves-effect waves-light">
                                               Register with Gmail
                                            </a>
                                        </div>

                                   
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>Already have an account ? <router-link to="/login"> Login</router-link> </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </body>
</template>


<script>

    import useVuelidate from '@vuelidate/core'
    import { required, email, minLength } from '@vuelidate/validators'
    import axios from 'axios'
    import Swal from 'sweetalert2'

    export default {

            setup () {
                return { v$: useVuelidate() }
            },

            data() {

                return {

                form: {
                    email: '',
                    total_employees:'',
                    phone:'',
                    address:'',
                    sub_category:'',
                    category:'',
                    name:'',
                },

                }

            },
                
            validations() {

                return {

                    form: {

                        email: {
                        required, email
                        },

                        total_employees: {
                            required,
                        },
                        phone: {
                            required,
                        },
                        address: {
                            required,
                        },
                        sub_category: {
                            required,
                        },
                        category: {
                            required,
                        },
                        name: {
                            required,
                        },

                    },

                }
            },


            methods: {

                    gmail(){

                        axios.post('http://127.0.0.1:8000/facebook/auth')

                          

                    },

                    signup() {
                            axios.post('http://127.0.0.1:8000/api/service-provider/signup', this.form)
                            .then((res)=> {
                                this.onSuccess(res.data.message);
                            })
                            .catch((error)=> {
                                if(error.response.status == 422){
                                    this.setErrors(error.response.data.errors);
                                } 
                                else {
                                    this.onFailure(error.response.data.message);
                                }
                            })
                            document.service_provider_signup.reset();
                    },

                    onSuccess(message) {
                                this.reset();
                                this.hide_error = false;
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Service Provider Registered Successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                    }, 

                    onFailure(message) {
                            this.error = true;
                    },

                    reset() {
                            for(let field in this.formData) {
                                this.formData[field] = null;
                            }
                    },

                    setErrors(errors) {
                            this.errors = errors;
                    },

                    hasError(fieldName) {
                            return (fieldName in this.errors);
                    },

                   
                    
            }
    
    }
</script>
