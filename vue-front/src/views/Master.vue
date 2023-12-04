<template>

    <div class="layout-wrapper">
            <Header v-if="isUser" />
            <Header v-if="isNone" />
            <ProviderHeader v-if="isProvider" />
                    <div class="main-content">
                        <div class="page-content">
                            <div class="container-fluid">
                        <router-view></router-view>
                            </div>
                        </div>
                    </div>
            <Footer v-if="isUser"/>
            <Footer v-if="isNone"/>
            <ProviderFooter v-if="isProvider"/>
    
    </div>
</template>


<script>

// Import Layout
import Header from '../components/partials/header.vue';
import ProviderHeader from '../components/partials/providerHeader.vue';
import Footer from '../components/partials/footer.vue';
import ProviderFooter from '../components/partials/providerFooter.vue';

export default {
            // The `components` property is an object that contains the `Header` and `Footer` components.
            components: {
                Header,
                ProviderHeader,
                Footer,
                ProviderFooter,
            },
            // The `data` property is a function that returns an object with a single property `isUser` initialized to `false`.
            data() {
                return {
                    isUser: false,
                    isNone: false,
                    isProvider: false,
                };
            },

            // The `created` hook is a lifecycle hook that is called when the Vue.js component is created.
            created() {
                // Call the `checkUser` method to set the `isUser` property based on the current URL.
                this.checkUser();
            },
            // The `methods` property is an object that contains the `checkUser` method.
            methods: {
                // This method uses the `window.location.pathname` property to get the current URL and split it into an array of path segments using the `split` method.
                checkUser() {

                            const type =  localStorage.getItem('type');
                            
                            if (type != '' && type == '"user"') {
                                
                                return this.isUser = true;
                            } 
                            else if(type != '' && type == '"provider"'){
                                    return this.isProvider = true;
                                }
                                // Otherwise, set the `isUser` property to `false`.
                                else {
                                    return this.isNone = true;
                                }
                },
            },
};

</script>