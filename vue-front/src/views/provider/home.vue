<template>

    <div class="pt-60 pb-120 ovx-hidden bg-color">
        <div class="container" v-if="count>0">
                        <div class="row" style="margin-bottom: 5px;">
                            <div class="col-md-2 job" style="margin-bottom: 10px;"><h2>{{ this.translate('myJobs') }}</h2></div>
                            <div class="col-md-1 col-3 col-sm-3" style="margin-left: 5px;"><button class="btn fontbg-color"  @click="showAll" >{{ this.translate('all') }}</button></div>
                            <div class="col-md-1 col-3 col-sm-3" style="margin-left: 5px;"><button class="btn fontbg-color"  @click="showPending" >{{ this.translate('pending') }}</button></div>
                            <div class="col-md-1 col-3 col-sm-3" style="margin-left: 15px;"><button class="btn fontbg-color" @click="showActive">{{ this.translate('active') }}</button></div>
                            <div class="col-md-1 col-3 col-sm-3" style="margin-left: 5px;"><button class="btn fontbg-color" @click="showDone">{{ this.translate('completed') }}</button></div>
                        </div>
                    <div class=" form-wrap login-form-wrap style--two card-button form-border">

                      <span v-for="(item,index) in paginatedResult" :key="index" @click="showJobModal(item.id)" >

                            <div class="row gray" >

                                <div class="col-lg-1 col-xs-6">
                                    <div class="form-group">
                                       <img  :src="this.$main + 'assets//img/icon/service-icon1.png'" alt="no">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-xs-6">
                                    <div class="form-group">
                                        <h3 class="font-color">{{item.title}}</h3>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <span class="font-color">{{item.date}} / {{ item.time }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <button v-if="item.provider_assign_status=='active'" class=" btn btn-success" >{{ item.provider_assign_status }}</button>&nbsp
                                        <button v-if="item.provider_assign_status=='pending'" class="btn btn-info" >{{ item.provider_assign_status }}</button>
                                        <button v-if="item.provider_assign_status=='active'"  class="btn btn-warning" @click="showChat(item.user_id);$event.stopPropagation()">{{ this.translate('chat') }}</button>
                                    </div>
                                </div>

                            </div>
                            <hr>
                        </span>

                        <div style="display: flex; align-items: center;">
                            <button :disabled="currentPage === 1" @click="currentPage--">{{ this.translate('prev') }}</button>
                            <div v-for="page in pageCount" :key="page" style="margin: 0 5px;">
                            <button 
                                @click="currentPage = page"
                                :class="{ 'selected': currentPage === page }"
                            >
                                {{ page }}
                            </button>
                            </div>
                            <button :disabled="currentPage === pageCount" @click="currentPage++">{{ this.translate('next') }}</button>
                        </div>

                               
            </div>
        </div>
        <div v-else><center><h2>{{ this.translate('jobNotAssign') }}</h2></center> </div>
    </div>

    

 <!--Add Model start-->

 <div class="modal fade jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="jobModalLabel">{{ this.translate('jobStatus') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" @click="hideJobModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="jobAccept">

                      <input type="hidden"  class="form-control" readonly v-model="form.job_id" >
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('category') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.category" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('subCategory') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.sub_category"  >
                                    </div>
                                </div>
                            </div>

                          <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('title') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.title" >
                                    </div>
                                </div>
                          </div>
                          <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('description') }}</label>
                                        <textarea class="form-control"  cols="30" rows="10" readonly>{{ form.description }}</textarea>
                                    </div>
                                </div>
                          </div>

                          <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('name') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.name"  >
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group" v-if="form.status == 'active'">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('email') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.email"   >
                                    </div>
                                    <div class="form-group" v-else>
                                        <label  class="mb-2 semi-bold black">{{ this.translate('email') }}</label>
                                        <input type="text"  class="form-control" readonly value="Email will display when job accept"  >
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group" v-if="form.status === 'active'">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('phone') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.phone"  >
                                    </div>
                                    <div class="form-group" v-else>
                                        <label  class="mb-2 semi-bold black">{{ this.translate('phone') }}</label>
                                        <input type="text"  class="form-control" readonly value="Phone will display when job accept"  >
                                    </div>
                                </div>

                          </div>

                          <div class="row">
                            <div class="col-lg-6">
                                    <div class="form-group">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('city') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.city"  >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label  class="mb-2 semi-bold black">{{ this.translate('address') }}</label>
                                        <input type="text"  class="form-control" readonly v-model="form.address" >
                                    </div>
                                </div>
                               

                              
                          </div>

                        <div style="float:right" v-if="form.status=='pending'">
                            <button type="submit"   class="btn btn-primary waves-effect waves-light" >{{ this.translate('accept') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<!--Add Model end-->


<!-- Chat Modal Start -->

    <div class="modal fade chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="chatModalLabel">{{ this.translate('chat') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" @click="hideChatModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="sentMsg">
                      <div v-html="contents"></div>

                      <li class="mb-3">
                          <div class="form-outline form-white">
                          <textarea class="form-control" id="textAreaExample3" rows="4" v-model="msg"></textarea>
                          </div>
                      </li>

                      <button type="submit" class="btn fontbg-color btn-light btn-lg btn-rounded float-end">{{ this.translate('send') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Chat Modal End -->


</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      result: [],
      contents:[],
      msg:'',
      receiver_id:'',
      form:{
          job_id:'',
          title:'',
          category:'',
          sub_category:'',
          description:'',
          email:'',
          phone:'',
          name:'',
          address:'',
          city:'',
          status:'',
          provider_job_status:'',
      },
      currentPage: 1,
      pageSize: 5,
      isPending: false,
      isActive: false,
      isDone: false,
      isAll:false,
      showModal: false,
      count:0,
    };
  },
  computed: {

      paginatedResult() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            const filteredResult = this.result.filter(item => {
              if (this.isPending) {
                return item.provider_assign_status === 'pending';
              }
              else if (this.isActive) {
                return item.provider_assign_status === 'active';
              }
              else if (this.isDone) {
                return item.provider_assign_status === 'done';
              }
               else {
                return this.result;
              }
            });
          return filteredResult.slice(start, end);
      },

      pageCount() {
            const filteredResult = this.result.filter(item => {
              if (this.isPending) {
                return item.provider_assign_status === 'pending';
              }
              else if (this.isActive) {
                return item.provider_assign_status === 'active';
              }
              else if (this.isDone) {
                return item.provider_assign_status === 'done';
              } else {
                  return true;
                }
            });
            // const filteredResult = this.result;
            return Math.ceil(filteredResult.length / this.pageSize);
      }

    },

    created() {
      this.fetchData();
    },

    methods: {

        fetchData() {

                  this.isLoggedIn = localStorage.getItem('provider');
                  const provider_id = JSON.parse(this.isLoggedIn);
                  const parameters = {
                    provider_id: provider_id,
                  };
              
                axios.post(this.$service + 'provider_job_list/', parameters)
                  .then(response => {
                      this.result = response.data.data;
                      this.count = this.result.length;
                  })
                  .catch(error => {
                      console.error(error);
                  });
            },


        showPending() {
                    this.isPending = !this.isPending;
                    this.isActive = false;
                    this.isDone = false;
                    this.isAll = false;

            },

        showActive() {
                this.isActive = true;
                this.isDone = false;
                this.isPending = false;
                this.isAll = false;
            },

        showDone() {
            this.isDone = !this.isDone;
            this.isActive = false;
            this.isPending = false;
            this.isAll = false;
            },

        showAll() {
            this.isAll = !this.isAll;
            this.isActive = false;
            this.isPending = false;
            this.isDone = false;
            },

        async showJobModal(id){

              this.isLoggedIn = localStorage.getItem('provider');
              const provider = JSON.parse(this.isLoggedIn);
              
              const parameters = {
                    provider_id: provider.id,
                    job_id:id,
                  };
              
                axios.post(this.$service + 'provider_single_job/', parameters)
                .then(response => {
                      if(response.status===200){
                          $('.jobModal').modal('show')
                          this.res =  response.data.data
                          this.form.title= this.res[0].title;
                          this.form.job_id= this.res[0].id;
                          this.form.category= this.res[0].category_title;
                          this.form.sub_category= this.res[0].sub_category_title;
                          this.form.description= this.res[0].description;
                          this.form.email= this.res[0].email;
                          this.form.phone= this.res[0].phone;
                          this.form.name= this.res[0].name;
                          this.form.address= this.res[0].address;
                          this.form.city= this.res[0].city;
                          this.form.status= this.res[0].provider_job_status;
                      }
                })
                .catch(error => {
                  console.error(error);
                });

            },

        hideJobModal(){

            $('.jobModal').modal('hide')

            },

        hideChatModal(){

            $('.chatModal').modal('hide')

            },

        jobAccept() {

                    this.isLoggedIn = localStorage.getItem('provider');
                    const provider = JSON.parse(this.isLoggedIn);
                    const parameters = {
                      provider_id: provider.id,
                      job_id:this.form.job_id,
                      status:'active',
                    };

                    axios.post(this.$service + 'provider_job_status_change/', parameters)
                    .then(response => {
                        $('.jobModal').modal('hide')
                        location.reload();
                    })
                    .catch(error => {
                    console.error(error);
                    });
              },

        showChat(receiver_id){

              this.isLoggedIn = localStorage.getItem('provider');
              const provider = JSON.parse(this.isLoggedIn);
              const parameters = {
                    provider_id: provider.id,
                    receiver_id:receiver_id,
                  };
                  axios.post(this.$chat + 'provider_messages/', parameters)
                                    .then(response => {
                                        let html = '';
                                        if (response.data.status == 200) {

                                            this.msgResult = response.data.data
                                            this.msgResult.forEach((message) => {

                                                html += `   <li class="d-flex justify-content-between mb-4"
                                                                    ${message.send === 'send_me' ? 'style="display: none!important"': ''}
                                                                >
                                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                                            <div class="card mask-custom w-100" style="background-color: #acafae;">
                                                            <div class="card-header d-flex justify-content-between p-3" style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                                                <p class="text-light small mb-0"><i class="far fa-clock"></i> `+message.deliver_date+` / `+message.deliver_time+`</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="mb-0">`+message.message+`</p>
                                                            </div>
                                                            </div>
                                                        </li>
                                                        
                                                        <li class="d-flex justify-content-between mb-4" ${message.send === 'other' ? 'style="display: none!important"': ''} >
                                                           
                                                            <div class="card mask-custom w-100" style="background-color: #d7d7d7;">
                                                            <div class="card-header d-flex justify-content-between p-3" style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                                                <p class="text-light small mb-0"><i class="far fa-clock"></i> `+message.deliver_date+` / `+message.deliver_time+`</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="mb-0">`+message.message+`</p>
                                                            </div>
                                                            </div>
                                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                                        </li>`;
                                        });

                                        const msg = this.msgResult[0];
                                        
                                        if(msg.send=== 'send_me'){
                                            const receiver_id = msg.receiver_id;
                                        }
                                        else{
                                            const receiver_id = msg.sender_id;
                                        }

                                        html = html+`<input type="hidden" id="receiver_id" v-model="receiver_id" value="`+receiver_id+`" >`;
                                        
                                        this.contents = html;
                                        $('.chatModal').modal('show')
                                        $('.jobModal').modal('hide')
                                        }
                                        else{

                                            html = `<input type="hidden" id="receiver_id" v-model="receiver_id" value="`+receiver_id+`" >`;
                                            this.contents = html;
                                            $('.chatModal').modal('show')
                                            $('.jobModal').modal('hide')
                                        }
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });
          },


        sentMsg(){

                      const receiver_id = $("#receiver_id").val();
                      this.isLoggedIn = localStorage.getItem('provider');
                      const provider = JSON.parse(this.isLoggedIn);      

                        const parameters = {
                            sender_id: provider.id,
                            receiver_id : receiver_id,
                            message: this.msg,
                            send_to:"user"
                        };
                        axios.post(this.$chat+'send_message/',parameters)
                                .then(response => {

                                    this.showChat(receiver_id);
                                    this.msg = '';
                                })

                  },


    } ,
};
</script>

