<template>

<section class="pt-120 bg-center" :style="{ backgroundImage: 'url(' + this.$main + 'assets/img/bg/about-bg.png)' }" >
         <div class="container">
            <div class="row mb-70">
               <div class="col-lg-6">
                  <div class="about-content mb-5 mb-lg-0">
                     <h5 class="font-color">About us</h5>
                     <h2>Innovative Solution </h2>
                     <router-link to="/about"  class="btn btn-lg c1-hover btn-border"><span>Learn More</span> 
                        <img :src="this.$main + 'assets/img/icon/plus-white.svg'" alt="" class="svg">
                     </router-link>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="about-right-content font-family-customer">
                     <p class="">Involve content generation consumption screen space dedicated content over other elements To ensure there is enough space.Our first project, Notension, was founded in 2010 by brothers Alu baba and Polow baba, along with their friend Joaquín hadda haddi, founder of Gondhor acquired by car servicing company.</p>
                     <p>Alu baba felt the urge to create a platform where designers could find free graphic resource bablo and aquín supported his idea and thats how Notension company was created. since then our universe has been expanding non-stop, creating two new project.</p>
                     <div class="arrow-box"><img :src="this.$main + 'assets/img/icon/about-arrow.svg'" alt="" class="svg"></div>
                  </div>
               </div>
            </div>
            <div class="row justify-content-end">
               <div class="col-lg-8">
                  <div class="statistics-wrapper" :style="{ backgroundImage: 'url(' + this.$main + 'assets/img/bg/about_bg.png)' }"  >
                     <div class="statistics d-flex flex-column flex-sm-row justify-content-evenly">
                        <div class="statistic mb-5 mb-sm-0">
                           <h3>29+</h3>
                           <h4>Experience</h4>
                        </div>
                        <div class="statistic mb-5 mb-sm-0">
                           <h3>99k+</h3>
                           <h4>Happy Client</h4>
                        </div>
                        <div class="statistic">
                           <h3>120k+</h3>
                           <h4>Servicing</h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      
</template>