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
                      <label for="stars" class="mb-2 semi-bold title-color">Stars</label><br>
                        <div class="rate">
                            <input type="radio" id="star5" name="rate" value="5" v-model="selectedRating" />
                            <label for="star5" title="text">5 stars</label>

                            <input type="radio" id="star4" name="rate" value="4" v-model="selectedRating" />
                            <label for="star4" title="text">4 stars</label>

                            <input type="radio" id="star3" name="rate" value="3" v-model="selectedRating" />
                            <label for="star3" title="text">3 stars</label>

                            <input type="radio" id="star2" name="rate" value="2" v-model="selectedRating" />
                            <label for="star2" title="text">2 stars</label>

                            <input type="radio" id="star1" name="rate" value="1" v-model="selectedRating" />
                            <label for="star1" title="text">1 star</label>
                        </div>
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
              <button type="submit" class="btn c1-hover btn-border" >
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
                                    selectedRating: '',
                                    form: {
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
                                        
                                            rate: {
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
                                                stars: this.selectedRating,
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

                            setRating(rating) {
                                    // Update the form.stars property when the user selects a rating
                                    this.form.stars = rating;
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




.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

</style>