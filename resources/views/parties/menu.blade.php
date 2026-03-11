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
                                <div class="header-top-guide">
                                    <span>Guide rapide</span>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aide
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="retours.html">Retours</a>
                                            <a class="dropdown-item" href="politique-confidentialite.html">Politique de
                                                confidentialité</a>
                                            <a class="dropdown-item" href="conditions.html">Conditions d’utilisation</a>
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
                                <div class="header-top-left">
                                    <ul>
                                        <li>
                                            <div class="heder-top-guide">
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle" type="button"
                                                        id="dropdownMenuButton2" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="flaticon-user"></i> Mon compte
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Mon
                                                            profil</a>
                                                        <a class="dropdown-item" href="{{ route('mesAchats') }}">Mes
                                                            achats</a>
                                                        <a class="dropdown-item" href="#">Historiques</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <li>
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
                                <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo/logosynapse.png') }}"
                                        width="100" alt="Logo"></a>
                            </div>
                            <div class="navbar-wrap main-menu d-none d-lg-flex">
                                <ul class="navigation">
                                    <li class="{{ isActive('home') }}"><a href="{{ route('home') }}">Accueil</a></li>
                                    <li class="{{ isActive('about') }}"><a href="{{ route('about') }}">A propos</a></li>
                                    <li class="{{ isActive('shop') }}"><a href="{{ route('shop') }}">Produits</a></li>
                                    <li class="{{ isActive('services') }}"><a href="{{ route('services') }}">Services</a></li>
                                    <li class="{{ isActive('contact') }}"><a href="{{ route('contact') }}">Contacts</a></li>
                                </ul>
                            </div>
                            <div class="header-action">
                                <ul>
                                    {{-- @dd(session()->get('cart_detail')) --}}
                                    <li class="header-shop-cart">
                                        <a href="{{ route('favories') }}" style="display:inline-flex;align-items:center;justify-content:center;">
                                            <i class="flaticon-heart"></i>
                                            <span class="cart-count favoriteCount" style="background: green">
                                                {{ isset($favorites) && !empty($favorites) ? $favorites[1]['favorites_count'] : 0 }}
                                            </span>
                                        </a>
                                    </li>
                                    <li class="header-shop-cart">
                                        <a href="{{ route('cart') }}" style="display:inline-flex;align-items:center;justify-content:center;">
                                            <i class="flaticon-shopping-bag"></i>
                                            <span class="cart-count count">{{ Auth::check() ? ($cartCount ?? 0) : 0 }}</span>
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
                            <div class="nav-logo"><a href="{{ route('home') }}"><img
                                        src="{{ asset('assets/img/logo/logosynapse.png') }}" alt=""
                                        title=""></a>
                            </div>
                            <div class="mobile-menu-actions">
                                <a href="{{ route('favories') }}" class="mobile-menu-action-link">
                                    <i class="flaticon-heart"></i>
                                    <span>Favoris</span>
                                    <span class="cart-count favoriteCount" style="background: green">{{ isset($favorites) && !empty($favorites) ? $favorites[1]['favorites_count'] : 0 }}</span>
                                </a>
                                <a href="{{ route('cart') }}" class="mobile-menu-action-link">
                                    <i class="flaticon-shopping-bag"></i>
                                    <span>Panier</span>
                                    <span class="cart-count count">{{ Auth::check() ? ($cartCount ?? 0) : 0 }}</span>
                                </a>
                            </div>
                            <div class="menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="mobile-menu-category">
                                <div class="mobile-cat-title">Produit et Service</div>
                                <ul class="mobile-cat-list">
                                    @forelse ($branches as $b)
                                        <li class="dropdown">
                                            @php
                                                $firstCategorie = $b->categorie->first();
                                                $hasVignette = !empty($b->vignette) && vignetteExists($b->vignette);
                                            @endphp
                                            <a href="{{ ($firstCategorie && $firstCategorie->type == 'service') ? route('services') : route('shop') }}">{{ $b->name }}</a>
                                            @if ($b->categorie->where('isActive', true)->isNotEmpty())
                                                <div class="dropdown-btn"><span class="fas fa-angle-down"></span></div>
                                                <ul class="mobile-cat-sublist">
                                                    @foreach ($b->categorie->where('isActive', true) as $cat)
                                                        <li><span class="mobile-cat-name">{{ $cat->name }}</span></li>
                                                        @if ($cat->type == 'produit')
                                                            @foreach ($cat->produits->where('isAvalable', true)->take(6) as $p)
                                                                <li><a href="{{ route('showProduct', ['slug' => $p->slug]) }}">{{ $p->name }}</a></li>
                                                            @endforeach
                                                            @if ($cat->produits->where('isAvalable', true)->count() > 6)
                                                                <li><a href="{{ route('shop', ['categorie' => $cat->id]) }}">Voir tout</a></li>
                                                            @endif
                                                        @elseif ($cat->type == 'service')
                                                            @foreach ($cat->services->where('active', true)->where('disponible', true)->take(6) as $s)
                                                                <li><a href="{{ route('showService', ['slug' => $s->slug]) }}">{{ $s->name }}</a></li>
                                                            @endforeach
                                                            @if ($cat->services->where('active', true)->where('disponible', true)->count() > 6)
                                                                <li><a href="{{ route('services', ['categorie' => $cat->id]) }}">Voir tout</a></li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @empty
                                        <li><a href="{{ route('shop') }}">Nos Produits</a></li>
                                        <li><a href="{{ route('services') }}">Nos Services</a></li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="mobile-menu-search">
                                <form action="{{ route('shop') }}" method="get">
                                    <input type="text" name="q" placeholder="Rechercher...">
                                    <button type="submit"><i class="flaticon-magnifying-glass-1"></i></button>
                                </form>
                            </div>
                            <div class="social-links">
                                <ul class="clearfix">
                                    <li><a href="https://www.facebook.com/share/19VybRAMhZ/" target="_blank">
                                            <span class="fab fa-facebook-square"></span></a></li>

                                    <li><a href="https://www.instagram.com/synapsegroupe4/profilecard/?igsh=dWE1bmpjcWs0dzV3"
                                            target="_blank">
                                            <span class="fab fa-instagram"></span></a></li>
                                    <li><a href="https://youtube.com/@synapsegroupe4?si=HvROIEpTMpCmcr6R"
                                            target="_blank">
                                            <span class="fab fa-youtube"></span></a></li>
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
                        <a href="#" class="cat-toggle"><i class="flaticon-menu"></i>Produit et Service</a>
                        <ul class="category-menu">
                            @forelse ($branches as $b)
                                <li class="has-dropdown">
                                    @php
                                        $firstCategorie = $b->categorie->first();
                                        $hasVignette = !empty($b->vignette) && vignetteExists($b->vignette);
                                    @endphp

                                    @if ($firstCategorie && $firstCategorie->type == 'service')
                                        <a href="{{ route('services') }}" style="display:flex;align-items:center;gap:8px;">
                                            <div class="cat-menu-img" style="width:38px;height:38px;display:flex;align-items:center;justify-content:center;background:#e9ecef;border-radius:4px;overflow:hidden;flex-shrink:0;">
                                                @if($hasVignette)
                                                    <img src="{{ asset('storage/' . $b->vignette) }}" width="38" height="38" alt="" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                    <span style="display:none;font-weight:bold;font-size:14px;color:#495057;">{{ getInitials($b->name) }}</span>
                                                @else
                                                    <span style="font-weight:bold;font-size:14px;color:#495057;">{{ getInitials($b->name) }}</span>
                                                @endif
                                            </div>
                                            <span>{{ $b->name }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('shop') }}" style="display:flex;align-items:center;gap:8px;">
                                            <div class="cat-menu-img" style="width:38px;height:38px;display:flex;align-items:center;justify-content:center;background:#e9ecef;border-radius:4px;overflow:hidden;flex-shrink:0;">
                                                @if($hasVignette)
                                                    <img src="{{ asset('storage/' . $b->vignette) }}" width="38" height="38" alt="" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                    <span style="display:none;font-weight:bold;font-size:14px;color:#495057;">{{ getInitials($b->name) }}</span>
                                                @else
                                                    <span style="font-weight:bold;font-size:14px;color:#495057;">{{ getInitials($b->name) }}</span>
                                                @endif
                                            </div>
                                            <span>{{ $b->name }}</span>
                                        </a>
                                    @endif

                                    @if ($b->categorie->isNotEmpty())
                                        <ul class="mega-menu">
                                            @forelse ($b->categorie->where('isActive', true) as $cat)
                                                <li class="mega-menu-column">
                                                    <span class="dropdown-title">{{ $cat->name }}</span>
                                                    <ul class="category-items">
                                                        @if ($cat->type == 'produit')
                                                            @foreach ($cat->produits as $p)
                                                                {{-- @if ($p->categorie_id == $cat->id) --}}
                                                                {{-- 🔐 sécurité --}}
                                                                <li><a
                                                                        href="{{ route('showProduct', ['slug' => $p->slug]) }}">{{ $p->name }}</a>
                                                                </li>
                                                                {{-- @endif --}}
                                                            @endforeach
                                                        @elseif ($cat->type == 'service')
                                                            @foreach ($cat->services as $s)
                                                                {{-- 🔐 sécurité --}}
                                                                <li><a
                                                                        href="{{ route('showService', ['slug' => $s->slug]) }}">{{ $s->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <li><em>Aucun élément disponible</em></li>
                                                        @endif
                                                    </ul>
                                                </li>
                                            @empty
                                                <li><em>Pas de catégories disponibles</em></li>
                                            @endforelse
                                        </ul>
                                    @endif
                                </li>
                            @empty

                            @endforelse


                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                        <div class="header-search-wrap" id="global-search-wrap" style="position:relative;">
                            <form action="{{ route('shop') }}" method="get" id="search-form">
                                <input type="text" id="global-search-input" name="q" placeholder="Rechercher produits, services..." autocomplete="off">
                                <button type="submit"><i class="flaticon-magnifying-glass-1"></i></button>
                            </form>
                            <div id="search-results-dropdown" style="display:none;position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #ddd;border-radius:4px;box-shadow:0 4px 12px rgba(0,0,0,0.15);max-height:400px;overflow-y:auto;z-index:9999;margin-top:4px;"></div>
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
