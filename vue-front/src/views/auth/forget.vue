<template>

    <div class="pt-120 pb-120 ovx-hidden">
        <div class="container">
            <div class="row">
            <div class="col-lg-6">
                    <div class="form-wrap login-form-wrap style--two">
                        <form @submit.prevent="forget" class="login-form">
                            <div class="form-group" :class="{ error: v$.form.email.$errors.length }" >
                                <label for="email" class="mb-2 semi-bold black">Email Address or Phone Number</label>
                                 <input type="text" id="email" class="form-control" v-bind:autocomplete="autocompleteValue" placeholder="Email Address or Phone number" v-model="v$.form.email.$model">
                                 
                                <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap align-items-center">
                                <button type="submit" class="btn c1-hover btn-border me-2" :disabled="v$.form.$invalid" >
                                    <span>Submit</span> 
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            <div class="col-lg-6">
                <div class="login-img mt-5 mt-lg-0"><img :src="$main + '/assets/img/media/login_img.png'" alt=""></div>
            </div>
            </div>
        </div>
    </div>

</template>


<script>
import axios from 'axios';
import swal from 'sweetalert';
import useVuelidate from '@vuelidate/core'
import { required} from '@vuelidate/validators'


export default {

    setup () {
        return { v$: useVuelidate() }

    },

    data() {

        return {

            form: {
                email: '',
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

            },
        }
    },
    methods: {

                async forget() {

                            const parameters = {
                                email: this.form.email,
                            };

                            
                            axios.post(this.$authentication+'user_forget/',parameters)
                                .then(response => {

                                    if(response.data.status==200){
                                        swal("Check your email!", "" ,"success");
                                    }
                                    else if(response.data.status==400){
                                        swal("Oops!", response.data.message, "error");
                                    }
                                    else if(response.data.status==404){
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