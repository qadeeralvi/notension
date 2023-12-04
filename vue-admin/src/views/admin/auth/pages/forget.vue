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
                                            <h5 class="text-primary"> Reset Password</h5>
                                            <p>Re-Password with Notension.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div>
                                    <a href="index.html">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="p-2">
                                    <div class="alert alert-success text-center mb-4" role="alert">
                                        Enter your Email and instructions will be sent to you!
                                    </div>
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
                    
                                        <div class="form-group row mb-0">
                                            <div class="col-12 text-right">
                                              <button :disabled="v$.form.$invalid" v-on:click="forget" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Reset</button>
                                            </div>
                                        </div>
    
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>Remember It ? <router-link to="/login"> Sign In here </router-link> </p>
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
        },
        }
    },
        
    validations() {
        return {
        form: {
            email: {
            required, email 
            },
        },
        }
    },
    methods: {
                    forget() {

                            axios.post('http://127.0.0.1:8000/api/forget', this.form)
                            .then((res)=> {
                                this.$router.push('/code?user=4'); 
                                // if(res.data.status == 200) {
                                   
                                //     this.onSuccess(res.data);
                                // }

                                // if(res.data.status == 404) {
                                // this.onFailure(res.data);
                                // }

                            })
                    },

                    onSuccess(data) {
                        this.hide_error =false;
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Check your email',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    },
                    
                    onFailure(data){

                        this.hide_error =false;
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Invalid Email',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                    },


                }
    
    }

</script>

