<!-- Scroll-top -->
<button class="scroll-top scroll-to-target" data-target="html">
    <i class="fas fa-angle-up"></i>
</button>
<!-- Scroll-top-end-->

<!-- header-area -->
<header class="header-style-two {{ Route::is('home') ? '' : 'header-style-three' }}">

    <!-- header-top -->
    <div class="header-top-area">
        <div class="custom-container-two">
            <div class="row">
                <div class="col-md-8 col-sm-7">
                    <div class="header-top-left">
                        <ul>
                            <li>
                                <div class="heder-top-guide">
                                    <span>Quick Guide</span>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Help
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="terms-conditios.html">Returns</a>
                                            <a class="dropdown-item" href="terms-conditios.html">Privacy</a>
                                            <a class="dropdown-item" href="terms-conditios.html">Terms</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <li>
                                <div class="heder-top-guide">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton3"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Sell With Us
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item" href="my-account.html">Seller Login</a>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-5">
                    <div class="header-top-right">
                        <ul>
                            @if (!Auth::check())
                                <li>
                                    <a href="{{ route('register') }}"><i class="flaticon-user"></i>Enregistrement</a>
                                    <span>or</span>
                                    <a href="{{ route('login') }}">Connexion</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('register') }}">
                                        <i class="flaticon-user"></i>Mon compte</a>
                                        <span>/</span>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i class="flaticon-logout"></i>Deconnexion
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-top-end -->

    <!-- menu-area -->
    <div id="sticky-header" class="main-header menu-area">
        <div class="custom-container-two">
            <div class="row">
                <div class="col-12">
                    <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                    <div class="menu-wrap">
                        <nav class="menu-nav show">
                            <div class="logo">
                                <a href="index.html"><img src="{{ asset('assets/img/logo/logosynapse.png') }}"
                                        width="100" alt="Logo"></a>
                            </div>
                            <div class="navbar-wrap main-menu d-none d-lg-flex">
                                <ul class="navigation">
                                    <li class="{{ isActive('home') }} dropdown"><a
                                            href="{{ route('home') }}">Accueil</a></li>
                                    <li class="{{ isActive('about') }}"><a href="{{ route('about') }}">A propos</a></li>
                                    <li class="{{ isActive('branches') }}"><a href="{{ route('branches') }}">Nos
                                            branches</a></li>
                                    <li class="{{ isActive('shop') }}"><a href="{{ route('shop') }}">Nos produits</a>
                                    </li>
                                    <li class="{{ isActive('contact') }}"><a
                                            href="{{ route('contact') }}">contacts</a></li>
                                </ul>
                            </div>
                            <div class="header-action  d-md-block">
                                <ul>
                                    {{-- @dd(session()->get('cart_detail')) --}}
                                    <li class="header-shop-cart">
                                        <a href="{{ route('favories') }}">
                                            <i class="flaticon-heart"></i>
                                            <span class="cart-count favoriteCount" style="background: green">
                                                {{ isset($favorites) && !empty($favorites) ? $favorites[1]['favorites_count'] : 0 }}
                                            </span>
                                        </a>
                                    </li>
                                    <li class="header-shop-cart">
                                        <a href="{{ route('cart') }}">
                                            <i class="flaticon-shopping-bag"></i>
                                            <span class="cart-count count">
                                                {{-- {{ count(session()->get('cart')['items']) }} --}}
                                            </span>
                                        </a>
                                        <span class="cart-total-price">
                                            {{-- {{!empty(session()->get('cart_detail'))?formatPrix(session()->get('cart_detail')['sub_total']):"" }} --}}
                                        </span>
                                        <ul class="minicart">
                                            {{-- @forelse (session()->get("cart_detail")["items"] as $item)
                                                <li class="d-flex align-items-start">
                                                    <div class="cart-img">
                                                        <a
                                                            href="{{ route('showProduct', ['slug' => $item['product']['slug']]) }}">
                                                            <img src="{{ asset($item['product']['imageUrls'][0]) }}"
                                                                width="100" height="100" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="cart-content">
                                                        <h4>
                                                            <a
                                                                href="{{ route('showProduct', ['slug' => $item['product']['slug']]) }}">{{ $item['product']['name'] }}</a>
                                                        </h4>
                                                        <div class="cart-price">
                                                            <span
                                                                class="new">{{ formatPrix($item['product']['soldePrice']) }}</span>
                                                            <span>
                                                                <del>{{ formatPrix($item['product']['prix']) }}</del>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="del-icon">
                                                        <a
                                                            href="{{ route('cart.remove', ['id' => $item['product']['id'], 'qty' => $item['quantity']]) }}">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            @empty
                                            @endforelse
                                            <li>
                                                <div class="total-price">
                                                    <span class="f-left">Total:</span>
                                                    <span
                                                        class="f-right">{{ formatPrix(session()->get('cart_detail')['sub_total']) }}</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkout-link">
                                                    <a href="#">Shopping Cart</a>
                                                    <a class="red-color" href="#">Checkout</a>
                                                </div>
                                            </li> --}}
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Mobile Menu  -->
                    <div class="mobile-menu">
                        <div class="menu-backdrop"></div>
                        <div class="close-btn"><i class="fas fa-times"></i></div>

                        <nav class="menu-box">
                            <div class="nav-logo"><a href="index.html"><img
                                        src="{{ asset('assets/img/logo/logosynapse.png') }}" alt=""
                                        title=""></a>
                            </div>
                            <div class="menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="social-links">
                                <ul class="clearfix">
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- End Mobile Menu -->
                </div>
            </div>
        </div>
    </div>
    <!-- menu-area-end -->

    <!-- header-search-area -->
    <div class="header-search-area d-none d-md-block">
        <div class="custom-container-two">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                    <div class="header-category d-none d-lg-block">
                        <a href="#" class="cat-toggle"><i class="flaticon-menu"></i>Branches</a>
                        <ul class="category-menu">
                            @forelse ($branches as $b)
                                <li class="has-dropdown">
                                    <a href="#">
                                        <div class="cat-menu-img">
                                            <img src="{{ $b->vignette }}" width="38" height="38"
                                                alt="">
                                        </div> {{ $b->name }}
                                    </a>
                                    <ul class="mega-menu">
                                        @forelse ($b->category->take(3) as $cat)
                                            <li>
                                                <ul>
                                                    <li class="dropdown-title">{{ $cat->name }}
                                                    </li>
                                                    @forelse ($cat->produits as $p)
                                                        <li><a href="#">{{ $p->name }}</a></li>
                                                    @empty
                                                    @endforelse
                                                </ul>
                                            </li>

                                        @empty
                                        @endforelse

                                    </ul>
                                </li>
                            @empty

                            @endforelse

                            {{-- <li class="has-dropdown"><a href="#"><div class="cat-menu-img"><img src="{{ asset('assets/img/product/category_menu_img02.png') }}" alt=""></div> TV, Appliances</a>
                                        <ul class="mega-menu">
                                            <li>
                                                <ul>
                                                    <li class="dropdown-title">Accessories & Parts</li>
                                                    <li><a href="#">Cables & Adapters</a></li>
                                                    <li><a href="#">Batteries</a></li>
                                                    <li><a href="#">Chargers</a></li>
                                                    <li><a href="#">Bags & Cases</a></li>
                                                </ul>
                                                <ul>
                                                    <li class="dropdown-title">Electronic Cigarettes</li>
                                                    <li><a href="#">Audio & Video</a></li>
                                                    <li><a href="#">Televisions</a></li>
                                                    <li><a href="#">TV Receivers</a></li>
                                                    <li><a href="#">Projectors</a></li>
                                                    <li><a href="#">Audio Amplifier Boards</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <ul>
                                                    <li class="dropdown-title">Smart Electronics</li>
                                                    <li><a href="#">Cables & Adapters</a></li>
                                                    <li><a href="#">Batteries</a></li>
                                                    <li><a href="#">Chargers</a></li>
                                                    <li><a href="#">Bags & Cases</a></li>
                                                </ul>
                                                <ul>
                                                    <li class="dropdown-title">Portable Audio & Video</li>
                                                    <li><a href="#">Audio & Video</a></li>
                                                    <li><a href="#">Televisions</a></li>
                                                    <li><a href="#">TV Receivers</a></li>
                                                    <li><a href="#">Projectors</a></li>
                                                    <li><a href="#">Audio Amplifier Boards</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <ul>
                                                    <li class="dropdown-title">Accessories & Parts</li>
                                                    <li><a href="#">Cables & Adapters</a></li>
                                                    <li><a href="#">Batteries</a></li>
                                                    <li><a href="#">Chargers</a></li>
                                                    <li><a href="#">Bags & Cases</a></li>
                                                </ul>
                                                <ul>
                                                    <li class="dropdown-title">Audio & Video</li>
                                                    <li class="mega-menu-banner"><a href="#"><img src="{{ asset('assets/img/images/megamenu_banner.jpg') }}" alt=""></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="shop-left-sidebar.html"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img03.png" alt=""></div> Baby Product</a></li>
                                    <li><a href="shop-left-sidebar.html"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img04.png" alt=""></div> Grocery Product</a></li>
                                    <li><a href="shop-left-sidebar.html"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img05.png" alt=""></div> Beauty, Health Product</a></li>
                                    <li><a href="shop-left-sidebar.html"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img06.png" alt=""></div> Industrial Product</a></li>
                                    <li><a href="shop-left-sidebar.html"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img07.png" alt=""></div> Car, Motorbike</a></li>
                                    <li><a href="shop-left-sidebar.html"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img08.png" alt=""></div> Club Sports</a></li>
                                    <li>
                                        <ul class="more_slide_open">
                                            <li><a href="#"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img01.png" alt=""></div> Western woman</a></li>
                                            <li><a href="#"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img02.png" alt=""></div> Health Product</a></li>
                                            <li><a href="#"><div class="cat-menu-img"><img src="assets/img/product/category_menu_img03.png" alt=""></div> Industrial Product</a></li>
                                        </ul>
                                    </li>
                                    <li class="more_categories">More Categories<i class="fas fa-angle-down"></i></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                        <div class="header-search-wrap">
                            <form action="#">
                                <input type="text" placeholder="Search for your item's type.....">
                                <select class="custom-select">
                                    <option selected="">Toutes Categories</option>
                                    @forelse ($categories->take(10) as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <button><i class="flaticon-magnifying-glass-1"></i></button>
                            </form>
                        </div>
                        <div class="header-free-shopping">
                            <p>Livraison gratuite à partir de <span>$10+</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-search-area-end -->

</header>
<!-- header-area-end -->
