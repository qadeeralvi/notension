<template>

    <footer class="footer">
             <div class="footer-main">
                <div class="container">
                   <div class="row">
                      <div class="col-xl-3 col-sm-6">
                         <div class="widget widget_about">
                            <div class="footer-logo mb-30"><img src='https://website.notension.pk//images/logo.png' style="width: 140px;" alt=""></div>
                            <div class="menu-container">
                               <p>Involve content generation & consumption screen space dedicated content over other to ensure there is enough space.</p>
                               <div class="socials">
                                 <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i> </a>
                                 <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i> </a>
                                 <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i> </a>
                                 <a href="https://www.pinterest.com/"><i class="fab fa-pinterest"></i></a>
                              </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-xl-3 col-sm-6">
                         <div class="widget widget_recent_entries">
                            <h3 class="widget-title">{{ this.translate('latestNews') }}</h3>
                            <ul>
                               <li class="post--item">
                                  <a href="blog-details.html" class="post--img"><img  :src="this.$main+'assets/img/post/popular1.png'" data-rjs="2" alt=""></a>
                                  <div class="post--content">
                                     <a class="post--date c1" href="blog-details.html">Aus 24,2021</a>
                                     <h4 class="post--title"><a href="blog-details.html">Verify That Open Still Electric Outlet</a></h4>
                                  </div>
                               </li>
                               <li class="post--item">
                                  <a href="blog-details.html" class="post--img"><img  :src="this.$main + 'assets/img/post/popular2.png'" data-rjs="2" alt=""></a>
                                  <div class="post--content">
                                     <a class="post--date c1" href="blog-details.html">Aus 25,2021</a>
                                     <h4 class="post--title"><a href="blog-details.html">Repaired Unlock Use Service</a></h4>
                                  </div>
                               </li>
                            </ul>
                         </div>
                      </div>
                      <div class="col-xl-2 col-sm-4">
                     <div class="widget widget_nav_menu">
                        <h3 class="widget-title">{{ this.translate('pages') }}</h3>
                        <div class="menu-container">
                           <ul class="menu">
                              <li> <router-link to="/provider/home">Home</router-link> </li>
                              <li><router-link to="/about">About</router-link></li>
                              <li><router-link to="/contact">Contact</router-link></li>
                              <li><router-link to="/provider/complaint-list">Complain List</router-link></li>
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
          </footer>
          <a class="back-to-top show" v-show="shouldShowBackToTop" @click="scrollToTop">
            <i class="fa fa-angle-up "></i>
         </a>
    </template>
   <script>

export default {
  data() {
      return {
         isLoggedIn: false,
         shouldShowBackToTop: false,
      };
  },

  mounted() {
   window.addEventListener("scroll", this.handleScroll);
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
         }     
}

   
   </script>
    