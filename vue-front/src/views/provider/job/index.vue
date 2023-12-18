<template>

<section class="pt-60 pb-90">
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
                                <td>{{item.provider_assign_status}}</td>
                                <td><span :class="getStatusClass(item.provider_assign_status)"  @click="statusModel(item.provider_assign_status,item.id)">{{item.provider_assign_status}}</span></td>
                            </tr>
                           
                        </tbody>
                    </table>


				</div>
			</div>
		</section>


        <!--Add StatusModel start-->

    <div class="modal fade status_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">{{ page }} {{ this.translate('status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                            <input type="hidden" v-model="job_id">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">{{ this.translate('status') }}</label>
                            <div class="col-md-10">
                                <select class="form-control" v-model="job_status" >
                                    <option value="pending">{{ this.translate('pending') }}</option>
                                    <option value="active">{{ this.translate('active') }}</option>
                                    <option value="cancelled">{{ this.translate('cancelled') }}</option>
                                </select>
                            </div>
                        </div>

                        <div style="float:right">
                            <button type="submit"  v-on:click="saveStatus"  class="btn btn-primary waves-effect waves-light" >{{ this.translate('save') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



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

        methods: {

                fetchData() {

                        this.isLoggedIn = localStorage.getItem('provider');

                        const provider_id = JSON.parse(this.isLoggedIn);
                        const parameters = {
                            provider_id: provider_id,
                        };
                        axios.post(`https://services.notension.pk/api/provider_job_list/`,parameters)
                            .then(response => {
                                this.result =  response.data.data
                            })
                            .catch(error => {
                            console.error(error);
                            });

                },

                statusModel(status,id){
                        $('.status_model').modal('show')
                        this.job_status=status;
                        this.job_id=id;

                    },

                getStatusClass(status) {
            
                    if (status === 'Pending') return 'btn btn-info'
                        if (status === 'Solved') return 'btn btn-success'
                        return 'btn btn-danger'
                    },

            },

    };

</script>