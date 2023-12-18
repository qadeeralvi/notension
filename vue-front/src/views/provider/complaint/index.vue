<template>
    <section class="pt-60 pb-90 bg-color">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-md-12 mb-2">
                            <button type="button" class="btn btn-primary" @click="showAddModel">{{ this.translate('addComplaint') }}</button>
                        </div>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; background-color:#f1f1f1;border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                        <th></th>
                                        <th>
                                            <input class="form-control" type="text" v-model="complain_type" placeholder="Search by Title...">
                                        </th>
                                        <th>
                                            <input class="form-control" type="text" v-model="serviceSearch" placeholder="Search by Category...">
                                        </th>
                                        <th>
                                            <select class="form-control" v-model="status">
                                                <option value="">{{ this.translate('all') }}</option>
                                                <option value="active">{{ this.translate('active') }}</option>
                                                <option value="pending">{{ this.translate('pending') }}</option>
                                                <option value="done">{{ this.translate('completed') }}</option>
                                            </select>
                                        </th>
                                        <th></th>
                                        <th></th>
                                </tr>
                                <tr>
                                    <th>{{ this.translate('sNo') }}</th>
                                    <th>{{ this.translate('complaintAgainst') }}</th>
                                    <th>{{ this.translate('serviceId') }}</th>
                                    <th>{{ this.translate('status') }}</th>
                                    <th>{{ this.translate('description') }}</th>
                                    <th>{{ this.translate('image') }}</th>
                                    <th>{{ this.translate('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in filteredResult" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.complaint_against_type}}</td>
                                    <td>{{item.service_id}}</td>
                                    <td> <button :class="(item.status=='Pending'?'btn btn-info':'btn btn-success')" >{{item.status}}</button></td>
                                    <td>{{item.description}}</td>
                                    <td><img :src="item.file" height="100" width="100"></td>
                                    <td>
                                        <button @click="showChat(item.complainer_id,item.complaint_type,item.id)" class="btn" style="background-color:aqua;">{{ this.translate('chat') }}</button>
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
    

<!--Add complain Modal start-->
    <div class="modal fade addComplainModel" tabindex="-1" role="dialog" aria-labelledby="chatLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="chatLabel">{{ page }}{{ this.translate('addComplaint') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" @click="hideAddModel" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveComplaint" >
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group  mb-20">
                                    <label for="l_name" class="mb-2 semi-bold title-color">{{ this.translate('complaintAgainst') }} <span style="color: red;">*</span></label>
                                        <div class="custom-select c1">
                                                <select  v-model="form.complaint_against_type" class="form-control">
                                                        <option selected disabled>{{ this.translate('choseCatDrop') }}</option>
                                                        <option value="user">{{ this.translate('user') }}</option>
                                                        <option value="system">{{ this.translate('system') }}</option>
                                                </select>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6"  v-if="form.complaint_against_type === 'user'">
                                <div class="form-group mb-20" >
                                    <label for="l_name" class="mb-2 semi-bold title-color">{{ this.translate('user') }}</label>
                                    <div class="custom-select c1">
                                        <select name="" id=""  class="form-control"  v-model="form.providerId">
                                                <option >{{ this.translate('choseCatDrop') }}</option>
                                                <option v-for="pro in userList" :value="pro.userId">{{ pro.userName }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6"  v-if="form.complaint_against_type === 'user'">
                                <div class="form-group mb-20" >
                                    <label for="name" class="mb-2 semi-bold title-color">{{ this.translate('jobId') }}</label>
                                    <div class="custom-select c1">
                                        <input type="text"  class="form-control" placeholder="Job Id" v-model="form.jobId">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                    <label class="mb-2 semi-bold title-color">{{ this.translate('description') }}</label>
                                    <textarea class="form-control" v-model="form.description" rows="8"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                    <label class="mb-2 semi-bold title-color">{{ this.translate('uploadImage') }}</label>
                                    <input ref="fileInput" @input="pickFile" @change="handleFileUpload"  type="file" class="form-control" :placeholder="this.translate('uploadImage')" >
                            </div>
                            <div class="col-lg-6"  v-if="this.previewImage">
                                <img :src="this.previewImage" alt="" width="300" height="300">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success btn-lg btn-rounded float-end" style="float:right">{{ this.translate('save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--Add complain Modal end-->

<!--Add chatModal start-->
    <div class="modal fade chatModel" tabindex="-1" role="dialog" aria-labelledby="chatLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="chatLabel">{{ page }} {{ this.translate('chat') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" @click="hideChatModel" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="sentMsg" >
                        <ul style="height: 700px;overflow: scroll;" id="chatList">
                            <div v-html="contents"></div>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--Add chat Model end-->

    
    </template>
    
    
    <script>
        import axios from 'axios';
        export default {
    
            data() {

                return {

                        result:[],
                        userList:[],
                        categories: [],
                        msgResult:[],
                        contents:[],

                        job_status: '',
                        job_id: '',
                        complain_type:'',
                        serviceSearch:'',
                        status:'',
                        currentPage: 1,
                        pageSize: 10,

                        complaint_status:'',
                        complainer_id:'',
                        complaint_against_type:'',
                        form:{
                            complaint_against_type:'',
                            complaint_type:'',
                            providerId:'',
                            jobId:'',
                            description:'',
                            previewImage: null,

                        },

                        previewImage: null,
                    
                    };

            },
    
            created() {
                    this.fetchData()
                    this.fetchUserList()
                },

            computed: {
            
                    filteredResult() {

                        if (Array.isArray(this.result) && this.result.length > 0) {

                                const filteredCats = this.result.filter(res => {
                                    const titleMatch = res.complaint_against_type.toLowerCase().includes(this.complain_type.toLowerCase());
                                    const serviceMatch = res.service_id.toLowerCase().includes(this.serviceSearch.toLowerCase());
                                    const statusMatch = res.status.toLowerCase().includes(this.status.toLowerCase());
                                    return titleMatch  && serviceMatch && statusMatch;
                                });
                                return filteredCats.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
                            }
                    },
                    pageCount() {

                        if (Array.isArray(this.result) && this.result.length > 0) {

                            const filteredCats = this.result.filter(res => {
                                const titleMatch = res.complaint_against_type.toLowerCase().includes(this.complain_type.toLowerCase());
                                const serviceMatch = res.service_id.toLowerCase().includes(this.serviceSearch.toLowerCase());
                                const statusMatch = res.status.toLowerCase().includes(this.status.toLowerCase());
                                return titleMatch  && serviceMatch && statusMatch;
                            });
                            return Math.ceil(filteredCats.length / this.pageSize);

                        }
                    },

                },

            methods: {
    
                    fetchData() {
                        
                        this.isLoggedIn = localStorage.getItem('provider');
                        const provider = JSON.parse(this.isLoggedIn);      
                            const parameters = {
                                provider_id: provider.id,
                            };
                            axios.post(this.$chat+'provider_complaints/',parameters)
                                .then(response => {
                                    this.result =  response.data.data
                                })
                                .catch(error => {
                                console.error(error);
                                });
    
                    },

                    fetchUserList() {
    
                        this.isLoggedIn = localStorage.getItem('provider');
                        const provider = JSON.parse(this.isLoggedIn);     
                            const parameters = {
                                provider_id: provider.id
                            };
                            axios.post(this.$service+'providerJobUserList/',parameters)
                                .then(response => {
                                    this.userList =  response.data.data
                                })
                                .catch(error => {
                                console.error(error);
                                });

                        },


                    saveComplaint() {
    
                                this.isLoggedIn = localStorage.getItem('provider');
                                const provider = JSON.parse(this.isLoggedIn);      
                                const parameters = {
                                    complainer_id: provider.id,
                                    complaint_against_type: this.form.complaint_against_type,
                                    complaint_type: 'provider',
                                    complaint_against_id: this.form.providerId,
                                    service_id: this.form.jobId,
                                    complain_description: this.form.description,
                                    image: this.previewImage,
                                };
                                axios.post(this.$chat+'register_complaint/',parameters)
                                    .then(response => {
                                        $('.addComplainModel').modal('hide');
                                        this.fetchData();
                                    })
                                    .catch(error => {
                                    console.error(error);
                                    });

                            },

                    handleFileUpload(event) {

                        const file = event.target.files[0];
                        this.convertToBase64(file);
                        this.v$.previewImage.$touch();       

                        },

                    convertToBase64(file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            this.previewImage = event.target.result;
                        };
                        reader.readAsDataURL(file);
                        },
                                        
                    async sentMsg(){
                        const parameters = {
                            complain_id : $('#complaint_id').val(),
                            complainer_id : $('#complainer_id').val(),
                            complaint_type : $('#complaint_type').val(),
                            message: $('#msg').val(),
                            send_by:"provider",
                            admin_id:"1",
                        };

                    axios.post(this.$chat+'saveComplainChat/',parameters)
                            .then(response => {

                                $('#msg').val(''),
                                this.showChat(parameters.complainer_id,parameters.complaint_type,parameters.complain_id);
                            
                            })
                    },
                    

                    async showChat(complainer_id,complaint_type,complaint_id){

                        const parameters = {
                            user_id: complainer_id,
                            complaint_id: complaint_id,
                            user_type: 'provider',
                        };

                        axios.post(this.$chat+'complainChat/',parameters)
                            .then(response => {

                                if(response.data.status===200){
                            
                                    setTimeout(function() {
                                        var listHeight = $('#chatList').height();
                                        $('#chatList').scrollTop(listHeight);
                                    }, 200); 
                                    
                                    $('.chatModel').modal('show');

                                    this.msgResult = response.data.data;

                                    // console.log(this.msgResult)
                                    let html = '';
                                    this.msgResult.forEach((message) => {

                                        html += `   <li class="d-flex justify-content-between mb-4"
                                                            ${message.send_by === 'admin' ? 'style="display: none!important"': ''}
                                                        >
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                                    <div class="card mask-custom w-100" style="background-color: #cb6666;">
                                                    <div class="card-header d-flex justify-content-between p-3" style="background-color: black;border-bottom: 1px solid rgba(255,255,255,.3);">
                                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> `+message.date+` / `+message.time+`</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="mb-0">`+message.message+`</p>
                                                    </div>
                                                    </div>
                                                </li>
                                                
                                                <li class="d-flex justify-content-between mb-4" ${message.send_by === 'provider' ? 'style="display: none!important"': ''} >
                                                    
                                                    <div class="card mask-custom w-100" style="background-color: #cb6666;">
                                                    <div class="card-header d-flex justify-content-between p-3" style="background-color: black;border-bottom: 1px solid rgba(255,255,255,.3);">
                                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> `+message.date+` / `+message.time+`</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="mb-0">`+message.message+`</p>
                                                    </div>
                                                    </div>
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                                </li>
                                                    
                                                    `;

                                    });

                                    const single_msg = this.msgResult[0];
                                    let input_msg = ` <div style="margin-right: 10px;">
                                                        <li class="mb-3" >
                                                            <div class="form-outline form-white" >
                                                                <textarea class="form-control" id="msg" rows="8"></textarea>
                                                            </div>
                                                        </li>
                                                        <button type="submit" class="btn btn-success btn-lg btn-rounded float-end" style="float:right">Send</button></div>`;

                                    let inputs = `
                                                <input type="hidden" id="complaint_id" value="`+single_msg.complaint_id+`" >
                                                <input type="hidden" id="complainer_id" value="`+single_msg.user_id+`" >
                                                <input type="hidden" id="complaint_type" value="`+single_msg.user_type+`" >
                                                `;

                                    html = html+inputs;

                                this.contents = html+input_msg;

                            }

                            else{
                                    $('.chatModel').modal('show');
                                    let input_msg = ` <div style="margin-right: 10px;">
                                                        <li class="mb-3" >
                                                            <div class="form-outline form-white" >
                                                                <textarea class="form-control" id="msg" rows="8"></textarea>
                                                            </div>
                                                        </li>
                                                        <button type="submit" class="btn btn-success btn-lg btn-rounded float-end" style="float:right">Send</button></div>`;

                                    let inputs = `
                                                <input type="hidden" id="complaint_id" value="`+complaint_id+`" >
                                                <input type="hidden" id="complainer_id" value="`+complainer_id+`" >
                                                <input type="hidden" id="complaint_type" value="`+complaint_type+`" >
                                                `;

                                    this.contents = inputs+input_msg;
                                }


                            })
                            .catch(error => {
                                console.error(error);
                            });
                    },

                    hideChatModel(){
                        $('#msg').val(''),
                        $('.chatModel').modal('hide');
                    },

                    showAddModel(){
                        $('.addComplainModel').modal('show');
                    },
                    hideAddModel(){
                        $('.addComplainModel').modal('hide');
                    }
    
                },
    
        };
    
    </script>


<style >
    .error-msg{
            color:red;
        }

    .gradient-custom {
        /* fallback for old browsers */
        background: #fccb90;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to bottom right, rgba(252, 203, 144, 1), rgba(213, 126, 235, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to bottom right, rgba(252, 203, 144, 1), rgba(213, 126, 235, 1))
    }

    .mask-custom {
        background: rgba(24, 24, 16, .2);
        border-radius: 2em;
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255, 255, 255, 0.05);
        background-clip: padding-box;
        box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
    }
</style>