<template>

        <div class="pt-120 pb-120 ovx-hidden bg-color">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-wrap login-form-wrap style--two form-border">
                               
                                <form @submit.prevent="login" class="login-form">
                                    <div v-if="currentStep === 1">
                                        <h2 style="margin-left: 100px;">{{ this.translate('loginForm') }}</h2>
                                        &nbsp;
                                        &nbsp;
                                        <div class="form-group" :class="{ error: v$.form.email.$errors.length }">
                                            <label for="email" class="mb-2 semi-bold black label_size">{{ this.translate('loginEmail') }}</label>
                                            <input type="text" @input="checkEmail" id="email" class="form-control" v-bind:autocomplete="autocompleteValue" placeholder="Email Address or Phone number" v-model="v$.form.email.$model">
                                            <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                            <div class="error-msg">{{ error.$message }}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <button type="button" data-testid="login-next-btn" font-size="18px" @click="nextStep('user')" class="nextBtn sc-cjERFW gsLvdx" :disabled="isDisabledNext">
                                                <span><font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">{{ this.translate('loginUser') }}</font>
                                                </font></span>
                                            </button>
                                            &nbsp;
                                            &nbsp;
                                            <button type="button" data-testid="login-next-btn" font-size="18px" @click="nextStep('provider')" class="nextBtn sc-cjERFW gsLvdx" :disabled="isDisabledNext">
                                                <span><font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">{{ this.translate('loginCompany') }}</font>
                                                </font></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div v-if="currentStep === 2">
                                        <div class="sc-jTrPJq bCDtea">
                                            <img src="https://mittanbud.no/assets/images/common/login/no-password.svg" alt="Log in without a password" class="sc-jItqcz fusgpG">
                                        </div>
                                        <h1 font-size="3,4,4,4,6,6,7,8" font-weight="500" class="sc-eDDNvR eMUhjc">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">{{ this.translate('loginWithoutPass') }}</font>
                                            </font>
                                        </h1>
                                    &nbsp;
                                    &nbsp;
                                    <p color="black.black9" font-size="2" class="sc-fbJfA eEtiQo">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">{{ this.translate('loginMsg') }}. </font>
                                            <font style="vertical-align: inherit;">{{ this.translate('loginMsg1') }}.</font>
                                        </font>
                                    </p>
                                    <!-- Step 2: Choose Login Method -->
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <button type="button" class="btn c1-hover btn-border me-2 margin2" @click="showPasswordLogin">
                                        <span>{{ this.translate('loginbtn') }}</span>
                                        </button>

                                        <button type="button" class="btn c1-hover btn-border me-2 margin_bt" @click="showOTPLogin">
                                        <span>{{ this.translate('loginbtn1') }}</span>
                                        </button>
                                    </div>
                                    </div>

                                    <div v-if="currentStep === 3 && loginMethod === 'password'">
                                    <!-- Step 3: Password Field -->
                                        <div class="form-group" :class="{ error: v$.form.password.$errors.length }">
                                            <label for="password" class="mb-2 semi-bold black label_size">{{ this.translate('password') }}</label>
                                            <div class="input-group">
                                            <input type="password" id="password" class="form-control" v-model="v$.form.password.$model" placeholder="********">
                                            <div class="input-group-append" style="margin-left: -1px;display: flex;">
                                                <span class="input-group-text eyeBtn" @click="togglePasswordVisibility">
                                                <i class="fa" :class="{'fa-eye': showPassword, 'fa-eye-slash': !showPassword}" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            </div>
                                            <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                            <div class="error-msg">{{ error.$message }}</div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center mb-4">
                                            <button type="submit" data-testid="login-next-btn" font-size="18px"  class="nextBtn sc-cjERFW gsLvdx" :disabled="v$.form.$invalid">
                                                <span><font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">{{ this.translate('login') }}</font>
                                                </font></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div v-if="currentStep === 3 && loginMethod === 'otp'">
                                        <div class="sc-jTrPJq bCDtea">
                                            <img src="https://mittanbud.no/assets/images/common/login/no-password.svg" alt="Log in without a password" class="sc-jItqcz fusgpG">
                                        </div>
                                        <h1 font-size="3,4,4,4,6,6,7,8" font-weight="500" class="sc-eDDNvR eMUhjc">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">{{ this.translate('loginWithoutPass') }}</font>
                                            </font>
                                        </h1>
                                        &nbsp;
                                        &nbsp;
                                        <p color="black.black9" font-size="2" class="sc-fbJfA eEtiQo">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">{{ this.translate('loginMsg') }}</font>
                                                <font style="vertical-align: inherit;">{{ this.translate('loginMsg1') }} <span>{{ v$.form.email.$model }}.</span></font>
                                            </font>
                                        </p>

                                        <div class="sc-hIqOWS eZIWtP">
                                            <p color="black.black9" font-size="1" class="sc-blLsxD jKdusN">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">{{ this.translate('loginMsg2') }} <span>{{ v$.form.email.$model }}</span> {{ this.translate('loginMsg3') }}.</font>
                                                </font>
                                            </p>
                                        </div>

                                        <div display="flex" class="sc-jTrPJq jVupeX" style="gap: 10px;">
                                            <h4 class="sc-hAtEyd dmdLyc">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">{{ this.translate('enterCode') }}</font>
                                                </font>
                                            </h4>
                                            <div data-testid="123" class="sc-4b8f1322-0 eJcBdw">
                                                <input v-for="(input, index) in inputs" :key="index" ref="inputRefs" :data-testid="'123-input-' + index" type="tel" maxlength="1" autocomplete="one-time-code" class="sc-4b8f1322-1 TDIDl" v-model="inputs[index]">
                                            </div>
                                            <button :disabled="isButtonDisabled" type="button" class="sc-irTswW iRzsxL" @click="verify">
                                                <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{ this.translate('verify') }}</font></font></span>
                                            </button>
                                            <button type="button" class="sc-irTswW cgDvLR">
                                                <span>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;" :disabled="isButtonDisabled" @click="verify">{{ this.translate('resendCode') }}</font>
                                                    </font>
                                                </span>
                                            </button>
                                        </div>

                                    </div>
                                </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-img mt-5 mt-lg-0">
                            <img :src="this.$main + '/assets/img/media/login_img.png'" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

