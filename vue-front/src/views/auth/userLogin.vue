<template>

        <div class="pt-120 pb-120 ovx-hidden bg-color">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-wrap login-form-wrap style--two form-border">
                               
                                <form @submit.prevent="login" class="login-form">
                                    <div v-if="currentStep === 1">
                                        <h2 style="margin-left: 100px;">Login Form</h2>
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
                                            <!-- <button type="button" class="nextBtn  me-2" @click="nextStep" disabled>Next</button> -->
                                            <button type="button" data-testid="login-next-btn" font-size="18px" @click="nextStep" class="nextBtn sc-cjERFW gsLvdx" :disabled="isDisabledNext">
                                                <span><font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Next</font>
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
                                                <font style="vertical-align: inherit;">Log in without a password</font>
                                            </font>
                                        </h1>
                                    &nbsp;
                                    &nbsp;
                                    <p color="black.black9" font-size="2" class="sc-fbJfA eEtiQo">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">At Notension you don't have to remember passwords. </font>
                                            <font style="vertical-align: inherit;">Press the button Send me login link.</font>
                                        </font>
                                    </p>
                                    <!-- Step 2: Choose Login Method -->
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <button type="button" class="btn c1-hover btn-border me-2 margin2" @click="showPasswordLogin">
                                        <span>I want to log in with a password</span>
                                        </button>

                                        <button type="button" class="btn c1-hover btn-border me-2 margin_bt" @click="showOTPLogin">
                                        <span>Send me login link</span>
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

                                            <button type="submit" name="user-login" value="user-login" class="btn c1-hover btn-border me-2 margin2" :disabled="v$.form.$invalid" >
                                                <span>{{ this.translate('loginUser') }}</span> 
                                                <img :src="$main + '/assets/img/icon/user-icon.svg'" alt="" class="svg">
                                            </button>

                                            <button type="submit" name="provider-login" value="provider-login" class="btn c1-hover btn-border me-2 margin_bt" :disabled="v$.form.$invalid" >
                                                <span>{{ this.translate('loginCompany') }}</span> 
                                                <img :src="$main + '/assets/img/icon/user-icon.svg'" alt="" class="svg">
                                            </button>

                                        </div>
                                    </div>

                                    <div v-if="currentStep === 3 && loginMethod === 'otp'">
                                        <div class="sc-jTrPJq bCDtea">
                                            <img src="https://mittanbud.no/assets/images/common/login/no-password.svg" alt="Log in without a password" class="sc-jItqcz fusgpG">
                                        </div>
                                        <h1 font-size="3,4,4,4,6,6,7,8" font-weight="500" class="sc-eDDNvR eMUhjc">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">Log in without a password</font>
                                            </font>
                                        </h1>
                                        &nbsp;
                                        &nbsp;
                                        <p color="black.black9" font-size="2" class="sc-fbJfA eEtiQo">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">At Notension you don't have to remember passwords. </font>
                                                <font style="vertical-align: inherit;">Press the button to be sent a login link to the e-mail <span>{{ v$.form.email.$model }}.</span></font>
                                            </font>
                                        </p>

                                        <div class="sc-hIqOWS eZIWtP">
                                            <p color="black.black9" font-size="1" class="sc-blLsxD jKdusN">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">An e-mail has been sent to <span>{{ v$.form.email.$model }}</span> if you have a user account with us.</font>
                                                </font>
                                            </p>
                                        </div>

                                        <div display="flex" class="sc-jTrPJq jVupeX" style="gap: 10px;">
                                            <h4 class="sc-hAtEyd dmdLyc">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Enter code from email</font>
                                                </font>
                                            </h4>
                                            <div data-testid="123" class="sc-4b8f1322-0 eJcBdw">
                                                <input v-for="(input, index) in inputs" :key="index" ref="inputRefs" :data-testid="'123-input-' + index" type="tel" maxlength="1" autocomplete="one-time-code" class="sc-4b8f1322-1 TDIDl" v-model="inputs[index]">
                                            </div>
                                            <button :disabled="isButtonDisabled" type="button" class="sc-irTswW iRzsxL" @click="verify">
                                                <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Verify</font></font></span>
                                            </button>
                                            <button type="button" class="sc-irTswW cgDvLR">
                                                <span>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;" :disabled="isButtonDisabled" @click="verify">Resend the code</font>
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

                    nextStep() {
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

                         axios.post(this.$authentication+'user_forget/',parameters)
                                .then(response => {
                                    if(response.data.status==200){
                                        swal("Check Your email!", "" ,"success");
                                    }
                                    if(response.data.status==404){
                                        swal("Oops!", response.data.message, "error");
                                    }
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

                            axios.post(this.$authentication+'use_verify_code/',parameters)
                                .then(response => {
                                    if(response.data.status==200){
                                                window.localStorage.setItem('accessToken',response.data.access_token)
                                                window.localStorage.setItem('user',JSON.stringify(response.data))
                                                window.localStorage.setItem('type',JSON.stringify(response.data.type))
                                                this.$router.push('/userHome');
                                                location.href='/userHome';
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