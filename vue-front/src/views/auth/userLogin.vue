<template>

        <div class="pt-120 pb-120 ovx-hidden bg-color">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-wrap login-form-wrap style--two form-border">
                                <h2 style="margin-left: 100px;">Login Form</h2>
                                &nbsp;
                                &nbsp;
                            <form @submit.prevent="login" class="login-form">
                                <div class="form-group" :class="{ error: v$.form.email.$errors.length }" >
                                    <label for="email" class="mb-2 semi-bold black label_size">{{ this.translate('loginEmail') }}</label>
                                     <input type="text" id="email" class="form-control" v-bind:autocomplete="autocompleteValue" placeholder="Email Address or Phone number" v-model="v$.form.email.$model">
                                     
                                    <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                        <div class="error-msg">{{ error.$message }}</div>
                                    </div>
                                </div>

                                <div class="form-group" :class="{ error: v$.form.password.$errors.length }">
                                <label for="password" class="mb-2 semi-bold black label_size">{{ this.translate('password') }}</label> 
                                <div class="input-group">
                                    <input type="password" id="password" class="form-control"  v-model="v$.form.password.$model" placeholder="********">
                                    <div class="input-group-append" style="margin-left: -1px;display: flex;">
                                        <span class="input-group-text eyeBtn" @click="togglePasswordVisibility" >
                                            <i class="fa" :class="{'fa-eye': showPassword, 'fa-eye-slash': !showPassword}" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                        <div class="error-msg">{{ error.$message }}</div>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <!-- <input type="checkbox" id="checkbox">  -->
                                        <!-- <label for="checkbox" class="mb-0 ml-2 remember">Remember Me</label> -->
                                    </div>
                                    <router-link to="/forget">{{ this.translate('forgotPassword') }}</router-link>
                                </div>

                                <div class="d-flex flex-wrap align-items-center mb-4">

                                    <button type="submit" name="user-login" value="user-login" class="btn c1-hover btn-border me-2 margin2" :disabled="v$.form.$invalid" >
                                        <span>{{ this.translate('loginUser') }}</span> 
                                        <img :src="$main + '/assets/img/icon/user-icon.svg'" alt="" class="svg">
                                    </button>

                                    <button type="submit" name="provider-login" value="provider-login" class="btn c1-hover btn-border me-2 margin_bt" :disabled="v$.form.$invalid" >
                                        <span>{{ this.translate('loginCompany') }}</span> 
                                        <img :src="$main + '/assets/img/icon/user-icon.svg'" alt="" class="svg">
                                    </button>

                                </div>

                                <div class="d-flex flex-wrap align-items-center">
                                    
                                    <router-link to="/signUp">
                                        <button type="submit" class="btn c1-hover btn-border me-2" >
                                            <span>{{ this.translate('signupUser') }}</span> 
                                            <img :src="$main + '/assets/img/icon/user-icon.svg'" alt="" class="svg">
                                        </button>
                                    </router-link>
                                   
                                    <router-link to="/provider/signUp">
                                        <button type="submit" class="btn c1-hover btn-border" >
                                            <span>{{ this.translate('registerBusiness') }}</span> 
                                        </button>
                                    </router-link>

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
    import { inject } from 'vue'
    import useVuelidate from '@vuelidate/core'
    import { required, email, minLength } from '@vuelidate/validators'


    export default {

        mounted(){

                    const type =  localStorage.getItem('type');
                    if (type != '' && type == '"user"') {
                        this.$router.push({name:"Home"});
                    } 
                    else if(type != '' && type == '"provider"'){
                        this.$router.push({name:"ProviderHome"});
                    }
        },

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
                showPassword:true,

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


            togglePasswordVisibility() {
                const passwordInput = document.getElementById('password');
                passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                (passwordInput.type=='text'? this.showPassword=false:this.showPassword=true);
            },
                    async login(event) {

                        event.preventDefault();
                        
                        const buttonClicked = event.submitter.name;
                        
                        const parameters = {
                                    email: this.form.email,
                                    password: this.form.password,
                                };
                                
                                let api;
                                if(buttonClicked=='user-login'){
                                    api=this.$authentication+'login/';
                                }

                                else{
                                     api=this.$authentication+'providerLogin/';
                                    }
                                    
                                    axios.post(api,parameters)
                                    
                                    .then(response => {

                                        if(response.data.status==200){
                                            
                                            if(buttonClicked=='user-login'){
                                                window.localStorage.setItem('accessToken',response.data.access_token)
                                                window.localStorage.setItem('user',JSON.stringify(response.data))
                                                window.localStorage.setItem('type',JSON.stringify(response.data.type))
                                                this.$router.push('/userHome');
                                                location.href='/userHome';
                                            }

                                            else{

                                                window.localStorage.setItem('tokem',JSON.stringify(response.data.access_token))
                                                window.localStorage.setItem('provider',JSON.stringify(response.data.provider_info))
                                                window.localStorage.setItem('type',JSON.stringify(response.data.type))
                                                this.$router.push({name:"ProviderHome"});
                                                window.location.reload();
                                            }
                                          
                                        }
                                        if(response.data.status==400 || response.data.status==404 || response.data.status==401  || response.data.status==203){
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

@media only screen and (max-width: 600px) {
    .margin2 {
        margin-right: auto;
    }
    .margin_bt {
        margin-bottom: 20px;
    }
    .remember {
        font-size: 20px;
    }
    .label_size {
        font-size: 20px;
    }
}

.eyeBtn{
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 0.47rem 0.75rem;
    margin-bottom: 0;
    font-size: .8125rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #eff2f7;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;height:56px
}
</style>