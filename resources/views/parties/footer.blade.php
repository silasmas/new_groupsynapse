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
                        <div id="newsletter-error" style="display:none;" class="alert alert-danger mt-3"></div>
                        <div id="newsletter-success" style="display:none;" class="alert alert-success mt-3">
                            Merci pour votre inscription !
                        </div>
                    </div>
                </div>


            </div>
            {{-- <div class="footer-alphabet mb-55">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-0 text-left newsletter-title">
                            <h4>Find Out More :</h4>
                            <span>Browse Alphabetically :</span>
                            <span><a href="#">A</a></span>
                            <span><a href="#">B</a></span>
                            <span><a href="#">C</a></span>
                            <span><a href="#">D</a></span>
                            <span><a href="#">E</a></span>
                            <span><a href="#">F</a></span>
                            <span><a href="#">G</a></span>
                            <span><a href="#">H</a></span>
                            <span><a href="#">I</a></span>
                            <span><a href="#">J</a></span>
                            <span><a href="#">K</a></span>
                            <span><a href="#">L</a></span>
                            <span><a href="#">M</a></span>
                            <span><a href="#">N</a></span>
                            <span><a href="#">O</a></span>
                            <span><a href="#">P</a></span>
                            <span><a href="#">Q</a></span>
                            <span><a href="#">R</a></span>
                            <span><a href="#">S</a></span>
                            <span><a href="#">T</a></span>
                            <span><a href="#">U</a></span>
                            <span><a href="#">V</a></span>
                            <span><a href="#">W</a></span>
                            <span><a href="#">X</a></span>
                            <span><a href="#">Y</a></span>
                            <span><a href="#">Z</a></span>
                            <span><a href="#">0~9</a></span>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                {{-- <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li> --}}
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
                                <li><i class="fas fa-map-marker-alt"></i> W898 RTower Stat, Suite 56
                                    Brockland, CA 9622 United States</li>
                                <li><i class="fas fa-headphones"></i> 458-965-3224</li>
                                <li><i class="fas fa-envelope-open"></i>Support@info.Com</li>
                                <li><i class="fas fa-fax"></i>458-965-3224</li>
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
