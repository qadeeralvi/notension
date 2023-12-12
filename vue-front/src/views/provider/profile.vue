<template>

    <div class="pt-120 pb-120  bg-color">
        <div class="container">
                    <div class="form-wrap login-form-wrap style--two">
                        <form @submit.prevent="saveProvider" class="login-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email" class="mb-2 semi-bold black">{{ this.translate('email') }}</label>
                                        <input type="email" id="email" class="form-control" v-bind:autocomplete="autocompleteValue" :placeholder="this.translate('email')" v-model="v$.form.email.$model">
                                        <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                            <div class="error-msg">{{ error.$message }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone" class="mb-2 semi-bold black">{{ this.translate('phone') }}</label> 
                                        <input type="text" id="phone" class="form-control"  v-model="v$.form.phone.$model" :placeholder="this.translate('phone')">
                                        <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                                            <div class="error-msg">{{ error.$message }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" >
                                        <label for="name" class="mb-2 semi-bold black">{{ this.translate('name') }}</label> 
                                        <input type="text" id="name" class="form-control"  v-model="v$.form.name.$model" :placeholder="this.translate('name')">
                                        <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                                            <div class="error-msg">{{ error.$message }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="address" class="mb-2 semi-bold black">{{ this.translate('address') }}</label> 
                                        <input type="text" id="address" class="form-control"  v-model="v$.form.address.$model" :placeholder="this.translate('address')">
                                        <div class="input-errors" v-for="(error, index) of v$.form.address.$errors" :key="index">
                                            <div class="error-msg">{{ error.$message }}</div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="d-flex flex-wrap align-items-center">
                                        <button type="submit" class="btn c1-hover btn-border me-2" :disabled="v$.form.$invalid" >
                                            <span>{{ this.translate('save') }}</span> 
                                        </button>
                                    </div>
                                </div>
                        </form>
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
            result:[],
            form: {
                email: '',
                phone: '',
                name: '',
                address: '',
            },
            autocompleteValue: 'off',

        }

    },

    mounted (){

    },

    created (){
        this.fetchUserInfo();
    },
        
    validations() {

        return {

            form: {
                
                email: {
                    required, email 
                },

                phone: {
                    required, 
                },
                name: {
                    required, 
                },
                address: {
                    required, 
                },

            },
        }
    },
    methods: {

                async fetchUserInfo() {

                    this.isLoggedIn = localStorage.getItem('provider');

                    const provider = JSON.parse(this.isLoggedIn);

                    const parameters = {
                        id: provider.id,
                    };
                    axios.post(this.$authentication+'provider_info/',parameters)
                        .then(response => {
                            if(response.data.status==200){
                                this.result =  response.data.provider
                                this.form.email =  this.result.email
                                this.form.phone =  this.result.phone_no
                                this.form.name =  this.result.name
                                this.form.address =  this.result.location
                            }
                            if(response.data.status==400){
                                swal("Oops!", response.data.message, "error");
                            }
                        })
                        .catch(error => {
                        console.log(error)
                        });
                },


                async saveProvider() {

                    this.isLoggedIn = localStorage.getItem('provider');

                    const provider_id = JSON.parse(this.isLoggedIn);

                    const parameters = {
                        user_id: provider_id,
                    };
                    axios.post(this.$authentication+'user_info/',parameters)
                        .then(response => {
                            if(response.data.status==200){
                                console.log(data)
                                swal("Successfully Logged!", "" ,"success");
                            }
                            if(response.data.status==400){
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