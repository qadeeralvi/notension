<template>
    <section class="pt-190 pb-60 bg-center bg-img" style="margin-bottom: 50px;background-color: rgb(245, 239, 233);color:black" >
        <div class="container">
            <div class="row justify-content-between">
            <div class="col-xl-3">
                <div class="section-title">
                    <h5 class="top-title style2 font-color">Our Services</h5>
                    <h2 class=" pb-1">Be Settled Up With Great Service</h2>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">

                    <!-- jb -->

                    <div  v-for="(cat, index) in categories.data"  class="col-sm-6">

                        <div class="services">
                        <div class="services-icon"><img :src="this.$main + 'assets//img/icon/service-icon1.png'" alt=""></div>
                        <div class="services-content">
                            <router-link to="/job"><h3 style="color: black;">{{ cat.name }}</h3></router-link>
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
        </div>
    </section>

</template>

<script>

import axios from 'axios';

export default {


  data() {

        return {
              categories: [],
        };

  },

  mounted() {

              axios.get(this.$service+'category/')
                 .then(response => {
                       this.categories = response.data;
                 })
                 .catch(error => {
                       console.error(error);
                 });
     
  },

};

</script>