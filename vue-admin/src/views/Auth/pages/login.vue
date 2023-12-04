<template>
        <div >
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
                                                    <h5 class="text-primary">Welcome Back !</h5>
                                                    <p>Sign in to continue to Notension.</p>
                                                </div>
                                            </div>
                                            <div class="col-5 align-self-end">
                                                <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0"> 
                                        <div>
                                            <router-link to="/login">
                                                <div class="avatar-md profile-user-wid mb-4">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                                    </span>
                                                </div>
                                            </router-link>
                                        </div>
                                        <div class="p-2">
                                            <form @submit.prevent="onSubmit">
                
                                                <div class="form-group" :class="{ error: v$.form.email.$errors.length }">
                                                    <label for="username">Email</label>
                                                    <input  placeholder="Enter your email ID"
                                                          type="email" v-model="v$.form.email.$model"
                                                            class="form-control"
                                                         />
                                               
                                                    <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>

                                                </div>

                        
                                                 <div class="form-group" :class="{ error: v$.form.password.$errors.length }">
                                                    <label for="userpassword">Password</label>
                                                    <input   type="password"
                                                               v-model="v$.form.password.$model"
                                                                placeholder="Enter your password"
                                                                class="form-control" 
                                                                />
                                                    <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>

                                                </div>
                        
                                                <div class="mt-3">
                                                    <button :disabled="v$.form.$invalid"  v-on:click="login" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
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
                    
                                                <div class="mt-4 text-center">
                                                    <router-link to="/forget"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</router-link>
                                                </div>
                                            </form>
                                        </div>
                    
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <p>Don't have an account ? <router-link to="/signup"> Signup now </router-link> </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </body>
        </div>
</template>


<script>
    import { inject } from 'vue'
    import useVuelidate from '@vuelidate/core'
    import { required, email, minLength } from '@vuelidate/validators'
    import axios from 'axios'
    import Swal from 'sweetalert2'



    export default {

        setup () {
            let cookies = inject('cookies');
            return { v$: useVuelidate() }

        },

        data() {

            return {

                form: {
                    email: '',
                    password: '',
                },
            }

        },
            
        validations() {

            return {

                form: {
                    
                    email: {
                        required, email 
                    },

                    password: {
                        required, 
                    },

                },
            }
        },
        methods: {
                   async login() {
                          const data =  await this.api('POST',this.$authentication+'login',this.form,false,true)
                          if(data.status===200){
                            localStorage.setItem('accessToken',data.access_token)
                            localStorage.setItem('user',JSON.stringify(data))
                            this.$router.push({name:"Dashboard"});
                          }
                    }
                    


                }
    }

</script>

