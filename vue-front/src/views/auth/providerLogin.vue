<template>

    <div class="pt-120 pb-120 ovx-hidden">
        <div class="container">
            <div class="row">
            <div class="col-lg-6">
                    <div class="form-wrap login-form-wrap style--two">
                        <form @submit.prevent="login" class="login-form">
                            
                            <div class="form-group" :class="{ error: v$.form.email.$errors.length }" >
                                <label for="email" class="mb-2 semi-bold black">Email Address</label>
                                 <input type="text" id="email" class="form-control" v-bind:autocomplete="autocompleteValue" placeholder="Email Address" v-model="v$.form.email.$model">
                                 
                                <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <div class="form-group" :class="{ error: v$.form.password.$errors.length }">
                                <label for="password" class="mb-2 semi-bold black">Password</label> 
                                <input type="password" id="password" class="form-control"  v-model="v$.form.password.$model" placeholder="********">
                                <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" id="checkbox"> 
                                    <label for="checkbox" class="mb-0 ml-2">Remember Me</label>
                                </div>
                                <a href="#">Forgot Password?</a>
                            </div>

                            <div class="d-flex flex-wrap align-items-center">
                                <button type="submit" class="btn c1-hover btn-border me-2" :disabled="v$.form.$invalid" >
                                    <span>Login</span> 
                                    <img :src="$main + '/assets/img/icon/user-icon.svg'" alt="" class="svg">
                                </button>
                                <router-link to="/provider/signUp">
                                    <button type="submit" class="btn c1-hover btn-border" >
                                        <span>Sigup</span> 
                                        <img :src="$main + '/assets/img/icon/user-icon.svg'" alt="" class="svg">
                                    </button>
                                </router-link>
                            </div>

                        </form>
                    </div>
                </div>
            <div class="col-lg-6">
                <div class="login-img mt-5 mt-lg-0"><img :src="$main + '/assets/img/media/plumber-logo.png'" alt=""></div>
            </div>
            </div>
        </div>
    </div>

</template>


<script>
import axios from 'axios';
import swal from 'sweetalert';
import { inject } from 'vue'
import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'


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
            autocompleteValue: 'off',

        }

    },
        
    validations() {

        return {

            form: {
                
                email: {
                    required, 
                },

                password: {
                    required, 
                },

            },
        }
    },
    methods: {
               async login() {
                    const parameters = {
                        email: this.form.email,
                        password: this.form.password,
                    };
                    axios.post(this.$authentication+'providerLogin/',parameters)
                        .then(response => {
                            if(response.data.status==200){
                                    // swal("Successfully Logged!", "" ,"success");
                                    // window.localStorage.setItem('provider',JSON.stringify(response.data.provider_info.id))
                                    // window.localStorage.setItem('type',JSON.stringify(response.data.type))
                                    // this.$router.push({name:"ProviderHome"});
                            }
                            if(response.data.status==404){
                                swal("Oops!", response.data.message, "error");
                            }
                        })
                        .catch(error => {
                          console.log(error)
                        });
                }
            }
}

</script>

<style>
.error-msg{
color:red;
}
</style>