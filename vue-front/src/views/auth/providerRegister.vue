<template>
    <div class="pt-120 pb-120 mt-n2 bg-color">
     <div class="container">
      <div class="justify-content-center">
       <div class="row justify-content-center">
        <div class="col">
          <div class="form-wrap login-form-wrap style--two form-border">
            <center><h2>Company Registration Form</h2></center>
            &nbsp;
            &nbsp;
         <form @submit.prevent="Signup">
          <div class="row">
              <div class="col-lg-6">
                  <div class="form-group mb-20" >
                      <label for="f_name" class="mb-2 semi-bold title-color">{{ this.translate('name') }}</label>
                      <input type="text" id="name" class="form-control" placeholder="Name" v-model="v$.form.name.$model">
                      <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                          <div class="error-msg">{{ error.$message }}</div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="form-group mb-20" >
                      <label for="city" class="mb-2 semi-bold title-color">{{ this.translate('email') }}</label>
                      <input type="email" id="email" class="form-control" :placeholder="this.translate('email')" v-model="v$.form.email.$model">
                      <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                          <div class="error-msg">{{ error.$message }}</div>
                      </div>
                  </div>
              </div>
                <div class="col-lg-6">
                    <div class="form-group mb-20">
                        <label for="phone" class="mb-2 semi-bold title-color">{{ this.translate('phone') }}</label>
                        <input  id="phone" type="tel" :placeholder="this.translate('phone')" name="phone" class="form-control" maxlength="11" @input="this.filterNumbers"  v-model="v$.form.phone.$model">
                        <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                            <div class="error-msg">{{ error.$message }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-20">
                        <label for="total_employees" class="mb-2 semi-bold title-color">{{ this.translate('totalEmplyee') }}</label>       
                        <input type="number" id="total_employees" class="form-control" :placeholder="this.translate('totalEmplyee')" v-model="v$.form.total_employees.$model">
                        <div class="input-errors" v-for="(error, index) of v$.form.total_employees.$errors" :key="index">
                            <div class="error-msg">{{ error.$message }}</div>
                        </div>
                    </div>
                </div>
              
                <div class="col-lg-6">
                    <div class="form-group mb-20">
                        <label for="address" class="mb-2 semi-bold title-color">{{ this.translate('address') }}</label>       
                        <input type="text" id="address" class="form-control" :placeholder="this.translate('address')" v-model="v$.form.address.$model">
                        <div class="input-errors" v-for="(error, index) of v$.form.address.$errors" :key="index">
                            <div class="error-msg">{{ error.$message }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-20">
                        <label for="l_name" class="mb-2 semi-bold title-color">{{ this.translate('category') }}</label>
                        <select  v-model="v$.form.category.$model" class="form-control">
                                <option value="" selected disabled>Choose category from dropdown</option>
                                <option v-for="cat in categories.data" :value="cat.id">{{ cat.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-20">
                        <label for="password" class="mb-2 semi-bold title-color">{{ this.translate('password') }}</label>
                        <div class="input-group">
                            <input type="password" id="password" class="form-control" :placeholder="this.translate('password')" v-model="v$.form.password.$model">
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
                </div>
                <div class="col-lg-6">
                <div class="form-group mb-20">
                    <label for="confirmPassword" class="mb-2 semi-bold title-color">{{ this.translate('confirmPassword') }}</label>
                    <div class="input-group">
                        <input type="password" id="confirmPassword" class="form-control" :placeholder="this.translate('confirmPassword')" v-model="v$.form.confirmPassword.$model">
                        <div class="input-group-append" style="margin-left: -1px;display: flex;">
                            <span class="input-group-text eyeBtn" @click="toggleConfirmPasswordVisibility" >
                                <i class="fa" :class="{'fa-eye': showConfirmPassword, 'fa-eye-slash': !showConfirmPassword}" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                        <div class="input-errors" v-for="(error, index) of v$.form.confirmPassword.$errors" :key="index">
                            <div class="error-msg" >
                                    {{ validationsErrorMessages.form.confirmPassword.sameAs }}
                            </div>
                        </div>
                    </div>
            </div>
          </div>
  
          <div class="d-flex align-items-center">
              <button type="submit" class="btn c1-hover btn-border" :disabled="v$.form.$invalid">
                  <span>{{ this.translate('signup') }}</span>
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
      import { inject } from 'vue'
      import useVuelidate from '@vuelidate/core'
      import { required, email,sameAs } from '@vuelidate/validators'
  
  
      export default {
  
            setup () {

                let cookies = inject('cookies');
                return { v$: useVuelidate() }
    
            },

            mounted() {

                    const phoneInputField = document.querySelector("#phone");
                    const phoneInput = window.intlTelInput(phoneInputField, {
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                    initialCountry: "pk",
                    });
                    const element = document.querySelector('.iti--allow-dropdown');
                    element.style.display = 'block';


                    axios.get('https://services.notension.pk/api/category')
                        .then(response => {
                            this.categories = response.data;
                        })
                        .catch(error => {
                            console.error(error);
                        });

            },

            computed: {
                validationsErrorMessages() {
                    return {
                        form: {
                                confirmPassword: {
                                    sameAs: 'The Confirm password do not match with password.',
                                },
                            }
                    }
                }
            },
  
            data() {
  
                return {
                    categories: [],
                    form: {
                        name: '',
                        email: '',
                        phone: '',
                        address: '',
                        password: '',
                        category: '',
                        confirmPassword: '',
                        total_employees: '',
                    },
                    autocompleteValue: 'off',
                    showPassword:true,
                    showConfirmPassword:true,
    
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
                    
                                        confirmPassword: {
                                                required,
                                                sameAs: function () {
                                                        const passwordValue = this.form.password;
                                                        const confirmPasswordValue = this.form.confirmPassword;
                                                        if (passwordValue !== confirmPasswordValue) {
                                                            return false;
                                                        }
                                                        return true;
                                                    },
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

                                        category: {
                                            required, 
                                        },

                                        total_employees: {
                                            required, 
                                        },
                                        
                                    },
                            }
            },

            methods: {

                    async Signup() {

                        const phoneInputField = document.querySelector("#phone");
                        const phoneInput = window.intlTelInputGlobals.getInstance(phoneInputField);
                        const phoneNumber = phoneInput.getNumber();

                          const parameters = {
                              email: this.form.email,
                              password: this.form.password,
                              confirmPassword: this.form.confirmPassword,
                              name: this.form.name,
                              phone: phoneNumber,
                              location: this.form.address,
                              category: this.form.category,
                              total_employees: this.form.total_employees,
                              signupmethod:"email"
                          };
  
                          axios.post(this.$authentication+'service-provider/signup',parameters)
                              .then(response => {
  
                                  if(response.data.status==200){

                                        swal("Successfully Register!", "" ,"success");
                                        location.href='/login';
                                  }
  
                                  if(response.data.status==400){
                                      swal("Oops!", response.data.message, "error");
                                  }
  
                              })
                              .catch(error => {
                                console.log(error)
                              });
                    },

                    togglePasswordVisibility() {
                        const passwordInput = document.getElementById('password');
                        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                        (passwordInput.type=='text'? this.showPassword=false:this.showPassword=true);
                    },
                    toggleConfirmPasswordVisibility() {
                        const passwordInput1 = document.getElementById('confirmPassword');
                        passwordInput1.type = passwordInput1.type === 'password' ? 'text' : 'password';
                        (passwordInput1.type=='text'? this.showConfirmPassword=false:this.showConfirmPassword=true);
                    },
                  }
      }
  
  </script>
  
  <style>
  .error-msg{
      color:red;
  }
  </style>