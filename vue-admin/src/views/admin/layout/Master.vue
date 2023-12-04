<template>
        <div class="layout-wrapper">
                <Header />
                        <div class="main-content">

                            <div class="page-content">
                                <div class="container-fluid">
                            <router-view></router-view>
                                </div>
                            </div>
                        </div>
                <Footer />
        
        </div>
</template>


<script>

// Import Layout
    import Header from './common/Header.vue';

    export default {

        components: {
            Header,
        },
        data() {
            return {
            };
        },
        mounted() {
            console.log( "main app" );
        },
    };
</script>