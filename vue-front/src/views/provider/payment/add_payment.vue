<template>

    <div class="pt-120 pb-120 mt-n2 bg-color">
     <div class="container">
      <div class="justify-content-center">
       <div class="row justify-content-center">
        <div class="col">
          <div class="form-wrap login-form-wrap style--two">
         <form @submit.prevent="savePayment" >
          <div class="row">
              <div class="col-lg-6">
                  <div class="form-group mb-20">
                      <label for="title" class="mb-2 semi-bold title-color">{{ this.translate('paymentType') }}</label>
                      <select v-model="this.form.payment_type" class="form-control">
                              <option selected disabled>Choose Payment Type</option>
                              <option value="bank">Bank</option>
                              <option value="jazzcash">Jazzcash</option>
                              <option value="easypaisa">Easypaisa</option>
                      </select>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="form-group mb-20">
                      <label for="l_name" class="mb-2 semi-bold title-color">{{ this.translate('amount') }}</label>
                      <input type="text" id="amount" class="form-control" :placeholder="this.translate('amount')" v-model="v$.form.amount.$model">
                      <div class="input-errors" v-for="(error, index) of v$.form.amount.$errors" :key="index">
                          <div class="error-msg">{{ error.$message }}</div>
                      </div>
                  </div>
              </div>
             
              <div class="col-lg-6">
                  <div class="form-group mb-20">
                      <label for="acc_title" class="mb-2 semi-bold title-color">{{ this.translate('accountTitle') }}</label>
                      <input type="text" id="acc_title" class="form-control" :placeholder="this.translate('accountTitle')" v-model="v$.form.acc_title.$model">
                      <div class="input-errors" v-for="(error, index) of v$.form.acc_title.$errors" :key="index">
                          <div class="error-msg">{{ error.$message }}</div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-6">
                  <div class="form-group mb-20">
                      <label for="reference_id" class="mb-2 semi-bold title-color">{{ this.translate('referenceId') }}</label>
                      <input type="text" id="reference_id" class="form-control" :placeholder="this.translate('referenceId')" v-model="v$.form.reference_id.$model">
                      <div class="input-errors" v-for="(error, index) of v$.form.reference_id.$errors" :key="index">
                          <div class="error-msg">{{ error.$message }}</div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-6">
                  <div class="form-group mb-20">
                      <label for="img" class="mb-2 semi-bold title-color">{{ this.translate('uploadImage') }}</label>
                      <input ref="fileInput" @input="pickFile" @change="handleFileUpload"  type="file" class="form-control" :placeholder="this.translate('uploadImage')" >
                  </div>
              </div>
              
          </div>
  
          <div class="d-flex align-items-center">
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
      import useVuelidate from '@vuelidate/core'
      import { required } from '@vuelidate/validators'
  
      export default {
  
          setup () {
              return { v$: useVuelidate() }
          },
  
          data() {
              return {
                        previewImage: null,
                  form: {
                            payment_type: '',
                            amount: '',
                            acc_title: '',
                            reference_id: '',
                      },
              };
          },
  
          validations() {
  
                      return {
  
                          form: {
                              
                                amount: {
                                    required, 
                                },
                                
                                acc_title: {
                                    required, 
                                },
                                
                                reference_id: {
                                    required, 
                                },
                          },
                      }
                  },
  
          methods: {

                handleFileUpload(event) {

                    const file = event.target.files[0];
                    this.convertToBase64(file);       

                },

                convertToBase64(file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.previewImage = event.target.result;
                    };
                    reader.readAsDataURL(file);
                },
             
                async savePayment() {
  
                    this.isLoggedIn = localStorage.getItem('provider');
        
                    const provider_id = JSON.parse(this.isLoggedIn);
  

                            const formData = new FormData();
                            formData.append('provider_id',provider_id);
                            formData.append('amount', this.form.amount);
                            formData.append('payment_type', this.form.payment_type);
                            formData.append('account_title', this.form.acc_title);
                            formData.append('reference_id', this.form.reference_id);
                            formData.append('image', this.previewImage);

                            axios.post(this.$payment+'save_payment',formData)
                            .then(response => {

                                if(response.status===200){
                                    this.$router.push({name:"Payment"});
                                }

                                else if(response.status==400){
                                    swal("Oops!", response.message, "error");
                                }

                                })
                                .catch(error => {
                                    console.error(error);
                                });

                    }
          },
  
      };
  
  </script>