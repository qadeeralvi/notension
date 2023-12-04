<template>

    <section class="pt-60 pb-90 bg-color">
                <div class="container">
                    <div class="row justify-content-center">
                        <h3>Job List</h3>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; background-color:#f1f1f1;border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <input class="form-control" type="text" v-model="title" :placeholder="this.translate('searchTitle')">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" v-model="categorySearch" :placeholder="this.translate('searchCategory')">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" v-model="subCategorySearch" :placeholder="this.translate('searchSubCategory')">
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select class="form-control" v-model="status">
                                            <option value="">All</option>
                                            <option value="active">Active</option>
                                            <option value="pending">Pending</option>
                                            <option value="done">Complete</option>
                                        </select>
                                    </th>
                                    <th></th>
                                </tr>

                                <tr>
                                    <th>S.no</th>
                                    <th>{{ this.translate('title') }}</th>
                                    <th>{{ this.translate('category') }}</th>
                                    <th>{{ this.translate('subCategory') }}</th>
                                    <th>{{ this.translate('date') }}</th>
                                    <th>{{ this.translate('time') }}</th>
                                    <th>{{ this.translate('address') }}</th>
                                    <th>{{ this.translate('status') }}</th>
                                    <th>{{ this.translate('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in filteredResult" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.title}}</td>
                                    <td>{{item.category_title}}</td>
                                    <td>{{item.sub_category_title}}</td>
                                    <td>{{item.date}}</td>
                                    <td>{{item.time}}</td>
                                    <td>{{item.address}}</td>
                                    <td> <button :class="getStatusClass(item.status)" >{{item.status}}</button></td>
                                    <td>
                                        <router-link :to="{ path: '/rating', query: { job_id: 5 } }"><button v-if="item.status === 'active'" class="btn" style="background-color:aqua;">Rating</button></router-link>
                                        <router-link :to="{ path: '/job-update',  query: { job_id: item.id} } "><button v-if="item.status === 'pending'" class="btn" style="background-color:darkred;">Update</button></router-link>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>

                        <div style="display: flex; align-items: center;">
                            <button class="btn btn-success" :disabled="currentPage === 1" @click="currentPage--">{{ this.translate('prev') }}</button>
                            <div v-for="page in pageCount" :key="page" style="margin: 0 5px;">
                            <button class="btn btn-info"
                                @click="currentPage = page"
                                :class="{ 'selected': currentPage === page }"
                            >
                                {{ page }}
                            </button>
                            </div>
                            <button class="btn btn-success" :disabled="currentPage === pageCount" @click="currentPage++">{{ this.translate('next') }}</button>
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
                    result:[],
                    categories: [],
                    job_status: '',
                    job_id: '',
                    title:'',
                    categorySearch:'',
                    subCategorySearch:'',
                    status:'',
                    currentPage: 1,
                    pageSize: 10,
                    
                };
            },
    
            created() {
                    this.fetchData()
                },

            computed: {
            
                    filteredResult() {
                        const filteredCats = this.result.filter(res => {
                                const titleMatch = res.title.toLowerCase().includes(this.title.toLowerCase());
                                const categoryMatch = res.category_title.toLowerCase().includes(this.categorySearch.toLowerCase());
                                const subCategoryMatch = res.sub_category_title.toLowerCase().includes(this.subCategorySearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.status.toLowerCase());
                                return titleMatch && categoryMatch && subCategoryMatch && statusMatch;
                            });
                            return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                    },
                    pageCount() {
                        const filteredCats = this.result.filter(res => {
                                const titleMatch = res.title.toLowerCase().includes(this.title.toLowerCase());
                                const categoryMatch = res.category_title.toLowerCase().includes(this.categorySearch.toLowerCase());
                                const subCategoryMatch = res.sub_category_title.toLowerCase().includes(this.subCategorySearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.status.toLowerCase());
                               
                                return titleMatch && categoryMatch && subCategoryMatch && statusMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);
                    },

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
                                    window.scrollTo({ top: 0, behavior: 'smooth' });
                                    this.result =  response.data.data
                                })
                                .catch(error => {
                                console.error(error);
                                });
    
                    },
    
                    getStatusClass(status) {
                
                        if (status === 'pending') return 'btn btn-info'
                        if (status === 'active') return 'btn btn-success'
                        else   return 'background-color:#ee2219'
                        },
    
                },
    
        };
    
    </script>