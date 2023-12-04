<template>

  <div class="pt-120 pb-120 mt-n2 bg-color">
   <div class="container">
    <div class="justify-content-center">
     <div class="row justify-content-center">
      <div class="col">
        <div class="form-wrap login-form-wrap style--two form-border">
       <form @submit.prevent="submitOTP" >
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group mb-20">
                    <label for="title" class="mb-2 semi-bold title-color">Heading</label>
                    <input type="text" id="title" class="form-control" placeholder="Brief explanation of the assignment" v-model="v$.form.title.$model">
                    <div class="input-errors" v-for="(error, index) of v$.form.title.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group mb-20">
                    <label for="title" class="mb-2 semi-bold title-color">Description</label>
                    <textarea class="form-control"  cols="30" rows="20" placeholder="A good description of the assignment makes it easier for companies to give a good answer." v-model="v$.form.description.$model"></textarea>
                    <div class="input-errors" v-for="(error, index) of v$.form.title.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group  mb-20">
                    <label for="l_name" class="mb-2 semi-bold title-color">Category</label>
                        <div class="custom-select c1">
                                <select  @change="fetchSubCategory($event)" v-model="selectedCategoryId" class="form-control">
                                        <option selected disabled>Choose category from dropdown</option>
                                        <option v-for="cat in categories.data" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
                                </select>
                        </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group mb-20">
                    <label for="l_name" class="mb-2 semi-bold title-color">Sub Category</label>
                    <div class="custom-select c1">
                        <select name="" id=""  class="form-control"  v-model="selectedSubCategoryId">
                                <option >Choose Subcategory from dropdown</option>
                                <option v-for="subCat in subCategories.data" :value="subCat.id">{{ subCat.name }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-6">
                <div class="form-group mb-20">
                    <label for="s_date" class="mb-2 semi-bold title-color">Start Job</label>
                    <select   v-model="v$.form.s_date.$model" class="form-control">
                            <option value="" Asselected disabled>Choose dropdown</option>
                            <option value="any time">Any Time</option>
                            <option value="As soon as possible">As soon as possible</option>
                    </select>
                    <div class="input-errors" v-for="(error, index) of v$.form.s_date.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mb-20">
                    <label for="cost" class="mb-2 semi-bold title-color">Estimated Cost</label>
                    <input type="text" id="cost" class="form-control" placeholder="Estimated Cost" v-model="v$.form.cost.$model">
                   
                    <div class="input-errors" v-for="(error, index) of v$.form.cost.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div> -->

            <div class="col-lg-4">
                <div class="form-group mb-20">
                    <label for="email" class="mb-2 semi-bold title-color">Email</label>
                    <input type="text" id="email" class="form-control" placeholder="Email" v-model="v$.form.email.$model">
                    <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mb-20">
                    <label for="phone" class="mb-2 semi-bold title-color">Phone</label>
                    <input type="text" id="phone" class="form-control"  v-model="v$.form.phone.$model">
                    <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group mb-20">
                    <label for="name" class="mb-2 semi-bold title-color">Name</label>       
                    <input type="text" id="name" class="form-control" placeholder="Name" v-model="v$.form.name.$model">
                    <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-20">
                    <label for="city" class="mb-2 semi-bold title-color">City</label>
                    <input type="text" id="city" class="form-control" placeholder="city" v-model="v$.form.city.$model">
                    <div class="input-errors" v-for="(error, index) of v$.form.city.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-20">
                    <label for="address" class="mb-2 semi-bold title-color">Address</label>
                    <input type="text" id="address" class="form-control" placeholder="address" v-model="v$.form.address.$model">
                    <div class="input-errors" v-for="(error, index) of v$.form.address.$errors" :key="index">
                        <div class="error-msg">{{ error.$message }}</div>
                    </div>
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

        <div class="d-flex align-items-center" v-if="!otpSent">
            <button type="submit" class="btn c1-hover btn-border" :disabled="v$.form.$invalid">
                <span>Submit</span>
            </button>
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

                this.fetchJob();
            },
       

        data() {

                return {
                    selectedCategoryId:null,
                    selectedSubCategoryId:null,
                    categories: [],
                    subCategories: [],
                    phoneNumber: '',
                    verificationId: '',
                    verificationCode: '',
                    confirmationResult: null,
                    otpSent: false,

                    form: {
                            name: '',
                            email: '',
                            phone: '',
                            title: '',
                            address: '',
                            city: '',
                            s_date: '',
                            cost: '',
                            category: '',
                            sub_category: '',
                            confirmPassword: '',
                            description:'',
                        },

                };
        },

        validations() {

                    return {

                        form: {
                            
                            email: {
                                required, email 
                            },

                            name: {
                                required, 
                            },
                            
                            phone: {
                                required, 
                            },
                            
                            address: {
                                required, 
                            },
                            title: {
                                required, 
                            },
                            city: {
                                required, 
                            },
                            description:{
                                required,
                            }
                            
                        },
                    }
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

                    submitOTP() {
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
                                    this.subCategories = response.data;
                                })
                                .catch(error => {
                                    console.log(error)
                                });

                        },

                    async fetchJob() {

                                        this.isLoggedIn = localStorage.getItem('accessToken') !== null;
                                        this.userId = localStorage.getItem('user');
                                        const user = JSON.parse(this.userId);

                                        if (this.isLoggedIn) {
                                                const parameters = {
                                                    user_id: user.user_id,
                                                    job_id: this.$route.query.job_id,
                                                   
                                                };
                                                axios.post(this.$service+'single_job/',parameters)
                                                    .then(response => {

                                                        if(response.data.status==200){

                                                            this.job =  response.data.data
                                                            this.form.title =  this.job[0].title
                                                            this.form.description =  this.job[0].description
                                                            this.form.email =  this.job[0].email
                                                            this.form.phone =  this.job[0].phone
                                                            this.form.name =  this.job[0].name
                                                            this.form.address =  this.job[0].address
                                                            this.form.city =  this.job[0].city
                                                            this.selectedCategoryId =  this.job[0].category
                                                            this.selectedSubCategoryId =  this.job[0].sub_category
                                                            
                                                        }

                                                        if(response.data.status==400){
                                                            swal("Oops!", response.data.message, "error");
                                                        }

                                                    })
                                                    .catch(error => {
                                                    console.log(error)
                                                    });
                                        }else{
                                            swal("Before Job Post must Login!", "" ,"error");
                                            this.$router.push({name:"Login"});
                                        }
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
                                        user_id: user.user_id,
                                        job_id: this.$route.query.job_id,
                                        email: this.form.email,
                                        category: this.selectedCategoryId,
                                        title: this.form.title,
                                        description: this.form.description,
                                        name: this.form.name,
                                        phone: phoneNumber,
                                        address: this.form.address,
                                        city: this.form.city,
                                        job_start: this.form.s_date,
                                        your_cost: this.form.cost,
                                        sub_category: this.selectedSubCategoryId,
                                       
                                    };

                                    axios.post(this.$service+'update_job/',parameters)
                                        .then(response => {

                                            if(response.data.status==200){
                                                swal("Job Updated Successfully!", "" ,"success");
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
                                swal("Before Job Post must Login!", "" ,"error");
                                this.$router.push({name:"Login"});
                            }
                        },

                   
        },

    };

</script>