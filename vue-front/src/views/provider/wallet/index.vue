<template>

    <section class="pt-120 pb-90">
                <div class="container">
                    <div class="row justify-content-center">
                        
    
                        <table id="example" class="display" style="width:100%">
    
                            <thead>
                                <tr>
                                    <th>{{ this.translate('sNo') }}</th>
                                    <th>{{ this.translate('title') }}</th>
                                    <th>{{ this.translate('catTitle') }}</th>
                                    <th>{{ this.translate('subCatTitle') }}</th>
                                    <th>{{ this.translate('date') }}</th>
                                    <th>{{ this.translate('time') }}</th>
                                    <th>{{ this.translate('address') }}</th>
                                    <th>{{ this.translate('status') }}</th>
                                    <th>{{ this.translate('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in result" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.title}}</td>
                                    <td>{{item.category_title}}</td>
                                    <td>{{item.sub_category_title}}</td>
                                    <td>{{item.date}}</td>
                                    <td>{{item.time}}</td>
                                    <td>{{item.address}}</td>
                                    <td> <button :style="getStatusClass(item.status)" class="btn" >{{item.status}}</button></td>
                                    <td>
                                        <router-link :to="{ path: '/rating', query: { job_id: 5 } }"><button v-if="item.status === 'active'" class="btn" style="background-color:aqua;">Rating</button></router-link>
                                        <router-link :to="{ path: '/job-update',  query: { job_id: item.id} } "><button v-if="item.status === 'pending'" class="btn" style="background-color:darkred;">Update</button></router-link>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
    
    
                    </div>
                </div>
            </section>
    
    
    </template>
    
    
    <script>
        import axios from 'axios';
        export default {
    
            setup () {
               
            },
    
            data() {
                return {
                    result:[],
                    categories: [],
                    job_status: '',
                    job_id: '',
                    
                };
            },
    
            created() {
                    this.fetchData()
                },

            mounted() {
                

            },
            methods: {
    
                    fetchData() {
    
                            this.isLoggedIn = localStorage.getItem('user');
                            const user = JSON.parse(this.isLoggedIn);
                            const parameters = {
                                user_id: user.user_id,
                            };
                            axios.post(this.$service+'user_job_list/',parameters)
                                .then(response => {
                                    this.result =  response.data.data
                                })
                                .catch(error => {
                                console.error(error);
                                });
    
                    },
    
                    getStatusClass(status) {
                
                        if (status === 'pending') return 'background-color:#31d2f2'
                        if (status === 'active') return 'background-color:#57347'
                        else   return 'background-color:#ee2219'
                        },
    
                },
    
        };
    
    </script>