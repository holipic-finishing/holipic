<!-- Header Section Starts-->
<header class="header-layout-1">
    <nav class="navbar navbar-expand-md navbar-light fixed-top" id="navigation">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="../images/holipic-large.png" alt="" /></a>
            <ul class="navbar-nav ml-auto" id="main-menu">
                <li class="nav-item"><a class="nav-link active" href="#homepage">{{ __('home') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#benefits">{{ __('benefit') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#howitwork">{{ __('itworks') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing">{{ __('pricing') }}</a></li>
                <li class="nav-item"><a class="nav-link has-popup" href="#login">{{ __('regis') }}</a></li>
                <!-- <li class="nav-item"><a class="nav-link has-popup" href="#login">EN</a></li> -->
                <li class="nav-item">
                  <select style="border: 0px;background: transparent;" class="form-group nav-link hidden" id="language" onChange="window.location.href=this.value">
                    <option value="http://127.0.0.1/lang/en" {{ $lang == 'en' ? 'selected' : '' }}>EN</option>
                    <option value="http://127.0.0.1/lang/tr" {{ $lang == 'tr' ? 'selected' : '' }}>TR</option>
                  </select>
                </li>
            </ul>
            <div class="navbar-toggle"></div>
            <div id="responsive-menu"></div>
        </div>
    </nav>
</header>
<!-- Header Section ends -->
