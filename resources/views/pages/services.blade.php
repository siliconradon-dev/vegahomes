@extends('layouts.app')

@section('title', 'Our Services | Vega Homes (Pvt) Ltd')

@section('content')
    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <!-- Swiper hero wrapper -->
        <div class="page-header-swiper">
            <div class="swiper page-header-swiper-instance">
                <div class="swiper-wrapper">
                    <!-- Slides: using images from images/downloads/hero/New/SH-/ -->
                    <div class="swiper-slide" style="background-image:url('{{ asset('images/downloads/hero/New/SH-6.jpg') }}')"></div>

                </div>

            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Services</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">services</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Our Services Section Start -->
    <div class="our-services">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">our services</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Comprehensive solutions for<span>modern
                                living</span></h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title-content">
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Our extensive portfolio encompasses residential
                            construction and intelligent living solutions customized to match your specific
                            requirements. Spanning from preliminary design through project delivery and ongoing support.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp">
                        <div class="service-image"><a href="#" data-cursor-text="View">
                                <figure class="image-anime"><img src="{{ asset('images/housing_building.jpeg') }}" alt=""></figure>
                            </a></div>
                        <div class="service-btn"><a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a>
                        </div>
                        <div class="service-content">
                            <h3><a href="#">home building</a></h3>
                            <p>Full-spectrum residential construction services, managing all building phases with careful focus on detail and adherence to the most demanding quality and construction standards.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-image"><a href="#" data-cursor-text="View">
                                <figure class="image-anime"><img src="{{ asset('images/home08.jpeg') }}" alt=""></figure>
                            </a></div>
                        <div class="service-btn"><a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a></div>
                        <div class="service-content">
                            <h3><a href="#">dream home planning</a></h3>
                            <p>Our skilled team of architects and designers collaborates closely to shape all aspects of your
                                ideal residence starting from preliminary designs through comprehensive technical drawings.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-image"><a href="#" data-cursor-text="View">
                                <figure class="image-anime"><img src="{{ asset('images/home6.jpeg') }}" alt=""></figure>
                            </a></div>
                        <div class="service-btn"><a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a></div>
                        <div class="service-content">
                            <h3><a href="#">garden design</a></h3>
                            <p>Reimagine your outdoor environment as an attractive and practical retreat. Our landscape
                                professionals craft gardens that elevate the aesthetic allure of your residence.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-image"><a href="#" data-cursor-text="View">
                                <figure class="image-anime"><img src="{{ asset('images/downloads/6.jpg') }}" alt=""></figure>
                            </a></div>
                        <div class="service-btn"><a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a></div>
                        <div class="service-content">
                            <h3><a href="#">smart home integration</a></h3>
                            <p>Sophisticated technological solutions delivering energy-conscious, protected, and pleasant intelligent homes
                                with connected platforms and constant monitoring options.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.8s">
                        <div class="service-image"><a href="#" data-cursor-text="View">
                                <figure class="image-anime"><img src="{{ asset('images/home07.jpeg') }}" alt=""></figure>
                            </a></div>
                        <div class="service-btn"><a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a></div>
                        <div class="service-content">
                            <h3><a href="#">free consultation</a></h3>
                            <p>Obtain specialized insights and individualized support for your construction project. Our specialists deliver thorough consultation to help navigate your options effectively.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="1.0s">
                        <div class="service-image"><a href="#" data-cursor-text="View">
                                <figure class="image-anime"><img src="{{ asset('images/downloads/2.jpg') }}" alt=""></figure>
                            </a></div>
                        <div class="service-btn"><a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a></div>
                        <div class="service-content">
                            <h3><a href="#">renovations & remodeling</a></h3>
                            <p>Upgrade and reimagine your current residence using our remodeling solutions. Whether you're transforming individual spaces or undertaking a complete residential renovation with superior outcomes.</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-12">
                    <div class="all-services-btn wow fadeInUp" data-wow-delay="1.2s"><a href="#" class="btn-default">see
                            all services</a></div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Our Services Section End -->

    @include('partials.packages')

    <!-- Why Choose Us Section Start -->
    <div class="why-choose-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <!-- Why Choose Content Start -->
                    <div class="why-choose-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Why Choose Us</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Insights into what makes <span>Vega
                                    Homes different</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Throughout the entire journey from vision to
                                realization, Vega Homes offers dependable, premium-quality residences with area
                                proficiency, responsive engagement and dependable execution.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Why Choose Item List Start -->
                        <div class="why-choose-item-list">
                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.4s">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="{{ asset('images/icon-why-choose-1.svg') }}" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Item Content Start -->
                                <div class="why-choose-item-content">
                                    <h3>Custom Design Approach</h3>
                                    <p>Bespoke strategies and authorized technical drawings customized to your property,
                                        financial limits and way of living.</p>
                                </div>
                                <!-- Why Choose Item Content End -->
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.6s">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="{{ asset('images/icon-why-choose-2.svg') }}" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Item Content Start -->
                                <div class="why-choose-item-content">
                                    <h3>Integrated Delivery Oversight</h3>
                                    <p>Comprehensive project handling alongside regional professionals, schedules and
                                        hands-on administration.</p>
                                </div>
                                <!-- Why Choose Item Content End -->
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.8s">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="{{ asset('images/icon-why-choose-3.svg') }}" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Item Content Start -->
                                <div class="why-choose-item-content">
                                    <h3>Partnership-Focused Communication</h3>
                                    <p>We maintain your involvement throughout the procedure — consistent messaging,
                                        informed selections and open pricing visibility.</p>
                                </div>
                                <!-- Why Choose Item Content End -->
                            </div>
                            <!-- Why Choose Item End -->
                        </div>
                        <!-- Why Choose Item List End -->
                    </div>
                    <!-- Why Choose Content End -->
                </div>

                <div class="col-lg-7">
                    <!-- Why Choose Images Images Start -->
                    <div class="why-choose-images">
                        <!-- Why Choose Box 1 Start -->
                        <div class="why-choose-img-box-1">
                            <div class="why-choose-img-1">
                                <figure class="image-anime reveal"><img src="{{ asset('images/downloads/hero/New/SH-29.jpg') }}" alt="">
                                </figure>
                            </div>
                            <div class="why-choose-img-2">
                                <figure class="image-anime reveal"><img src="{{ asset('images/downloads/hero/New/SH-18.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <div class="why-choose-img-box-2">
                            <div class="why-choose-img-3">
                                <figure class="image-anime reveal"><img src="{{ asset('images/downloads/hero/New/SH-16.jpg') }}" alt="">
                                </figure>
                            </div>
                            <div class="why-choose-img-4">
                                <figure class="image-anime reveal"><img src="{{ asset('images/downloads/hero/New/SH-15.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- Why Choose Box 2 End -->
                    </div>
                    <!-- Why Choose Images Images End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Why Choose Us Section End -->

    <!-- Our Skill Start -->
    <div class="our-skill">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Our Skill Content Start -->
                    <div class="our-skill-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Our Skills</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Expertise that brings your<span> vision
                                    to life</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Vega Homes' design specialists, technical
                                professionals and construction crews work in unison to produce practical, implementable
                                strategies and premium-grade execution with precision and care.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- About SkillBar Start -->
                        <div class="our-skillbar">
                            <!-- Skills Progress Bar Start -->
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="95%">
                                    <div class="skill-data">
                                        <div class="skill-title">Space Planning &amp; Layout</div>
                                        <div class="skill-no">95%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                            <!-- Skills Progress Bar End -->

                            <!-- Skills Progress Bar Start -->
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="85%">
                                    <div class="skill-data">
                                        <div class="skill-title">Project Management &amp; Problem Solving</div>
                                        <div class="skill-no">85%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                            <!-- Skills Progress Bar End -->

                            <!-- Skills Progress Bar Start -->
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="75%">
                                    <div class="skill-data">
                                        <div class="skill-title">Sustainability &amp; Energy Efficiency</div>
                                        <div class="skill-no">75%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                            <!-- Skills Progress Bar End -->
                        </div>
                        <!-- About SkillBar End -->
                    </div>
                    <!-- Our Skill Content End -->
                </div>

                <div class="col-lg-6">
                    <!-- Our Skill Image Start -->
                    <div class="our-skill-image">
                        <div class="our-skill-img-1">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('images/downloads/hero/New/SH-12.jpg') }}" alt="">
                            </figure>
                        </div>

                        <div class="our-skill-img-2">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('images/downloads/hero/New/SH-11.jpg') }}" alt="">
                            </figure>
                        </div>

                        <div class="our-skill-img-3">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('images/downloads/hero/New/SH-10.jpg') }}" alt="">
                            </figure>
                        </div>
                    </div>
                    <!-- Our Skill Image End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Skill End -->
@endsection

@push('scripts')
<script>
        (function () {
            if (typeof Swiper === 'undefined') return console && console.warn('Swiper not found');
            try {
                new Swiper('.page-header-swiper-instance', {
                    loop: true,
                    speed: 2400,
                    autoplay: {
                        delay: 11000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    effect: 'fade',
                    fadeEffect: { crossFade: true }
                });

                // Contact Us Swiper init
                new Swiper('.contact-us-swiper', {
                    loop: true,
                    speed: 2400,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.contact-us-swiper .swiper-pagination',
                        clickable: true,
                    },
                    effect: 'fade',
                    fadeEffect: { crossFade: true }
                });
            } catch (e) {
                console && console.error('Swiper init error', e);
            }
        })();
    </script>
@endpush
