@extends('layouts.app')

@section('title', 'Contact Us | Vega Homes (Pvt) Ltd')

@section('content')
    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <!-- Swiper hero wrapper -->
        <div class="page-header-swiper">
            <div class="swiper page-header-swiper-instance">
                <div class="swiper-wrapper">
                    <!-- Slides: using images from images/downloads/hero/New/SH-/ -->
                    <div class="swiper-slide" style="background-image:url('{{ asset('images/downloads/hero/New/SH-58.jpg') }}')"></div>
                    
                </div>


            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Contact us</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Page Contact Us Start -->
    <div class="page-contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!-- Contact Us Image Start -->
                    <div class="contact-us-image">
                        <div class="swiper contact-us-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <figure class="image-anime reveal">
                                        <img src="{{ asset('images/downloads/hero/20.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="image-anime reveal">
                                        <img src="{{ asset('images/downloads/hero/21.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="image-anime reveal">
                                        <img src="{{ asset('images/downloads/hero/22.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="image-anime reveal">
                                        <img src="{{ asset('images/downloads/hero/23.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="image-anime reveal">
                                        <img src="{{ asset('images/downloads/hero/24.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="image-anime reveal">
                                        <img src="{{ asset('images/downloads/hero/25.jpg') }}" alt="">
                                    </figure>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <!-- Contact Us Image End -->
                </div>
                
                <div class="col-lg-6">
                    <!-- Contact Us Form Start -->
                    <div class="contact-us-form">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">contact form</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">We would love to hear <span>from you</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Your email address will not be published. Required fields are marked *</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Contact Form Start -->
                        <div class="contact-form">
                            <!-- Contact Form Start -->
                            <form id="contactForm" action="{{ route('contact.store') }}" method="POST" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.4s">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Name*" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <input type="email" name ="email" class="form-control" id="email" placeholder="Email Address*" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Your Phone" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-12 mb-5">
                                        <textarea name="message" class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn-default">submit</button>
                                        <div id="msgSubmit" class="h3 hidden"></div>
                                    </div>
                                </div>
                            </form>
                            <!-- Contact Form End -->
                        </div>
                        <!-- Contact Form End -->
                    </div>
                    <!-- Contact Us Form End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Contact Us End -->

    <!-- Google Map Section Start -->
    <div class="google-map">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Our contact</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Get in touch with us</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Get in touch to discuss your employee wellbeing needs today. Please give us a call, drop us an email or fill out the contact form and we'll get back to you.</p>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-lg-12">
                    <!-- Google Map IFrame Start -->
                    <div class="google-map-iframe">
                        <!-- Responsive embedded Google Map for VEGA HOMES -->
                        <div class="embed-map-fixed">
                            <div class="embed-map-container">
                                <iframe class="embed-map-frame" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=VEGA%20HOMES%20(PVT)%20LTD&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                            </div>
                        </div>
                        <style>
                        /* Inline styles kept local to this block to avoid modifying global css files */
                        .embed-map-fixed{position:relative;text-align:right;width:100%;height:400px;}
                        .embed-map-container{overflow:hidden;background:none!important;width:100%;height:100%;}
                        .embed-map-frame{width:100%!important;height:100%!important;border:0;}
                        </style>
                    </div>
                    <!-- Google Map IFrame End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Contact Info Box Start -->
                    <div class="contact-info-box">
                        <!-- Conatct Info Item Start -->
                        <div class="contact-info-item wow fadeInUp">
                            <!-- Icon Box Start -->
                            <div class="icon-box">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <!-- Icon Box End -->

                            <!-- Contact Info Content Start -->
                            <div class="contact-info-content">
                                <h3>phone number</h3>
                                <p>+94 71 274 1577</p>
                                <p>+94 77 772 0888</p>
                                <p>+94 37 223 1174</p>
                            </div>
                            <!-- Contact Info Content End -->
                        </div>
                        <!-- Conatct Info Item End -->

                        <!-- Conatct Info Item Start -->
                        <div class="contact-info-item wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Icon Box Start -->
                            <div class="icon-box">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <!-- Icon Box End -->

                            <!-- Contact Info Content Start -->
                            <div class="contact-info-content">
                                <h3>e-mail support</h3>
                                <p>vegahomeslk@gmail.com</p>
                            </div>
                            <!-- Contact Info Content End -->
                        </div>
                        <!-- Conatct Info Item End -->

                        <!-- Conatct Info Item Start -->
                        <div class="contact-info-item wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Icon Box Start -->
                            <div class="icon-box">
                                <i class="fa-solid fa-house"></i>
                            </div>
                            <!-- Icon Box End -->

                            <!-- Contact Info Content Start -->
                            <div class="contact-info-content">
                                <h3>headquarters</h3>
                                <p>No.494, Puttalam Road, Kurunegala</p>
                            </div>
                            <!-- Contact Info Content End -->
                        </div>
                        <!-- Conatct Info Item End -->
                    </div>
                    <!-- Contact Info Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map Section End -->

    <!-- init removed; initialization will run after all scripts are loaded -->
@endsection

@push('scripts')
<script>
        (function(){
            if(typeof Swiper === 'undefined') return console && console.warn('Swiper not found');
            try{
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
            }catch(e){
                console && console.error('Swiper init error', e);
            }
        })();
    </script>
@endpush
