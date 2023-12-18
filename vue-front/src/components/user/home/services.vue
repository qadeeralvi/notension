<template>
    <section class="pt-60 pb-60 bg-center bg-img"  style="background-color: rgb(245, 239, 233);color:black">
        <div class="container">
            <div class="row justify-content-between">
            <div class="col-xl-3">
                <div class="section-title">
                    <h5 class="top-title style2 font-color">{{ this.translate('ourService') }}</h5>
                    <h2 class="pb-1 font-color">{{ this.translate('beSettle') }}</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-title" style="margin-bottom: 0px;">
                <h2 class="font-color">{{ this.translate('homeJobDone') }}</h2>
            </div>
            <br>
            <font class="home-cont font-family-customer">{{ this.translate('describeJob') }}</font>
                <div class="col-md-12">
                    <div class="input-group">
                            <input type="text" autocomplete="off" :placeholder="this.translate('whyNeedHelp')" id="myInput" v-model="searchQuery" @keyup="search()" style="border-color: white;"  class="form-control search-input" >
                        <button type="button" @click="JobForm" style="  border-left:none;border-top-right-radius: 20px;border-bottom-right-radius: 20px;height: 70px;background-color: white;color: red;border-color: white;" class="btn btn-primary search-btn">
                            <svg width="32" height="32" viewBox="0 0 26 26" fill="#3960BF" xmlns="http://www.w3.org/2000/svg" data-name="FilledArrowRight" role="img"><path fill-rule="evenodd" clip-rule="evenodd" d="M13 25.001C19.6274 25.001 25 19.6284 25 13.001C25 6.37356 19.6274 1.00098 13 1.00098C6.37258 1.00098 1 6.37356 1 13.001C1 19.6284 6.37258 25.001 13 25.001ZM12.9994 8.61248C12.9994 7.62244 14.2406 7.12682 14.9667 7.82656L20.333 12.9992L14.9667 18.1712C14.2406 18.8715 12.9994 18.3753 12.9994 17.3859V14.999L7.49924 14.999C6.49902 14.999 5.66902 13.999 5.66706 12.999C5.66706 11.999 6.49902 10.999 7.49924 10.999L12.9994 10.999V8.61248Z"></path></svg>
                        </button>
                    </div>

                    <div class="results" v-if="results" style="position: absolute;height: 200px; width: 640px; overflow-y: auto;">
                        <ul class="list-group" >
                            <router-link v-for="(cat, index) in results.data" :key="index" :to="{ path: '/job', query: { cat: cat.id,param:cat.table } }">
                                <li class="list-group-item">{{ cat.name}}</li>
                            </router-link>
                        </ul>
                    </div>
                </div>
              
                <div v-if="categories.data" class="row" style="display: flex;line-height: 1.25;gap: 35px 0px;">
                    <div v-for="(cat, index) in categories.data.sort((a, b) => a.id - b.id)"  class="col-sm-3 col-xs-2">
                        <router-link :to="{ path: '/job', query: { cat: cat.id,param:'cat' } }">
                            <div class="row">
                                <div class="services-icon" style="text-align: center;">
                                    <img v-bind:src="cat.image" alt="" width="70" height="70"> 
                                </div>
                            </div>
                            <div class="row" style="text-align: center;">
                                <span class="font-color font-family-customer category-font" style="white-space: nowrap;" v-if="this.translate(cat.name) !== undefined">{{ this.translate(cat.name) }}</span>
                                <span class="font-color font-family-customer category-font" style="white-space: nowrap;" v-else>{{ cat.name}}</span>
                            </div>
                        </router-link>
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

                    query: '',
                    categories: [], 
                    results: null
            
                };
        },

    computed: {

            filteredResults() {
                return this.results.filter(result =>
                    result.title.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
            }
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

        methods: {

                    search() {

                            const parameters = {
                                q: this.searchQuery
                            };

                            axios.post(this.$service + 'category_search/', parameters)
                            .then(response => {
                                if(response.data.status==200){
                                    this.results = response.data;
                                }
                                else{
                                    this.results = null;
                                }
                            })
                            .catch(error => {
                                console.error(error);
                                this.results = null;
                            });
                    },

                    JobForm(){

                            window.localStorage.setItem('formHeading',this.searchQuery)

                            const parameters = {
                                q: this.searchQuery
                            };

                            axios.post(this.$service + 'categorySearchByWord/', parameters)

                            .then(response => {
                                if(response.data.status==200){
                                    console.log(response.data.data)
                                    localStorage.setItem('typeFromHeading', JSON.stringify(response.data.data));

                                }
                                else{
                                    localStorage.removeItem('typeFromHeading');
                                }
                            })

                            .catch(error => {
                                console.error(error);
                                this.results = null;
                            });

                            this.$router.push('/job');
                    }
                }


};

</script>

<style>
  .list-group-item:hover {
    background-color: #cbcbcb;
    cursor: pointer;
  }
</style>