</template>


<script>
    import axios from 'axios';
    import swal from 'sweetalert';
    import useVuelidate from '@vuelidate/core'
    import { required } from '@vuelidate/validators'

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
            return { v$: useVuelidate() }
        },

        computed: {

                concatenatedValues() {
                return this.inputs.join('');
                },
                isButtonDisabled() {
                // Adjust your condition based on the concatenatedValues
                return this.concatenatedValues.length !== 6;
                },
        },

        watch: {
                inputs: {
                handler(newInputs) {
                    const nonEmptyCount = newInputs.filter(value => value !== '').length;
                    this.isButtonDisabled = nonEmptyCount !== 6;
                },
                deep: true,
                },
        },

        data() {

            return {
                inputs: ['', '', '', '', '', ''],
                isButtonDisabled: true,
                form: {
                    email: '',
                    password: '',
                },
                autocompleteValue: 'off',
                showPassword:true,
                currentStep: 1,
                loginMethod: '', // 'password' or 'otp'
                isDisabledNext: true,

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

                        this.loader();
                        event.preventDefault();
                        this.checkBtn = localStorage.getItem('btnClicked');  
                        const parameters = {
                                    email: this.form.email,
                                    password: this.form.password,
                                };
                                
                                let api;
                                if(this.checkBtn=='user'){
                                    api=this.$authentication+'login/';
                                }

                                else{
                                     api=this.$authentication+'providerLogin/';
                                    }
                                    
                                    axios.post(api,parameters)
                                    
                                    .then(response => {

                                        $('.spinner-container').hide();

                                        if(response.data.status==200){
                                            this.isLoading = false;
                                            if(this.checkBtn=='user'){
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
                                            this.isLoading = false;
                                        }
                                    })
                                    .catch(error => {
                                    console.log(error)
                                    });
                    },

                    checkEmail(){

                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        this.isEmailValid = emailRegex.test(this.form.email);

                        const inputString = this.form.email.toString();

                        const isDigitString = /^\d+$/.test(inputString);

                        this.digitCount = isDigitString ? true: false;

                        const digitTotal = inputString.length;

                        if(this.digitCount===true && digitTotal>=11){
                            this.isDisabledNext = false;
                        }
                        else if(this.isEmailValid===true){
                            this.isDisabledNext = false;
                        }
                        else{
                            this.isDisabledNext = true;
                        }

                    },

                    nextStep(type) {
                        if(type=='user'){
                            window.localStorage.setItem('btnClicked',"user");
                        }
                        else if(type=='provider'){
                            window.localStorage.setItem('btnClicked',"provider");
                        }
                        this.currentStep = 2;
                    },
                    showPasswordLogin() {
                        this.loginMethod = 'password';
                        this.currentStep = 3;
                    },

                    showOTPLogin() {

                        this.loginMethod = 'otp';
                        this.currentStep = 3;

                        const parameters = {
                                email: this.form.email,
                            };

                         axios.post(this.$authentication+'optForgetUserProvider/',parameters)
                                .then(response => {
                                })
                                .catch(error => {
                                console.log(error)
                                });

                    },

                    verify() {

                            const values = this.concatenatedValues;
                        
                            const parameters = {
                                email: this.form.email,
                                code:values,
                            };

                            axios.post(this.$authentication+'verifyOtpUserProvider/',parameters)
                                .then(response => {
                                    if(response.data.status==200){
                                        if(response.data.type=='provider'){
                                                window.localStorage.setItem('token',JSON.stringify(response.data.access_token))
                                                window.localStorage.setItem('provider',JSON.stringify(response.data.provider_info))
                                                window.localStorage.setItem('type',JSON.stringify(response.data.type))
                                                this.$router.push({name:"ProviderHome"});
                                                window.location.reload();
                                            }
                                            else{
                                                window.localStorage.setItem('accessToken',response.data.access_token)
                                                window.localStorage.setItem('user',JSON.stringify(response.data))
                                                window.localStorage.setItem('type',JSON.stringify(response.data.type))
                                                this.$router.push('/userHome');
                                                location.href='/userHome';
                                            }
                                    }
                                    if(response.data.status==404){
                                        swal("Oops!", response.data.message, "error");
                                    }
                                })
                                .catch(error => {
                                console.log(error)
                                });
                               
                            },
                }
    }

    $(document).ready(function () {

        setTimeout(function () {
            $('.spinner-container').hide();
        }, 1000);

    });

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
.nextBtn{
    display: flex;
    flex-direction: row;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    width: 100%;
    position: relative;
    font-weight: 500;
    text-align: center;
    user-select: none;
    padding: 15px 47px;
    border-radius: 0px;
    transition: all 150ms ease-in-out 0s;
    background-color: rgb(57, 96, 191);
    color: rgb(255, 255, 255);
    border: none;
    margin-left: 0px;
    font-size: 18px;
}
.bCDtea{
    text-align: center;
    margin-bottom: 20px;
}
.eEtiQo {
    margin: 0px 0px 30px;
    font-weight: 400;
    display: block;
    text-align: center;
    color: rgb(16, 31, 65);
    font-size: 17px;
    line-height: 1.5;
}

