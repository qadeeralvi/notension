<template>
    
    <div class="pt-120 pb-120">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="contact-info mb-30 mb-lg-0 fontbg-color">
              <h3>Contact Info</h3>
              <h2>
             {{ number }}
              </h2>
              
              <p class="mb-2 pb-1">
                <img :src="this.$main + 'assets/img/icon/mail.svg'" alt="" class="svg">
                {{ email }}
              </p>
              <p class="mb-2 pb-1">
                <img :src="this.$main + 'assets/img/icon/mail.svg'" alt="" class="svg">
               Support@notension.pk
              </p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="widget widget_service_hour white-dot all-white fontbg-color" style="background-color: #6db5ff;">
              <h3 class="widget-title">Opening Hours</h3>
              <div class="menu-container">
                <ul class="menu">
                  <li>
                    <span>Monday </span>7.00 - 16.00
                  </li>
                  <li>
                    <span>Tuesday</span>7.00 - 16.00
                  </li>
                  <li>
                    <span>Wednesday</span>7.00 - 16.00
                  </li>
                  <li>
                    <span>Thursday</span>7.00 - 16.00
                  </li>
                  <li>
                    <span>Friday</span>7.00 - 16.00
                  </li>
                  <li>
                    <span>Saturday</span>7.00 - 16.00
                  </li>
                  <li>
                    <span>Sunday</span>7.00 - 16.00
                  </li>
                </ul>
              </div>
            </div>
          </div>
         
         
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
        return {
          
           number:'',
           email:'',
        }
  },
  
  mounted() {
  
        axios.post('https://website.notension.pk/api/webSetting/')
           .then(response => {
                 this.setting = response.data.data;
                 this.number = this.setting.number
                 this.email = this.setting.email
           })
           .catch(error => {
                 console.error(error);
           });

  },

 
}
</script>