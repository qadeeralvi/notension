<template>
    <AuthApp  />
    <!-- <MainApp/> -->
</template>

<script>

    // Import apps
    import AuthApp from './views/Auth/Master.vue';
    import MainApp from './views/admin/layout/Master.vue';

    export default {
        name: 'App',
        data() {
           
            return {
                
            };
        },
        created() {
            // console.log("App app");
        },
        components: {
            AuthApp,
            // MainApp
        },
        created() {
                           
                        
            
        }
    }
</script>