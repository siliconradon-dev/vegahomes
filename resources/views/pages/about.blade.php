@extends('layouts.app')

@section('title', 'About Us | Vega Homes (Pvt) Ltd')

@section('content')
    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <!-- Swiper hero wrapper -->
        <div class="page-header-swiper">
            <div class="swiper page-header-swiper-instance">
                <div class="swiper-wrapper">
                    <!-- Slides: using images from images/downloads/hero/New/SH-/ -->
                    <div class="swiper-slide" style="background-image:url('{{ asset('images/downloads/hero/New/SH-8.jpg') }}')"></div>
                    
                </div>

            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">About us</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">about us</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Us Section Start -->
    <div class="about-us page-about-us" >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-us-images">
                        <div class="about-img-1">
                            <figure class="image-anime reveal"><img src="{{ asset('images/downloads/hero/New/SH-32.jpg') }}" alt=""></figure>
                        </div>
                        <div class="about-img-2">
                            <figure class="image-anime reveal"><img src="{{ asset('images/downloads/hero/New/SH-31.jpg') }}" alt=""></figure>
                            <div class="experience-counter">
                                <h3><span class="counter">10</span>+</h3>
                                <p>Years of experience</p>
                            </div>
                        </div>
                        <div class="feedback-counter">
                            <p><span class="counter">100</span>%</p>
                            <h3>customer satisfaction</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="about-us-content">
                        <div class="section-title">
                            <h3 class="wow fadeInUp">about us</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Where creativity meets 
                                quality <span>in every project we deliver</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Vega Homes is dedicated to transforming 
                                residential living experiences. Our approach centers on technological advancement, 
                                environmental responsibility, and exceptional client outcomes, delivering intelligent 
                                residences that combine efficiency, protection, and comfort seamlessly.</p>
                        </div>
                        <div class="about-us-content-body">
                            <div class="about-us-content-info">
                                <div class="about-us-content-list wow fadeInUp" data-wow-delay="0.4s">
                                    <ul>
                                        <li>intelligent technology solutions</li>
                                        <li>eco-conscious construction methods</li>
                                    </ul>
                                </div>
                                <div class="about-us-content-btn wow fadeInUp" data-wow-delay="0.6s"><a href="#"
                                        class="btn-default">read more</a></div>
                            </div>
                            <div class="about-us-contact-list">
                                <div class="about-contact-item wow fadeInUp" data-wow-delay="0.4s">
                                    <div class="icon-box"><i class="fa-solid fa-phone"></i></div>
                                    <div class="about-contact-content">
                                        <p>need any help?</p>
                                        <h3>Contact Us Today</h3>
                                    </div>
                                </div>
                                <div class="about-contact-item wow fadeInUp" data-wow-delay="0.6s">
                                    <div class="icon-box">
                                        <figure class="image-anime"><img src="{{ asset('images/author-1.jpg') }}" alt=""></figure>
                                    </div>
                                    <div class="about-contact-content">
                                        <h3>vega homes team</h3>
                                        <p>expert builders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- About Us Content End -->
            </div>

            <!-- Vision Mission Start -->
            <div class="vision-mission" >
                <div class="container">
                    <div class="row section-row align-items-center">
                        <div class="col-lg-6">
                            <!-- Section Title Start -->
                            <div class="section-title dark-section">
                                <h3 class="wow fadeInUp">vision mission</h3>
                                <h2 class="text-anime-style-2" data-cursor="-opaque">Discover what drives 
                                    <span>our company forward</span></h2>
                            </div>
                            <!-- Section Title End -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Section Title Content Start -->
                            <div class="section-title-content dark-section">
                                <p class="wow fadeInUp" data-wow-delay="0.2s">Our collection of completed projects demonstrates our expertise across residential developments and contemporary commercial spaces</p>
                            </div>
                            <!-- Section Title Content End -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Vision Mission Box Start -->
                            <div class="vision-mission-box">
                                <!-- Vision Mission Item Start -->
                                <div class="vision-mission-item wow fadeInUp">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-our-vision.svg') }}" alt="">
                                    </div>
                                    <div class="vision-mission-content">
                                        <h3>our vision</h3>
                                        <p>Vega Homes is grounded in core principles that guide every decision. Technological innovation, environmental stewardship, and operational excellence form the foundation of our purpose. We're devoted to designing and constructing residences that not only fulfill but surpass client aspirations. Our unwavering commitment to superior workmanship, advanced systems, and sustainable building practices distinguishes us as industry leaders. We view ourselves as architects of tomorrow's living standards, not merely constructing buildings. Our dedication to client experience and progressive solutions ensures we're reshaping residential construction norms for the contemporary age. Become part of our mission to foster intelligent, environmentally responsible living.</p>
                                    </div>
                                </div>
                                <!-- Vision Mission Item End -->

                                <!-- Vision Mission Item Start -->
                                <div class="vision-mission-item wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-our-mission.svg') }}" alt="">
                                    </div>
                                    <div class="vision-mission-content">
                                        <h3>our mission</h3>
                                        <p>Our passion drives us to shape the residential spaces of tomorrow. We bring together skilled professionals dedicated to delivering smart, sustainable, and aesthetically pleasing environments tailored to contemporary households. Through cutting-edge solutions and technological advancement, we aim to revolutionize modern residential experiences. Our commitment to delivering superior quality remains steadfast, and we take satisfaction in creating homes that merge visual appeal with practicality and resource efficiency. Join our mission as we transform the future of residential living through each carefully crafted project.</p>
                                    </div>
                                </div>
                                <!-- Vision Mission Item End -->
                            </div>
                            <!-- Vision Mission Box End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vision Mission End -->

            <!-- Our Offerings Start -->
            <div class="vision-mission" >
                <div class="container">
                    <div class="row section-row align-items-center">
                        <div class="col-lg-6">
                            <!-- Section Title Start -->
                            <div class="section-title dark-section">
                                <h3 class="wow fadeInUp">our offerings</h3>
                                <h2 class="text-anime-style-2" data-cursor="-opaque">Key features that make us 
                                        <span>distinctive</span></h2>
                            </div>
                            <!-- Section Title End -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Section Title Content Start -->
                            <div class="section-title-content dark-section">
                                <p class="wow fadeInUp" data-wow-delay="0.2s">Explore the distinctive qualities that position Vega Homes as an industry leader.</p>
                            </div>
                            <!-- Section Title Content End -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Vision Mission Box Start -->
                            <div class="vision-mission-box">
                                <!-- Vision Mission Item Start -->
                                <div class="vision-mission-item wow fadeInUp">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-about-facility-1.svg') }}" alt="">
                                    </div>
                                    <div class="vision-mission-content">
                                        <h3>Smart Technology</h3>
                                        <p>Implementing state-of-the-art innovations to create unified and intuitive residential environments.</p>
                                    </div>
                                </div>
                                <!-- Vision Mission Item End -->

                                <!-- Vision Mission Item Start -->
                                <div class="vision-mission-item wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-about-facility-2.svg') }}" alt="">
                                    </div>
                                    <div class="vision-mission-content">
                                        <h3>Sustainable Design</h3>
                                        <p>Green-focused methodology that develops residences prioritizing environmental responsibility and reduced energy consumption.</p>
                                    </div>
                                </div>
                                <!-- Vision Mission Item End -->

                                <!-- Vision Mission Item Start -->
                                <div class="vision-mission-item wow fadeInUp" data-wow-delay="0.4s">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-how-we-work-3.svg') }}" alt="">
                                    </div>
                                    <div class="vision-mission-content">
                                        <h3>Quality Craftsmanship</h3>
                                        <p>Meticulous precision with every element, guaranteeing exceptional construction standards and refined finishes throughout.</p>
                                    </div>
                                </div>
                                <!-- Vision Mission Item End -->

                                <!-- Vision Mission Item Start -->
                                <div class="vision-mission-item wow fadeInUp" data-wow-delay="0.6s">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-how-we-work-4.svg') }}" alt="">
                                    </div>
                                    <div class="vision-mission-content">
                                        <h3>Personalized Touch</h3>
                                        <p>Customizing residences according to individual lifestyle requirements and preferences to deliver one-of-a-kind, tailored solutions.</p>
                                    </div>
                                </div>
                                <!-- Vision Mission Item End -->
                            </div>
                            <!-- Vision Mission Box End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Our Offerings End -->

            <div class="col-lg-12">
                <!-- Our Services Start -->
                <div class="our-services">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title">
                                    <h3 class="wow fadeInUp">our services</h3>
                                    <h2 class="text-anime-style-2" data-cursor="-opaque">Solutions we provide to <span>realize your vision</span></h2>
                                    <p class="wow fadeInUp" data-wow-delay="0.2s">Our complete range of services spans design, building, intelligent home solutions, and landscape enhancement — all essential elements for transforming your residence.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="about-facility-list service-list">
                                    <!-- Service Item -->
                                    <div class="about-facility-item wow fadeInUp">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-about-facility-1.svg') }}" alt="">
                                        </div>
                                        <div class="about-facility-content">
                                            <h3>Dream Home Planning</h3>
                                            <p>We partner with you to transform your aspirations into comprehensive design blueprints customized to your lifestyle and financial scope.</p>
                                            <div class="about-us-content-btn"><a href="{{ route('contact') }}"
                                                    class="btn-default">GET STARTED</a></div>
                                        </div>
                                    </div>

                                    <!-- Service Item -->
                                    <div class="about-facility-item wow fadeInUp" data-wow-delay="0.1s">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-how-we-work-2.svg') }}" alt="">
                                        </div>
                                        <div class="about-facility-content">
                                            <h3>Home Building</h3>
                                            <p>From initial groundwork to final touches, our skilled professionals produce robust, attractive residences meeting strict timelines.</p>
                                            <div class="about-us-content-btn"><a href="{{ route('contact') }}"
                                                    class="btn-default">GET STARTED</a></div>
                                        </div>
                                    </div>

                                    <!-- Service Item -->
                                    <div class="about-facility-item wow fadeInUp" data-wow-delay="0.2s">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-how-we-work-3.svg') }}" alt="">
                                        </div>
                                        <div class="about-facility-content">
                                            <h3>Garden Design</h3>
                                            <p>Innovative outdoor arrangements and environmentally conscious vegetation selection that elevate exterior beauty and property value.</p>
                                            <div class="about-us-content-btn"><a href="{{ route('contact') }}"
                                                    class="btn-default">GET STARTED</a></div>
                                        </div>
                                    </div>

                                    <!-- Service Item -->
                                    <div class="about-facility-item wow fadeInUp" data-wow-delay="0.3s">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-our-mission.svg') }}" alt="">
                                        </div>
                                        <div class="about-facility-content">
                                            <h3>Smart Home Integration</h3>
                                            <p>We implement connected systems for illumination, temperature control, protection and media features — personalized for your requirements.</p>
                                            <div class="about-us-content-btn"><a href="{{ route('contact') }}"
                                                    class="btn-default">GET STARTED</a></div>
                                        </div>
                                    </div>

                                    <!-- Service Item -->
                                    <div class="about-facility-item wow fadeInUp" data-wow-delay="0.4s">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-how-we-work-4.svg') }}" alt="">
                                        </div>
                                        <div class="about-facility-content">
                                            <h3>Free Consultation</h3>
                                            <p>Begin with a cost-free session to discuss your objectives, financial parameters and project timeline — completely pressure-free.</p>
                                            <div class="about-us-content-btn"><a href="{{ route('contact') }}"
                                                    class="btn-default">GET STARTED</a></div>
                                        </div>
                                    </div>

                                    <!-- Service Item -->
                                    <div class="about-facility-item wow fadeInUp" data-wow-delay="0.5s">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-about-facility-2.svg') }}" alt="">
                                        </div>
                                        <div class="about-facility-content">
                                            <h3>Renovations & Remodeling</h3>
                                            <p>Reimagine your current spaces through strategic design and skilled execution, reducing interruption to daily life while enhancing property worth.</p>
                                            <div class="about-us-content-btn"><a href="{{ route('contact') }}"
                                                    class="btn-default">GET STARTED</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Our Services End -->
            </div>
        </div>
    </div>





    <!-- Our Team Section Start 
    <div class="our-team">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-5">
                    
                    <div class="section-title">
                        <h3 class="wow fadeInUp">meet our team</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Expert Builders Crafting <span>Your
                                Future</span></h2>
                    </div>
                    
                </div>

                <div class="col-lg-7">
                    
                    <div class="section-title-content">
                        <p class="wow fadeInUp" data-wow-delay="0.2s">We offer a range of comprehensive home
                            construction services tailored to your unique needs. From initial planning and design to
                            final construction and handover.</p>
                    </div>
                   
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                   
                    <div class="team-member-item wow fadeInUp">
                        
                        <div class="team-image">
                            <a href="#" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('images/team-1.jpg') }}" alt="">
                                </figure>
                            </a>

                            
                            <div class="team-readmore-btn">
                                <a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a>
                            </div>
                           
                        </div>
                        

                        
                        <div class="team-body">
                            
                            <div class="team-content">
                                <h3>Kamal A. Sirimanna</h3>
                                <p>Co-founder & CEO</p>
                            </div>
                           

                            
                            <div class="team-social-list">
                               
                                <div class="team-social-icon">
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    </ul>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                   
                </div>

                <div class="col-lg-4 col-md-6">
                  
                    <div class="team-member-item wow fadeInUp" data-wow-delay="0.2s">
                       
                        <div class="team-image">
                            <a href="#" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('images/team-2.jpg') }}" alt="">
                                </figure>
                            </a>

                            
                            <div class="team-readmore-btn">
                                <a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a>
                            </div>
                          
                        </div>
                        
                       
                        <div class="team-body">
                        
                            <div class="team-content">
                                <h3>Apsara Weeriyasuriya</h3>
                                <p>Human Resources Manager</p>
                            </div>
                         

                           
                            <div class="team-social-list">
                           
                                <div class="team-social-icon">
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    </ul>
                                </div>
                                
                            </div>
                          
                        </div>
                       
                    </div>
                    
                </div>

                <div class="col-lg-4 col-md-6">
                  
                    <div class="team-member-item wow fadeInUp" data-wow-delay="0.4s">
                      
                        <div class="team-image">
                            <a href="#" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('images/team-3.jpg') }}" alt="">
                                </figure>
                            </a>

                            
                            <div class="team-readmore-btn">
                                <a href="#"><img src="{{ asset('images/arrow-white.svg') }}" alt=""></a>
                            </div>
                        
                        </div>
                
                  
                        <div class="team-body">
                     
                            <div class="team-content">
                                <h3>Shamali Jaysinghe</h3>
                                <p>Civil Engineer</p>
                            </div>
                           

                      
                            <div class="team-social-list">
                            
                                <div class="team-social-icon">
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    </ul>
                                </div>
                         
                            </div>
                       
                        </div>
               
                    </div>
                </div>
            </div>
        </div>
    </div>
    Our Team Section End -->
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
