@extends('layouts.template')

@if ($produit->isProduct==false)
    @section('content')
        @include('parties.banner', [
            'page' => 'Détails du produit',
            'breadcrumb' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Nos produits', 'url' => route('shop')],
                ['label' => 'Détails du produit', 'url' => null]
            ]
        ])
          <!-- shop-details-area -->
          <section class="shop-details-area pt-100 pb-50">
            <div class="container">
                <div class="row mb-95">
                    <div class="col-xl-7 col-lg-6">
                        @php
                            $detailImages = $produit->getImageUrlsAttribute();
                            $detailInitials = getInitials($produit->name);
                        @endphp
                        <div class="shop-details-nav-wrap">
                            <div class="shop-details-nav">
                                @forelse ($detailImages as $p)
                                    <div class="shop-nav-item">
                                        <div style="position:relative;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:6px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                            <img src="{{ $p }}" alt="" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <span style="display:none;font-weight:bold;font-size:1.2rem;color:white;">{{ $detailInitials }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="shop-nav-item">
                                        <div style="aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                            <span style="font-weight:bold;font-size:1.2rem;color:white;">{{ $detailInitials }}</span>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="shop-details-img-wrap">
                            <div class="shop-details-active">
                                @forelse ($detailImages as $p)
                                    <div class="shop-details-img">
                                        <div style="position:relative;width:100%;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                            <a href="{{ $p }}" class="popup-image">
                                                <img src="{{ $p }}" alt="" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <span style="display:none;font-weight:bold;font-size:3rem;color:white;">{{ $detailInitials }}</span>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="shop-details-img">
                                        <div style="width:100%;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                            <span style="font-weight:bold;font-size:3rem;color:white;">{{ $detailInitials }}</span>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                    <div class="shop-details-content">
                            <span class="stock-info">{{ $produit->isAvalable ? 'Disponible' : 'En rupture' }}</span>
                            <h2>{{ $produit->name }}</h2>
                            @php
                                $avgRating = round($produit->avg_rating ?? 0);
                                $avgRating = max(0, min(5, $avgRating));
                                $commentsCount = $produit->comments()->count();
                            @endphp
                            <div class="shop-details-review mb-3">
                                <div class="rating d-inline-block">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $avgRating ? '' : '-o' }} {{ $i <= $avgRating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                                <span class="ml-2">- {{ $commentsCount }} {{ $commentsCount <= 1 ? 'avis' : 'avis' }}</span>
                            </div>
                            <div class="shop-details-price">
                                <h2>
                                    {!! formatPrix2($produit->isSpecialOffer, $produit->prix, $produit->soldePrice, $produit->currency) !!}
                                </h2>
                            </div>
                            <p>{{ $produit->description }}</p>

                            <div class="perched-info">
                                <div class="cart-plus">
                                    <form action="#">
                                        <div class="cart-plus-minus plusbtn" id="cart-plus-minus">
                                            <div class="dec qtybutton qtybuttonb">-</div>
                                            <input type="text" value="1">
                                            <div class="inc qtybutton qtybuttonb">+</div>
                                        </div>
                                    </form>
                                </div>
                                <a href="{{ route('cart.add', ['id' => $produit->id, 'qty' => 1]) }}"
                                    data-id="{{ $produit->id }}" class="btn add-card-btn add-to-cart-btn">Ajouter au panier</a>
                            </div>
                            <div class="shop-details-bottom">
                                <h5>
                                    <a href="{{ route('removeFavorie', ['id' => $produit->id, 'qty' => 1]) }}"
                                        class="remove-favorie-to-button {{ !$produit->favories->isNotEmpty() ? 'd-none' : '' }}"
                                        data-id="{{ $produit->id }}" data-type="remove">
                                        <i class="fas fa-heart text-danger"></i> Déjà dans vos favoris
                                    </a>

                                    <a href="{{ route('addFavorie', ['id' => $produit->id]) }}"
                                        class="add-favorie-to-button {{ !$produit->favories->isNotEmpty() ? '' : 'd-none' }}"
                                        data-id="{{ $produit->id }}" data-type="add">
                                        <i class="far fa-heart text-secondary"></i> Ajouter dans vos favoris
                                    </a>
                                </h5>
                                <ul>
                                    <li>
                                        <span>Tag : </span>
                                        <a href="#">clothing</a>
                                    </li>
                                    <li>
                                        <span>CATEGORIES :</span>
                                        <a href="">{{ $produit->categories->pluck('name')->join(', ') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-desc-wrap mb-100">
                            <ul class="nav nav-tabs mb-25" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                                        role="tab" aria-controls="details" aria-selected="true">Détails du service</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="val-tab" data-toggle="tab" href="#val" role="tab"
                                        aria-controls="val" aria-selected="false">Commentaires <span id="service-comment-badge" class="badge bg-success ms-1" style="display:none;">0</span></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="details" role="tabpanel"
                                    aria-labelledby="details-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">Détails du service</h4>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4">
                                                <div class="product-desc-img">
                                                    <img src="{{ asset('assets/img/product/585x444-.jpg') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-md-8">
                                                <h5 class="small-title">The Christina Fashion</h5>
                                                <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap
                                                    into
                                                    electronic typesetting, remaining Lorem
                                                    Ipsum is simply dummy text of the printing and typesetting industry.
                                                    Lorem
                                                    Ipsum has been the industry's standard dummy
                                                    text ever since the 1500s, when an unknown printer took a galley of type
                                                    and
                                                    scrambled it to make a type specimen book.</p>
                                                <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="val" role="tabpanel" aria-labelledby="val-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title mb-4">Commentaires</h4>
                                        <ul id="service-comment-list" class="comment-list mb-4"></ul>
                                        <div id="service-comment-actions" class="mb-4"></div>
                                        <div class="comment-reply-box mt-4">
                                            <h5 class="b-details-inner-title mb-35">Laisser un commentaire et noter</h5>
                                            <form id="service-comment-form" data-type="produit" data-id="{{ $produit->id }}" class="comment-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="d-inline-block mb-2 mr-2">Votre note</label>
                                                    <div class="rating-input d-inline-flex" data-rating="0" style="vertical-align:middle;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star-o" data-value="{{ $i }}" style="cursor:pointer;font-size:1.5rem;color:#d4a017;"></i>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="rating" id="service-comment-rating" value="0">
                                                </div>
                                                <textarea name="body" id="service-comment-message" placeholder="Votre commentaire" required></textarea>
                                                @guest
                                                <div class="row mt-2">
                                                    <div class="col-md-6"><input type="text" name="guest_name" placeholder="Votre nom *" required></div>
                                                    <div class="col-md-6"><input type="email" name="guest_email" placeholder="Votre e-mail *" required></div>
                                                </div>
                                                @endguest
                                                <button type="submit" class="btn mt-3" style="background:#FD0100;color:#fff;">Envoyer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop-details-add mb-95">
                            <a href="#"><img src="img/product/shop_details_add.jpg" alt=""></a>
                        </div>
                        <div class="related-product-wrap pb-0">
                            <div class="deal-day-top">
                                <div class="deal-day-title">
                                    <h4 class="title">Produits similaires et suggestions</h4>
                                </div>
                                <div class="related-slider-nav">
                                    <div class="slider-nav"></div>
                                </div>
                            </div>
                            @if(($similarProducts ?? collect())->isNotEmpty())
                            <div class="related-product-active">
                                @foreach($similarProducts as $sim)
                                    @include('parties.listeProd', ['p' => $sim, 'inSlider' => true])
                                @endforeach
                            </div>
                            @else
                            <div class="row">
                                <div class="col-12 text-center py-4 text-muted">Aucun produit similaire pour le moment.</div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- shop-details-area-end -->
        {{-- Modal pour commentaires service --}}
        <div class="modal fade" id="serviceAllCommentsModal" tabindex="-1" aria-labelledby="serviceAllCommentsModalLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceAllCommentsModalLabel">Tous les commentaires</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" style="font-size:1.5rem;opacity:.7;"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <ul id="service-all-comment-list" class="list-unstyled mb-0"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @section('content')
        @include('parties.banner', [
            'page' => 'Détails du produit',
            'breadcrumb' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Nos produits', 'url' => route('shop')],
                ['label' => 'Détails du produit', 'url' => null]
            ]
        ])

        <!-- shop-details-area -->
        <section class="shop-details-area pt-100 pb-50">
            <div class="container">
                <div class="row mb-95">
                    <div class="col-xl-7 col-lg-6">
                        @php
                            $detailImages = $produit->getImageUrlsAttribute();
                            $detailInitials = getInitials($produit->name);
                        @endphp
                        <div class="shop-details-nav-wrap">
                            <div class="shop-details-nav">
                                @forelse ($detailImages as $p)
                                    <div class="shop-nav-item">
                                        <div style="position:relative;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:6px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                            <img src="{{ $p }}" alt="" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <span style="display:none;font-weight:bold;font-size:1.2rem;color:white;">{{ $detailInitials }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="shop-nav-item">
                                        <div style="aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                            <span style="font-weight:bold;font-size:1.2rem;color:white;">{{ $detailInitials }}</span>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="shop-details-img-wrap">
                            <div class="shop-details-active">
                                @forelse ($detailImages as $p)
                                    <div class="shop-details-img">
                                        <div style="position:relative;width:100%;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                            <a href="{{ $p }}" class="popup-image">
                                                <img src="{{ $p }}" alt="" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <span style="display:none;font-weight:bold;font-size:3rem;color:white;">{{ $detailInitials }}</span>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="shop-details-img">
                                        <div style="width:100%;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                            <span style="font-weight:bold;font-size:3rem;color:white;">{{ $detailInitials }}</span>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="shop-details-content">
                            <span class="stock-info">{{ $produit->isAvalable ? 'Disponible' : 'En rupture' }}</span>
                            <h2>{{ $produit->name }}</h2>
                            @php
                                $avgRating = round($produit->avg_rating ?? 0);
                                $avgRating = max(0, min(5, $avgRating));
                                $commentsCount = $produit->comments()->count();
                            @endphp
                            <div class="shop-details-review mb-3">
                                <div class="rating d-inline-block">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $avgRating ? '' : '-o' }} {{ $i <= $avgRating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                                <span class="ml-2">- {{ $commentsCount }} {{ $commentsCount <= 1 ? 'avis' : 'avis' }}</span>
                            </div>
                            <div class="shop-details-price">
                                <h2>
                                    {!! formatPrix2($produit->isSpecialOffer, $produit->prix, $produit->soldePrice, $produit->currency) !!}
                                </h2>
                            </div>
                            <p>{{ $produit->description }}</p>

                            <div class="perched-info">
                                <div class="cart-plus">
                                    <form action="#">
                                        <div class="cart-plus-minus plusbtn" id="cart-plus-minus">
                                            <div class="dec qtybutton qtybuttonb">-</div>
                                            <input type="text" value="1">
                                            <div class="inc qtybutton qtybuttonb">+</div>
                                        </div>
                                    </form>
                                </div>
                                <a href="{{ route('cart.add', ['id' => $produit->id, 'qty' => 1]) }}"
                                    data-id="{{ $produit->id }}" class="btn add-card-btn add-to-cart-btn">Ajouter au panier</a>
                            </div>
                            <div class="shop-details-bottom">
                                <h5>

                                    <a href="{{ route('removeFavorie', ['id' => $produit->id, 'qty' => 1]) }}"
                                        class="remove-favorie-to-button {{ !$produit->favories->isNotEmpty() ? 'd-none' : '' }}"
                                        data-id="{{ $produit->id }}" data-type="remove">
                                        <i class="fas fa-heart text-danger"></i> Déjà dans vos favoris
                                    </a>

                                    <a href="{{ route('addFavorie', ['id' => $produit->id]) }}"
                                        class="add-favorie-to-button {{ !$produit->favories->isNotEmpty() ? '' : 'd-none' }}"
                                        data-id="{{ $produit->id }}" data-type="add">
                                        <i class="far fa-heart text-secondary"></i> Ajouter dans vos favoris
                                    </a>
                                </h5>
                                <ul>
                                    <li>
                                        <span>Tag : </span>
                                        <a href="#">clothing</a>
                                    </li>
                                    <li>
                                        <span>CATEGORIES :</span>
                                        <a href="">{{ $produit->categories->pluck('name')->join(', ') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-desc-wrap mb-100">
                            <ul class="nav nav-tabs mb-25" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                                        role="tab" aria-controls="details" aria-selected="true">Détails du produit</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="val-tab" data-toggle="tab" href="#val" role="tab"
                                        aria-controls="val" aria-selected="false">Commentaires <span id="product-comment-badge" class="badge bg-success ms-1" style="display:none;">0</span></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="details" role="tabpanel"
                                    aria-labelledby="details-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">Détails du produit</h4>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4">
                                                <div class="product-desc-img">
                                                    <img src="{{ asset('assets/img/product/585x444-.jpg') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-md-8">
                                                <h5 class="small-title">The Christina Fashion</h5>
                                                <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap
                                                    into
                                                    electronic typesetting, remaining Lorem
                                                    Ipsum is simply dummy text of the printing and typesetting industry.
                                                    Lorem
                                                    Ipsum has been the industry's standard dummy
                                                    text ever since the 1500s, when an unknown printer took a galley of type
                                                    and
                                                    scrambled it to make a type specimen book.</p>
                                                <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="val" role="tabpanel" aria-labelledby="val-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title mb-4">Commentaires</h4>
                                        <ul id="product-comment-list" class="comment-list mb-4"></ul>
                                        <div id="product-comment-actions" class="mb-4"></div>
                                        <div class="comment-reply-box mt-4">
                                            <h5 class="b-details-inner-title mb-35">Laisser un commentaire et noter</h5>
                                            <form id="product-comment-form" data-type="produit" data-id="{{ $produit->id }}" class="comment-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="d-inline-block mb-2 mr-2">Votre note</label>
                                                    <div class="rating-input d-inline-flex" data-rating="0" style="vertical-align:middle;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star-o" data-value="{{ $i }}" style="cursor:pointer;font-size:1.5rem;color:#d4a017;"></i>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="rating" id="product-comment-rating" value="0">
                                                </div>
                                                <textarea name="body" id="product-comment-message" placeholder="Votre commentaire" required></textarea>
                                                @guest
                                                <div class="row mt-2">
                                                    <div class="col-md-6"><input type="text" name="guest_name" placeholder="Votre nom *" required></div>
                                                    <div class="col-md-6"><input type="email" name="guest_email" placeholder="Votre e-mail *" required></div>
                                                </div>
                                                @endguest
                                                <button type="submit" class="btn mt-3" style="background:#FD0100;color:#fff;">Envoyer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop-details-add mb-95">
                            <a href="#"><img src="img/product/shop_details_add.jpg" alt=""></a>
                        </div>
                        <div class="related-product-wrap pb-0">
                            <div class="deal-day-top">
                                <div class="deal-day-title">
                                    <h4 class="title">Produits similaires et suggestions</h4>
                                </div>
                                <div class="related-slider-nav">
                                    <div class="slider-nav"></div>
                                </div>
                            </div>
                            @if(($similarProducts ?? collect())->isNotEmpty())
                            <div class="related-product-active">
                                @foreach($similarProducts as $sim)
                                    @include('parties.listeProd', ['p' => $sim, 'inSlider' => true])
                                @endforeach
                            </div>
                            @else
                            <div class="row">
                                <div class="col-12 text-center py-4 text-muted">Aucun produit similaire pour le moment.</div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- shop-details-area-end -->
        <div id="comment-loader-overlay"><div class="comment-loader-spinner"></div></div>
        {{-- Modal pour tous les commentaires produit --}}
        <div class="modal fade" id="productAllCommentsModal" tabindex="-1" aria-labelledby="productAllCommentsModalLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productAllCommentsModalLabel">Tous les commentaires</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" style="font-size:1.5rem;opacity:.7;"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <ul id="product-all-comment-list" class="list-unstyled mb-0"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection


@endif

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .related-product-slide { padding: 0 10px; }
        .related-product-active .exclusive-item-three { margin-bottom: 0; }
        .modal.fade .modal-dialog { transition: transform 0.3s ease-out; transform: scale(0.8); }
        .modal.show .modal-dialog { transform: scale(1); }
        .modal-dialog-centered { display: flex; align-items: center; min-height: calc(100% - 1rem); }
        #comment-loader-overlay { position:fixed;inset:0;background:rgba(255,255,255,0.7);display:none;align-items:center;justify-content:center;z-index:9999; }
        #comment-loader-overlay.show { display:flex; }
        .comment-loader-spinner { border:4px solid #f3f3f3;border-top:4px solid #FD0100;border-radius:50%;width:40px;height:40px;animation:comment-spin .8s linear infinite; }
        @keyframes comment-spin { to { transform:rotate(360deg); } }
        .btn-loading { position:relative;pointer-events:none; }
        .btn-loading .btn-spinner { display:inline-block;width:1em;height:1em;border:2px solid currentColor;border-top-color:transparent;border-radius:50%;animation:comment-spin .6s linear infinite;margin-right:6px;vertical-align:middle; }
    </style>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).on("click", ".add-to-cart-btn", function(e) {
            e.preventDefault();
            let qty = $("#cart-plus-minus").find("input[type='text']").val();
            let produitId = $(this).data('id');
            let actionUrl = '../cart/add/' + produitId + "/" + qty;
            if (qty < 1) {
                swal({
                    title: "La quantité ne peut être inferieur à 1",
                    icon: 'error'
                });
                return;
            }

            $.ajax({
                url: actionUrl,
                method: "GET",
                success: function(data) {
                    console.log(data)
                    if (data.reponse) {
                        updateCartUI();
                        swal({
                            title: data.message,
                            icon: 'success'
                        });
                        // qty.val(data.qty);

                    } else {
                        swal({
                            title: data.message,
                            icon: 'error'
                        });
                    }

                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        alert('Vous devez être connecté pour accéder à cette page.');
                        window.location.href = '/login'; // Redirection vers la page de connexion
                    } else {
                        console.error('Une erreur est survenue:', error);
                    }
                }
            });

        });

        // $(document).ready(function() {
        //     // Gestion du clic sur les boutons de favoris (utilisation de delegation)
        //     $(document).on('click', '.add-favorie-to-button, .remove-favorie-to-button', function(e) {
        //         e.preventDefault();

        //         const button = $(this); // Récupération du bouton cliqué
        //         let actionUrl = button.attr("href"); // URL d'ajout ou de suppression
        //         let productId = button.data('id');

        //         $.ajax({
        //             url: actionUrl,
        //             method: "GET",
        //             success: function(data) {
        //                 console.log(data);

        //                 if (data.reponse) {
        //                     // Ajout réussi aux favoris : afficher bouton "Déjà dans vos favoris"
        //                     $('.add-favorie-to-button[data-id="' + productId + '"]').addClass(
        //                         'd-none');
        //                     $('.remove-favorie-to-button[data-id="' + productId + '"]')
        //                         .removeClass('d-none');
        //                 } else {
        //                     // Suppression des favoris : afficher bouton "Ajouter dans vos favoris"
        //                     $('.remove-favorie-to-button[data-id="' + productId + '"]')
        //                         .addClass('d-none');
        //                     $('.add-favorie-to-button[data-id="' + productId + '"]')
        //                         .removeClass('d-none');
        //                 }
        //                 updateFavorite();

        //             },
        //             error: function(xhr, status, error) {
        //                 if (xhr.status === 401) {
        //                     alert('Vous devez être connecté pour ajouter aux favoris.');
        //                     window.location.href =
        //                         '/login'; // Redirection vers la page de connexion
        //                 } else {
        //                     console.error('Une erreur est survenue:', error);
        //                 }
        //             }
        //         });
        //     });
        // });
        $(document).ready(function() {
            // Gestion du clic sur les boutons de favoris
            $(document).on('click', '.add-favorie-to-button, .remove-favorie-to-button', function(e) {
                e.preventDefault();

                const button = $(this); // Bouton cliqué
                let actionUrl = button.attr("href"); // URL d'ajout ou de suppression
                let productId = button.data('id');
                let type = button.data('type');

                $.ajax({
                    url: actionUrl,
                    method: "GET",
                    success: function(data) {
                        console.log(data);

                        if (data.reponse == true && type == "add") {
                            // Passage de l'état "Ajouter" à "Déjà dans les favoris"
                            $('.add-favorie-to-button[data-id="' + productId + '"]').addClass(
                                'd-none');
                            $('.remove-favorie-to-button[data-id="' + productId + '"]')
                                .removeClass('d-none');
                        } else if (data.reponse == true && type == "remove") { // Correction ici
                            // Passage de l'état "Déjà" à "Ajouter aux favoris"
                            $('.remove-favorie-to-button[data-id="' + productId + '"]')
                                .addClass('d-none');
                            $('.add-favorie-to-button[data-id="' + productId + '"]')
                                .removeClass('d-none');
                        }
                        updateFavorite();
                        // Affichage d'une notification si nécessaire
                        swal({
                            title: data.message,
                            icon: data.reponse ? 'success' : 'error'
                        });
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 401) {
                            alert('Vous devez être connecté pour gérer vos favoris.');
                            window.location.href =
                                '/login'; // Redirection vers la page de connexion
                        } else {
                            console.error('Une erreur est survenue:', error);
                        }
                    }
                });

            });
        });

        // ─── Commentaires produit (si on est sur une page produit) ───
        (function() {
            const form = document.getElementById('product-comment-form');
            if (!form) return;

            const list = document.getElementById('product-comment-list');
            const allList = document.getElementById('product-all-comment-list');
            const btnAll = document.getElementById('product-show-all-comments');
            toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: "5000" };

            function createCommentItem(c) {
                const maxLen = 100;
                let text = c.body;
                let truncated = text.length > maxLen;
                if (truncated) text = text.slice(0, maxLen) + '... ';
                const initials = c.initials || (c.author_name ? c.author_name.slice(0,2).toUpperCase() : '?');
                const avatarHtml = c.has_avatar
                    ? `<img src="${c.avatar_url}" alt="${c.author_name}" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"><span class="comment-avatar-initials" style="display:none;width:100%;height:100%;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);align-items:center;justify-content:center;font-weight:bold;color:#fff;font-size:0.9rem;">${initials}</span>`
                    : `<span class="comment-avatar-initials" style="width:100%;height:100%;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;font-weight:bold;color:#fff;font-size:0.9rem;">${initials}</span>`;
                const ellipsisHtml = (c.can_delete && c.id) ? `<div class="comment-options-dropdown" style="position:relative;"><button type="button" class="comment-ellipsis-btn" title="Options" aria-label="Options"><i class="fas fa-ellipsis-h"></i></button><div class="comment-dropdown-menu" style="display:none;position:absolute;right:0;top:100%;background:#fff;border:1px solid #ddd;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:100;min-width:140px;margin-top:4px;"><a href="#" class="comment-opt-modifier d-block px-3 py-2 text-dark" style="text-decoration:none;border-radius:4px;"><i class="fas fa-edit mr-2"></i>Modifier</a><a href="#" class="comment-opt-supprimer d-block px-3 py-2 text-danger" style="text-decoration:none;border-radius:4px;"><i class="fas fa-trash mr-2"></i>Supprimer</a></div></div>` : '';
                const headerHtml = ellipsisHtml ? `<div class="d-flex justify-content-between align-items-start w-100"><h5 class="mb-1">${c.author_name} <span class="comment-date text-muted small">${c.date}</span></h5>${ellipsisHtml}</div>` : `<h5 class="mb-1">${c.author_name} <span class="comment-date text-muted small">${c.date}</span></h5>`;
                const li = document.createElement('li');
                if (c.id) li.dataset.commentId = c.id;
                li.innerHTML = `<div class="single-comment d-flex" style="align-items:flex-start;"><div class="comment-avatar-img flex-shrink-0" style="width:50px;height:50px;min-width:50px;border-radius:50%;overflow:hidden;display:flex;align-items:center;justify-content:center;margin-right:12px;">${avatarHtml}</div><div class="flex-grow-1" style="min-width:0;">${headerHtml}<p class="comment-body mb-0">${text}${truncated ? '<a href="#" class="read-more">Voir plus</a>' : ''}</p></div></div>`;
                const bodyEl = li.querySelector('.comment-body');
                const shortText = text;
                function showMore() {
                    bodyEl.innerHTML = c.body.replace(/</g,'&lt;').replace(/>/g,'&gt;') + ' <a href="#" class="read-less">Voir moins</a>';
                    bodyEl.querySelector('.read-less').addEventListener('click', function(e) { e.preventDefault(); showLess(); });
                }
                function showLess() {
                    bodyEl.innerHTML = shortText.replace(/</g,'&lt;').replace(/>/g,'&gt;') + ' <a href="#" class="read-more">Voir plus</a>';
                    bodyEl.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); showMore(); });
                }
                if (truncated) li.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); showMore(); });
                if (c.can_delete && c.id) {
                    const btn = li.querySelector('.comment-ellipsis-btn');
                    const menu = li.querySelector('.comment-dropdown-menu');
                    btn.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); const isOpen = menu.style.display === 'block'; menu.style.display = isOpen ? 'none' : 'block'; if (!isOpen) setTimeout(() => { const h = (ev) => { if (!li.contains(ev.target)) { menu.style.display = 'none'; document.removeEventListener('click', h); } }; document.addEventListener('click', h); }, 0); });
                    li.querySelector('.comment-opt-modifier').addEventListener('click', function(e) {
                        e.preventDefault(); menu.style.display = 'none';
                        const savedScrollY = window.scrollY || window.pageYOffset;
                        const oldHtml = bodyEl.innerHTML;
                        const oldText = c.body;
                        bodyEl.innerHTML = '<textarea class="form-control comment-edit-textarea" rows="5" style="width:100%;min-height:80px;">' + oldText.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</textarea><div class="mt-2"><button type="button" class="btn btn-sm btn-success comment-save-edit">Enregistrer</button> <button type="button" class="btn btn-sm btn-secondary comment-cancel-edit">Annuler</button></div>';
                        const textarea = bodyEl.querySelector('.comment-edit-textarea');
                        setTimeout(function(){ window.scrollTo(0, savedScrollY); }, 0);
                        bodyEl.querySelector('.comment-cancel-edit').onclick = () => { bodyEl.innerHTML = oldHtml; if (truncated) { const moreLink = bodyEl.querySelector('.read-more'); if (moreLink) moreLink.addEventListener('click', function(ev) { ev.preventDefault(); showMore(); }); } };
                        bodyEl.querySelector('.comment-save-edit').onclick = () => {
                            const newBody = textarea.value.trim();
                            if (!newBody) return;
                            const saveBtn = bodyEl.querySelector('.comment-save-edit');
                            const origText = saveBtn.innerHTML;
                            saveBtn.disabled = true;
                            saveBtn.innerHTML = '<span class="btn-spinner"></span> Enregistrement...';
                            fetch(`${window.location.origin}/${form.dataset.type}/${form.dataset.id}/comments/${c.id}`, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }, body: JSON.stringify({ body: newBody }) })
                                .then(r => r.json()).then(data => {
                                    saveBtn.disabled = false;
                                    saveBtn.innerHTML = origText;
                                    if (data.success) {
                                        c.body = data.body;
                                        const shortT = data.body.length > 100 ? data.body.slice(0,100) + '... ' : data.body;
                                        bodyEl.innerHTML = shortT + (data.body.length > 100 ? '<a href="#" class="read-more">Voir plus</a>' : '');
                                        if (data.body.length > 100) { const ml = bodyEl.querySelector('.read-more'); if (ml) ml.addEventListener('click', function(ev) { ev.preventDefault(); showMore(); }); }
                                        toastr.success('Commentaire modifié.');
                                    } else toastr.error(data.message || 'Erreur');
                                }).catch(() => { saveBtn.disabled = false; saveBtn.innerHTML = origText; toastr.error('Erreur.'); });
                        };
                    });
                    li.querySelector('.comment-opt-supprimer').addEventListener('click', function(e) {
                        e.preventDefault(); menu.style.display = 'none';
                        swal({ title: "Supprimer ce commentaire ?", text: "Cette action est irréversible.", icon: "warning", buttons: { cancel: "Annuler", confirm: "Supprimer" }, dangerMode: true }).then((willDelete) => {
                            if (willDelete) {
                                const loader = document.getElementById('comment-loader-overlay');
                                if (loader) loader.classList.add('show');
                                fetch(`${window.location.origin}/${form.dataset.type}/${form.dataset.id}/comments/${c.id}`, { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' } })
                                    .then(r => r.json()).then(data => {
                                        if (loader) loader.classList.remove('show');
                                        if (data.success) { li.remove(); loadProductComments(); toastr.success('Commentaire supprimé.'); } else toastr.error(data.message || 'Erreur');
                                    }).catch(() => { if (loader) loader.classList.remove('show'); toastr.error('Erreur lors de la suppression.'); });
                            }
                        });
                    });
                }
                return li;
            }

            const actionsEl = document.getElementById('product-comment-actions');
            const badgeEl = document.getElementById('product-comment-badge');

            async function loadProductComments() {
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/latest`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Erreur ' + res.status);
                    const data = await res.json();
                    const comments = Array.isArray(data) ? data : (data.comments || []);
                    const total = data.total ?? comments.length;
                    list.innerHTML = '';
                    comments.forEach(c => list.appendChild(createCommentItem(c)));
                    if (badgeEl) { badgeEl.textContent = total; badgeEl.style.display = total > 0 ? 'inline' : 'none'; }
                    if (actionsEl) {
                        if (total > 7) {
                            actionsEl.innerHTML = '<p class="mb-0">Vos avis comptent ! <a href="#" id="product-show-all-comments" class="text-decoration-none font-weight-bold" style="color:#FD0100;">Découvrir l\'ensemble des avis</a></p>';
                            actionsEl.querySelector('#product-show-all-comments').addEventListener('click', function(e){ e.preventDefault(); var o=document.getElementById('comment-loader-overlay');if(o){o.classList.add('show');} loadAllProductComments(); });
                        } else if (total === 0) {
                            actionsEl.innerHTML = '<p class="text-muted mb-0">Aucun commentaire pour le moment. Soyez le premier à donner votre avis !</p>';
                        } else {
                            actionsEl.innerHTML = '';
                        }
                    }
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger les commentaires.');
                }
            }

            async function loadAllProductComments() {
                const loader = document.getElementById('comment-loader-overlay');
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/all`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Statut ' + res.status);
                    const comments = await res.json();
                    allList.innerHTML = '';
                    comments.forEach(c => allList.appendChild(createCommentItem(c)));
                    $('#productAllCommentsModal').modal('show');
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger tous les commentaires.');
                } finally {
                    if (loader) loader.classList.remove('show');
                }
            }

            const ratingInput = form.querySelector('.rating-input');
            const ratingHidden = document.getElementById('product-comment-rating');
            if (ratingInput && ratingHidden) {
                ratingInput.querySelectorAll('i[data-value]').forEach(star => {
                    star.addEventListener('click', function() {
                        const val = parseInt(this.dataset.value);
                        ratingHidden.value = val;
                        ratingInput.dataset.rating = val;
                        ratingInput.querySelectorAll('i[data-value]').forEach((s, i) => {
                            s.classList.toggle('fa-star', i < val);
                            s.classList.toggle('fa-star-o', i >= val);
                            s.classList.toggle('text-warning', i < val);
                            s.classList.toggle('text-muted', i >= val);
                        });
                    });
                });
            }

            loadProductComments();

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && submitBtn.disabled) return;
                const origBtnText = submitBtn ? submitBtn.innerHTML : '';
                if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="btn-spinner"></span> Envoi...'; }
                const type = form.dataset.type, id = form.dataset.id;
                const body = document.getElementById('product-comment-message').value.trim();
                const rating = parseInt(ratingHidden?.value || 0);
                let payload = { body, rating: (rating >= 1 && rating <= 5) ? rating : null };
                const guestName = form.querySelector('input[name="guest_name"]');
                const guestEmail = form.querySelector('input[name="guest_email"]');
                if (guestName) payload.guest_name = guestName.value.trim();
                if (guestEmail) payload.guest_email = guestEmail.value.trim();
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch(`${window.location.origin}/${type}/${id}/comments`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken || '' },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(data => {
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = origBtnText; }
                    if (data.success) {
                        toastr.success('Commentaire publié !');
                        form.reset();
                        if (ratingHidden) ratingHidden.value = 0;
                        if (ratingInput) {
                            ratingInput.querySelectorAll('i[data-value]').forEach((s, i) => {
                                s.classList.toggle('fa-star', false);
                                s.classList.toggle('fa-star-o', true);
                                s.classList.toggle('text-warning', false);
                                s.classList.toggle('text-muted', true);
                            });
                        }
                        loadProductComments();
                    } else toastr.error(data.message || 'Erreur');
                }).catch(err => { if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = origBtnText; } console.error(err); toastr.error('Erreur lors de l\'envoi.'); });
            });
        })();

        // ─── Commentaires service (si on est sur une page service) ───
        (function() {
            const form = document.getElementById('service-comment-form');
            if (!form) return;

            const list = document.getElementById('service-comment-list');
            const allList = document.getElementById('service-all-comment-list');
            const actionsEl = document.getElementById('service-comment-actions');
            const badgeEl = document.getElementById('service-comment-badge');
            if (!toastr.options) toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: "5000" };

            function createCommentItem(c) {
                const maxLen = 100;
                let text = c.body;
                let truncated = text.length > maxLen;
                if (truncated) text = text.slice(0, maxLen) + '... ';
                const initials = c.initials || (c.author_name ? c.author_name.slice(0,2).toUpperCase() : '?');
                const avatarHtml = c.has_avatar
                    ? `<img src="${c.avatar_url}" alt="${c.author_name}" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"><span class="comment-avatar-initials" style="display:none;width:100%;height:100%;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);align-items:center;justify-content:center;font-weight:bold;color:#fff;font-size:0.9rem;">${initials}</span>`
                    : `<span class="comment-avatar-initials" style="width:100%;height:100%;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;font-weight:bold;color:#fff;font-size:0.9rem;">${initials}</span>`;
                const ellipsisHtml = (c.can_delete && c.id) ? `<div class="comment-options-dropdown" style="position:relative;"><button type="button" class="comment-ellipsis-btn" title="Options" aria-label="Options"><i class="fas fa-ellipsis-h"></i></button><div class="comment-dropdown-menu" style="display:none;position:absolute;right:0;top:100%;background:#fff;border:1px solid #ddd;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:100;min-width:140px;margin-top:4px;"><a href="#" class="comment-opt-modifier d-block px-3 py-2 text-dark" style="text-decoration:none;"><i class="fas fa-edit mr-2"></i>Modifier</a><a href="#" class="comment-opt-supprimer d-block px-3 py-2 text-danger" style="text-decoration:none;"><i class="fas fa-trash mr-2"></i>Supprimer</a></div></div>` : '';
                const headerHtml = ellipsisHtml ? `<div class="d-flex justify-content-between align-items-start w-100"><h5 class="mb-1">${c.author_name} <span class="comment-date text-muted small">${c.date}</span></h5>${ellipsisHtml}</div>` : `<h5 class="mb-1">${c.author_name} <span class="comment-date text-muted small">${c.date}</span></h5>`;
                const li = document.createElement('li');
                if (c.id) li.dataset.commentId = c.id;
                li.innerHTML = `<div class="single-comment d-flex" style="align-items:flex-start;"><div class="comment-avatar-img flex-shrink-0" style="width:50px;height:50px;min-width:50px;border-radius:50%;overflow:hidden;display:flex;align-items:center;justify-content:center;margin-right:12px;">${avatarHtml}</div><div class="flex-grow-1" style="min-width:0;">${headerHtml}<p class="comment-body mb-0">${text}${truncated ? '<a href="#" class="read-more">Voir plus</a>' : ''}</p></div></div>`;
                const bodyEl = li.querySelector('.comment-body');
                const shortText = text;
                function showMore() {
                    bodyEl.innerHTML = c.body.replace(/</g,'&lt;').replace(/>/g,'&gt;') + ' <a href="#" class="read-less">Voir moins</a>';
                    bodyEl.querySelector('.read-less').addEventListener('click', function(e) { e.preventDefault(); showLess(); });
                }
                function showLess() {
                    bodyEl.innerHTML = shortText.replace(/</g,'&lt;').replace(/>/g,'&gt;') + ' <a href="#" class="read-more">Voir plus</a>';
                    bodyEl.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); showMore(); });
                }
                if (truncated) li.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); showMore(); });
                if (c.can_delete && c.id) {
                    const btn = li.querySelector('.comment-ellipsis-btn');
                    const menu = li.querySelector('.comment-dropdown-menu');
                    btn.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); const isOpen = menu.style.display === 'block'; menu.style.display = isOpen ? 'none' : 'block'; if (!isOpen) setTimeout(() => { const h = (ev) => { if (!li.contains(ev.target)) { menu.style.display = 'none'; document.removeEventListener('click', h); } }; document.addEventListener('click', h); }, 0); });
                    li.querySelector('.comment-opt-modifier').addEventListener('click', function(e) {
                        e.preventDefault(); menu.style.display = 'none';
                        const savedScrollY = window.scrollY || window.pageYOffset;
                        const oldHtml = bodyEl.innerHTML;
                        bodyEl.innerHTML = '<textarea class="form-control comment-edit-textarea" rows="5" style="width:100%;min-height:80px;">' + c.body.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</textarea><div class="mt-2"><button type="button" class="btn btn-sm btn-success comment-save-edit">Enregistrer</button> <button type="button" class="btn btn-sm btn-secondary comment-cancel-edit">Annuler</button></div>';
                        const textarea = bodyEl.querySelector('.comment-edit-textarea');
                        setTimeout(function(){ window.scrollTo(0, savedScrollY); }, 0);
                        bodyEl.querySelector('.comment-cancel-edit').onclick = () => { bodyEl.innerHTML = oldHtml; if (truncated) { const moreLink = bodyEl.querySelector('.read-more'); if (moreLink) moreLink.addEventListener('click', function(ev) { ev.preventDefault(); showMore(); }); } };
                        bodyEl.querySelector('.comment-save-edit').onclick = () => {
                            const newBody = textarea.value.trim();
                            if (!newBody) return;
                            const saveBtn = bodyEl.querySelector('.comment-save-edit');
                            const origText = saveBtn.innerHTML;
                            saveBtn.disabled = true;
                            saveBtn.innerHTML = '<span class="btn-spinner"></span> Enregistrement...';
                            fetch(`${window.location.origin}/${form.dataset.type}/${form.dataset.id}/comments/${c.id}`, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }, body: JSON.stringify({ body: newBody }) })
                                .then(r => r.json()).then(data => {
                                    saveBtn.disabled = false;
                                    saveBtn.innerHTML = origText;
                                    if (data.success) {
                                        c.body = data.body;
                                        const shortT = data.body.length > 100 ? data.body.slice(0,100) + '... ' : data.body;
                                        bodyEl.innerHTML = shortT + (data.body.length > 100 ? '<a href="#" class="read-more">Voir plus</a>' : '');
                                        if (data.body.length > 100) { const ml = bodyEl.querySelector('.read-more'); if (ml) ml.addEventListener('click', function(ev) { ev.preventDefault(); showMore(); }); }
                                        toastr.success('Commentaire modifié.');
                                    } else toastr.error(data.message || 'Erreur');
                                }).catch(() => { saveBtn.disabled = false; saveBtn.innerHTML = origText; toastr.error('Erreur.'); });
                        };
                    });
                    li.querySelector('.comment-opt-supprimer').addEventListener('click', function(e) {
                        e.preventDefault(); menu.style.display = 'none';
                        swal({ title: "Supprimer ce commentaire ?", text: "Cette action est irréversible.", icon: "warning", buttons: { cancel: "Annuler", confirm: "Supprimer" }, dangerMode: true }).then((willDelete) => {
                            if (willDelete) {
                                const loader = document.getElementById('comment-loader-overlay');
                                if (loader) loader.classList.add('show');
                                fetch(`${window.location.origin}/${form.dataset.type}/${form.dataset.id}/comments/${c.id}`, { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' } })
                                    .then(r => r.json()).then(data => {
                                        if (loader) loader.classList.remove('show');
                                        if (data.success) { li.remove(); loadServiceComments(); toastr.success('Commentaire supprimé.'); } else toastr.error(data.message || 'Erreur');
                                    }).catch(() => { if (loader) loader.classList.remove('show'); toastr.error('Erreur lors de la suppression.'); });
                            }
                        });
                    });
                }
                return li;
            }

            async function loadServiceComments() {
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/latest`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Erreur ' + res.status);
                    const data = await res.json();
                    const comments = Array.isArray(data) ? data : (data.comments || []);
                    const total = data.total ?? comments.length;
                    list.innerHTML = '';
                    comments.forEach(c => list.appendChild(createCommentItem(c)));
                    if (badgeEl) { badgeEl.textContent = total; badgeEl.style.display = total > 0 ? 'inline' : 'none'; }
                    if (actionsEl) {
                        if (total > 7) {
                            actionsEl.innerHTML = '<p class="mb-0">Vos avis comptent ! <a href="#" id="service-show-all-comments" class="text-decoration-none font-weight-bold" style="color:#FD0100;">Découvrir l\'ensemble des avis</a></p>';
                            actionsEl.querySelector('#service-show-all-comments').addEventListener('click', function(e){ e.preventDefault(); var o=document.getElementById('comment-loader-overlay');if(o){o.classList.add('show');} loadAllServiceComments(); });
                        } else if (total === 0) {
                            actionsEl.innerHTML = '<p class="text-muted mb-0">Aucun commentaire pour le moment. Soyez le premier à donner votre avis !</p>';
                        } else {
                            actionsEl.innerHTML = '';
                        }
                    }
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger les commentaires.');
                }
            }

            async function loadAllServiceComments() {
                const loader = document.getElementById('comment-loader-overlay');
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/all`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Statut ' + res.status);
                    const comments = await res.json();
                    allList.innerHTML = '';
                    comments.forEach(c => allList.appendChild(createCommentItem(c)));
                    $('#serviceAllCommentsModal').modal('show');
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger tous les commentaires.');
                } finally {
                    if (loader) loader.classList.remove('show');
                }
            }

            const ratingInput = form.querySelector('.rating-input');
            const ratingHidden = document.getElementById('service-comment-rating');
            if (ratingInput && ratingHidden) {
                ratingInput.querySelectorAll('i[data-value]').forEach(star => {
                    star.addEventListener('click', function() {
                        const val = parseInt(this.dataset.value);
                        ratingHidden.value = val;
                        ratingInput.dataset.rating = val;
                        ratingInput.querySelectorAll('i[data-value]').forEach((s, i) => {
                            s.classList.toggle('fa-star', i < val);
                            s.classList.toggle('fa-star-o', i >= val);
                            s.classList.toggle('text-warning', i < val);
                            s.classList.toggle('text-muted', i >= val);
                        });
                    });
                });
            }

            loadServiceComments();

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && submitBtn.disabled) return;
                const origBtnText = submitBtn ? submitBtn.innerHTML : '';
                if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="btn-spinner"></span> Envoi...'; }
                const type = form.dataset.type, id = form.dataset.id;
                const body = document.getElementById('service-comment-message').value.trim();
                const rating = parseInt(ratingHidden?.value || 0);
                let payload = { body, rating: (rating >= 1 && rating <= 5) ? rating : null };
                const guestName = form.querySelector('input[name="guest_name"]');
                const guestEmail = form.querySelector('input[name="guest_email"]');
                if (guestName) payload.guest_name = guestName.value.trim();
                if (guestEmail) payload.guest_email = guestEmail.value.trim();
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch(`${window.location.origin}/${type}/${id}/comments`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken || '' },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(data => {
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = origBtnText; }
                    if (data.success) {
                        toastr.success('Commentaire publié !');
                        form.reset();
                        if (ratingHidden) ratingHidden.value = 0;
                        if (ratingInput) {
                            ratingInput.querySelectorAll('i[data-value]').forEach((s, i) => {
                                s.classList.toggle('fa-star', false);
                                s.classList.toggle('fa-star-o', true);
                                s.classList.toggle('text-warning', false);
                                s.classList.toggle('text-muted', true);
                            });
                        }
                        loadServiceComments();
                    } else toastr.error(data.message || 'Erreur');
                }).catch(err => { if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = origBtnText; } console.error(err); toastr.error('Erreur lors de l\'envoi.'); });
            });
        })();
    </script>
@endsection
