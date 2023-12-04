<template>

        <div class="banner layer style--five bg-center" :style="{ backgroundImage: 'url(' + imageUrl + ')' }">

			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="banner-content style--two mb-70 mb-lg-0">
							<h5 class="banner-top-title">Repair Company</h5>
							<h1>We Help To Solution!</h1>
							<p>Starting an auto repairing business is a wonderfully way to spend your daily mobiles caring their mobile & resolving the problems.</p>
								<a href="service.html" class="btn c_5 btn-lg"><span>Signup</span>
								</a>
							<div><a href="contact.html" class="chat-profile d-none d-lg-inline-flex pb-0">
									<div class="profile-img"><img src="assets/img/media/chat-profile2.png" alt=""></div>
									<div class="profile-content">
										<p>Any Inquiry?</p>
										<h5 class="c5">Talk to Our Expert!</h5>
									</div>
								</a></div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="banner-img"><img src="assets/img/media/img-elements.png" class="banner-img-elements" alt=""> <img src="assets/img/media/banner-img5.png" class="main-img" data-rjs="2" alt=""></div>
					</div>
				</div>
			</div>
		</div>

</template>

<script>
    import bannerBg from '/assets/img/bg/banner-bg5.png'

    export default {
    data() {
        return {
        imageUrl: bannerBg
        }
    }
    }
</script>
