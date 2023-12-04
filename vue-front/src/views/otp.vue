<template>
    <div class="pt-120 pb-120 mt-n2">
      <div class="container">
        <div class="justify-content-center">
          <div class="row justify-content-center">
            <div class="col">
              <div class="form-wrap login-form-wrap style--two">
                <div id="recaptcha-container"></div>
                <form @submit.prevent="sendOTP">
                  <input type="text" v-model="phoneNumber" placeholder="Phone number">
                  <button type="submit">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'SendOTP',
    data() {
      return {
        phoneNumber: '',
        confirmationResult: null
      };
    },
    methods: {

            sendOTP() {

                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
                        'size': 'visible',
                        'callback': (response) => {
                            // reCAPTCHA solved, allow signInWithPhoneNumber.
                            onSignInSubmit();
                        }
                    });

                    const appVerifier = window.recaptchaVerifier;
                    firebase.auth().signInWithPhoneNumber(this.phoneNumber, appVerifier)
                    .then((confirmationResult) => {
                    this.confirmationResult = confirmationResult;
                        console.log('OTP Sent');
                    })
                    .catch((error) => {
                    console.error(error);
                    });
            },

    },

    created() {

        const config = {
                    apiKey: "AIzaSyCE16bwKFDAlZ2BKl_p-gCVEEfoy1NULYQ",
                    authDomain: "notension-mobile-otp.firebaseapp.com",
                    projectId: "notension-mobile-otp",
                    storageBucket: "notension-mobile-otp.appspot.com",
                    messagingSenderId: "477712646493",
                    appId: "1:477712646493:web:7b048ce53a35a81f0ca8b4",
                    measurementId: "G-9CKCEZ133R"
        };
        
        firebase.initializeApp(config);
    }

  };
  </script>