.eMUhjc {
    margin: 0px 0px 15px;
    line-height: 1.25;
    font-size: 17px;
    font-weight: 700;
    text-align: center;
}

.jVupeX {
    display: flex;
    margin-top: 15px;
    flex-direction: column;
}

.eZIWtP {
    font-family: "Euclid Fireball", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    display: inline-flex;
    -webkit-box-align: center;
    align-items: center;
    margin: 5px 0px;
    padding: 7px 10px;
    border-radius: 0px;
    color: rgb(9, 19, 42);
    font-size: 15px;
    background: rgb(206, 242, 238);
}

.eJcBdw {
    display: flex;
    -webkit-box-pack: center;
    justify-content: center;
    gap: 10px;
}

.dmdLyc {
    margin: 0px 0px 10px;
    font-size: 17px;
    font-weight: 600;
    line-height: 1.25;
    text-align: center;
}
.TDIDl {
    width: 30px;
    height: 40px;
    font-size: 24px;
    text-align: center;
    background-color: rgb(245, 246, 247);
    border: 1px solid rgb(207, 210, 217);
    border-radius: 1px;
    padding: 0px;
}

.iRzsxL:disabled, .iRzsxL:disabled:hover {
    background-color: rgb(231, 233, 236);
    color: rgb(183, 188, 198);
    border: none;
    text-decoration: none;
    cursor: not-allowed;
}

.iRzsxL {
    display: flex;
    flex-direction: row;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    width: auto;
    position: relative;
    font-weight: 500;
    text-align: center;
    user-select: none;
    padding: 15px 47px;
    border-radius: 0px;
    transition: all 150ms ease-in-out 0s;
    font-size: 15px;
    background-color: rgb(57, 96, 191);
    color: rgb(255, 255, 255);
    border: none;
    margin: 7px auto;
}

.gsLvdx:disabled, .gsLvdx:disabled:hover {
    background-color: rgb(231, 233, 236);
    color: rgb(183, 188, 198);
    border: none;
    text-decoration: none;
    cursor: not-allowed;
}

.gsLvdx {
    display: flex;
    flex-direction: row;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    width: 100%;
    position: relative;
    font-weight: 500;
    text-align: center;
    user-select: none;
    padding: 15px 47px;
    border-radius: 0px;
    transition: all 150ms ease-in-out 0s;
    background-color: rgb(57, 96, 191);
    color: rgb(255, 255, 255);
    border: none;
    margin-left: 0px;
    font-size: 18px;
}

@media screen and (min-width: 376px){
    .eMUhjc {
        font-size: 18px;
    }
}

@media screen and (min-width: 1200px){
    .eMUhjc {
        font-size: 42px;
    }
}
</style>