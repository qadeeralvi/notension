<template>
      <!-- <Banner></Banner> -->
      <!-- <About></About> -->
     
      <Service/>
      <Features/>
      <Team/>
      <!-- <Testimonial></Testimonial> -->
      <Blog/>
      <!-- <Subscribe></Subscribe> -->
</template>

<script>

    import Banner from '../../components/user/home/banner.vue';
    import About from '../../components/user/home/about.vue';
    import Service from '../../components/user/home/services.vue';
    import Team from '../../components/user/home/team.vue';
    import Testimonial from '../../components/user/home/testimonials.vue';
    import Blog from '../../components/user/home/blog.vue';
//     import Subscribe from '../components/user/home/subscribe.vue';
    import Features from '../../components/user/home/our_features.vue';

    export default {

         components: {
               Banner,
               About,
               Service,
               Team,
               Testimonial,
               Blog,
            //    Subscribe,
               Features,
         },
         methods:{
            check(){
                alert();
            }
         }
    };

</script>