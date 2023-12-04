<template>

    <section class="newsletter-section">
        <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="newsletter-inner">
                     <div class="row align-items-center">
                        <div class="col-xxl-3 col-lg-4">
                           <div class="newsletter-content text-center text-lg-start mb-3 mb-lg-0">
                              <h3 class="mb-2">Subscribe To Newsletter</h3>
                              <p>Daily Update And Promotion</p>
                           </div>
                        </div>
                        <div class="col-xxl-9 col-lg-8">
                           <div class="newsletter-form-wrap">
                              <form action="https://themelooks.us13.list-manage.com/subscribe/post?u=79f0b132ec25ee223bb41835f&amp;id=f4e0e93d1d" class="newsletter-form">
                                 <div class="form-group"><input type="text" class="form-control" placeholder="Your Name"></div>
                                 <div class="form-group"><input type="email" class="form-control" placeholder="Your Email"></div>
                                 <button type="submit" class="btn btn-lg"><span>Subscribe</span> <img :src="this.$main + 'assets/img/icon/subscribe-icon.svg'" alt="" class="svg"></button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
    </section>

</template>