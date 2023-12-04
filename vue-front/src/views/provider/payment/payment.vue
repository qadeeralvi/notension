<template>

    <section class="pt-120 pb-90 bg-color">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <label>From</label>
                            <input type="date" class="form-control" v-model="fromDate" @change="filter">
                        </div>
                        <div class="col-md-4">
                            <label>To</label>
                            <input type="date" class="form-control" v-model="toDate" @change="filter">
                        </div>
                        <div class="col-md-4" >
                         <router-link to="/provider/add-payment"><button class="btn btn-warning" style="float: right;">{{ this.translate('paymentAdd') }}</button>  </router-link> 
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <table id="example" class="  table-striped table-hover" style="width:100%;">
    
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>{{ this.translate('paymentType') }}</th>
                                    <th>{{ this.translate('amount') }}</th>
                                    <th>{{ this.translate('accountTitle') }}</th>
                                    <th>{{ this.translate('referenceId') }}</th>
                                    <th>{{ this.translate('date') }}</th>
                                    <th>{{ this.translate('time') }}</th>
                                    <th>{{ this.translate('image') }}</th>
                                    <th>{{ this.translate('status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in result" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.payment_type}}</td>
                                    <td>{{item.amount}}</td>
                                    <td>{{item.account_title}}</td>
                                    <td>{{item.reference_id}}</td>
                                    <td>{{item.date}}</td>
                                    <td><img :src="'https://payment.notension.pk/images/'+item.image" height="100" width="100"></td>
                                    <td>{{item.time}}</td>
                                    <td>
                                        <button v-if="item.status=='accept'" class="btn btn-success">Approved</button>
                                        <button v-else class="btn btn-info">{{item.status}}</button>
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
    
            data() {
                return {
                    result:[],
                    fromDate:'',
                    toDate:'',
                   
                };
            },
    
            created() {
                    this.fetchData()
                   
                },
    
            methods: {
    
                        fetchData() {
                            
                            this.isLoggedIn = localStorage.getItem('provider');
                            const provider_id = JSON.parse(this.isLoggedIn);
                            const parameters = {
                                provider_id: provider_id,
                            };
                            axios.post(this.$payment+'provider_payment/',parameters)
                                .then(response => {
                                    this.result =  response.data.data
                                })
                                .catch(error => {
                                console.error(error);
                                });
                        },

                        
        
                        getStatusClass(status) {
                    
                                if (status === 'pending') return 'btn btn-info'
                                if (status === 'accept') return 'btn btn-success'
                                return 'btn btn-danger'
                        },

                        filter(){
                           
                            this.isLoggedIn = localStorage.getItem('provider');

                            const provider_id = JSON.parse(this.isLoggedIn);

                            const parameters = {
                                start_date: this.fromDate,
                                end_date: this.toDate,
                                provider_id: provider_id,
                            };

                            if(this.fromDate!='' && this.toDate!=''){

                                axios.post(this.$payment+'payment_filter/',parameters)
                                .then(response => {
                                    this.result =  response.data.data
                                })
                                .catch(error => {
                                console.error(error);
                                });

                            }
                            
                        }
    
                },
    
        };
    
    </script>