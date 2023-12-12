<template>

    <div class="preloader">
             <div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>
          </div>
          <header class="header">
            <div class="header-middle" style="background-color: rgb(245, 239, 233); color: black;">
               <div class="container">
                     <div class="row align-items-center position-relative">
                        <div class="col-md-4 col-12">
                           <div class="logo text-center text-md-start mb-4 mb-md-0">
                                 <router-link v-if="!isLoggedIn" to="/provider/home">
                                    <img v-bind:src="logo" style="width: 145px;" class="main-logo" alt="">
                                 </router-link>
                                 <router-link v-if="isLoggedIn" to="/provider/home">
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
                                       <li><router-link v-if="isLoggedIn" to="/provider/payment"><i class="fas fa-arrow-alt-circle-right"></i>{{ this.translate('payment') }}</router-link></li>
                                       <li><router-link v-if="isLoggedIn" to="/provider/profile"><i class="fas fa-arrow-alt-circle-right"></i>{{ this.translate('profile') }}</router-link></li>
                                       <li><button v-if="isLoggedIn" @click="logout"><i class="fas fa-arrow-alt-circle-right"></i>{{ logoutText }}</button></li>
                                    </ul>
                                 </div>
                                 <router-link v-if="isLoggedIn" to="/provider/payment" class="btn fontbg-color d-none d-lg-block ms-5">{{ this.translate('payment') }}</router-link>
                                 <router-link v-if="isLoggedIn" to="/provider/profile" class="btn fontbg-color d-none d-lg-block ms-5">{{ this.translate('profile') }}</router-link>
                                 <router-link v-if="!isLoggedIn" to="/login" class="btn fontbg-color d-none d-lg-block ms-5">{{ loginText }}</router-link>
                                 <button v-if="isLoggedIn" @click="logout" class="btn fontbg-color d-none d-lg-block ms-5">{{ logoutText }}</button>
                                 <button v-if="isLoggedIn" class="btn btn-secondary ms-5">{{ this.translate('balance') }} <span class="wallet-price">{{ this.amount }}</span></button>
                                 &nbsp;
                                 <select name="lang" v-model="lang" @change="changeLanguage(), this.translate()" class="d-none d-lg-block">
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
                     loginText: 'Loginjb',
                     logoutText: 'Logout',
                     number:'',
                     email:'',
                     logo:'',
                     amount:'',
                     lang: localStorage.getItem('lang') || 'en'
                  }
            },

            created() {
                     this.checkLoggedIn();
                     this.wallet()
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

            watch: {
                  '$route': function() {
                     this.checkLoggedIn();
                  }
            },

            methods: {

                  checkLoggedIn() {

                        this.isLoggedIn = localStorage.getItem('provider') !== null;
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
                     localStorage.removeItem('provider');
                     localStorage.removeItem('type');
                     this.checkLoggedIn();
                     this.$router.push('/');
                     location.href='/';

                  },

                  wallet() {
                            
                            this.isLoggedIn = localStorage.getItem('provider');
                            const provider = JSON.parse(this.isLoggedIn);
                            const parameters = {
                                provider_id: provider.id,
                            };
                            axios.post('https://payment.notension.pk/api/wallet/',parameters)
                                .then(response => {
                                    this.amount =  response.data.data.amount
                                })
                                .catch(error => {
                                console.error(error);
                                });
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