<template>

        <section class="pt-120 pb-120 video-section style--two" :style="{ backgroundImage: 'url(' + reviewsBg + ')' }">
			<div class="container">
				<div class="row justify-content-end">
					<div class="col-xl-6 col-lg-8 d-flex justify-content-center justify-content-lg-start">
						<div class="video-slider-wrap c5-bg">
							<div class="video-slider swiper-container">
								<div class="swiper-wrapper">
									<div class="swiper-slide">
										<div class="video-slide-card all-white"><img src="assets/img/icon/video-quote.svg" alt="" class="svg quote">
											<p>I have been a seller on Notension from march. repair been very supportive & my sales are increased day delivery very fast mode of payments is very smooth to develop their business privacy policy.</p>
											<div class="d-flex align-items-center">
												<div class="icon me-3"><img src="assets/img/media/daniel.png" alt=""></div>
												<div class="content">
													<h3>Daniel Smith</h3>
													<p>Lovely Customer</p>
												</div>
											</div>
										</div>
									</div>
									<div class="swiper-slide">
										<div class="video-slide-card all-white"><img src="assets/img/icon/video-quote.svg" alt="" class="svg quote">
											<p>Global Electronic Services provides truly in-house comprehensive repair services and solutions for most manufacturers as well as new, refurbished and obsolete equipment. We have a 1-5 day standard</p>
											<div class="d-flex align-items-center">
												<div class="icon me-3"><img src="assets/img/media/daniel_01.png" alt=""></div>
												<div class="content">
													<h3>Jhon Wick</h3>
													<p>Lovely Customer</p>
												</div>
											</div>
										</div>
									</div>
									<div class="swiper-slide">
										<div class="video-slide-card all-white"><img src="assets/img/icon/video-quote.svg" alt="" class="svg quote">
											<p>I have been a seller on Notension from march. repair been very supportive & my sales are increased day delivery very fast mode of payments is very smooth to develop their business privacy policy.</p>
											<div class="d-flex align-items-center">
												<div class="icon me-3"><img src="assets/img/media/daniel_02.png" alt=""></div>
												<div class="content">
													<h3>Robert Downy</h3>
													<p>Lovely Customer</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-pagination white"></div>
							</div>
						</div>
					</div>
				</div>
			</div><a href="https://www.youtube.com/watch?v=hnp1pt8biD4" class="mfp-iframe video-btn c5-bg w-120 d-none d-md-inline-flex"><img src="assets/img/icon/play.svg" alt="" class="svg"></a>
		</section>

</template>


<script>
    import ReviewsBg from '/assets/img/bg/video-bg3.png'

    export default {
    data() {
        return {
			reviewsBg: ReviewsBg
        }
    }
    }
</script>