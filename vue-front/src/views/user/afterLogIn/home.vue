<template>

    <div class="pt-60 pb-120 ovx-hidden bg-color">
        <div class="container" v-if="count>0">
                            <div class="row">
                                <div class="col-md-6 job" style="margin-bottom: 10px;"><h2>{{ this.translate('myJobs') }}</h2></div>
                                <div class="col-md-5 job">
                                    <label class="toggle" style="float:right">
                                        <input type="checkbox" v-model="showPending">
                                        <span class="slider"></span>
                                        <span class="labels" :data-on="onText" :data-off="offText"></span>
                                    </label>

                                </div>
                            </div>
                    <div class=" form-wrap login-form-wrap style--two card-button">
                           
                            <span v-for="(item,index) in paginatedResult" :key="index">
                            <div class="row gray" >
                                <div class="col-lg-2 col-xs-6">
                                    <div class="form-group">
                                       <img :src="this.$main + 'assets//img/icon/service-icon1.png'" alt="no">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-6">
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
                                    <button :class="{'btn btn-info': item.status === 'pending', 'btn btn-success': item.status !== 'pending'}">{{ item.status }}</button>
                                    &nbsp <router-link  v-if="item.status=='active'" :to="{ path: '/chat', query: { id: item.id } }">
                                            <button  class="btn btn-warning notification">Chat
                                              <span class="badge" style="display:none">{{ getBadgeValue(item.id) }}</span>
                                              <span class="badge">{{this.unseen}}</span>
                                            </button>
                                          </router-link>
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
        <div v-else><center><h2>You don't post job yet</h2></center> </div>
    </div>

</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      result: [],
      currentPage: 1,
      pageSize: 10,
      showPending: true,
      onText: 'Active',
      offText: 'Finished',
      unseen:'0',
      count:0,
    };
  },
  computed: {


    getBadgeValue() {
          return async  function(jobId) {
              await this.fetchCounter(jobId);
          }
    },     

      paginatedResult() {
          const start = (this.currentPage - 1) * this.pageSize;
          const end = start + this.pageSize;
          const filteredResult = this.result.filter(item => {
            if (this.showPending) {
              return item.status === 'pending';
            } else {
              return true;
            }
          });
          return filteredResult.slice(start, end);
      },
      pageCount() {
          const filteredResult = this.result.filter(item => {
            if (this.showPending) {
              return item.status === 'pending';
            } else {
              return true;
            }
          });
          return Math.ceil(filteredResult.length / this.pageSize);
      }

  },

  created() {
    this.fetchData();
  },

  methods: {

    fetchData() {

        this.isLoggedIn = localStorage.getItem('user');
        const user = JSON.parse(this.isLoggedIn);
        const parameters = {
          user_id: user.user_id
        };
        axios.post(this.$service + 'user_job_list/', parameters)
          .then(response => {
            this.result = response.data.data;
            this.count = this.result.length;
          })
          .catch(error => {
            console.error(error);
          });

    },

    async fetchCounter(jobId) {

                  this.isLoggedIn = localStorage.getItem('user');
                  const user = JSON.parse(this.isLoggedIn);
                  const parameters = {
                      jobId: jobId,
                      userId: user.user_id
                  };

                  if(user.user_id!=''){
                    const counter = '';
                      axios.post(this.$service+'providerByJob/',parameters)
                          .then(response => {
                              if(response.data.status==200){
                                  this.unseen =  this.count.reduce((total, provider) => total + provider.unseen, 0);
                              }
                          })
                          .catch(error => {
                              console.error(error);
                          });         
                      }

                      return 0;
    },

    showChat(receiver_id){

              this.isLoggedIn = localStorage.getItem('user');
              const user = JSON.parse(this.isLoggedIn);
              const parameters = {
                    user_id: user.user_id,
                    receiver_id:receiver_id,
                  };
                  axios.post(this.$chat + 'user_messages/', parameters)
                                    .then(response => {
                                        let html = '';
                                        if (response.data.status == 200) {

                                            this.msgResult = response.data.data
                                            this.msgResult.forEach((message) => {

                                                html += `   <li class="d-flex justify-content-between mb-4"
                                                      ${message.send === 'send_me' ? 'style="display: none!important"': ''} >
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

          this.isLoggedIn = localStorage.getItem('user');
          const user = JSON.parse(this.isLoggedIn);

            const parameters = {
                sender_id: user.user_id,
                receiver_id : receiver_id,
                message: this.msg,
                send_to:"provider"
            };

            axios.post(this.$chat+'send_message/',parameters)
                    .then(response => {
                        this.showChat(receiver_id);
                        this.msg = '';
                    })
      },

  }
};
</script>

<style>


.notification {
  background-color: #555;
  color: white;
  text-decoration: none;
  padding: 15px 26px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}


.notification .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background-color: red;
  color: white;
}

.selected {
    background-color: rgba(0,0,0,.7);
    color: white;
    border-radius: 36px;
    width: 36px!important;
    height: 36px!important;
}
.toggle {
      --width: 125px;
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
