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
                        <h1>Online / Offline <br> Photo Selling Systems</h1>
                        <h3>to increase your business</h3>
                        <p>labore et dolore magna aliqua. Ut eniminim veniam, the exercitation ullamco laboris commodo.labore et dolore magna aliqua. Ut eniminim veniam.</p>

                        <div class="btn-video-play">
                            <a href="https://holipic.com/wp-content/uploads/2018/07/compress_2_1.mp4" class="popup-video">
                                <div class="btn-play">
                                    <figure>
                                        <img src="images/holipic-mardan-copy.jpg" alt="" />
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

    <!-- Version History Secton starts -->
    <section class="version-history-layout-1" id="benefits">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>Benefits</h2>
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
                                    <!-- <div class="version-slide" data-version="Launch" data-date="June, 2001"> -->
                                    <div class="version-slide" data-version="Manage">
                                        <div class="version-image">
                                            <img src="images/holipic.jpg" alt="" />
                                        </div>

                                        <div class="version-entry">
                                            <h3>Manage All Bussiness Activy</h3>
                                            <p>Holipic App is ideal for Bussiness that need to monitor and manage retail/shop real time operations.</p>

                                            <ul>
                                                <li>Check Quality of Photos & Selling</li>
                                                <li>Compare selling, daily, weekly, monthly or yearly</li>
                                                <li>See detailed finance reports</li>
                                                <li>Control easily your customer, feedbacks, requests etc.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Version slide end -->

                                <!-- Version slide start -->
                                <div class="swiper-slide">
                                    <div class="version-slide" data-version="Increase" data-date="June, 2002">
                                        <div class="version-image">
                                            <img src="images/version-image-1.png" alt="" />
                                        </div>

                                        <div class="version-entry">
                                            <h3>Increase Company Income</h3>
                                            <p>Holipic App is online software which is automates the process of accepting photo order for your bussiness. You can gain selling benefits from this software like:</p>

                                            <ul>
                                                <li>Continue to sale photos, even after customers back to home.</li>
                                                <li>Holipic App will send auto promo emails to increase your sales.</li>
                                                <li>Leave work to computers, make your staff busy in other important things.</li>
                                                <li>Accept orders much faster and reduce mistake caused by human factors.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Version slide end -->

                                <!-- Version slide start -->
                                <div class="swiper-slide">
                                    <div class="version-slide" data-version="Secure" data-date="June, 2003">
                                        <div class="version-image">
                                            <img src="images/version-image-1.png" alt="" />
                                        </div>

                                        <div class="version-entry">
                                            <h3>Secure your Company from Mistakes</h3>
                                            <p>The Holipic App are fully integrated to provide consumers with this type of a ecured experience for photo ordering and storage, regardless of channel or device.</p>

                                            <ul>
                                                <li>No more using CD/DVD</li>
                                                <li>Secure online payments</li>
                                                <li>By storing your data online you are reducing losing of your photos</li>
                                                <li>Private Page for your ever costumer</li>
                                                <li>Limited access for branches, full access for owners</li>
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
                                <a id="tab-B" href="#search" class="nav-link" data-toggle="tab" role="tab"><i class="flaticon-friend-request"></i> Setup System</a>
                            </li>
                            <li class="nav-item">
                                <a id="tab-C" href="#friend" class="nav-link" data-toggle="tab" role="tab"><i class="flaticon-joke"></i> Start Selling</a>
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
                                                    <img src="images/holipic.jpg" alt="" />
                                                </div>
                                            </div>

                                            <div class="col-md-7">
                                                <div class="how-it-content">
                                                    <h3>Register / Login</h3>

                                                    <p>We offer a secure Digital Goods eCommerce service or anyone to sell photos and pictures online easily.
                                                      <br>
                                                      Get started selling photos on Holipic App in just a few minutes using our simple links anywhere you like.</p>
                                                    <p>Follow Easy 3 Steps</p>
                                                    <ul>
                                                      <li>Select Package: Basic or Pro</li>
                                                      <li>Fill the Form: Register your Company</li>
                                                      <li>Login: Use passwords sent by email</li>
                                                    </ul>
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
                                            <i class="flaticon-friend-request"></i> Setup Selling
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
                                                    <h3>Setup Selling</h3>

                                                    <p>Holipic App makes it easy to manage multiple stores from the same account.</p>

                                                    <ul>
                                                      <li>Login to main dashboard</li>
                                                      <li>Setup your branches, team, packages and products</li>
                                                      <li>Deliver links and logins to the team</li>
                                                    </ul>
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
                                        <a class="collapsed" data-toggle="collapse" href="#collapse-C" data-parent="#content" aria-expanded="false" aria-controls="collapse-C"><i class="flaticon-joke"></i> Start Selling
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
                                                    <h3>Start Selling</h3>

                                                    <p>Holipic Shop App automates the photos order and even order fulfillment process. Leave monotonous work to computers, Your customers will be much happier with your quality service.</p>

                                                    <ul>
                                                      <li>Upload photos</li>
                                                      <li>Start selling in shop app</li>
                                                      <li>Offer to your customers rest of photos</li>
                                                    </ul>
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

    <section class="pricing-layout-1 section-pricing " id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>Pricing</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="pricing-title wow fadeInUp">
                        <h3>Pay As You Go</h3>
                        <p>The Holipic Online Selling systems is completely free to use and there is no charger until you make a sale. We'll only earn when you earn.</p>

                        <p>Your online sales are automatically loaded into ewallet which is is support your system fee not paying from your pocket, that means Holipic App can earn own payment by promoting and selling your photos.</p>
                        <p>Get started now by select suitable packages.</p>
                    </div>

                    <div class="pricing-tab">
                    </div>
                </div>

                <div class="col-lg-8">
                    <div id="clothing-nav-content" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="monthly" aria-labelledby="monthly-tab">
                            <div class="row">
                                <!-- Pricing single start -->
                                @if(!empty($packages))
                                @php
                                    $amounts = count($packages);
                                @endphp
                                @foreach( $packages as $value)

                                <div class="col-md-6 common-package-discount">
                                    <div class="pricing-box-wrapper common-pricing-box">
                                        <div class="pricing-box">
                                            <div class="pricing-header">
                                                <div class="icon-box">
                                                    <img src="/static/img/pricing-icon.png" alt="pricing icon" width="" height="" class="img-responsive">
                                                </div>
                                                <h3{{$value->package_name=="Basic" ? "" : " class=title-name"}}>{{$value->package_name}}</h3>
                                            </div>

                                            <div class="pricing-body">
                                                <ul>

                                                    <li>
                                                        {{$value->short_description}}
                                                    </li>
                                                    <li {{$value->package_name=="Basic" ? "class=title-basic" : " class=title-enterprise"}}>
                                                        {{$value->fee}}%
                                                    </li>
                                                    <li>{{$value->file_upload}} DAYS <b style="color:#8a8a8a;">Storage</b> </li>

                                                    <li>
                                                        {{$value->secure_storage}} <b style="color:#8a8a8a;">Space</b>
                                                    </li>

                                                    <li>
                                                        Auto <b style="color:#8a8a8a;">Email</b>
                                                    </li>

                                                    <li>
                                                      @if($value->package_name=="Basic")
                                                        Auto <b style="color:#8a8a8a;">SMS</b>
                                                      @else
                                                          Auto <b style="color:#8a8a8a;">SMS</b>
                                                      @endif
                                                    </li>

                                                    <li>{{$value->max_user}} <b style="color:#8a8a8a;">Branch</b>

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        @if($value->package_name=="Basic")

                                            <!-- <div class="btn-buynow"> -->
                                                <!-- <a data-package='1' class="select-package has-popup" href="/register" id="{{ $value->id }}">START TO BASIC</a> -->
                                                <!-- <a data-package='1' class="select-package has-popup" href="#login" id="{{ $value->id }}">GET STARTED</a>
                                            </div> -->
                                            <a style="color:#fff!important;" data-package='1' class="select-package has-popup" href="#login" id="{{ $value->id }}">
                                            <div class="btn-buynow">GET STARTED</div></a>
                                        @else
                                            <a style="color:#fff!important;" data-package='1' class="select-package has-popup" href="#login" id="{{ $value->id }}">
                                            <div class="btn-buynow btn-enterprise">GET STARTED</div></a>
                                        @endif
                                    </div>
                                </div>
                                <!-- Pricing single end -->
                                @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="popup-page mfp-with-anim mfp-hide" id="login">
  <div class="row">
    <div class="col-md-6">
      <div class="myaccount-form">
        <h3>Let's get started, <br />
        Sign Up just in minutes</h3>

        <form action="#" method="post">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-user"></span>
              </div>

              <input type="text" class="form-control" placeholder="Enter Your Full Name" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-building"></span>
              </div>

              <input type="text" class="form-control" placeholder="Enter Your Company Name" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-phone"></span>
              </div>

              <input type="tel" class="form-control" placeholder="Enter Your Phone Number" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-envelope"></span>
              </div>

              <input type="email" class="form-control" placeholder="Enter Your Email" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-lock"></span>
              </div>

              <input type="password" class="form-control" placeholder="Enter Your Password" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-suitcase"></span>
              </div>

              <select class="form-control" name="package_id" required>
                @foreach($packages as $value)
                <option value="{{$value->id}}">{{$value->package_name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-dollar"></span>
              </div>

              <select class="form-control" name="package_id" required>
                <option value="1">Dollar</option>
                <option value="2">Rupiah</option>
              </select>
            </div>
          </div>

          <div class="account-row">
            <!-- <div class="account-left"> -->
              <label class="account-checkbox">
                <input type="checkbox">
                <span class="checkmark"></span>
                <b>I read and agree to Terms & Conditions</b>
              </label>
            <!-- </div> -->
          </div>

          <div class="form-group">
            <input type="submit" value="Sign Up" class="btn-submit" />
            <span style="font-size: .8rem!important;">have an account? <a href="http://127.0.0.1:8000/login">Sign In</a></span>
            <!-- <a href="#signup" class="btn-submit has-popup">Sign Up</a> -->
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-6">
      <div class="myaccount-image-note">
        <figure>
          <img src="images/logo-large.png" alt="" />
        </figure>

        <p>Start fully manage your customer, incomes, staff and Improving sales by registration your company.</p>
      </div>
    </div>
  </div>
</div>
<!-- End login popup -->
@endsection
