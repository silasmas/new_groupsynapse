@extends("layouts.template")

@section("content")
@include("parties.banner",['page'=>"A propos"])
 <!-- about-area -->
 <section class="about-area pt-100 pb-100">
    <div class="container">
        <div class="row align-items-xl-center">
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="{{ asset('assets/img/images/about_img.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h4 class="title">Our Story</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting indust orem Ipsum has been the industry's standard
                    dummy texever since the when anunknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <p>Dorem Ipsum is simply dummy consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam</p>
                    <div class="our-mission-wrap">
                        <h4 class="title">Mission of Our Creative House</h4>
                        <div class="our-mission-list">
                            <div class="mission-box">
                                <div class="mission-icon">
                                    <i class="flaticon-project"></i>
                                </div>
                                <div class="mission-count">
                                    <h2><span class="odometer" data-count="324">00</span>+</h2>
                                    <span>Projects</span>
                                </div>
                            </div>
                            <div class="mission-box">
                                <div class="mission-icon">
                                    <i class="flaticon-revenue"></i>
                                </div>
                                <div class="mission-count">
                                    <h2>$<span class="odometer" data-count="3">00</span>M</h2>
                                    <span>Revenue</span>
                                </div>
                            </div>
                            <div class="mission-box">
                                <div class="mission-icon">
                                    <i class="flaticon-quality"></i>
                                </div>
                                <div class="mission-count">
                                    <h2><span class="odometer" data-count="379">00</span>+</h2>
                                    <span>Awards</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about-area-end -->

<!-- features-area -->
<section class="features-area theme-bg pt-100 pb-70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-70">
                    <span class="sub-title">Why Choose Us</span>
                    <h2 class="title">experience in setting up</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="features-wrap-item mb-30">
                    <div class="features-icon">
                        <i class="flaticon-shuttle"></i>
                    </div>
                    <div class="features-content">
                        <h5>Home Fast Delivery</h5>
                        <p>Lorem Ipsum simply dumm the printing and typesetting indust orem Ipsum has been the industry standard dummy men book.</p>
                        <div class="features-item-list">
                            <ul>
                                <li>Smart UHD TV</li>
                                <li>Snow Frost in Freezer</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="features-wrap-item mb-30">
                    <div class="features-icon">
                        <i class="flaticon-secure-payment"></i>
                    </div>
                    <div class="features-content">
                        <h5>Secure Payment</h5>
                        <p>Lorem Ipsum simply dumm the printing and typesetting indust orem Ipsum has been the industry standard dummy men book.</p>
                        <div class="features-item-list">
                            <ul>
                                <li>24/7 Support</li>
                                <li>Money back in 15 days</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="features-wrap-item mb-30">
                    <div class="features-icon">
                        <i class="flaticon-24-hours-support"></i>
                    </div>
                    <div class="features-content">
                        <h5>24/7 Customer Support</h5>
                        <p>Lorem Ipsum simply dumm the printing and typesetting indust orem Ipsum has been the industry standard dummy men book.</p>
                        <div class="features-item-list">
                            <ul>
                                <li>Smart UHD TV</li>
                                <li>Snow Frost in Freezer</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- features-area-end -->

<!-- testimonial-area -->
<section class="testimonial-area pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-60">
                    <span class="sub-title">Our testimonial</span>
                    <h2 class="title">happy customer quotes</h2>
                </div>
            </div>
        </div>
        <div class="row testimonial-active">
            <div class="col-xl-4">
                <div class="testimonial-item text-center">
                    <div class="testi-avatar-img mb-20">
                        <img src="img/images/testi_avatar01.png" alt="">
                    </div>
                    <div class="testi-avatar-info">
                        <h5>Emma Watson</h5>
                        <span>CEO of <strong>Amazon</strong></span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="testi-content">
                        <p>“ In promotion and advertising, a testimonial show consists of a person's written spoken
                            statement extolling the virtue
                            of a product ”</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="testimonial-item text-center">
                    <div class="testi-avatar-img mb-20">
                        <img src="img/images/testi_avatar02.png" alt="">
                    </div>
                    <div class="testi-avatar-info">
                        <h5>Janet Jackson</h5>
                        <span>CEO of <strong>Amazon</strong></span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="testi-content">
                        <p>“ In promotion and advertising, a testimonial show consists of a person's written spoken
                            statement extolling the virtue
                            of a product ”</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="testimonial-item text-center">
                    <div class="testi-avatar-img mb-20">
                        <img src="img/images/testi_avatar03.png" alt="">
                    </div>
                    <div class="testi-avatar-info">
                        <h5>Anddy Willam</h5>
                        <span>CEO of <strong>Amazon</strong></span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="testi-content">
                        <p>“ In promotion and advertising, a testimonial show consists of a person's written spoken
                            statement extolling the virtue
                            of a product ”</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="testimonial-item text-center">
                    <div class="testi-avatar-img mb-20">
                        <img src="img/images/testi_avatar04.png" alt="">
                    </div>
                    <div class="testi-avatar-info">
                        <h5>Emma Watson</h5>
                        <span>CEO of <strong>Amazon</strong></span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="testi-content">
                        <p>“ In promotion and advertising, a testimonial show consists of a person's written spoken
                            statement extolling the virtue
                            of a product ”</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial-area-end -->
@endsection
