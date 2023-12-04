<template>

<footer class="footer">
         <!-- <div class="footer-main all-white overlay" data-bg-img="assets/img/bg/footer-bg.png"> -->
         <div class="footer-main " >
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-sm-6">
                     <div class="widget widget_about">
                        <div class="footer-logo mb-30"><img src='https://website.notension.pk//images/logo.png' style="width: 141px;" alt=""></div>
                        <div class="menu-container">
                           <p>Involve content generation & consumption screen space dedicated content over other to ensure there is enough space.</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-2 col-sm-4">
                     <div class="widget widget_nav_menu">
                        <h3 class="widget-title">{{ this.translate('ourService') }}</h3>
                        <div class="menu-container">
                           <ul class="menu">
                              <li><router-link to="/job">Post Job</router-link></li>
                              <li  v-if="isLoggedIn"><router-link to="/job-list">Job List</router-link></li>
                              <li  v-if="isLoggedIn"><router-link to="/complaint-list">Complain List</router-link></li>
                              <li  v-if="isLoggedIn"><router-link  to="/chat">Inbox</router-link></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-2 col-sm-4">
                     <div class="widget widget_nav_menu">
                        <h3 class="widget-title">{{ this.translate('pages') }}</h3>
                        <div class="menu-container">
                           <ul class="menu">
                              <li> <router-link to="/">Home</router-link> </li>
                              <li><router-link to="/about">About</router-link></li>
                             
                              <li><router-link to="/contact">Contact</router-link></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-2 col-sm-4">
                     <div class="widget widget_nav_menu style--two">
                        <h3 class="widget-title">{{ this.translate('serviceHour') }}</h3>
                        <div class="menu-container">
                           <ul class="menu">
                              <li><span>Mon & Tue</span>7.00 - 16.00</li>
                              <li><span>Wed & Thu</span>7.00 - 16.00</li>
                              <li><span>Friday</span>7.00 - 16.00</li>
                              <li><span>Saturday</span>7.00 - 16.00</li>
                              <li><span>Sunday</span>7.00 - 16.00</li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- <div class="footer-bottom fontbg-color">
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-lg-6">
                     <div class="copyright-text white text-center text-lg-start mb-3 mb-lg-0">© Notension, <span class="currentYear"></span> . All Rights Reserved.</div>
                  </div>
                  <div class="col-lg-6">
                     <div class="footer-menu-wrap text-center text-lg-end">
                        <ul class="footer-menu text-white list-inline">
                           <li><router-link to="/">Home</router-link></li>
                           <li><router-link to="/term">Terms</router-link></li>
                           <li><router-link to="/privacy">Privacy Policy</router-link></li>
                           <li><router-link to="/contact">Contact</router-link></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div> -->
      </footer>
      <a class="back-to-top show" v-show="shouldShowBackToTop" @click="scrollToTop">
         <i class="fa fa-angle-up "></i>
      </a>
</template>

<script>
import "bootstrap/dist/js/bootstrap.bundle";
  import "bootstrap/dist/js/bootstrap";

export default {
  data() {
      return {
         isLoggedIn: false,
         shouldShowBackToTop: false,
      };
  },

   mounted() {

               $('.navbar-toggler').click(function() {
                     let navbarCollapse = $('.navbar-collapse1');
                     if (navbarCollapse.hasClass('show')) {
                        navbarCollapse.removeClass('show');
                        
                     } else {
                        navbarCollapse.addClass('show');
                        
                     }
               });
               window.addEventListener("scroll", this.handleScroll);
               
      },

   created() {
               this.checkLoggedIn();
      },

   destroyed() {
               window.removeEventListener("scroll", this.handleScroll);
   },

   methods: {

            handleScroll() {
               this.shouldShowBackToTop = window.pageYOffset > 0;
            },
            scrollToTop() {
               window.scrollTo({
               top: 0,
               behavior: "smooth",
               });
            },
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
            
      },
};
</script>