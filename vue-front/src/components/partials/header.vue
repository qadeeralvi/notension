<template>
            <div class="preloader" >
               <div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>
            </div>
            <header class="header">
                <div class="header-middle" style="background-color: rgb(245, 239, 233); color: black;">
                    <div class="container">
                        <div class="row align-items-center position-relative">
                            <div class="col-md-4 col-12">
                                <div class="logo text-center text-md-start mb-4 mb-md-0">
                                    <router-link v-if="!isLoggedIn" to="/">
                                        <img v-bind:src="logo" style="width: 145px;" class="main-logo" alt="">
                                    </router-link>
                                    <router-link v-if="isLoggedIn" to="/userHome">
                                        <img v-bind:src="logo" style="width: 145px;" class="main-logo" alt="">
                                    </router-link>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                    <div class="dropdown d-lg-none">
                                        <button class="btn dropdown-toggle mobile-toggle" type="button" id="mobileNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color:rgb(0 149 255);">
                                            ☰
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="mobileNavbarDropdown">
                                            <li><router-link v-if="!isLoggedIn" to="/login"><i class="fas fa-arrow-alt-circle-right"></i>{{ loginText }}</router-link></li>
                                            <li><router-link to="/job"><i class="fas fa-arrow-alt-circle-right"></i>{{ this.translate('postJob') }}</router-link></li>
                                            <li><router-link v-if="!isLoggedIn" to="/provider/signUp"><i class="fas fa-arrow-alt-circle-right"></i>{{ this.translate('registerCompany') }}</router-link></li>
                                            <li v-if="isLoggedIn"><button @click="logout"><i class="fas fa-arrow-alt-circle-right"></i>{{ logoutText }}</button></li>
                                            <li><router-link v-if="isLoggedIn" to="/user/profile"><i class="fas fa-arrow-alt-circle-right"></i>{{ this.translate('profile') }}</router-link></li>
                                        </ul>
                                    </div>
                                    <router-link v-if="!isLoggedIn" to="/login" class="d-none d-lg-block ms-5">{{ loginText }}</router-link>
                                    <router-link to="/job" class="d-none d-lg-block ms-5">{{ this.translate('postJob') }}</router-link>
                                    <router-link v-if="!isLoggedIn" to="/provider/signUp" class="fontbg-color btn d-none d-lg-block ms-5">{{ this.translate('registerCompany') }}</router-link>
                                    <button v-if="isLoggedIn" @click="logout" class="fontbg-color btn d-none d-lg-block ms-5">{{ logoutText }}</button>
                                    <router-link v-if="isLoggedIn" to="/user/profile">
                                        <button class="fontbg-color btn d-none d-lg-block ms-5">{{ this.translate('profile') }}</button>
                                    </router-link>
                                    &nbsp;
                                    <select name="lang" v-model="lang" @change="changeLanguage(), this.translate()" >
                                        <option value="en">English</option>
                                        <option value="urdu">Urdu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

         
   </template>
   
   <script>
   
      import axios from 'axios';
      
      export default {
         data() {
               return {
                  isLoggedIn: false,
                  loginText: 'sign in',
                  logoutText: 'Logout',
                  number:'',
                  email:'',
                  logo:'',
                  lang: localStorage.getItem('lang') || 'en'
               }
         },
         
         watch: {
               '$route': function() {
                  this.checkLoggedIn();
               }

         },
         mounted() {
            
                  axios.post('https://website.notension.pk/api/webSetting/')
                     .then(response => {
                           this.setting = response.data.data;
                           this.number = this.setting.number
                           this.email = this.setting.email
                           this.logo = this.setting.logo
                     })
                     .catch(error => {
                           console.error(error);
                     });
            },

         methods: {

               checkLoggedIn() {
                     this.isLoggedIn = localStorage.getItem('accessToken') !== null;
                     if (this.isLoggedIn) {
                     this.loginText = '';
                     this.logoutText = 'Logout';
                     } else {
                     this.loginText = 'Login';
                     this.logoutText = '';
                     }
               },
               logout() {
                  localStorage.removeItem('accessToken');
                  localStorage.removeItem('user');
                  localStorage.removeItem('type');
                  this.checkLoggedIn();
                  this.$router.push('/login');
               },

               changeLanguage(){
                  localStorage.setItem('lang',this.lang)
                  this.$router.go()
               }

            }
      }
   </script>


<style>
    .dropdown-menu {
        background-color: #c4c4c4;
        font-weight: bold;
        font-size: 20px;
    }

</style>