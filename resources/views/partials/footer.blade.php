    <!-- Footer Start -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Footer Header Start -->
                    <div class="footer-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <!-- Footer Logo Start -->
                                <div class="footer-logo">
                                    <img src="{{ asset('images/downloads/logo-full.png') }}" alt="Vega Homes - We Bring Your Dream Space to Life">
                                </div>
                                <!-- Footer Logo End -->
                            </div>

                            <div class="col-md-6">
                                <!-- Footer Social Link Start -->
                                <div class="footer-social-links">
                                    <div class="footer-social-link-title">
                                        <h3>follow our socials</h3>
                                    </div>
                                    <ul>
                                        <li><a href="https://wa.me/94777720888"><i
                                                    class="fa-brands fa-whatsapp"></i></a></li>
                                        <li><a href="https://www.facebook.com/vegahomesconstruction/"><i
                                                    class="fa-brands fa-facebook-f"></i></a></li>
                                        <li>
                                            <a href="https://www.linkedin.com/company/vegaconstructionhomes/"><i
                                                    class="fa-brands fa-linkedin"></i></a>
                                        </li>
                                        <li><a href="mailto:vegahomeslk@gmail.com"><i class="bi bi-envelope"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Footer Social Link End -->
                            </div>
                        </div>
                    </div>
                    <!-- Footer Header End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Links Start -->
                    <div class="footer-links">
                        <h3>information</h3>
                        <ul>
                            <li><a href="{{ route('home') }}">Homepage</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('services') }}">Our Services</a></li>
                            <li><a href="{{ route('projects') }}">Our Projects</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- Footer Links End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Links Start -->
                    <div class="footer-links">
                        <h3>our services</h3>
                        <ul>
                            <li><a href="{{ route('services') }}">Dream Home Planning</a></li>
                            <li><a href="{{ route('services') }}">Home Building</a></li>
                            <li><a href="{{ route('services') }}">Garden Design</a></li>
                            <li><a href="{{ route('services') }}">Smart Home Integration</a></li>
                            <li><a href="{{ route('services') }}">Free Consultation</a></li>
                            <li><a href="{{ route('services') }}">Renovations & Remodeling</a></li>
                        </ul>
                    </div>
                    <!-- Footer Links End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Contact Box Start -->
                    <div class="footer-contact-box footer-links">
                        <h3>contact us</h3>
                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="footer-contact-content">
                                <p>+94 71 274 1577</p>
                                <p>+94 77 772 0888</p>
                                <p>+94 37 223 1174</p>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->

                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="footer-contact-content">
                                <p>vegahomeslk@gmail.com</p>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->

                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="footer-contact-content">
                                <p>No.494, Puttalam Road, Kurunegala</p>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->
                    </div>
                    <!-- Footer Contact Box End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Newsletter Form Start -->
                    <div class="footer-latest-news footer-links">
                        <h3>get the latest trending news</h3>

                        <div class="footer-newsletter-form">
                            <p>Your Dream Space Starts Here Get Exclusive Design Straight to Your Inbox!</p>

                            <form id="newslettersForm" action="{{ route('newsletter.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" id="mail"
                                        placeholder="Enter your email" required>
                                    <button type="submit"><i class="fa-solid fa-envelope"></i> </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Footer Newsletter Form End -->
                </div>
            </div>

            <!-- Footer Copyright Section Start -->
            <div class="footer-copyright">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Footer Copyright Start -->
                        <div class="footer-copyright-text">
                            <p>2025 © All Rights Reserved | Vega Homes (Pvt) Ltd | Designed &
                                Developed by Silicon Radon Networks (Pvt) Ltd</p>
                        </div>
                        <!-- Footer Copyright End -->
                    </div>
                </div>
            </div>
            <!-- Footer Copyright Section End -->
        </div>
    </footer>
    <!-- Footer End -->
