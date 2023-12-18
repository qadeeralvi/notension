<template>

<section class="gradient-custom">
  <div class="container" style="padding-top:7rem!important;padding-bottom: 5rem!important;">

    <div class="row">

      <div class="col-md-6 col-lg-5 col-xl-5 mb-4 mb-md-0">

        <h5 class="font-weight-bold mb-3 text-center text-white">{{ this.translate('provider') }}</h5>

        <div class="card mask-custom">
          <div class="card-body">

            <ul class="list-unstyled mb-0">
              <li v-for="(item,index) in result" :key="index" v-on:click="showMessage(item.user_id)" class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                <!-- <a href="#!" class="d-flex justify-content-between link-light"> -->
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">{{ item.name }}</p>
                      <p class="small text-white">{{ item.message }}</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">Just now</p>
                    <span class="badge bg-danger float-end">1</span>
                  </div>
                <!-- </a> -->
              </li>
             
            </ul>

          </div>
        </div>

      </div>

      <div class="col-md-6 col-lg-7 col-xl-7">

        <ul class="list-unstyled text-white" >

            <form @submit.prevent="sentMsg" >
                <div v-html="contents"></div>

                <li class="mb-3">
                    <div class="form-outline form-white">
                    <textarea class="form-control" id="textAreaExample3" rows="4" v-model="form.msg"></textarea>
                    </div>
                </li>

                <button type="submit" class="btn btn-light btn-lg btn-rounded float-end">{{ this.translate('send') }}</button>

            </form>

        </ul>

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
                msgResult:[],
                contents:[],
                form:{
                    msg:'',
                    receiver_id:'',
                },
                receiver_id:'',
            }
    },
    created() {
                this.fetchMsg();
                this.showMessage();
    },
    methods: {

                    fetchMsg() {

                            this.isLoggedIn = localStorage.getItem('provider');
                            const provider_id = JSON.parse(this.isLoggedIn);      
                            const parameters = {
                                provider_id: provider_id,
                            };

                            axios.post(this.$chat+'provider_mesgs_list/',parameters)
                                .then(response => {
                                    if(response.data.status==200){
                                        this.result =  response.data.data
                                    }
                                    
                                })
                                .catch(error => {
                                    console.error(error);
                                });         
                        },

                    sentMsg(){

                      this.isLoggedIn = localStorage.getItem('provider');
                      const provider_id = JSON.parse(this.isLoggedIn);      

                        const parameters = {
                            sender_id: provider_id,
                            receiver_id : 3,
                            // receiver_id : this.form.receiver_id,
                            message: this.form.msg,
                            send_to:"user"
                        };
                        console.log(parameters)

                        axios.post(this.$chat+'send_message/',parameters)
                                .then(response => {

                                    this.showMessage(3);
                                    this.msg = '';
                                })

                    },

                    showMessage(receiver_id) {

                            this.isLoggedIn = localStorage.getItem('provider');
                            const provider_id = JSON.parse(this.isLoggedIn);   
                            const parameters = {
                                provider_id: provider_id,
                                receiver_id: receiver_id,
                            };

                                axios.post(this.$chat + 'provider_messages/', parameters)
                                    .then(response => {

                                        if (response.data.status == 200) {

                                            this.msgResult = response.data.data
                                            let html = '';
                                            this.msgResult.forEach((message) => {

                                                html += `   <li class="d-flex justify-content-between mb-4"
                                                                    ${message.send === 'send_me' ? 'style="display: none!important"': ''}
                                                                >
                                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                                            <div class="card mask-custom w-100" style="background-color: #cb6666;">
                                                            <div class="card-header d-flex justify-content-between p-3" style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                                                <p class="text-light small mb-0"><i class="far fa-clock"></i> `+message.deliver_date+` / `+message.deliver_time+`</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="mb-0">`+message.message+`</p>
                                                            </div>
                                                            </div>
                                                        </li>
                                                        
                                                        <li class="d-flex justify-content-between mb-4" ${message.send === 'other' ? 'style="display: none!important"': ''} >
                                                           
                                                            <div class="card mask-custom w-100" style="background-color: #cb6666;">
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

                                        html = html+`<input type="hidden" v-model="receiver_id" value="`+receiver_id+`" >`;
                                        
                                        this.contents = html;
                                        }
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });
  
                        }
        }
}
</script>


<style>

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