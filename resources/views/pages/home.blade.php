@extends('layouts.template', ['titre' => 'Accueil'])

@section('style')
@endsection

@section('content')
    <!-- main-area -->
    <main> <!-- slider-area -->
        <section class="second-slider-area" data-background="{{ asset('assets/img/slider/slider_bg.jpg') }} ">
            <div class="custom-container-two">
                <div class="row justify-content-end">
                    <div class="col-xl-10">
                        <div class="slider-active">
                            <div class="single-slider slider-bg" data-background="{{ asset('assets/img/slider/4.jpg') }}">
                                <div class="slider-content">
                                    <h5 data-animation="fadeInUp" data-delay=".3s">Agent Bancaire</h5>
                                    <h2 data-animation="fadeInUp" data-delay=".6s">Des services bancaires à la pointe !</h2>
                                    <p data-animation="fadeInUp" data-delay=".9s">
                                        Profitez de solutions bancaires modernes avec nos cartes VISA, en partenariat avec
                                        ECOBANK.
                                        Sécurisées, accessibles et adaptées à vos besoins, elles simplifient vos
                                        transactions au quotidien.
                                    </p>
                                    <a href="services.html" class="btn yellow-btn" data-animation="fadeInUp"
                                        data-delay="1s">Découvrir nos services</a>
                                </div>
                            </div>
                            <div class="single-slider slider-bg"
                                data-background="{{ asset('assets/img/slider/slide1.jpg') }} ">
                                <div class="slider-content">
                                    <h5 data-animation="fadeInUp" data-delay=".3s">Bienvenue chez Groupe Synapse </h5>
                                    <h2 data-animation="fadeInUp" data-delay=".6s" class="mt-10">La solution à votre portée
                                        !!!</h2>
                                    <a href="{{ route('shop') }}" class="btn yellow-btn" data-animation="fadeInUp"
                                        data-delay="1s">Voir nos produits</a>
                                </div>
                            </div>
                            <div class="single-slider slider-bg"
                                data-background="{{ asset('assets/img/slider/slide2.jpg') }}">
                                <div class="slider-content">
                                    <h5 data-animation="fadeInUp" data-delay=".3s">Nos services</h5>
                                    <h2 data-animation="fadeInUp" data-delay=".6s">Solutions digitales</h2>
                                    <p data-animation="fadeInUp" data-delay=".9s">
                                        Entreprise spécialisée dans le digital et les services aux clients,
                                        opérant dans divers secteurs pour offrir des solutions innovantes et
                                        adaptées aux besoins du marché.
                                    </p>
                                    <a href="shop-left-sidebar.html" class="btn yellow-btn" data-animation="fadeInUp"
                                        data-delay="1s">En savoir plus</a>
                                </div>
                            </div>

                            <div class="single-slider slider-bg"
                                data-background="{{ asset('assets/img/slider/slide3.jpg') }}">
                                <div class="slider-content">
                                    <h5 data-animation="fadeInUp" data-delay=".3s">Innovation digitale</h5>
                                    <h2 data-animation="fadeInUp" data-delay=".6s">L’essentiel du digital !</h2>
                                    <p data-animation="fadeInUp" data-delay=".9s">
                                        Nous aidons votre entreprise à devenir agile,
                                        proactive et innovante grâce à la conception d'expériences numériques
                                        et à des services digitaux gérés dans le Cloud.
                                    </p>
                                    <a href="services.html" class="btn yellow-btn" data-animation="fadeInUp"
                                        data-delay="1s">Découvrir nos services</a>
                                </div>
                            </div>
                            <div class="single-slider slider-bg" data-background="{{ asset('assets/img/slider/5.jpg') }}">
                                <div class="slider-content">
                                    <h5 data-animation="fadeInUp" data-delay=".3s">Technologie & Innovation</h5>
                                    <h2 data-animation="fadeInUp" data-delay=".6s">Le meilleur de l'informatique et de la
                                        téléphonie !</h2>
                                    <p data-animation="fadeInUp" data-delay=".9s">
                                        Découvrez une large gamme d’ordinateurs, d’accessoires high-tech et de smartphones.
                                        Des produits de qualité aux meilleurs prix pour booster votre productivité et votre
                                        connectivité.
                                    </p>
                                    <a href="services.html" class="btn yellow-btn" data-animation="fadeInUp"
                                        data-delay="1s">Voir nos produits</a>
                                </div>
                            </div>
                            <div class="single-slider slider-bg" data-background="{{ asset('assets/img/slider/rep.jpg') }}">
                                <div class="slider-content">
                                    <h5 data-animation="fadeInUp" data-delay=".3s">Réparation Express</h5>
                                    <h2 data-animation="fadeInUp" data-delay=".6s">Donnez une seconde vie à votre smartphone
                                        !</h2>
                                    <p data-animation="fadeInUp" data-delay=".9s">
                                        Écran cassé, batterie faible ou problème de performance ?
                                        Nos experts réparent votre téléphone rapidement avec des pièces de qualité, pour une
                                        utilisation optimale.
                                    </p>
                                    <a href="services.html" class="btn yellow-btn" data-animation="fadeInUp"
                                        data-delay="1s">Voir nos services</a>
                                </div>
                            </div>
                            <div class="single-slider slider-bg"
                                data-background="{{ asset('assets/img/slider/telp.jpg') }}">
                                <div class="slider-content">
                                    <h5 data-animation="fadeInUp" data-delay=".3s">Smartphones & Accessoires</h5>
                                    <h2 data-animation="fadeInUp" data-delay=".6s">Les meilleures marques, aux meilleurs
                                        prix !</h2>
                                    <p data-animation="fadeInUp" data-delay=".9s">
                                        Découvrez notre sélection de smartphones dernier cri et d’accessoires
                                        indispensables.
                                        Qualité, performance et prix imbattables pour une expérience mobile sans compromis.
                                    </p>
                                    <a href="shop.html" class="btn yellow-btn" data-animation="fadeInUp"
                                        data-delay="1s">Voir nos produits</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider-area-end -->

        <!-- top-cat-banner -->
        <div class="top-cat-banner-area">
            <div class="custom-container-two">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="top-cat-banner-item mt-30">
                            <a href="shop-left-sidebar.html">
                                <img src="{{ asset('assets/img/images/1.jpg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="top-cat-banner-item mt-30">
                            <a href="shop-left-sidebar.html"><img src="{{ asset('assets/img/images/2.jpg') }}"
                                    alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="top-cat-banner-item mt-30">
                            <a href="shop-left-sidebar.html"><img src="{{ asset('assets/img/images/3.jpg') }}"
                                    alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- top-cat-banner-end -->

        <!-- exclusive-collection-area -->
        {{-- <section class="exclusive-collection pt-100 pb-60">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center section-title mb-60">
                            <span class="sub-title">collection exclusive</span>
                            <h2 class="title">produits les plus vendus</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-12">
                        <div class="product-menu mb-60">
                            <button class="active" data-filter="*">Toutes</button>
                            @foreach ($groupedProducts as $groupe => $products)
                                <button
                                    data-filter="{{ '.' . Str::replaceFirst(' ', '-', $groupe) }}">{{ $groupe }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row exclusive-active">
                    @foreach ($groupedProducts as $groupe => $products)
                        @foreach ($products->take(6) as $produit)
                            <div
                                class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer {{ Str::replaceFirst(' ', '-', $groupe) }}">
                                <div class="mb-40 exclusive-item exclusive-item-two">
                                    <div class="exclusive-item-thumb">
                                        <a href="{{ route('showProduct', ['slug' => $produit->slug]) }}">
                                            <img src="{{ asset($produit->getImageUrlsAttribute()[0]) }}" alt=""
                                                width="278" height="290">
                                            <img class="overlay-product-thumb"
                                                src="{{ asset($produit->getImageUrlsAttribute()[1]) }}" alt=""
                                                width="278" height="290">

                                        </a>
                                        <span class="discount"{{ $produit->isSpecialOffer ? '' : ' hidden' }}>Solde</span>
                                        <span class="sd-meta"{{ $produit->isNewArivale ? '' : ' hidden' }}>New!</span>
                                        <a href="{{ route('cart.add', ['id' => $produit->id, 'qty' => 1]) }}"
                                            class="to-cart add-to-cart">Ajouter au panier <i
                                                class="fas fa-cart-plus"></i></a>
                                    </div>
                                    <div class="exclusive-item-content">
                                        <div class="exclusive--content--top">
                                            <div class="tag">
                                                <a
                                                    href="{{ route('showProduct', ['slug' => $produit->slug]) }}">{{ $produit->categories->pluck('name')->join(', ') }}</a>
                                            </div>
                                            <del class="old-price">
                                                {{ is_solde($produit->isSpecialOffer, $produit->prix, $produit->soldePrice, $produit->currency, 'solde') }}
                                            </del>
                                        </div>
                                        <div class="exclusive--content--bottom">
                                            <h5>
                                                <a
                                                    href="{{ route('showProduct', ['slug' => $produit->slug]) }}">{{ $produit->name }}</a>
                                            </h5>
                                            <span>
                                                {{ is_solde($produit->isSpecialOffer, $produit->prix, $produit->soldePrice, $produit->currency, 'normal') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </section> --}}
        <!-- exclusive-collection-area-end -->

        <!-- deal-of-the-day -->
        <section class="deal-of-the-day theme-bg pt-100 pb-70">
            <div class="custom-container-two">
                <div class="row">
                    <div class="custom-col-4">
                        <div class="deal-of-day-banner mb-30">
                            <a href="shop-left-sidebar.html">
                                <img src="{{ asset('assets/img/product/promo.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="custom-col-8">
                        <div class="deal-day-top">
                            <div class="deal-day-title">
                                <h4 class="title">Offre du jour</h4>
                            </div>
                            <div class="view-all-deal">
                                <a href="{{ route('services') }}"><i class="flaticon-scroll"></i> Tout voir</a>
                            </div>
                        </div>
                        <div class="row deal-day-active">
                            @forelse ($allServices as $cat)
                                <div class="col-xl-3">
                                    <div class="most-popular-viewed-item mb-30">
                                        <div class="viewed-item-top">
                                            <div class="mb-20 most--popular--item--thumb">
                                                <a href="shop-details.html"><img
                                                        src="{{ asset('assets/img/product/promo1.jpg') }}"
                                                        alt=""></a>
                                            </div>
                                            <div class="super-deal-content">
                                                <h6><a href="shop-details.html">{{ $cat->name }}</a></h6>
                                                <p>
                                                    {{ $cat->prix ? number_format($cat->prix, 2) . ' ' . $cat->currency : '' }}
                                                </p>

                                            </div>
                                        </div>
                                        <div class="viewed-item-bottom">
                                            {{-- <ul>
                                            <li>Total Sold : 25</li>
                                            <li>Stocks : 3456</li>
                                        </ul>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 25%;"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div> --}}
                                            <div class="viewed-offer-time">
                                                <p><span>Dépêchez-vous</span> Offre à durée limitée</p>
                                                {{-- <div class="coming-time" data-countdown="2020/9/20"></div> --}}
                                                <form action="{{ route('getService', ['slug' => $cat->slug]) }}"
                                                    method="GET">
                                                    <button type="submit" class="btn"
                                                        style="background: #FD0100">PROCEED TO CHECKOUT</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- deal-of-the-day-end -->

        <!-- best-cat-area -->
        {{-- <section class="best-cat-area">
            <div class="container">
                <div class="best-cat-border pt-100 pb-45">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center section-title mb-60">
                                <span class="sub-title">PARCOURIR LES CATÉGORIES</span>
                                <h2 class="title">PARCOURIR LES MEILLEURES CATÉGORIES</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="best-cat-list">
                                <div class="best-cat-item">
                                    <div class="best-cat-thumb">
                                        <a href="shop-left-sidebar.html"><img src="assets/img/product/b_cat_product01.png"
                                                alt=""></a>
                                    </div>
                                    <div class="best-cat-content">
                                        <h5><a href="shop-left-sidebar.html">fashion clothes</a></h5>
                                        <span>Women Fashion</span>
                                    </div>
                                </div>
                                <div class="best-cat-item">
                                    <div class="best-cat-thumb">
                                        <a href="shop-left-sidebar.html"><img src="assets/img/product/b_cat_product02.png"
                                                alt=""></a>
                                    </div>
                                    <div class="best-cat-content">
                                        <h5><a href="shop-left-sidebar.html">smart watch</a></h5>
                                        <span>Men Fashion</span>
                                    </div>
                                </div>
                                <div class="best-cat-item">
                                    <div class="best-cat-thumb">
                                        <a href="shop-left-sidebar.html"><img src="assets/img/product/b_cat_product03.png"
                                                alt=""></a>
                                    </div>
                                    <div class="best-cat-content">
                                        <h5><a href="shop-left-sidebar.html">Casual Shoes</a></h5>
                                        <span>Men Fashion</span>
                                    </div>
                                </div>
                                <div class="best-cat-item">
                                    <div class="best-cat-thumb">
                                        <a href="shop-left-sidebar.html"><img src="assets/img/product/b_cat_product04.png"
                                                alt=""></a>
                                    </div>
                                    <div class="best-cat-content">
                                        <h5><a href="shop-left-sidebar.html">Woman clothes</a></h5>
                                        <span>Woman Fashion</span>
                                    </div>
                                </div>
                                <div class="best-cat-item">
                                    <div class="best-cat-thumb">
                                        <a href="shop-left-sidebar.html"><img src="assets/img/product/b_cat_product05.png"
                                                alt=""></a>
                                    </div>
                                    <div class="best-cat-content">
                                        <h5><a href="shop-left-sidebar.html">hair removal</a></h5>
                                        <span>Woman Fashion</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- best-cat-area-end -->

        <!-- list-product-area -->
        {{-- <section class="list-product-area pt-100 pb-30">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-md-6 mb-50">
                        <div class="list-product-top">
                            <h4 class="title">Produits phares</h4>
                            <a href="shop-left-sidebar.html" class="view-all">Tout voir</a>
                        </div>
                        <div class="mb-20 list-product-item">
                            <div class="list-product-thumb">
                                <a href="shop-details.html"><img src="assets/img/product/list_product_thumb01.png"
                                        alt=""></a>
                            </div>
                            <div class="list-product-content">
                                <h6><a href="shop-details.html">Stylish Bag</a></h6>
                                <p>US $ 17.29<span>{ 50% off }</span></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span class="list-product-tag">New!</span>
                        </div>
                        <div class="mb-20 list-product-item">
                            <div class="list-product-thumb">
                                <a href="shop-details.html"><img src="assets/img/product/list_product_thumb02.png"
                                        alt=""></a>
                            </div>
                            <div class="list-product-content">
                                <h6><a href="shop-details.html">Party Dress</a></h6>
                                <p>US $ 21.99<span>{ 50% off }</span></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span class="list-product-tag">New!</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-50">
                        <div class="list-product-top">
                            <h4 class="title">Produits les mieux notés</h4>
                            <a href="shop-left-sidebar.html" class="view-all">Tout voir</a>
                        </div>
                        <div class="mb-20 list-product-item">
                            <div class="list-product-thumb">
                                <a href="shop-details.html"><img src="assets/img/product/list_product_thumb03.png"
                                        alt=""></a>
                            </div>
                            <div class="list-product-content">
                                <h6><a href="shop-details.html">Smart Watch</a></h6>
                                <p>US $ 17.29<span>{ 50% off }</span></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-20 list-product-item">
                            <div class="list-product-thumb">
                                <a href="shop-details.html"><img src="assets/img/product/list_product_thumb04.png"
                                        alt=""></a>
                            </div>
                            <div class="list-product-content">
                                <h6><a href="shop-details.html">Stylish Bag</a></h6>
                                <p>US $ 21.99<span>{ 50% off }</span></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span class="list-product-tag">Hot!</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-50">
                        <div class="list-product-top">
                            <h4 class="title">Produits la plus vendu</h4>
                            <a href="shop-left-sidebar.html" class="view-all">Tout voir</a>
                        </div>
                        <div class="mb-20 list-product-item">
                            <div class="list-product-thumb">
                                <a href="shop-details.html"><img src="assets/img/product/list_product_thumb05.png"
                                        alt=""></a>
                            </div>
                            <div class="list-product-content">
                                <h6><a href="shop-details.html">Web Camera s20</a></h6>
                                <p>US $ 17.29<span>{ 50% off }</span></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-20 list-product-item">
                            <div class="list-product-thumb">
                                <a href="shop-details.html"><img src="assets/img/product/list_product_thumb06.png"
                                        alt=""></a>
                            </div>
                            <div class="list-product-content">
                                <h6><a href="shop-details.html">Baby Toys</a></h6>
                                <p>US $ 21.99<span>{ 50% off }</span></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span class="list-product-tag">Hot!</span>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- list-product-area-end -->

        <!-- limited-offer-area -->
        <section class="limited-offer-area" data-background="assets/img/bg/limited_offer_bg.jpg">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-5 col-lg-6 col-md-7">
                        <div class="limited-offer-left">
                            <div class="limited-offer-title">
                                <span class="sub-title">exclusive offer</span>
                                <h2 class="title">Smart Watch Bracelet</h2>
                            </div>
                            <div class="limited-offer-disc">
                                <img src="assets/img/images/limited_offer_discount.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="limited-offer-action">
                            <a href="shop-left-sidebar.html" class="btn">Offre à durée limitée</a>
                            <div class="amount-info">
                                <span class="upto">UPTO</span>
                                <span class="amount">$ 50.00</span>
                                <span class="off">OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="limited-overlay-title">Vanam Top Sale 35<span>%</span></h2>
            <div class="limited-overlay-img"><img src="assets/img/images/limited_offer_img.png" alt=""></div>
        </section>
        <!-- limited-offer-area-end -->

    </main>
    <!-- main-area-end -->
@endsection

@section('script')
@endsection
