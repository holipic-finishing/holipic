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
                        <h1>{{ __('header1-1') }} <br> {{ __('header1-2') }}</h1>
                        <h3>{{ __('subheader1-1') }}</h3>
                        <p>{{ __('subheader1-2') }}</p>

                        <div class="btn-video-play">
                            <a href="https://holipic.com/wp-content/uploads/2018/07/compress_2_1.mp4" class="popup-video">
                                <div class="btn-play">
                                    <figure>
                                        <img src="../images/holipic-mardan-copy.jpg" alt="" />
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
                        <img src="../images/header.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section Ends -->
    <section class="version-history-layout-1" id="benefits">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="section-title">
                      <h2>{{ __('benefit') }}</h2>
                  </div>
              </div>
          </div>
          <div class="row d-none d-sm-none d-md-block">
            <div class="col-12">
              <div class="card-deck">
                <div class="card wow fadeInLeft">
                  <div class="row">
                    <div class="col-4">
                      <span class="fa-stack fa-besar text-center">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-television fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="col-8 position-relative">
                      <div class="center-text">
                        <h3>{{ __('manage') }}</h3>
                        <h6>{{ __('manage-title') }}</h6>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="card-body">
                    <p class="card-text">{{ __('manage-subtitle') }}</p>
                    <p class="card-text">
                      <ul>
                          <li>{{ __('manage-li-1') }}</li>
                          <li>{{ __('manage-li-2') }}</li>
                          <li>{{ __('manage-li-3') }}</li>
                          <li>{{ __('manage-li-4') }}</li>
                      </ul>
                    </p>
                  </div>
                </div>
                <div class="card wow fadeInUp">
                  <div class="row">
                    <div class="col-4">
                      <span class="fa-stack fa-besar text-center">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-line-chart fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="col-8 position-relative">
                      <div class="center-text">
                        <h3>{{ __('increase') }}</h3>
                        <h6>{{ __('increase-title') }}</h6>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="card-body">
                    <p class="card-text">{{ __('increase-subtitle') }}</p>
                    <p class="card-text">
                      <ul>
                          <li>{{ __('increase-li-1') }}</li>
                          <li>{{ __('increase-li-2') }}</li>
                          <li>{{ __('increase-li-3') }}</li>
                          <li>{{ __('increase-li-4') }}</li>
                      </ul>
                    </p>
                  </div>
                </div>
                <div class="card wow fadeInRight">
                  <div class="row">
                    <div class="col-4">
                      <span class="fa-stack fa-besar text-center">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-shield fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="col-8 position-relative">
                      <div class="center-text">
                        <h3>{{ __('secure') }}</h3>
                        <h6>{{ __('secure-title') }}</h6>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="card-body">
                    <p class="card-text">{{ __('secure-subtitle') }}</p>
                    <p class="card-text">
                      <ul>
                          <li>{{ __('secure-li-1') }}</li>
                          <li>{{ __('secure-li-2') }}</li>
                          <li>{{ __('secure-li-3') }}</li>
                          <li>{{ __('secure-li-4') }}</li>
                      </ul>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="carouselExampleIndicators" class="d-block d-sm-block d-md-none carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner card-deck">
              <div class="carousel-item active">
                <div class="card wow fadeInLeft">
                  <div class="row">
                    <div class="col-4">
                      <span class="fa-stack fa-besar text-center">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-television fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="col-8 position-relative">
                      <div class="center-text">
                        <h3>{{ __('manage') }}</h3>
                        <h6>{{ __('manage-title') }}</h6>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="card-body">
                    <p class="card-text">{{ __('manage-subtitle') }}</p>
                    <p class="card-text">
                      <ul>
                          <li>{{ __('manage-li-1') }}</li>
                          <li>{{ __('manage-li-2') }}</li>
                          <li>{{ __('manage-li-3') }}</li>
                          <li>{{ __('manage-li-4') }}</li>
                      </ul>
                    </p>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="card wow fadeInUp">
                  <div class="row">
                    <div class="col-4">
                      <span class="fa-stack fa-besar text-center">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-line-chart fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="col-8 position-relative">
                      <div class="center-text">
                        <h3>{{ __('increase') }}</h3>
                        <h6>{{ __('increase-title') }}</h6>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="card-body">
                    <p class="card-text">{{ __('increase-subtitle') }}</p>
                    <p class="card-text">
                      <ul>
                          <li>{{ __('increase-li-1') }}</li>
                          <li>{{ __('increase-li-2') }}</li>
                          <li>{{ __('increase-li-3') }}</li>
                          <li>{{ __('increase-li-4') }}</li>
                      </ul>
                    </p>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="card wow fadeInRight">
                  <div class="row">
                    <div class="col-4">
                      <span class="fa-stack fa-besar text-center">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-shield fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="col-8 position-relative">
                      <div class="center-text">
                        <h3>{{ __('secure') }}</h3>
                        <h6>{{ __('secure-title') }}</h6>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="card-body">
                    <p class="card-text">{{ __('secure-subtitle') }}</p>
                    <p class="card-text">
                      <ul>
                          <li>{{ __('secure-li-1') }}</li>
                          <li>{{ __('secure-li-2') }}</li>
                          <li>{{ __('secure-li-3') }}</li>
                          <li>{{ __('secure-li-4') }}</li>
                      </ul>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

    <section class="how-it-work-layout-1" id="howitwork">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                  <div class="section-title">
                    <h2>{{ __('itworks') }}</h2>
                  </div>
                </div>
            </div>

            <div class="row dashed pt-3">
              <div class="col-md-10 wow fadeInLeft">
                <div class="how-it-content">
                    <h3>{{ __('register') }}</h3>
                    <p>{{ __('register-subtitle-1') }} {{ __('register-subtitle-2') }}</p>
                    <ul>
                      <li>{{ __('register-li-1') }}</li>
                      <li>{{ __('register-li-2') }}</li>
                      <li>{{ __('register-li-3') }}</li>
                    </ul>
                </div>
              </div>
              <div class="col-md-2 wow fadeInRight">
                <img src="../files/itworks-1.png">
              </div>
            </div>

            <div class="row dashed pt-3">
              <div class="col-md-2 wow fadeInRight">
                <img src="../files/itworks-2.png">
              </div>
              <div class="col-md-10 wow fadeInLeft">
                <div class="how-it-content">
                    <h3>{{ __('setup') }}</h3>
                    <p>{{ __('setup-subtitle') }}</p>
                    <ul>
                      <li>{{ __('setup-li-1') }}</li>
                      <li>{{ __('setup-li-2') }}</li>
                      <li>{{ __('setup-li-3') }}</li>
                    </ul>
                </div>
              </div>
            </div>

            <div class="row dashed pt-3">
              <div class="col-md-10 wow fadeInLeft">
                <div class="how-it-content">
                    <h3>{{ __('selling') }}</h3>
                    <p>{{ __('selling-subtitle') }}</p>
                    <ul>
                      <li>{{ __('selling-li-1') }}</li>
                      <li>{{ __('selling-li-2') }}</li>
                      <li>{{ __('selling-li-3') }}</li>
                    </ul>
                </div>
              </div>
              <div class="col-md-2 wow fadeInRight">
                <img src="../files/itworks-3.png">
              </div>
            </div>
            <div class="row dashed">

            </div>
        </div>
    </section>

    <section class="pricing-layout-1 section-pricing " id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>{{ __('pricing') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="pricing-title wow fadeInUp">
                        <h3>{{ __('pricing-title') }}</h3>
                        <p>{{ __('pricing-subtitle-1') }}</p>

                        <p>{{ __('pricing-subtitle-2') }}</p>
                        <p>{{ __('pricing-subtitle-3') }}</p>
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
                                                <!-- <div class="icon-box">
                                                    <img src="/static/img/pricing-icon.png" alt="pricing icon" width="" height="" class="img-responsive">
                                                </div> -->
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
                                                    <li class="paket">{{$value->file_upload}} {{ __('day') }} <b style="color:#8a8a8a;">{{ __('storage') }}</b> </li>

                                                    <li class="paket">
                                                        {{$value->secure_storage}} <b style="color:#8a8a8a;">{{ __('space') }}</b>
                                                    </li>

                                                    <li class="paket">
                                                        {{ __('auto') }} <b style="color:#8a8a8a;">Email</b>
                                                    </li>

                                                    <li class="paket">
                                                      @if($value->package_name=="Basic")
                                                        No <b style="color:#8a8a8a;">SMS</b>
                                                      @else
                                                          {{ __('auto') }} <b style="color:#8a8a8a;">SMS</b>
                                                      @endif
                                                    </li>

                                                    <li class="paket">{{$value->max_user}} <b style="color:#8a8a8a;">Branch</b>

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        @if($value->package_name=="Basic")
                                            <a style="color:#fff!important;" data-package='1' class="select-package has-popup" href="#login" id="{{ $value->id }}">
                                            <div class="btn-buynow">{{ __('button') }}</div></a>
                                        @else
                                            <a style="color:#fff!important;" data-package='1' class="select-package has-popup" href="#login" id="{{ $value->id }}">
                                            <div class="btn-buynow btn-enterprise">{{ __('button') }}</div></a>
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
        <h3>{{ __('modal-title-1') }}<br />
        {{ __('modal-title-2') }}</h3>

        <form action="http://127.0.0.1/register" method="post">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-user"></span>
              </div>
              <input type="text" name="first_name" class="form-control" placeholder="{{ __('modal-first-name') }}" required>
            </div>
          </div>

          <!-- <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-user"></span>
              </div>
              <input type="text" name="last_name" class="form-control" placeholder="{{ __('modal-last-name') }}" required>
            </div>
          </div> -->

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-building"></span>
              </div>

              <input type="text" name="company" class="form-control" placeholder="{{ __('modal-company') }}" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-phone"></span>
              </div>

              <input type="tel" name="phone" class="form-control" placeholder="{{ __('modal-phone') }}" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-envelope"></span>
              </div>

              <input type="email" name="email" class="form-control" placeholder="{{ __('modal-email') }}" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-lock"></span>
              </div>

              <input type="password" name="password" class="form-control" placeholder="{{ __('modal-password') }}" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-tag"></span>
              </div>

              <select style="border-right:none; color:#8d97ad!important;" class="form-control" name="package_id" required>
                <option disabled selected>Select Your Package</option>
                @foreach($packages as $value)
                <option value="{{$value->id}}">{{$value->package_name}}</option>
                @endforeach
              </select>

              <div class="input-group-append">
                <i class="fa fa-chevron-down"></i>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="fa fa-money"></span>
              </div>

              <select style="border-right:none; color:#8d97ad!important;" class="form-control" name="currency_id" required>
                <option disabled selected>Select Your Currency</option>
                <option value="1">Dollar</option>
                <option value="3">Rupiah</option>
              </select>

              <div class="input-group-append">
                <i class="fa fa-chevron-down"></i>
              </div>
            </div>
          </div>

          <div class="account-row">
            <!-- <div class="account-left"> -->
              <label class="account-checkbox">
                <input type="checkbox">
                <span class="checkmark"></span>
                <b>{{ __('modal-term') }} <a class="has-popup" href="#term">{{ __('modal-term-link') }}</a> </b>
              </label>
            <!-- </div> -->
          </div>

          <div class="form-group">
            <input type="submit" value="{{ __('modal-up') }}" class="btn-submit" />
            <span style="font-size: .8rem!important;">have an account? <a href="http://127.0.0.1/login">{{ __('modal-sign') }}</a></span>
            <!-- <a href="#signup" class="btn-submit has-popup">Sign Up</a> -->
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-6">
      <div class="myaccount-image-note">
        <figure>
          <img src="../images/logo-large.png" alt="" />
        </figure>

        <p>{{ __('modal-sublogo') }}</p>
      </div>
    </div>
  </div>
</div>

<div class="popup-page mfp-with-anim mfp-hide" id="term">
  <div class="row">
    <div class="col-md-12">
      {!! $term->page_content !!}
    </div>

  </div>
</div>

<div class="popup-page mfp-with-anim mfp-hide" id="refund">
  <div class="row">
    <div class="col-md-12">
      {!! $refund->page_content !!}
    </div>

  </div>
</div>

<div class="popup-page mfp-with-anim mfp-hide" id="policy">
  <div class="row">
    <div class="col-md-12">
      {!! $policy->page_content !!}
    </div>

  </div>
</div>
<!-- End login popup -->
@endsection
