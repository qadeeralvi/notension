<template>

<section class="funfact pt-120 pb-80 c4-bg" :style="{ backgroundImage: 'url(' + experienceBg + ')' }">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="single-funfact right-shape right-shape--two text-white text-center"><img src="assets/img/icon/funfact1.svg" alt="">
							<h2><span class="counter">29</span><span>+</span></h2>
							<h3>Years Experience</h3>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="single-funfact right-shape right-shape--two text-white text-center"><img src="assets/img/icon/funfact2.svg" alt="">
							<h2><span class="counter">12</span><span>k+</span></h2>
							<h3>Happy Clients</h3>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="single-funfact right-shape right-shape--two text-white text-center"><img src="assets/img/icon/funfact3.svg" alt="">
							<h2><span class="counter">99</span><span>k+</span></h2>
							<h3>Success Service</h3>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="single-funfact text-white style--two text-center"><img src="assets/img/icon/funfact4.svg" alt="">
							<h2><span class="counter">69</span><span>+</span></h2>
							<h3>Service Points</h3>
						</div>
					</div>
				</div>
			</div>
		</section>

</template>

<script>
    import ExperienceBg from '/assets/img/bg/funfact-bg2.png'

    export default {
    data() {
        return {
			experienceBg: ExperienceBg
        }
    }
    }
</script>