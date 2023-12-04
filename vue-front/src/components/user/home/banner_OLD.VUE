<template>

    <div class="banner-slider swiper-container overlay bg-img swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events" :style="{ backgroundImage: 'url(' + this.$main + 'assets/img/bg/banner-bg.png)' }">
          <div class="swiper-wrapper" aria-live="off" style="transform: translate3d(-5709px, 0px, 0px); transition-duration: 0ms;">
             <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active" data-swiper-slide-index="2" role="group" aria-label="1 / 5" style="width: 1903px;">
                <div class="container">
                   <div class="row align-items-center">
                      <div class="col-lg-6">
                         <div class="banner-content text-white mb-5 mb-lg-0">
                            <h5 class="banner-top-title box-style">Welcome to <span class="white ps-3">Notension</span></h5>
                            <h1>The perfect <span class="c1">care on your</span> budget</h1>
                            <p>Starting an auto repairing business is a wonderful way to spend your day with <br>faces as you are caring their  and resolving the problems.</p>
                            <div class="banner-btn-group"><a href="service.html" class="btn btn-lg white-hover"><span>Our Service</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a>
                         </div>
                         </div>
                      </div>
                      <div class="col-lg-6">
                         <div class="banner-img left-minus"><img :src="this.$main + 'assets/img/media/slider3.png'" data-rjs="2" alt=""></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="swiper-slide swiper-slide-duplicate-next" data-swiper-slide-index="0" role="group" aria-label="2 / 5" style="width: 1903px;">
                <div class="container">
                   <div class="row align-items-center">
                      <div class="col-lg-6">
                         <div class="banner-content text-white mb-5 mb-lg-0">
                            <h5 class="banner-top-title box-style">Welcome to <span class="white ps-3">Notension</span></h5>
                            <h1>Quality <span class="c1">Service<br>&amp;</span> Repairing</h1>
                            <p>Starting an auto repairing business is a wonderful way to spend your day with <br>faces as you are caring their  and resolving the problems.</p>
                            <div class="banner-btn-group"><a href="service.html" class="btn btn-lg white-hover"><span>Our Service</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a><a href="about.html" class="btn btn-lg white-hover btn-white btn-border"><span>Learn More</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a></div>
                         </div>
                      </div>
                      <div class="col-lg-6">
                         <div class="banner-img left-minus"><img :src="this.$main + 'assets/img/media/slider.png'" data-rjs="2" alt=""></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="swiper-slide swiper-slide-prev" data-swiper-slide-index="1" role="group" aria-label="3 / 5" style="width: 1903px;">
                <div class="container">
                   <div class="row align-items-center">
                      <div class="col-lg-6">
                         <div class="banner-content text-white mb-5 mb-lg-0">
                            <h5 class="banner-top-title box-style">Welcome to <span class="white ps-3">Notension</span></h5>
                            <h1>Share Smile <span class="c1">through Car</span> Caring</h1>
                            <p>Starting an auto repairing business is a wonderful way to spend your day with car<br>faces as you are caring their cars and resolving the problems.</p>
                            <div class="banner-btn-group"><a href="service.html" class="btn btn-lg white-hover"><span>Our Service</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a><a href="about.html" class="btn btn-lg white-hover btn-white btn-border"><span>Learn More</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a></div>
                         </div>
                      </div>
                      <div class="col-lg-6">
                         <div class="banner-img left-minus"><img :src="this.$main + 'assets/img/media/slider2.png'" data-rjs="2" alt=""></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="2" role="group" aria-label="4 / 5" style="width: 1903px;">
                <div class="container">
                   <div class="row align-items-center">
                      <div class="col-lg-6">
                         <div class="banner-content text-white mb-5 mb-lg-0">
                            <h5 class="banner-top-title box-style">Welcome to <span class="white ps-3">Notension</span></h5>
                            <h1>The perfect <span class="c1">care on your</span> budget</h1>
                            <p>Starting an auto repairing business is a wonderful way to spend your day with car<br>faces as you are caring their cars and resolving the problems.</p>
                            <div class="banner-btn-group"><a href="service.html" class="btn btn-lg white-hover"><span>Our Service</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a><a href="about.html" class="btn btn-lg white-hover btn-white btn-border"><span>Learn More</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a></div>
                         </div>
                      </div>
                      <div class="col-lg-6">
                         <div class="banner-img left-minus"><img :src="this.$main + 'assets/img/media/slider3.png'" data-rjs="2" alt=""></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="swiper-slide swiper-slide-duplicate swiper-slide-next" data-swiper-slide-index="0" role="group" aria-label="5 / 5" style="width: 1903px;">
                <div class="container">
                   <div class="row align-items-center">
                      <div class="col-lg-6">
                         <div class="banner-content text-white mb-5 mb-lg-0">
                            <h5 class="banner-top-title box-style">Welcome to <span class="white ps-3">Notension</span></h5>
                            <h1>Quality Car <span class="c1">Service<br>&amp;</span> Repairing</h1>
                            <p>Starting an auto repairing business is a wonderful way to spend your day with car<br>faces as you are caring their cars and resolving the problems.</p>
                            <div class="banner-btn-group"><a href="service.html" class="btn btn-lg white-hover"><span>Our Service</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a><a href="about.html" class="btn btn-lg white-hover btn-white btn-border"><span>Learn More</span> <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg"></a></div>
                         </div>
                      </div>
                      <div class="col-lg-6">
                         <div class="banner-img left-minus"><img :src="this.$main + 'assets/img/media/slider.png'" data-rjs="2" alt=""></div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
             <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span>
             <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span>
             <span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 3"></span>
          </div>
       <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
    </div>
 
 </template>
 
 <script>
 
 import Swiper from 'swiper';
 import 'swiper/swiper.css';
 
 
 export default {
 
       data() {
          
          return {
             currentSlide: 0,
          }
 
       },
 
       mounted() {
 
             const swiper = new Swiper('.swiper-container', {
                // Optional parameters
 
                direction: 'horizontal',
                loop: true,
 
                // If we need pagination
                pagination: {
                   el: '.swiper-pagination',
                },
 
                autoplay: {
                   delay: 2000,
                },
             
             })
 
          
       },
  
 }
 
 
 </script>
 