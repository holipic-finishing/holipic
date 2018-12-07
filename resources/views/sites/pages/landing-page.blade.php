@extends('sites.layouts.layout')

@section('title')
	Holipic
@endsection

@section('content')
	<!-- Banner Section Starts -->
	<section class="banner-layout-1" id="homepage">
		<div class="container">
			<div class="row">
				<div class="col-lg-5">
					<!-- Header content start -->
					<div class="header-content wow fadeInUp">
						<h2>Just another #1 Mobile app landing page template</h2>
						<p>labore et dolore magna aliqua. Ut eniminim veniam, the exercitation ullamco laboris commodo.labore et dolore magna aliqua. Ut eniminim veniam.</p>
						
						<div class="btn-video-play">
							<a href="http://www.youtube.com/watch?v=K4wEI5zhHB0" class="popup-video">
								<div class="btn-play">
									<figure>
										<img src="images/video-bg.jpg" alt="" />
									</figure>
									
									<i class="flaticon-play-button"></i>
								</div>
								
								<span>Watch the intro video</span>
							</a>
						</div>
					</div>
					<!-- Header content end -->
				</div>
				
				<div class="col-lg-7">
					<div class="header-img wow fadeInRight">
						<img src="images/header.png" alt="" />
					</div>
				</div>
			</div>
		</div>	
	</section>
	<!-- Banner Section Ends -->


	<!-- Service box starts -->
	<div class="service-layout-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<!-- service single box start -->
					<div class="service-single wow fadeInUp" data-wow-delay="0.2s">
						<div class="icon-box">
							<i class="flaticon-social-network"></i>
						</div>
						
						<h3>Exclusive Design</h3>
						<a href="#" class="btn-seemore">See More</a>
					</div>
					<!-- service single box end -->
				</div>
				
				<div class="col-lg-3 col-md-6">
					<!-- service single box start -->
					<div class="service-single wow fadeInUp" data-wow-delay="0.4s">
						<div class="icon-box">
							<i class="flaticon-settings"></i>
						</div>
						
						<h3>Easy to Customize</h3>
						<a href="#" class="btn-seemore">See More</a>
					</div>
					<!-- service single box end -->
				</div>
				
				<div class="col-lg-3 col-md-6">
					<!-- service single box start -->
					<div class="service-single wow fadeInUp" data-wow-delay="0.6s">
						<div class="icon-box">
							<i class="flaticon--01-thinking"></i>
						</div>
						
						<h3>Creative Design</h3>
						<a href="#" class="btn-seemore">See More</a>
					</div>
					<!-- service single box end -->
				</div>
				
				<div class="col-lg-3 col-md-6">
					<!-- service single box start -->
					<div class="service-single wow fadeInUp" data-wow-delay="0.8s">
						<div class="icon-box">
							<i class="flaticon-technology"></i>
						</div>
						
						<h3>Quick Support</h3>
						<a href="#" class="btn-seemore">See More</a>
					</div>
					<!-- service single box end -->
				</div>
			</div>
		</div>
	</div>
	<!-- Service box ends -->

	<!-- welcome quotes section starts -->
	<div class="welcome-layout-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="welcome-box">
						<h2>Welcome to app landing</h2>
						<p>We're on a mission to build #1 landing page template for mobile app showcase & promotions.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- welcome quotes section ends -->

	<!-- How it work section starts -->
	<section class="how-it-work-layout-1" id="howitwork">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2>How it works</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<!-- How it work tab starts -->
					<div class="how-it-work-tab">
						<!-- How it work tab navigation start -->
						<ul id="tabs" class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a id="tab-A" href="#register" class="nav-link active" data-toggle="tab" role="tab"><i class="flaticon-login"></i> Register / Login</a>
							</li>
							<li class="nav-item">
								<a id="tab-B" href="#search" class="nav-link" data-toggle="tab" role="tab"><i class="flaticon-friend-request"></i> Search & Find Friends</a>
							</li>
							<li class="nav-item">
								<a id="tab-C" href="#friend" class="nav-link" data-toggle="tab" role="tab"><i class="flaticon-joke"></i> Become Friend</a>
							</li>
						</ul>
						<!-- How it work tab navigation end -->

						<!-- How it work tab content start -->
						<div id="content" class="tab-content" role="tablist">
							<!-- Tab Content start -->
							<div id="register" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
								<div class="card-header" role="tab" id="heading-A">
									<h5 class="mb-0">
									  <a data-toggle="collapse" href="#collapse-A" data-parent="#content" aria-expanded="true" aria-controls="collapse-A">
										<i class="flaticon-login"></i> Register / Login
									  </a>
									</h5>
								</div>
								
								<div id="collapse-A" class="collapse show" role="tabpanel" aria-labelledby="heading-A">
									<div class="card-body">
										<div class="row">
											<div class="col-md-5">
												<div class="how-it-image">
													<img src="images/howit.jpg" alt="" />
												</div>
											</div>
											
											<div class="col-md-7">
												<div class="how-it-content">
													<h3>Register / Login</h3>
													
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
													
													<p>Text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets and Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Tab Content end -->

							<!-- Tab Content start -->
							<div id="search" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
								<div class="card-header" role="tab" id="heading-B">
									<h5 class="mb-0">
									  <a class="collapsed" data-toggle="collapse" href="#collapse-B" data-parent="#content" aria-expanded="false" aria-controls="collapse-B">
										<i class="flaticon-friend-request"></i> Search & Find Friends
									  </a>
									</h5>
								</div>
								
								<div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
									<div class="card-body">
										<div class="row">
											<div class="col-md-5">
												<div class="how-it-image">
													<img src="images/howit.jpg" alt="" />
												</div>
											</div>
											
											<div class="col-md-7">
												<div class="how-it-content">
													<h3>Search & Find Friends</h3>
													
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
													
													<p>Text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets and Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Tab Content end -->

							<!-- Tab Content start -->
							<div id="friend" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
								<div class="card-header" role="tab" id="heading-C">
									<h5 class="mb-0">
									  <a class="collapsed" data-toggle="collapse" href="#collapse-C" data-parent="#content" aria-expanded="false" aria-controls="collapse-C"><i class="flaticon-joke"></i> Become Friend
									  </a>
									</h5>
								</div>
								<div id="collapse-C" class="collapse" role="tabpanel" aria-labelledby="heading-C">
									<div class="card-body">
										<div class="row">
											<div class="col-md-5">
												<div class="how-it-image">
													<img src="images/howit.jpg" alt="" />
												</div>
											</div>
											
											<div class="col-md-7">
												<div class="how-it-content">
													<h3>Become Friend</h3>
													
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
													
													<p>Text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets and Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Tab Content end -->
						</div>
						<!-- How it work tab content end -->
					</div>
					<!-- How it work tab ends -->
				</div>
			</div>
		</div>
	</section>
	<!-- How it work section ends -->


	<!-- Features section starts -->
	<section class="features-layout-1">
		<div class="container">
			<div class="row">
				<div class="col-md-6 offset-md-1">
					<!-- Features content start -->
					<div class="feature-content">
						<h2>Everything get easier here</h2>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
						
						<a href="#" class="btn-custom">Know More</a>
					</div>
					<!-- Features content end -->
				</div>
				
				<div class="col-md-4">
					<!-- Features Image start -->
					<div class="feature-image wow fadeInRight">
						<img src="images/feature.png" alt="" />
					</div>
					<!-- Features Image end -->
				</div>
			</div>
		</div>
	</section>
	<!-- Features section ends -->

	<section class="pricing-layout-1" id="pricing">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2>Try few weeks for free</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-4">
					<div class="pricing-title wow fadeInUp">
						<h3>Great p rice plan for you!</h3>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
						
						<p>Took a galley of type and scrambled it to make a type specimen book.</p>
					</div>
					
					<div class="pricing-tab">
						<ul id="clothing-nav" class="nav nav-tabs" role="tablist">
							<li class="nav-item"><a class="nav-link active" href="#monthly" id="monthly-tab" role="tab" data-toggle="tab" aria-controls="monthly" aria-expanded="true">Monthly</a></li>
							<li class="nav-item"><a class="nav-link" href="#yearly" role="tab" id="yearly-tab" data-toggle="tab" aria-controls="yearly">Yearly</a></li>
						</ul>
					</div>
				</div>
				
				<div class="col-lg-8">
					<div id="clothing-nav-content" class="tab-content">
						<div role="tabpanel" class="tab-pane fade show active" id="monthly" aria-labelledby="monthly-tab">
							<div class="row">
								<!-- Pricing single start -->
								<div class="col-md-6">
									<div class="pricing-box-wrapper">
										<div class="pricing-box">
											<div class="pricing-header">
												<div class="icon-box">
													<i class="flaticon-sun"></i>
												</div>
												
												<h3>Startup</h3>
											</div>
											
											<div class="pricing-body">
												<ul>
													<li>Unlimited bug reports</li>
													<li>1 year data storage</li>
													<li>All Integrations</li>
													<li>Screenshot Attechment</li>
													<li>Custom Bug Reports</li>
													<li>5 Team Member</li>
												</ul>
												
												<h4>Free Forever</h4>
											</div>
										</div>
										
										<div class="btn-buynow">
											<a href="#">Buy Now</a>
										</div>
									</div>
								</div>
								<!-- Pricing single end -->
								
								<!-- Pricing single start -->
								<div class="col-md-6">
									<div class="pricing-box-wrapper">
										<div class="pricing-box">
											<div class="pricing-header">
												<div class="icon-box">
													<i class="flaticon-cityscape"></i>
												</div>
												
												<h3>Enterprise</h3>
											</div>
											
											<div class="pricing-body">
												<ul>
													<li>Unlimited bug reports</li>
													<li>1 year data storage</li>
													<li>All Integrations</li>
													<li>Screenshot Attechment</li>
													<li>Custom Bug Reports</li>
													<li>5 Team Member</li>
												</ul>
												
												<h4>$100 / Per Month</h4>
											</div>
										</div>
										
										<div class="btn-buynow">
											<a href="#">Buy Now</a>
										</div>
									</div>
								</div>
								<!-- Pricing single end -->
							</div>
						</div>

						<div role="tabpanel" class="tab-pane fade" id="yearly" aria-labelledby="yearly-tab">
							<div class="row">
								<!-- Pricing single start -->
								<div class="col-md-6">
									<div class="pricing-box-wrapper">
										<div class="pricing-box pricing-orange">
											<div class="pricing-header">
												<div class="icon-box">
													<i class="flaticon-sun"></i>
												</div>
												
												<h3>Startup 1</h3>
											</div>
											
											<div class="pricing-body">
												<ul>
													<li>Unlimited bug reports</li>
													<li>1 year data storage</li>
													<li>All Integrations</li>
													<li>Screenshot Attechment</li>
													<li>Custom Bug Reports</li>
													<li>5 Team Member</li>
												</ul>
												
												<h4>Free Forever</h4>
											</div>
										</div>
										
										<div class="btn-buynow">
											<a href="#">Buy Now</a>
										</div>
									</div>
								</div>
								<!-- Pricing single end -->
								
								<!-- Pricing single start -->
								<div class="col-md-6">
									<div class="pricing-box-wrapper">
										<div class="pricing-box pricing-green">
											<div class="pricing-header">
												<div class="icon-box">
													<i class="flaticon-cityscape"></i>
												</div>
												
												<h3>Enterprise 1</h3>
											</div>
											
											<div class="pricing-body">
												<ul>
													<li>Unlimited bug reports</li>
													<li>1 year data storage</li>
													<li>All Integrations</li>
													<li>Screenshot Attechment</li>
													<li>Custom Bug Reports</li>
													<li>5 Team Member</li>
												</ul>
												
												<h4>$100 / Per Month</h4>
											</div>
										</div>
										
										<div class="btn-buynow">
											<a href="#">Buy Now</a>
										</div>
									</div>
								</div>
								<!-- Pricing single end -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Pricing section ends -->

	<!-- Testimonial section starts -->
	<section class="testimonial-layout-1" id="testimonial">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2>Testimonial</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<!-- Testimonial slider starts -->
					<div class="testimonial-slider-wrapper wow fadeInUp">
						<div class="swiper-container testimonial-slider">
							<div class="swiper-wrapper">
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-1.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
								
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-2.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
								
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-3.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
								
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-4.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
								
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-1.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
								
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-2.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
								
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-3.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
								
								<!-- Testimonial slide start -->
								<div class="swiper-slide">
									<div class="testimonial-slide">
										<figure>
											<img src="images/author-4.jpg" alt="" />
										</figure>
										
										<div class="testimonial-entry">
											<p>Lorem Ipsum is simply dummy text of the printing and type setting industry</p>
										</div>
									</div>
								</div>
								<!-- Testimonial slide end -->
							</div>
						</div>
						
						<!-- Testimonial Pagination start -->
						<div class="testimonial-pagination">
							<div class="testimonial-prev"><i class="flaticon-left-arrow"></i></div>
							<div class="testimonial-next"><i class="flaticon-right-arrow"></i></div>
						</div>
						<!-- Testimonial Pagination end -->
					</div>
					<!-- Testimonial slider ends -->
				</div>
			</div>
		</div>
	</section>
	<!-- Testimonial section ends -->

	<!-- FAQ Section starts -->
	<section class="faq-layout-1" id="faq">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2>Frequently asked questions</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<!-- FAQ Tab starts -->
					<div class="faq-tabs">
						<!-- FAQ Tab navigation start -->
						<ul class="nav nav-tabs responsive" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="flaticon-power"></i> Getting Started</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="flaticon-signs"></i> Sales Questions</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><i class="flaticon-float"></i> Quality Support</a>
							</li>
						</ul>
						<!-- FAQ Tab navigation end -->
						
						<!-- FAQ Tab Content start -->
						<div class="tab-content responsive" id="myTabContent">
							<!-- Single Tab content start -->
							<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
								<div id="accordion1" class="faq-accordion">
									<div class="card active">
										<div class="card-header" id="headingOne">
											<h5 class="mb-0">
											<a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Which devices does it supported?</a>
											</h5>
										</div>

										<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion1">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingTwo">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">How do i know if i have the latest versions of the app?</a>
											</h5>
										</div>
										
										<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion1">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingThree">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">What if payment failed while purchasing any chipas on app?</a>
											</h5>
										</div>
										
										<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion1">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingFour">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">How's your reward point system work?</a>
											</h5>
										</div>
										
										<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion1">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingFive">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Is the free version is avilable for lifetime?</a>
											</h5>
										</div>
										
										<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion1">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Single Tab content end -->
							
							<!-- Single Tab content start -->
							<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
								<div id="accordion2" class="faq-accordion">
									<div class="card active">
										<div class="card-header" id="headingSix">
											<h5 class="mb-0">
											<a data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseOne">Which devices does it supported?</a>
											</h5>
										</div>

										<div id="collapseSix" class="collapse show" aria-labelledby="headingSix" data-parent="#accordion2">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingSeven">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseTwo">How do i know if i have the latest versions of the app?</a>
											</h5>
										</div>
										
										<div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion2">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingEight">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">What if payment failed while purchasing any chipas on app?</a>
											</h5>
										</div>
										
										<div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion2">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingNine">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">How's your reward point system work?</a>
											</h5>
										</div>
										
										<div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion2">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingTen">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">Is the free version is avilable for lifetime?</a>
											</h5>
										</div>
										
										<div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordion2">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Single Tab content end -->
							
							<!-- Single Tab content start -->
							<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
								<div id="accordion3" class="faq-accordion">
									<div class="card active">
										<div class="card-header" id="headingSix1">
											<h5 class="mb-0">
											<a data-toggle="collapse" data-target="#collapseSix1" aria-expanded="true" aria-controls="collapseOne">Which devices does it supported?</a>
											</h5>
										</div>

										<div id="collapseSix1" class="collapse show" aria-labelledby="headingSix1" data-parent="#accordion3">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingSeven1">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseSeven1" aria-expanded="false" aria-controls="collapseSeven1">How do i know if i have the latest versions of the app?</a>
											</h5>
										</div>
										
										<div id="collapseSeven1" class="collapse" aria-labelledby="headingSeven1" data-parent="#accordion3">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingEight1">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseEight1" aria-expanded="false" aria-controls="collapseEight1">What if payment failed while purchasing any chipas on app?</a>
											</h5>
										</div>
										
										<div id="collapseEight1" class="collapse" aria-labelledby="headingEight1" data-parent="#accordion3">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingNine1">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseNine1" aria-expanded="false" aria-controls="collapseNine1">How's your reward point system work?</a>
											</h5>
										</div>
										
										<div id="collapseNine1" class="collapse" aria-labelledby="headingNine1" data-parent="#accordion3">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="headingTen1">
											<h5 class="mb-0">
												<a class="collapsed" data-toggle="collapse" data-target="#collapseTen1" aria-expanded="false" aria-controls="collapseTen1">Is the free version is avilable for lifetime?</a>
											</h5>
										</div>
										
										<div id="collapseTen1" class="collapse" aria-labelledby="headingTen1" data-parent="#accordion3">
											<div class="card-body">
												<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Single Tab content end -->
						</div>
						<!-- FAQ Tab Content end -->
					</div>
					<!-- FAQ Tab ends -->
				</div>
			</div>
		</div>
	</section>
	<!-- FAQ Section ends -->

	<!-- Version History Secton starts -->
	<section class="version-history-layout-1">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2>Version Hisotry</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<!-- Version Hisotry slider start -->
					<div class="version-history-slider wow fadeInUp">
						<div class="swiper-container history-version-slider">
							<div class="swiper-wrapper">
								<!-- Version slide start -->
								<div class="swiper-slide">
									<div class="version-slide" data-version="Launch" data-date="June, 2001">
										<div class="version-image">
											<img src="images/version-image-1.png" alt="" />
										</div>
								
										<div class="version-entry">
											<h3>Group chat & Profile setting</h3>
											<p>Before you arrive, check in from the train, plane, or road. As you depart, leave your key and hit the road. Before you arrive, check in from the train, plane, or road. As you depart.</p>
											
											<ul>
												<li>Easy to Use</li>
												<li>Easy to Use</li>
												<li>Account Activity</li>
												<li>Account Activity</li>
												<li>Friendly Support</li>
												<li>Friendly Support</li>
												<li>Great Security</li>
												<li>Great Security</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Version slide end -->
								
								<!-- Version slide start -->
								<div class="swiper-slide">
									<div class="version-slide" data-version="Version 1.1" data-date="June, 2002">
										<div class="version-image">
											<img src="images/version-image-1.png" alt="" />
										</div>
								
										<div class="version-entry">
											<h3>Group chat & Profile setting</h3>
											<p>Before you arrive, check in from the train, plane, or road. As you depart, leave your key and hit the road. Before you arrive, check in from the train, plane, or road. As you depart.</p>
											
											<ul>
												<li>Easy to Use</li>
												<li>Easy to Use</li>
												<li>Account Activity</li>
												<li>Account Activity</li>
												<li>Friendly Support</li>
												<li>Friendly Support</li>
												<li>Great Security</li>
												<li>Great Security</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Version slide end -->
								
								<!-- Version slide start -->
								<div class="swiper-slide">
									<div class="version-slide" data-version="Version 1.2" data-date="June, 2003">
										<div class="version-image">
											<img src="images/version-image-1.png" alt="" />
										</div>
								
										<div class="version-entry">
											<h3>Group chat & Profile setting</h3>
											<p>Before you arrive, check in from the train, plane, or road. As you depart, leave your key and hit the road. Before you arrive, check in from the train, plane, or road. As you depart.</p>
											
											<ul>
												<li>Easy to Use</li>
												<li>Easy to Use</li>
												<li>Account Activity</li>
												<li>Account Activity</li>
												<li>Friendly Support</li>
												<li>Friendly Support</li>
												<li>Great Security</li>
												<li>Great Security</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Version slide end -->
								
								<!-- Version slide start -->
								<div class="swiper-slide">
									<div class="version-slide" data-version="Version 1.3" data-date="June, 2004">
										<div class="version-image">
											<img src="images/version-image-1.png" alt="" />
										</div>
								
										<div class="version-entry">
											<h3>Group chat & Profile setting</h3>
											<p>Before you arrive, check in from the train, plane, or road. As you depart, leave your key and hit the road. Before you arrive, check in from the train, plane, or road. As you depart.</p>
											
											<ul>
												<li>Easy to Use</li>
												<li>Easy to Use</li>
												<li>Account Activity</li>
												<li>Account Activity</li>
												<li>Friendly Support</li>
												<li>Friendly Support</li>
												<li>Great Security</li>
												<li>Great Security</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Version slide end -->
								
								<!-- Version slide start -->
								<div class="swiper-slide">
									<div class="version-slide"  data-version="Version 1.4" data-date="June, 2005">
										<div class="version-image">
											<img src="images/version-image-1.png" alt="" />
										</div>
								
										<div class="version-entry">
											<h3>Group chat & Profile setting</h3>
											<p>Before you arrive, check in from the train, plane, or road. As you depart, leave your key and hit the road. Before you arrive, check in from the train, plane, or road. As you depart.</p>
											
											<ul>
												<li>Easy to Use</li>
												<li>Easy to Use</li>
												<li>Account Activity</li>
												<li>Account Activity</li>
												<li>Friendly Support</li>
												<li>Friendly Support</li>
												<li>Great Security</li>
												<li>Great Security</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Version slide end -->
								
								<!-- Version slide start -->
								<div class="swiper-slide">
									<div class="version-slide"  data-version="Version 1.5" data-date="June, 2006">
										<div class="version-image">
											<img src="images/version-image-1.png" alt="" />
										</div>
								
										<div class="version-entry">
											<h3>Group chat & Profile setting</h3>
											<p>Before you arrive, check in from the train, plane, or road. As you depart, leave your key and hit the road. Before you arrive, check in from the train, plane, or road. As you depart.</p>
											
											<ul>
												<li>Easy to Use</li>
												<li>Easy to Use</li>
												<li>Account Activity</li>
												<li>Account Activity</li>
												<li>Friendly Support</li>
												<li>Friendly Support</li>
												<li>Great Security</li>
												<li>Great Security</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Version slide end -->
								
								<!-- Version slide start -->
								<div class="swiper-slide">
									<div class="version-slide"  data-version="Version 1.6" data-date="June, 2001">
										<div class="version-image">
											<img src="images/version-image-1.png" alt="" />
										</div>
								
										<div class="version-entry">
											<h3>Group chat & Profile setting</h3>
											<p>Before you arrive, check in from the train, plane, or road. As you depart, leave your key and hit the road. Before you arrive, check in from the train, plane, or road. As you depart.</p>
											
											<ul>
												<li>Easy to Use</li>
												<li>Easy to Use</li>
												<li>Account Activity</li>
												<li>Account Activity</li>
												<li>Friendly Support</li>
												<li>Friendly Support</li>
												<li>Great Security</li>
												<li>Great Security</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Version slide end -->
							</div>
						</div>
						
						<div class="version-history"></div>
						
						<!-- Timeline slider pagination start -->
						<div class="version-navigation">
							<div class="version-prev"><i class="flaticon-left-arrow"></i></div>
							<div class="version-next"><i class="flaticon-right-arrow"></i></div>
						</div>
						<!-- Timeline slider pagination end -->
					</div>
					<!-- Version Hisotry slider end -->
				</div>
			</div>
		</div>
	</section>
	<!-- Version History Secton ends -->


	<!-- Screenshot section starts -->
	<section class="screenshot-layout-1" id="design">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2>Design Screenshot</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<!-- Screenshot slider starts -->
					<div class="screenshot-slider-wrapper">
						<div class="swiper-container screenshot-slider">
							<div class="swiper-wrapper">
								<!-- Screenshot slide start -->
								<div class="swiper-slide">
									<div class="screenshot-slide">
										<img src="images/screenshot-1.jpg" alt="" />
									</div>
								</div>
								<!-- Screenshot slide end -->
								
								<!-- Screenshot slide start -->
								<div class="swiper-slide">
									<div class="screenshot-slide">
										<img src="images/screenshot-2.jpg" alt="" />
									</div>
								</div>
								<!-- Screenshot slide end -->
								
								<!-- Screenshot slide start -->
								<div class="swiper-slide">
									<div class="screenshot-slide">
										<img src="images/screenshot-3.jpg" alt="" />
									</div>
								</div>
								<!-- Screenshot slide end -->
								
								<!-- Screenshot slide start -->
								<div class="swiper-slide">
									<div class="screenshot-slide">
										<img src="images/screenshot-4.jpg" alt="" />
									</div>
								</div>
								<!-- Screenshot slide end -->
								
								<!-- Screenshot slide start -->
								<div class="swiper-slide">
									<div class="screenshot-slide">
										<img src="images/screenshot-1.jpg" alt="" />
									</div>
								</div>
								<!-- Screenshot slide end -->
								
								<!-- Screenshot slide start -->
								<div class="swiper-slide">
									<div class="screenshot-slide">
										<img src="images/screenshot-2.jpg" alt="" />
									</div>
								</div>
								<!-- Screenshot slide end -->
							</div>
						</div>
						
						<!-- Screenshot Pagination start -->
						<div class="screenshot-pagination">
							<div class="screenshot-prev"><i class="flaticon-left-arrow"></i></div>
							<div class="screenshot-next"><i class="flaticon-right-arrow"></i></div>
						</div>
						<!-- Screenshot Pagination end -->
					</div>
					<!-- Screenshot slider ends -->
				</div>
			</div>
		</div>
	</section>
	<!-- Screenshot section ends -->

	<!-- Download app section starts -->
	<section class="download-app-layout-1" id="download">
		<div class="container">
			<div class="row">
				<div class="col-lg-5">
					<div class="download-entry wow fadeInUp">
						<h2>Everthing on the go in your pocket</h2>
						<p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>
						
						<div class="app-download">
							<a href="#" class="btn-download btn-apple"><i class="fa fa-apple"></i> <span>Download on the</span>App Store</a>
							<a href="#" class="btn-download btn-android"><i class="fa fa-android"></i> <span>Get in on</span>Google Play</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Download app section ends -->

	<!-- Login popup -->
	<div class="popup-page mfp-with-anim mfp-hide" id="login">
		<div class="row">
			<div class="col-md-6">
				<div class="myaccount-form">
					<h3>Welcome back, <br />
					Please sign in to your account</h3>
					<div id="message-form-login" style="color:#05cbfc">
						
					</div>
					<form method="post" id="form-signin">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="fa fa-user"></span>
								</div>
								
								<input type="text" class="form-control" placeholder="Enter Your User Name" name=
								"email" >
							</div>
						</div>
						
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="fa fa-lock"></span>
								</div>
								
								<input type="password" class="form-control" placeholder="Enter Your Password" name="password" > 
							</div>
						</div>
						
						<div class="account-row">
							<div class="account-left">
								<label class="account-checkbox">
									<input type="checkbox">
									<span class="checkmark"></span>
									<b>Remember Me</b>
								</label>
							</div>
							
							<div class="account-right text-right">
								<a href="#" class="forget-password">Forget Password?</a>
							</div>
						</div>
						
						<div class="form-group">
							<button type="submit" class="btn-submit">Login</button>
							<a href="#signup" class="btn-submit has-popup">Sign Up</a>
							{{-- <input type="submit" value="Login" class="btn-submit" /> --}}
						</div>
					</form>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="myaccount-image-note">
					<figure>
						<img src="images/logo-large.png" alt="" />
					</figure>
					
					<p>Lorem Ipsum is simply dummy text of the printing and this typesetting industry. Lorem Ipsum has been the.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- End login popup -->
	
	<!-- SignUp popup -->
	<div class="popup-page mfp-with-anim mfp-hide" id="signup">
		<div class="row">
			<div class="col-md-6">
				<div class="myaccount-form">
					<h3>Let's get started,<br />
					Sign Up just in minute</h3>
				
					<form action="#" method="post">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="fa fa-user"></span>
								</div>
								
								<input type="text" class="form-control" placeholder="Enter Your User Name">
							</div>
						</div>
						
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="fa fa-envelope"></span>
								</div>
								
								<input type="text" class="form-control" placeholder="Enter Your Email">
							</div>
						</div>
						
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="fa fa-lock"></span>
								</div>
								
								<input type="password" class="form-control" placeholder="Enter Your Password">
							</div>
						</div>
						
						<div class="single-row">
							<label class="account-checkbox">
								<input type="checkbox">
								<span class="checkmark"></span>
								<b>I read and agree to <a href="#">Terms & Conditions</a></b>
							</label>
						</div>
						
						<div class="form-group">
							<input type="submit" value="Sign Up" class="btn-submit" />
							<p class="other-text">have an account? <a href="#login" class="has-popup">Sign in</a></p>
						</div>
						
					</form>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="myaccount-image-note">
					<figure>
						<img src="images/logo-large.png" alt="" />
					</figure>
					
					<p>Lorem Ipsum is simply dummy text of the printing and this typesetting industry. Lorem Ipsum has been the.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- End signup popup -->