<style>
      .selected {
          background-color: rgba(0,0,0,.7);
          color: white;
          border-radius: 36px;
          width: 36px!important;
          height: 36px!important;
      }
      .toggle {
      --width: 100px;
      --height: calc(var(--width) / 3);

      position: relative;
      display: inline-block;
      width: var(--width);
      height: var(--height);
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
      border-radius: var(--height);
      cursor: pointer;
    }

    .toggle input {
      display: none;
    }

    .toggle .slider {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: var(--height);
      background-color: #ccc;
      transition: all 0.4s ease-in-out;
    }

    .toggle .slider::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: calc(var(--height));
      height: calc(var(--height));
      border-radius: calc(var(--height) / 2);
      background-color: #fff;
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
      transition: all 0.4s ease-in-out;
    }

    .toggle input:checked+.slider {
      background-color: #2196F3;
    }

    .toggle input:checked+.slider::before {
      transform: translateX(calc(var(--width) - var(--height)));
    }

    .toggle .labels {
      position: absolute;
      top: 8px;
      left: 0;
      width: 100%;
      height: 100%;
      font-size: 15px;
      font-family: sans-serif;
      transition: all 0.4s ease-in-out;
    }

    .toggle .labels::after {
      content: attr(data-off);
      position: absolute;
      right: 5px;
      color: #4d4d4d;
      opacity: 1;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
      transition: all 0.4s ease-in-out;
    }

    .toggle .labels::before {
      content: attr(data-on);
      position: absolute;
      left: 5px;
      color: #ffffff;
      opacity: 0;
      text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
      transition: all 0.4s ease-in-out;
    }

    .toggle input:checked~.labels::after {
      opacity: 0;
    }

    .toggle input:checked~.labels::before {
      opacity: 1;
    }

</style>
