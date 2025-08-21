   <!-- limited-offer-area -->
        <section class="limited-offer-area" data-background="assets/img/bg/limited_offer_bg.jpg">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-5 col-lg-6 col-md-7">
                        <div class="limited-offer-left">
                            <div class="limited-offer-title">
                                {{-- <span class="sub-title">exclusive offer</span>
                                <h2 class="title">Smart Watch Bracelet</h2> --}}
                            </div>
                            <div class="limited-offer-disc">
                                {{-- <img src="assets/img/images/limited_offer_discount.png" alt=""> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="limited-offer-action">
                            {{-- <a href="shop-left-sidebar.html" class="btn">Offre à durée limitée</a>
                            <div class="amount-info">
                                <span class="upto">UPTO</span>
                                <span class="amount">$ 50.00</span>
                                <span class="off">OFF</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <h2 class="limited-overlay-title">Vanam Top Sale 35<span>%</span></h2>
            <div class="limited-overlay-img"><img src="assets/img/images/limited_offer_img.png" alt=""></div> --}}
        </section>
        <!-- limited-offer-area-end -->

<!-- footer-area -->
<footer class="footer-area">
    <div class="footer-top pt-65 pb-25">
        <div class="container">
            <div class="footer-newsletter-wrap footer-newsletter-two">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-6">
                        <div class="newsletter-title">
                            <h4>Inscrivez-vous maintenant !</h4>
                            <span>Recevez nos nouveautés en vous abonnant à la newsletter.</span>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="newsletter-form">
                            <form id="newsletter-form">
                                @csrf
                                <input type="email" name="email" placeholder="Entrez votre adresse email..."
                                    required>
                                <button class="btn yellow-btn" type="submit">S'abonner</button>
                            </form>
                        </div>
                        <!-- Message de succès -->
                        <div id="newsletter-error" style="display:none;" class="mt-3 alert alert-danger"></div>
                        <div id="newsletter-success" style="display:none;" class="mt-3 alert alert-success">
                            Merci pour votre inscription !
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget mb-50">
                        <div class="footer-logo mb-30">
                            <a href="index.html"><img width="100"
                                    src="{{ asset('assets/img/logo/logosynapse.png') }}" alt=""></a>
                        </div>
                        <div class="footer-text mb-35">
                            <p>Nous visons à transformer les potentiels de la RDC et de l'Afrique en richesse stable et
                                durable au travers nos différents secteurs d’activités. </p>
                        </div>
                        <div class="footer-social">
                            <ul>
                                <li><a href="https://www.facebook.com/share/19VybRAMhZ/" target="_blank">
                                    <i class="fab fa-facebook-f" ></i></a></li>
                                <li><a href="https://www.instagram.com/synapsegroupe4/profilecard/?igsh=dWE1bmpjcWs0dzV3" target="_blank">
                                    <i class="fab fa-instagram" ></i></a></li>
                                <li><a href="https://youtube.com/@synapsegroupe4?si=HvROIEpTMpCmcr6R" target="_blank">
                                    <i class="fab fa-youtube" ></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-2 col-lg-3 col-sm-6">
                    <div class="footer-widget mb-50">
                        <div class="fw-title mb-35">
                            <h5>Service client</h5>
                        </div>
                        <div class="fw-link">
                            <ul>
                                <li><a href="#">Help Center</a></li>
                                <li><a href="#">Returns</a></li>
                                <li><a href="#">Product Recalls</a></li>
                                <li><a href="#">Accessibility</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
                <div class="col-xl-2 col-lg-3 col-sm-6">
                    <div class="footer-widget mb-50">
                        <div class="fw-title mb-35">
                            <h5>Liens rapides</h5>
                        </div>
                        <div class="fw-link">
                            <ul>
                                <li><a href="{{ route('about') }}">Apropos</a></li>
                                <li><a href="{{ route('shop') }}">Nos produits</a></li>
                                <li><a href="{{ route('services') }}">Nos services</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="footer-widget mb-50">
                        <div class="fw-title mb-35">
                            <h5>Nous avoir</h5>
                        </div>
                        <div class="footer-contact">
                            <ul>
                                <li><i class="fas fa-map-marker-alt">
                                    </i>Local 81, Immeuble Botour, Avenue  de la presse, Kinshasa / Gombe</li>
                                <li><i class="fas fa-headphones"></i>+243 99 99 30 158</li>
                                <li><i class="fas fa-envelope-open"></i>info@groupsynapse.ord</li>
                                <li><i class="fas fa-fax"></i> +243 81 99 01 290</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap copyright-style-two">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright-text">
                        <p>Copyright © 2024 <a href="#">Groupsynapse</a> Tous droits réservés. Designed by <a
                                href="silasmas.com" target="blank">SDEV</a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 d-none d-md-block">
                    <div class="text-right payment-method-img">
                        <img src="{{ asset('assets/img/images/p-ways.png') }}" width="200" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-area-end -->