@endsection
@section('scripts')
<script>
	$(document).ready(function() {
		$("#form-signin").submit(function(e) {
			e.preventDefault();	
	    	var form = $(this);
	    //var url = form.attr('action');
	    $.ajax({
	           type: "POST",
	           url: 'landing-page/login',
	           data: form.serialize(), 
	           success: function(data)
	           {
	           	if(data && data.success == false) {
	           		$('#message-form-login').empty();
	           		$("#message-form-login").append(
	           			"<span class='label label-important'><i class='fa fa-close'></i>"+" "+data.message+"</span>");
	           	} else {
	           		// console.log(data.data.user.access_token)
	           		localStorage.setItem('access_token', data.data.user.access_token)
	           		localStorage.setItem('currentUser', JSON.stringify(data.data.user))
	           		console.log(localStorage.access_token)
	           		window.location.href = "/";
	           	}
	           	
	           	
	           },
	            error: function(error) {
			        // console.log(error.responseJSON.errors);

			        if(error.responseJSON.errors.email && error.responseJSON.errors.password) {
			        	$('#message-form-login').empty();
	           			$("#message-form-login").append(
	           			"<span class='label label-important'><i class='fa fa-close'></i>"+" "+'Please enter your email and password '+"</span>");
			        }

			        if(error.responseJSON.errors.email) {
			        	var errorMessage = error.responseJSON.errors.email[0]
			        } else {
			        	var errorMessage = error.responseJSON.errors.password[0]
			        }

			        $('#message-form-login').empty();
	           		$("#message-form-login").append(
	           			"<span class='label label-important'><i class='fa fa-close'></i>"+" "+errorMessage+"</span>");
			        console.log(error); 

			    }   
	         });

	     // avoid to execute the actual submit of the form.
		});
	});
</script>

@endsection