@extends('layouts.app')

@section('title', 'Our Projects | Vega Homes (Pvt) Ltd')

@section('content')
    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <!-- Swiper hero wrapper -->
        <div class="page-header-swiper">
            <div class="swiper page-header-swiper-instance">
                <div class="swiper-wrapper">
                    <!-- Slides: using images from images/downloads/hero/New/SH-/ -->
                    <div class="swiper-slide" style="background-image:url('{{ asset('images/downloads/hero/New/SH-30.jpg') }}')"></div>

                </div>


            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Projects</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Projects</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- Our Project Start -->
    <div class="page-project">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="display: none;">
                    <!-- Our Project Nav start -->
                    <div class="our-Project-nav wow fadeInUp">
                        <ul>
                            <li><a href="#" class="active-btn" data-filter="*">all</a></li>
                            <li><a href="#" data-filter=".3d">3D</a></li>
                        </ul>
                    </div>
                    <!-- Our Project Nav End -->
                </div>

                <div class="col-lg-12">
                    <!-- Project Item Boxes start -->
                    <div class="row project-item-boxes align-items-center">
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="789"
                                data-images="14">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/789/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-789</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="790"
                                data-images="14">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/790/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-790</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="791"
                                data-images="14">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/791/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-791</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="792"
                                data-images="12">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/792/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-792</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="793"
                                data-images="14">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/793/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-793</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="794"
                                data-images="12">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/794/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-794</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="795-1"
                                data-images="14">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/795-1/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-795 (Exterior)</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Project Item -->
                        <div class="col-md-6 col-lg-4 project-item-box 3d">
                            <div class="project-item wow fadeInUp" data-wow-delay="0.2s" data-project="795-2"
                                data-images="44">
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('images/projects/795-2/1.jpg') }}" alt="project-img">
                                        </figure>
                                    </div>
                                    <div class='project-btn d-none'>
                                        <a href='#'><img src='images/arrow-white.svg' alt=''></a>
                                    </div>
                                </div>
                                <div class="project-content">
                                    <h3>3D</h3>
                                    <h2><a href="#">VH-795 (Interior)</a></h2>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- Project Item Boxes End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Project End -->
@endsection

@push('scripts')
<script>
        document.querySelectorAll('.project-item').forEach(item => {
            item.addEventListener('click', function () {
                const projectId = this.getAttribute('data-project');
                const imgCount = parseInt(this.getAttribute('data-images'), 10);

                const carouselInner = document.getElementById('carouselInner');
                const carouselIndicators = document.getElementById('carouselIndicators');

                // Clear old slides & indicators
                carouselInner.innerHTML = '';
                carouselIndicators.innerHTML = '';

                // Generate slides & indicators
                for (let i = 1; i <= imgCount; i++) {
                    const activeClass = i === 1 ? 'active' : '';

                    // Slide
                    const slide = `
        <div class="carousel-item ${activeClass}">
          <img src="{{ asset('images/projects') }}/${projectId}/${i}.jpg" class="d-block w-100" alt="Slide ${i}">
        </div>`;
                    carouselInner.insertAdjacentHTML('beforeend', slide);

                    // Indicator
                    const indicator = `
        <button type="button" data-bs-target="#projectCarousel" data-bs-slide-to="${i - 1}" 
          class="${activeClass}" aria-current="${i === 1 ? 'true' : 'false'}" aria-label="Slide ${i}">
        </button>`;
                    carouselIndicators.insertAdjacentHTML('beforeend', indicator);
                }

                // Show modal
                new bootstrap.Modal(document.getElementById('projectModal')).show();
            });
        });
    </script>
@endpush
