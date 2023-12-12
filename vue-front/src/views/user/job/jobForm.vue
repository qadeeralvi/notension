<template>
    <div class="pt-60 pb-120 mt-n2 bg-color">
        <div class="container">
            <div class="justify-content-center">
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="form-wrap login-form-wrap style--two form-border">
                            <center><h2>Job Post Form</h2></center>
                                &nbsp;
                                &nbsp;
                            <form @submit.prevent="submitOTP" >
                                <div class="tab" v-show="currentTab === 0">
                                    <input type="hidden" v-model="tab[0].inputValue">
                            <div v-if="currentTab === 0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group  mb-20">
                                                <center><h3 class="deYsAp">{{ this.translate('headingLable') }}</h3></center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-20">
                                            <label for="title" class="mb-2 semi-bold title-color">{{ this.translate('heading') }} <span style="color: red;">*</span></label>
                                            <input type="text"  :class="{ 'form-control': true, 'is-invalid': v$.form.title.$errors.length > 0 }" v-model="v$.form.title.$model" id="title" class="form-control"  placeholder="Brief explanation of the assignment" >
                                                <div class="input-errors" v-for="(error, index) of v$.form.title.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="form-group mb-20">
                                            <label for="title" class="mb-2 semi-bold title-color">{{ this.translate('description') }} <span style="color: red;">*</span></label>
                                            <textarea :class="{ 'form-control': true, 'is-invalid': v$.form.description.$errors.length > 0 }" v-model="v$.form.description.$model"  cols="30" rows="20" placeholder="A good description of the assignment makes it easier for companies to give a good answer." ></textarea>
                                                <div class="input-errors" v-for="(error, index) of v$.form.description.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group  mb-20">
                                                <label for="l_name" class="mb-2 semi-bold title-color">{{ this.translate('category') }} <span style="color: red;">*</span></label>
                                                    <div class="custom-select c1">
                                                            <select  @change="fetchSubCategory($event)" v-model="selectedCategoryId" class="form-control">
                                                                    <option disabled>Choose category from dropdown</option>
                                                                    <option v-for="cat in categories.data" :value="cat.id" :selected="this.selectedCategoryId === cat.id">{{ cat.name }}</option>
                                                            </select>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6"  >
                                            <div class="form-group mb-20" v-if="showSubCategorySelect==true">
                                                <label for="l_name" class="mb-2 semi-bold title-color">{{ this.translate('subCategory') }}</label>
                                                <div class="custom-select c1">
                                                    <select name="" id=""  class="form-control"  v-model="selectedSubCategoryId">
                                                            <option value="">Choose Subcategory from dropdown</option>
                                                            <option v-for="subCat in subCategories.data" :value="subCat.id">{{ subCat.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="tab" v-show="currentTab === 1">
                                    <input v-model="tab[1].inputValue" class="form-controle" type="hidden">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group  mb-20">
                                                <center><h3 class="deYsAp">{{ this.translate('nameLable') }}</h3></center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group mb-20">
                                                <label for="name" class="mb-2 semi-bold title-color">{{ this.translate('name') }} <span style="color: red;">*</span></label>       
                                                <input type="text" id="name" :class="{ 'form-control': true, 'is-invalid': v$.form.name.$errors.length > 0 }" v-model="v$.form.name.$model" placeholder="Name" >
                                                    <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                            
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-20">
                                                <label for="email" class="mb-2 semi-bold title-color">{{ this.translate('email') }}</label>
                                                <input type="text" id="email" :class="{ 'form-control': true, 'is-invalid': v$.form.email.$errors.length > 0 }" v-model="v$.form.email.$model" placeholder="Email">
                                                    <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-20">
                                                <label for="phone" class="mb-2 semi-bold title-color">{{ this.translate('phone') }} <span style="color: red;">*</span></label>
                                                <input type="tel" :placeholder="this.translate('phone')" maxlength="11" id="phone" :class="{ 'form-control': true, 'is-invalid': v$.form.phone.$errors.length > 0 }" @input="this.filterNumbers" v-model="v$.form.phone.$model"  >
                                                    <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-20">
                                                <label for="city" class="mb-2 semi-bold title-color">{{ this.translate('city') }} <span style="color: red;">*</span></label>
                                                <input type="text" id="city" placeholder="city" :class="{ 'form-control': true, 'is-invalid': v$.form.city.$errors.length > 0 }" v-model="v$.form.city.$model">
                                                <div class="input-errors" v-for="(error, index) of v$.form.city.$errors" :key="index">
                                                    <div class="error-msg">{{ error.$message }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-20">
                                                <label for="address" class="mb-2 semi-bold title-color">{{ this.translate('address') }} <span style="color: red;">*</span></label>
                                                <input type="text" id="address" class="form-control" placeholder="address" :class="{ 'form-control': true, 'is-invalid': v$.form.address.$errors.length > 0 }" v-model="v$.form.address.$model">
                                                    <div class="input-errors" v-for="(error, index) of v$.form.address.$errors" :key="index">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                            </div>
                                        </div>

                                        

                                    </div>
                                </div>
                                <div class="tab" v-show="currentTab === 2">
                                    <input v-model="tab[2].inputValue" class="form-controle" type="hidden">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group  mb-20">
                                                <center><h3 class="deYsAp">{{ this.translate('jobQuestuionLable') }}</h3></center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-20">
                                                <label for="s_date" class="mb-2 semi-bold title-color">{{ this.translate('jobQuestuion1') }}</label>
                                                <select   v-model="form.s_date" class="form-control">
                                                        <option value="" Asselected disabled>Choose dropdown</option>
                                                        <option value="any time">Any Time</option>
                                                        <option value="As soon as possible">As soon as possible</option>
                                                </select>
                                            
                                            </div>
                                        </div>
                                        <div class="col-lg-6" >
                                            <div class="form-group mb-20">
                                                <label for="cost" class="mb-2 semi-bold title-color">{{ this.translate('jobQuestuion2') }}</label>
                                                <input type="text" id="cost" class="form-control" placeholder="Estimated Cost" v-model="form.cost">
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="!otpSent" id="recaptcha-container"></div>
                                    <br>
                                    <div v-if="verificationId">
                                        <form @submit.prevent="verifyOtp">

                                            <div class="form-group mb-20">
                                                <label  class="mb-2 semi-bold title-color">Verification code</label>
                                                <input type="text"  class="form-control" required placeholder="Enter the verification code sent to your phone:" v-model="verificationCode">
                                                <button type="submit" class="btn c1-hover btn-border">Verify OTP</button>
                                            </div>
                                        </form>
                                    </div>
                                    <center>
                                        <button class="btn btn-success" @click="prevTab">Prev</button>&nbsp
                                        <button type="submit"
                                                        class="btn btn-success"
                                                        :disabled="v$.form.$invalid" >
                                                    <span>Submit</span>
                                        </button>
                                    </center>
                                </div>
                                    <center>
                                        <div v-show="currentTab != 2">
                                            <button type="button" class="btn btn-success"  :disabled="prewBtn" @click="prevTab">Prev</button>&nbsp
                                            <button type="button" class="btn btn-success btnNext" :disabled="isNextButtonDisabled" :class="'length' + currentTab " @click="nextTab">{{ currentTab === steps.length - 1 ? '' : 'Next' }}</button>
                                        </div>
                                    </center>
                                    <div>
                                </div>
                            </form>
                            </div>
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
    import { required, email } from '@vuelidate/validators'
    const config = {
                    apiKey: "AIzaSyCE16bwKFDAlZ2BKl_p-gCVEEfoy1NULYQ",
                    authDomain: "notension-mobile-otp.firebaseapp.com",
                    projectId: "notension-mobile-otp",
                    storageBucket: "notension-mobile-otp.appspot.com",
                    messagingSenderId: "477712646493",
                    appId: "1:477712646493:web:7b048ce53a35a81f0ca8b4",
                    measurementId: "G-9CKCEZ133R"
            };

  export default {

    setup () {
            return { v$: useVuelidate() }
        },

        created() {

                this.fetchUserInfo();
                // set selected category ID from query parameter if it exists
                const selectedCat = JSON.parse(localStorage.getItem('typeFromHeading'));

                    if(selectedCat) {
                    
                        if(selectedCat.type==='category'){
                            this.selectedCategoryId = selectedCat.id;
                            console.log(this.selectedCategoryId )
                            this.fetchSubCategory('',selectedCat.id,'cat');
                        }
                        else if(selectedCat.type==='sub_category')
                        {
                            this.selectedSubCategoryId = selectedCat.id;
                        }
                    }

                    if (this.$route.query.cat) {
                        if(this.$route.query.param=='cat'){
                            
                            this.selectedCategoryId = parseInt(this.$route.query.cat);
                            this.fetchSubCategory('',this.$route.query.cat,'cat');
                        }
                        else{
                            const parameters = { subCat_id: this.$route.query.cat, };
                            axios.post(this.$service+'category_Id',parameters)
                            .then(response => {
                                this.selectedCategoryId = response.data.data.category_id;
                            })
                            .catch(error => {
                                console.error(error);
                            });
                            this.fetchSubCategory('',this.$route.query.cat,'cat');
                            this.selectedSubCategoryId = parseInt(this.$route.query.cat);
                        }
                    }
                // fetch categories from API or elsewhere and set to this.categories
                },

    data() {

      return {
                    selectedCategoryId:null,
                    selectedSubCategoryId:null,
                    categories: [],
                    subCategories: [],  
                    showSubCategorySelect:true, 
                    phoneNumber: '',
                    verificationId: '',
                    verificationCode: '',
                    confirmationResult: null,
                    otpSent: false,

                    form: {
                            title: (localStorage.getItem('formHeading')!=''?localStorage.getItem('formHeading'):''),
                            description:'',
                            name: '',
                            email: '',
                            phone: '',
                            address: '',
                            city: '',
                            s_date: '',
                            cost: '',
                            category: '',
                            sub_category: '',
                            confirmPassword: '',
                        },      
                currentTab: 0,
                prewBtn:true,
                steps: ['Step 1', 'Step 2', 'Step 3'],
                tab: [
                { inputValue: '', valid: false },
                { inputValue: '', valid: false },
                { inputValue: '', valid: false }
                ]
      }

    },
    validations() {

                return {

                    form: {
                        
                        title: {  required },
                        description: {  required },
                        name: {  required },
                        email: {  email },
                        phone: {  required },
                        city: {  required },
                        address: {  required },
                        
                    },
                }
        },

        computed: {
            isNextButtonDisabled() {
            if (this.currentTab === 0) {
               
                this.prewBtn=true;
                if (this.form.title && this.form.title.length>0 && this.form.description && this.form.description.length>0  && this.selectedCategoryId!=null) {
                    return false;
                }
               
            }

            if (this.currentTab === 1) {
                this.prewBtn=false;
                if(this.form.name.length>0 && this.form.phone.length>0 && this.form.address.length>0 && this.form.city.length>0 ){
                    return false;
                }
            }

            if (this.currentTab === 2) {
                this.prewBtn=false;
                if(this.form.name.length>0 && this.form.phone.length>0 && this.form.address.length>0 && this.form.city.length>0 ){
                    return false;
                }
            }
            return true;
            },
        },

    mounted() {

            axios.get(this.$service+'category')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.error(error);
                });

                const phoneInputField = document.querySelector("#phone");
                const phoneInput = window.intlTelInput(phoneInputField, {
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                    initialCountry: "pk",
                });

                const element = document.querySelector('.iti--allow-dropdown');
                element.style.display = 'block';

            },

    methods: {

            prevTab() {
                if (this.currentTab > 0) {
                    this.currentTab--;
                }
            },

            nextTab() {
                

                if (this.currentTab < this.steps.length - 1) {
                    this.currentTab++;
                } else {
                    this.submitForm();
                }
            },
            
            submitOTP() {
                        
                        if (!this.isLoggedIn) {
                            this.postJob();
                        }
                        else{
                                firebase.initializeApp(config);
                                const phoneInputField = document.querySelector("#phone");
                                const phoneInput = window.intlTelInputGlobals.getInstance(phoneInputField);
                                const phoneNumber = phoneInput.getNumber();

                                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
                                    'size': 'visible',
                                    'callback': (response) => {
                                        // reCAPTCHA solved, allow signInWithPhoneNumber.
                                        onSignInSubmit();
                                    }
                                });

                                const appVerifier = window.recaptchaVerifier;
                                firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                                .then((confirmationResult) => {

                                    this.otpSent = true;
                                    this.confirmationResult = confirmationResult;
                                    this.verificationId = confirmationResult.verificationId
                                })
                                .catch((error) => {
                                    console.error(error);
                                });
                            }

                    },


            verifyOtp() {
                            // firebase.initializeApp(config);
                            const credential = firebase.auth.PhoneAuthProvider.credential(this.verificationId, this.verificationCode)
                            firebase.auth().signInWithCredential(credential)
                                .then(() => {
                                    this.postJob();
                                })
                                .catch(error => {
                                    swal("Oops!", "Please Enter correct code", "error");
                                })
                        },


            fetchSubCategory(event='',cat=''){

                                let parameters = {};

                                if(cat!=''){
                                    parameters = {  id: cat, };
                                }
                                else{
                                    parameters = { id: event.target.value, };
                                }

                                axios.post(this.$service+'subCategory',parameters)
                                .then(response => {
                                    if(response.data.status==200){
                                        this.subCategories = response.data;
                                        this.showSubCategorySelect=true;
                                    }
                                    else{
                                        this.showSubCategorySelect=false;
                                    }
                                })
                                .catch(error => {
                                    console.log(error)
                                });

                        },

            async postJob() {

                                this.isLoggedIn = localStorage.getItem('accessToken') !== null;
                                this.userId = localStorage.getItem('user');
                                const user = JSON.parse(this.userId);

                                const phoneInputField = document.querySelector("#phone");
                                const phoneInput = window.intlTelInputGlobals.getInstance(phoneInputField);
                                const phoneNumber = phoneInput.getNumber();
                                if (this.isLoggedIn) {
                                        const parameters = {
                                            user_id: (user?user.user_id:'0'),
                                            email: this.form.email,
                                            category: this.selectedCategoryId,
                                            title: this.form.title,
                                            name: this.form.name,
                                            phone: phoneNumber,
                                            address: this.form.address,
                                            city: this.form.city,
                                            job_start: this.form.s_date,
                                            your_cost: this.form.cost,
                                            sub_category: this.selectedSubCategoryId,
                                            description: "test",
                                            signupmethod:"email"
                                        };

                                        axios.post(this.$service+'post_job/',parameters)
                                            .then(response => {

                                                if(response.data.status==200){

                                                    swal("Job Posted Successfully!", "" ,"success");
                                                    localStorage.removeItem('formHeading');
                                                    localStorage.removeItem('typeFromHeading');
                                                    this.$router.push({name:"JobList"});
                                                }

                                                if(response.data.status==400){
                                                    swal("Oops!", response.data.message, "error");
                                                }

                                            })
                                            .catch(error => {
                                                    console.log(error)
                                            });
                                }else{

                                    swal("Do Login for more details!", "" ,"success");
                                    this.$router.push({name:"Login"});
                                }
                        },


                        async fetchUserInfo() {

                            this.isLoggedIn = localStorage.getItem('user');

                            if(this.isLoggedIn!=null){

                                const data = JSON.parse(this.isLoggedIn);

                                const user_id = data.user_id; // Access the status property

                                const parameters = {
                                    id: user_id,
                                };

                                axios.post(this.$authentication+'user_info/',parameters)
                                .then(response => {
                                    if(response.data.status==200){
                                        this.info =  response.data.user
                                        this.form.email =  this.info.email
                                        this.form.phone =  this.info.phone_no
                                        this.form.name =  this.info.name
                                        this.form.address =  this.info.address
                                    }
                                    if(response.data.status==400){
                                        swal("Oops!", response.data.message, "error");
                                    }
                                })
                                .catch(error => {
                                    console.log(error)
                                });
                            }
                        },

                        
    }
  };
  </script>
  

  