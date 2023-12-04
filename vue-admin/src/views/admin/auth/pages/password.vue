<template>

    <body>
          
           <div class="account-pages my-5 pt-sm-5">
               <div class="container">
                   <div class="row justify-content-center">
                       <div class="col-md-8 col-lg-6 col-xl-5">
                           <div class="card overflow-hidden">
                               <div class="bg-soft-primary">
                                   <div class="row">
                                       <div class="col-7">
                                           <div class="text-primary p-4">
                                               <h5 class="text-primary"> Reset Password</h5>
                                               <p>Re-Password with Notension.</p>
                                           </div>
                                       </div>
                                       <div class="col-5 align-self-end">
                                           <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                       </div>
                                   </div>
                               </div>
                               <div class="card-body pt-0"> 
                                   <div>
                                       <a href="index.html">
                                           <div class="avatar-md profile-user-wid mb-4">
                                               <span class="avatar-title rounded-circle bg-light">
                                                   <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                               </span>
                                           </div>
                                       </a>
                                   </div>
                                   
                                   <div class="p-2">
                                       <div class="alert alert-success text-center mb-4" role="alert">
                                           Enter your Email and instructions will be sent to you!
                                       </div>
                                       <form @submit.prevent="onSubmit">
                   
                                                   <div class="form-group" :class="{ error: v$.form.password.$errors.length }">
                                                       <label for="username">Password</label>
                                                       <input  placeholder="Enter password"
                                                             type="password" v-model="v$.form.password.$model"
                                                               class="form-control"
                                                            />
                                                       <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                                           <div class="error-msg">{{ error.$message }}</div>
                                                       </div>
   
                                                   </div>

                                                   <div class="form-group" :class="{ error: v$.form.confirm_password.$errors.length }">
                                                       <label for="username">Confirm Password</label>
                                                       <input  placeholder="Enter confirm_password"
                                                             type="password" v-model="v$.form.confirm_password.$model"
                                                               class="form-control"
                                                            />
                                                       <div class="input-errors" v-for="(error, index) of v$.form.confirm_password.$errors" :key="index">
                                                           <div class="error-msg">{{ error.$message }}</div>
                                                       </div>
   
                                                   </div>
                       
                                           <div class="form-group row mb-0">
                                               <div class="col-12 text-right">
                                                 <button :disabled="v$.form.$invalid" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Reset</button>
                                               </div>
                                           </div>
       
                                       </form>
                                   </div>
               
                               </div>
                           </div>
                           <div class="mt-5 text-center">
                               <p>Remember It ? <router-link to="/login"> Sign In here </router-link> </p>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
   
       </body>
   
   
   </template>
   
   
   <script>
   
       import useVuelidate from '@vuelidate/core'
       import { required, email, minLength } from '@vuelidate/validators'
   
       export default {
       setup () {
           return { v$: useVuelidate() }
       },
   
       data() {
           return {
           form: {
               email: '',
           },
           }
       },
           
       validations() {
           return {
           form: {
               email: {
               required, email 
               },
           },
           }
       },
       
       }
   
   </script>
   
   