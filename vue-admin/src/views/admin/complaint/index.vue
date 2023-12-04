<template>
    <body data-sidebar="dark">

  <Header></Header>
    <Sidebar></Sidebar>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">{{page}} List</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">{{page}} List</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="card-header mb-2">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <h4 class="card-title">{{page}} Management</h4>
                                            </div>
                                            <div class="col-md-1">
                                            </div>
                                        </div>
                                        <div >
                                        </div>
                                    </div>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Complaint By</th>
                                            <th>Complaint Against</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in result" :key="index">
                                                <td>{{index+1}}</td>
                                                <td>{{item.complaint_type}}</td>
                                                <td>{{item.complaint_against_type}}</td>
                                                <td>{{item.created_at}}</td>
                                                <td v-if="this.hasActionPermission(11,'update')"><span :class="getStatusClass(item.status)"   @click="statusModel(item.status,item.id)">{{item.status}}</span></td>
                                                <td v-else><span :class="getStatusClass(item.status)">{{item.status}}</span></td>
                                                <td><img :src="item.file" width="100" height="100"></td>
                                                <td style="display:flex; justify-content: space-around; align-items: center;">
                                                    <router-link :to="{name:'ComplaintDetail',params:{id:item.id}}" v-if="this.hasActionPermission(11,'read')" title="View Job" class="btn btn-info btn-sm">
                                                        <i class="bx bx-bullseye"></i>
                                                    </router-link>
                                                    <button class="btn btn-info btn-sm" v-if="this.hasActionPermission(11,'read')" @click="showChat(item.complainer_id,item.complaint_type,item.id)">
                                                        <i class="bx bx-message"></i>
                                                    </button>
                                                </td>
                                                
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div>
            </div>
        </div>
    </body>


<!--Add StatusModel start-->
    <div class="modal fade status_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">{{ page }} Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="onSubmit">
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <select class="form-control" v-model="complaint_status" >
                                    <option value="Pending">Pending</option>
                                    <option value="Solved">Solved</option>
                                </select>
                            </div>
                        </div>

                        <div style="float:right">
                            <button type="submit"   v-on:click="saveStatus"  class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<!--Add Status Model end-->


<!--Add chatModel start-->
<div class="modal fade chatModel" tabindex="-1" role="dialog" aria-labelledby="chatLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="chatLabel">{{ page }} Chat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

    import Header from '../layout/common/Header.vue';
    import Sidebar from '../layout/common/Sidebar.vue';
    import Footer from '../layout/common/Footer.vue';

    export default {
        props: ['page','img_url'],

        components: {

                    Header,
                    Sidebar,
                    Footer,
                },

        created() {
                this.getResult(),
                this.hasParentPermission(10);
            },

        data() {

                return {
                    form: {
                    complaint_against_type: '',
                    id: '',
                },
                    complaint_status:'',
                    complainer_id:'',
                    complaint_against_type:'',
                    result:[],
                    msgResult:[],
                    contents:[],
                }
            },

        methods: {

                async getResult(page=1) {

                        const data =  await this.api('POST',this.$chat+'all_complaint',this.form,false,false)
                        if(data.status===200){
                            this.result =  data.data
                        }
                },

                getStatusClass(status) {
          
                    if (status === 'Pending') return 'btn btn-info'
                        if (status === 'Solved') return 'btn btn-success'
                        return 'btn btn-danger'
                },

                async saveStatus(page=1) {

                        const data =  await this.api('POST',this.$chat+'change_status_complaint',{status:this.complaint_status,complain_id:this.complaint_id},true,true)
                        if(data.status===200){
                            location.reload();
                        }
                },

                statusModel(status,id){
                    $('.status_model').modal('show')
                    this.complaint_status=status;
                    this.complaint_id=id;
                },

                async sentMsg(){
                        const user_typee = ($('#complaint_type').val()=='user'?'provider':'user');
                        const parameters = {
                            complain_id : $('#complaint_id').val(),
                            complainer_id : $('#complainer_id').val(),
                            complaint_against_type : $('#complaint_type').val(),
                            message: $('#msg').val(),
                            send_by:"admin",
                            admin_id:"1",
                        };

                        const data =  await this.api('POST',this.$chat+'saveComplainChat',{ complain_id : $('#complaint_id').val(),
                                            complainer_id : $('#complainer_id').val(),
                                            complaint_type : $('#complaint_type').val(),
                                            message: $('#msg').val(),
                                            send_by:"admin",
                                            admin_id:"1"})
                                .then(response => {

                                    $('#msg').val(''),
                                    this.showChat(parameters.complainer_id,parameters.complaint_against_type,parameters.complain_id);
                                
                                })
                        },

                async showChat(complainer_id,complaint_type,complaint_id){


                    const data =  await this.api('POST',this.$chat+'complainChat',{user_id:complainer_id,user_type:complaint_type,complaint_id:complaint_id})
                        if(data.status===200){

                            setTimeout(function() {
                                var listHeight = $('#chatList').height();
                                $('#chatList').scrollTop(listHeight);
                            }, 200); 
                            
                            $('.chatModel').modal('show');
                               

                            this.msgResult = data.data;
                            let html = '';
                            this.msgResult.forEach((message) => {

                                html += `   <li class="d-flex justify-content-between mb-4"
                                                    ${message.send_by === 'user' ? 'style="display: none!important"': ''}
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
                                        
                                        <li class="d-flex justify-content-between mb-4" ${message.send_by === 'admin' ? 'style="display: none!important"': ''} >
                                            
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
                },

            }
        }
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