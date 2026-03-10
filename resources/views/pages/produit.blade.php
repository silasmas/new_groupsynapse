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
          <section class="shop-details-area pt-100 pb-100">
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
                                        aria-controls="val" aria-selected="false">Commentaires</a>
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
                                        <button id="service-show-all-comments" class="btn btn-sm mb-4" style="background:#FD0100;color:#fff;">Voir tous les commentaires</button>
                                        <div class="comment-reply-box mt-4">
                                            <h5 class="b-details-inner-title mb-35">Laisser un commentaire et noter</h5>
                                            <form id="service-comment-form" data-type="produit" data-id="{{ $produit->id }}" class="comment-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="d-block mb-2">Votre note</label>
                                                    <div class="rating-input" data-rating="0">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star-o fa-lg text-muted" data-value="{{ $i }}" style="cursor:pointer;"></i>
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
                        <div class="related-product-wrap pb-30">
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
                                    @include('parties.listeProd', ['p' => $sim])
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
        <div class="modal fade" id="serviceAllCommentsModal" tabindex="-1" aria-labelledby="serviceAllCommentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceAllCommentsModalLabel">Tous les commentaires</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="service-all-comment-list" class="list-unstyled mb-0"></ul>
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
        <section class="shop-details-area pt-100 pb-100">
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
                                        aria-controls="val" aria-selected="false">Commentaires</a>
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
                                        <button id="product-show-all-comments" class="btn btn-sm mb-4" style="background:#FD0100;color:#fff;">Voir tous les commentaires</button>
                                        <div class="comment-reply-box mt-4">
                                            <h5 class="b-details-inner-title mb-35">Laisser un commentaire et noter</h5>
                                            <form id="product-comment-form" data-type="produit" data-id="{{ $produit->id }}" class="comment-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="d-block mb-2">Votre note</label>
                                                    <div class="rating-input" data-rating="0">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star-o fa-lg text-muted" data-value="{{ $i }}" style="cursor:pointer;"></i>
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
                        <div class="related-product-wrap pb-30">
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
                                    @include('parties.listeProd', ['p' => $sim])
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
        {{-- Modal pour tous les commentaires produit --}}
        <div class="modal fade" id="productAllCommentsModal" tabindex="-1" aria-labelledby="productAllCommentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productAllCommentsModalLabel">Tous les commentaires</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="product-all-comment-list" class="list-unstyled mb-0"></ul>
                    </div>
                </div>
            </div>
        </div>
    @endsection


@endif

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                const li = document.createElement('li');
                li.innerHTML = `<div class="single-comment"><div class="comment-avatar-img" style="width:50px;height:50px;min-width:50px;border-radius:50%;overflow:hidden;display:flex;align-items:center;justify-content:center;">${avatarHtml}</div><div class="comment-text"><div class="comment-avatar-info"><h5>${c.author_name} <span class="comment-date">${c.date}</span></h5></div><p class="comment-body">${text}${truncated ? '<a href="#" class="read-more">Voir plus</a>' : ''}</p></div></div>`;
                if (truncated) {
                    li.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); li.querySelector('.comment-body').textContent = c.body; });
                }
                return li;
            }

            async function loadProductComments() {
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/latest`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Erreur ' + res.status);
                    const comments = await res.json();
                    list.innerHTML = '';
                    comments.forEach(c => list.appendChild(createCommentItem(c)));
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger les commentaires.');
                }
            }

            async function loadAllProductComments() {
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/all`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Statut ' + res.status);
                    const comments = await res.json();
                    allList.innerHTML = '';
                    comments.forEach(c => allList.appendChild(createCommentItem(c)));
                    new bootstrap.Modal(document.getElementById('productAllCommentsModal')).show();
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger tous les commentaires.');
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

            if (btnAll) btnAll.addEventListener('click', loadAllProductComments);
            loadProductComments();

            form.addEventListener('submit', function(e) {
                e.preventDefault();
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
                }).catch(err => { console.error(err); toastr.error('Erreur lors de l\'envoi.'); });
            });
        })();

        // ─── Commentaires service (si on est sur une page service) ───
        (function() {
            const form = document.getElementById('service-comment-form');
            if (!form) return;

            const list = document.getElementById('service-comment-list');
            const allList = document.getElementById('service-all-comment-list');
            const btnAll = document.getElementById('service-show-all-comments');
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
                const li = document.createElement('li');
                li.innerHTML = `<div class="single-comment"><div class="comment-avatar-img" style="width:50px;height:50px;min-width:50px;border-radius:50%;overflow:hidden;display:flex;align-items:center;justify-content:center;">${avatarHtml}</div><div class="comment-text"><div class="comment-avatar-info"><h5>${c.author_name} <span class="comment-date">${c.date}</span></h5></div><p class="comment-body">${text}${truncated ? '<a href="#" class="read-more">Voir plus</a>' : ''}</p></div></div>`;
                if (truncated) {
                    li.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); li.querySelector('.comment-body').textContent = c.body; });
                }
                return li;
            }

            async function loadServiceComments() {
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/latest`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Erreur ' + res.status);
                    const comments = await res.json();
                    list.innerHTML = '';
                    comments.forEach(c => list.appendChild(createCommentItem(c)));
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger les commentaires.');
                }
            }

            async function loadAllServiceComments() {
                try {
                    const type = form.dataset.type, id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/all`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Statut ' + res.status);
                    const comments = await res.json();
                    allList.innerHTML = '';
                    comments.forEach(c => allList.appendChild(createCommentItem(c)));
                    new bootstrap.Modal(document.getElementById('serviceAllCommentsModal')).show();
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger tous les commentaires.');
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

            if (btnAll) btnAll.addEventListener('click', loadAllServiceComments);
            loadServiceComments();

            form.addEventListener('submit', function(e) {
                e.preventDefault();
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
                }).catch(err => { console.error(err); toastr.error('Erreur lors de l\'envoi.'); });
            });
        })();
    </script>
@endsection
