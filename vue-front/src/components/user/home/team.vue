<template>
      <section class="pt-60 pb-90" style="background-color: rgb(245, 239, 233);color:black">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-auto">
                  <div class="section-title text-center">
                     <h5 class="top-title icon-center font-color">{{ this.translate('notensionTeam') }}</h5>
                     <h2>{{ this.translate('professionalProvider') }}</h2>
                  </div>
               </div>
            </div>
            <div class="row justify-content-center">
               <div class="col-lg-3 col-sm-6">
                  <div class="single-team">
                     <div class="team-img"><img :src="this.$main + 'assets/img/media/tm1.png'" alt=""></div>
                     <div class="team-content">
                        <h3>Junaid Akhtar</h3>
                        <p>Computer Specialist</p>
                     </div>
                    
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <div class="single-team">
                     <div class="team-img"><img :src="this.$main + 'assets/img/media/tm2.png'" alt=""></div>
                     <div class="team-content">
                        <h3>Faheem Iqbal</h3>
                        <p>Techenical Specialist</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <div class="single-team">
                     <div class="team-img"><img :src="this.$main + 'assets/img/media/tm3.png'" alt=""></div>
                     <div class="team-content">
                        <h3>Raheem Khan</h3>
                        <p>Plumber Specialist</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <div class="single-team">
                     <div class="team-img"><img :src="this.$main + 'assets/img/media/tm4.png'" alt=""></div>
                     <div class="team-content">
                        <h3>Usman Tahir</h3>
                        <p>Car Specialist</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
</template>