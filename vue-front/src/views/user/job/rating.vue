<template>

    <div class="pt-120 pb-120 mt-n2">
     <div class="container">
      <div class="justify-content-center">
       <div class="row justify-content-center">
        <div class="col">
          <div class="form-wrap login-form-wrap style--two">
         <form @submit.prevent="saveRating" >
          <div class="row">
              <div class="col-lg-6">
                  <div class="form-group mb-20">
                      <label for="provider" class="mb-2 semi-bold title-color">Provider</label>
                      <select v-model="v$.form.provider.$model" class="form-control">
                              <option selected disabled>Choose Provider who done the Job</option>
                              <option v-for="pro in result" :value="pro.provider_id">{{ pro.provider_name }}</option>
                              
                      </select>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="form-group mb-20">
                    <label for="stars" class="mb-2 semi-bold title-color">Stars</label>
                    <br>
                    <input type="radio" id="star1" name="stars"  v-model="v$.form.stars.$model" value="1" />
                    <label for="star1" title="1 stars">&#9733;</label>

                    <input type="radio" id="star2" name="stars" v-model="v$.form.stars.$model" value="2" />
                    <label for="star2" title="2 stars">&#9733;</label>

                    <input type="radio" id="star3" name="stars" v-model="v$.form.stars.$model" value="3" />
                    <label for="star3" title="3 stars">&#9733;</label>

                    <input type="radio" id="star4" name="stars" v-model="v$.form.stars.$model" value="4" />
                    <label for="star4" title="4 stars">&#9733;</label>

                    <input type="radio" id="star5" name="stars" v-model="v$.form.stars.$model" value="5" />
                    <label for="star5" title="5 star">&#9733;</label>
                  </div>
              </div>
              <div class="col-lg-12">
                  <div class="form-group mb-20">
                      <label for="comment" class="mb-2 semi-bold title-color">Comment</label>
                      <textarea rows="20" cols="20" class="form-control" v-model="v$.form.comment.$model" > </textarea>
                  </div>
              </div>
  
          </div>
  
          <div class="d-flex align-items-center">
              <button type="submit" class="btn c1-hover btn-border" :disabled="v$.form.$invalid">
                  <span>Submit</span>
              </button>
          </div>
         </form>
          </div>
        </div>
       </div>
      </div>
     </div>
    </div>
  </template>
  <script>
      import axios from 'axios';
      import swal from 'sweetalert';
      import useVuelidate from '@vuelidate/core'
      import { required, email, minLength } from '@vuelidate/validators'
  
      export default {
  
                        setup () {
                            return { v$: useVuelidate() }
                        },
            
                        data() {

                            return {

                                    result:[],
                                    rating:'',
                                    form: {
                                            stars:'',
                                            comment: '',
                                            provider: '',
                                        },
                            };

                        },

                        created() {
                                this.fetchProvider()
                                this.fetchRating()
                            },
            
                        validations() {
            
                                return {
            
                                    form: {
                                        
                                            stars: {
                                                required 
                                            },
                                            comment: {
                                                required 
                                            },
                                            provider: {
                                                required 
                                            },
                                    },
                                }
                            },
            
                        methods: {

                            fetchProvider() {

                                            const parameters = {
                                                            job_id:this.$route.query.job_id,
                                                }

                                            axios.post(this.$service+'provider_jobs/',parameters)
                                                .then(response => {
                                                    this.result =  response.data.data
                                                })
                                                .catch(error => {
                                                console.error(error);
                                                });
                                    },

                            fetchRating() {

                                            const parameters = {
                                                        job_id:this.$route.query.job_id,
                                                }

                                            axios.post(this.$service+'job_rating/',parameters)
                                                .then(response => {
                                                    if(response.data.status==200){
                                                      
                                                        this.rating =  response.data.data
                                                        this.form.provider =  this.rating.provider_id
                                                        this.form.stars =  this.rating.stars
                                                        this.form.comment =  this.rating.comment
                                                    }
                                                })
                                                .catch(error => {
                                                console.error(error);
                                                });
                                            },

                            saveRating() {

                                            this.isLoggedIn = localStorage.getItem('user');
                                            const user = JSON.parse(this.isLoggedIn);
                                            const parameters = {
                                                user_id: user.user_id,
                                                job_id:this.$route.query.job_id,
                                                stars: this.form.stars,
                                                comment: this.form.comment,
                                                provider_id: this.form.provider,
                                                comment_given_by: 'user',
                                            };

                                            axios.post(this.$service+'save_rating/',parameters)
                                                .then(response => {

                                                    if(response.data.status==200){
                                                        swal("Rating save successfully", "" ,"success");
                                                        this.$router.push({name:"JobList"});
                                                    }
                                                })
                                                .catch(error => {
                                                console.error(error);
                                                });
                
                                        },
                        
                    },
            
                };
  
  </script>


<style>
/* Hide the radio buttons */
input[type="radio"] {
  display: none;
}

/* Style the labels */
label {
  font-size: 2rem;
  color: #ccc;
  cursor: pointer;
}

/* Change the color of selected stars */
input[type="radio"]:checked ~ label {
  color: #f5a623;
}

/* Add hover effects */
label:hover {
  color: #f5a623;
}
</style>