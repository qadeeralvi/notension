<template>
      <Service/>
      <Features/>
      <Team/>
      <Blog/>
</template>

<script>

    import Service from '../../components/user/home/services.vue';
    import Team from '../../components/user/home/team.vue';
    import Blog from '../../components/user/home/blog.vue';
    import Features from '../../components/user/home/our_features.vue';

    export default {

         components: {
               Service,
               Team,
               Blog,
               Features,
         },
    };

</script>