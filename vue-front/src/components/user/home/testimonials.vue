<template>

<section class="pt-120 pb-120 overlay" :style="{ backgroundImage: 'url(' + this.$main + 'assets/img/bg/testimonial-bg.png)' }">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-auto">
                  <div class="section-title text-center">
                     <h5 class="top-title icon-center">Testimonials</h5>
                     <h2 class="text-white">Lovely Client Say</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <div class="testimonial-slider swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                     <div class="swiper-wrapper">
                        <div class="swiper-slide">
                           <div class="d-flex align-items-center customer-top">
                              <div class="img"><img :src="this.$main + 'assets/img/media/client1.png'" alt=""></div>
                              <div class="meta">
                                 <h3>Kyra Knight</h3>
                                 <p>Happy Customer</p>
                              </div>
                           </div>
                           <div class="rating"><img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-empty.svg'" alt="" class="svg"></div>
                           <p>Window repair generation repair space dedicated content over the each other when sensors indicate problemthey’re window service.</p>
                        </div>
                        <div class="swiper-slide">
                           <div class="d-flex align-items-center customer-top">
                              <div class="img"><img :src="this.$main + 'assets/img/media/client2.png'" alt=""></div>
                              <div class="meta">
                                 <h3>Rach McAdam</h3>
                                 <p>Happy Customer</p>
                              </div>
                           </div>
                           <div class="rating"><img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"></div>
                           <p>Involve content generation constant space dedicat content over the each other when sensors indicate problemthey’re mobile service.</p>
                        </div>
                        <div class="swiper-slide">
                           <div class="d-flex align-items-center customer-top">
                              <div class="img"><img :src="this.$main + 'assets/img/media/client3.png'" alt=""></div>
                              <div class="meta">
                                 <h3>Olga Kurylen</h3>
                                 <p>Happy Customer</p>
                              </div>
                           </div>
                           <div class="rating"><img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-fill.svg'" alt="" class="svg"> <img :src="this.$main + 'assets/img/icon/star-empty.svg'" alt="" class="svg"></div>
                           <p>New door Install service repservs space dedicate content over the each other when sensor indicate problemthey’re door install service.</p>
                        </div>
                     </div>
                     <div class="swiper-pagination"></div>
                  </div>
               </div>
            </div>
         </div>
      </section>
</template>

