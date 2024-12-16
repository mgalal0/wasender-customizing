<header>
    <!-- tp-header-area-start -->
    <div id="header-sticky"
         class="tp-header__area tp-header__space tp-header__transparent tp-header__menu-space z-index-5">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-2 col-md-6 col-8">
                    <div class="tp-header__logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset(get_option('primary_data',true,true,false,current_locale())->footer_logo ?? '') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 d-none d-lg-block">
                    <div class="tp-header__main-menu tp-header__main-menu1">
                        <nav id="mobile-menu">
                            <ul>
                                {{ PrintMenu('main-menu') }}
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-4">
                    <div class="tp-header__right">
                        <a class="tp-btn d-none d-md-block"
                           href="{{ !Auth::check() ? url('/pricing') : url('/login') }}"><span>{{ !Auth::check() ? __('Get Started') : __('Dashboard') }}</span></a>
                        <a class="tp-header__bars tp-menu-bar" href="javascript:void(0)"><i class="fas fa-bars"></i></a>
                    </div>
                </div>
                <div class="dropdown d-flex justify-content-between">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        {{ __('Languages') }}
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($languages as $code => $language)
                            <li>
                                <a class="dropdown-item" href="{{ route('switchLang', $code) }}">
                                    {{ $language }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- tp-header-area-end -->
</header>

<!-- tp-offcanvus-area-start -->
<div class="tp-offcanvas-area">
    <div class="tpoffcanvas">
        <div class="tpoffcanvas__close-btn">
            <button class="close-btn"><i class="fal fa-times"></i></button>
        </div>
        <div class="tpoffcanvas__logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset(get_option('primary_data',true,true,false,current_locale())->footer_logo ?? '') }}" alt="">
            </a>
        </div>
        <div class="tpoffcanvas__text">
            <p>{{ get_option('header_footer',true,true,false,current_locale())->footer->description ?? ''  }}</p>
        </div>
        <div class="mobile-menu"></div>
        <div class="tpoffcanvas__info">
            <h3 class="offcanva-title">{{ __('Get In Touch') }}</h3>
            <div class="tp-info-wrapper mb-20 d-flex align-items-center">
                <div class="tpoffcanvas__info-icon">
                    <a href="maito:{{ get_option('primary_data',true,true,false,current_locale())->contact_email ?? '' }}"><i
                            class="fal fa-envelope"></i></a>
                </div>
                <div class="tpoffcanvas__info-address">
                    <span>{{ __('Email') }}</span>
                    <a href="maito:{{ get_option('primary_data',true,true,false,current_locale())->contact_email ?? '' }}">{{ get_option('primary_data',true,true,false,current_locale())->contact_email ?? '' }}</a>
                </div>
            </div>
            <div class="tp-info-wrapper mb-20 d-flex align-items-center">
                <div class="tpoffcanvas__info-icon">
                    <a href="tel:{{ get_option('primary_data',true,true,false,current_locale())->contact_phone ?? '' }}"><i
                            class="fal fa-phone-alt"></i></a>
                </div>
                <div class="tpoffcanvas__info-address">
                    <span>{{ __('Phone') }}</span>
                    <a href="tel:{{ get_option('primary_data',true,true,false,current_locale())->contact_phone ?? '' }}">{{ get_option('primary_data',true,true,false,current_locale())->contact_phone ?? '' }}</a>
                </div>
            </div>
            <div class="tp-info-wrapper mb-20 d-flex align-items-center">
                <div class="tpoffcanvas__info-icon">
                    <a href="#"><i class="fas fa-map-marker-alt"></i></a>
                </div>
                <div class="tpoffcanvas__info-address">
                    <span>{{ __('Address') }}</span>
                    <a href="javascript:void(0)">{{ get_option('primary_data',true,true,false,current_locale())->address ?? '' }}</a>
                </div>
            </div>
        </div>
        <div class="tpoffcanvas__social">
            <div class="social-icon">
                @if(!empty(get_option('primary_data',true,true,false,current_locale())->socials->twitter))
                    <a href="{{ get_option('primary_data',true,true,false,current_locale())->socials->twitter }}"><i class="fab fa-twitter"></i></a>
                @endif
                @if(!empty(get_option('primary_data',true,true,false,current_locale())->socials->instagram))
                    <a href="{{ get_option('primary_data',true,true,false,current_locale())->socials->instagram }}"><i class="fab fa-instagram"></i></a>
                @endif
                @if(!empty(get_option('primary_data',true,true,false,current_locale())->socials->facebook))
                    <a href="{{ get_option('primary_data',true,true,false,current_locale())->socials->facebook }}"><i
                            class="fab fa-facebook-square"></i></a>
                @endif
                @if(!empty(get_option('primary_data',true,true,false,current_locale())->socials->linkedin))
                    <a href="{{ get_option('primary_data',true,true,false,current_locale())->socials->linkedin }}"><i
                            class="fab fa-linkedin"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- tp-offcanvus-area-end -->
