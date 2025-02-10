@extends('layouts.template')

@section('content')
    @include('parties.banner', ['page' => 'Detail produit'])

    <!-- shop-details-area -->
    <section class="shop-details-area pt-100 pb-100">
        <div class="container">
            <div class="row mb-95">
                <div class="col-xl-7 col-lg-6">
                    <div class="shop-details-nav-wrap">
                        <div class="shop-details-nav">
                            @forelse ($produit->imageUrls() as $p)
                                <div class="shop-nav-item">
                                    <img src="{{ asset($p) }}" alt="">
                                </div>

                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="shop-details-img-wrap">
                        <div class="shop-details-active">
                            @forelse ($produit->imageUrls() as $p)
                                <div class="shop-details-img">
                                    <a href="{{ asset($p) }}" class="popup-image"><img src="{{ asset($p) }}"
                                            alt=""></a>
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="shop-details-content">
                        <span class="stock-info">{{ $produit->isAvalable ? 'Disponible' : 'En ripture' }}</span>
                        <h2>{{ $produit->name }}</h2>
                        {{-- <div class="shop-details-review">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span>- 3 Customer Reviews</span>
                        </div> --}}
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
                                data-id="{{ $produit->id }}" class="btn add-card-btn add-to-cart-btn">ADD TO CART</a>
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
                                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab"
                                    aria-controls="details" aria-selected="true">Product Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="val-tab" data-toggle="tab" href="#val" role="tab"
                                    aria-controls="val" aria-selected="false">Viewers Also Like</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="looks-tab" data-toggle="tab" href="#looks" role="tab"
                                    aria-controls="looks" aria-selected="false">Looks</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="product-desc-content">
                                    <h4 class="title">Product Details</h4>
                                    <div class="row">
                                        <div class="col-xl-3 col-md-4">
                                            <div class="product-desc-img">
                                                <img src="img/product/desc_img.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-9 col-md-8">
                                            <h5 class="small-title">The Christina Fashion</h5>
                                            <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into
                                                electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and
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
                                    <h4 class="title">Product Details</h4>
                                    <div class="row">
                                        <div class="col-xl-3 col-md-4">
                                            <div class="product-desc-img">
                                                <img src="img/product/desc_img.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-9 col-md-8">
                                            <h5 class="small-title">The Christina Fashion</h5>
                                            <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into
                                                electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and
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
                            <div class="tab-pane fade" id="looks" role="tabpanel" aria-labelledby="looks-tab">
                                <div class="product-desc-content">
                                    <h4 class="title">Product Details</h4>
                                    <div class="row">
                                        <div class="col-xl-3 col-md-4">
                                            <div class="product-desc-img">
                                                <img src="img/product/desc_img.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-9 col-md-8">
                                            <h5 class="small-title">The Christina Fashion</h5>
                                            <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into
                                                electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and
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
                            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                <div class="product-desc-content">
                                    <h4 class="title">Product Details</h4>
                                    <div class="row">
                                        <div class="col-xl-3 col-md-4">
                                            <div class="product-desc-img">
                                                <img src="img/product/desc_img.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-9 col-md-8">
                                            <h5 class="small-title">The Christina Fashion</h5>
                                            <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into
                                                electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and
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
                            <div class="tab-pane fade" id="qa" role="tabpanel" aria-labelledby="qa-tab">
                                <div class="product-desc-content">
                                    <h4 class="title">Product Details</h4>
                                    <div class="row">
                                        <div class="col-xl-3 col-md-4">
                                            <div class="product-desc-img">
                                                <img src="img/product/desc_img.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-9 col-md-8">
                                            <h5 class="small-title">The Christina Fashion</h5>
                                            <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into
                                                electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and
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
                        </div>
                    </div>
                    <div class="shop-details-add mb-95">
                        <a href="#"><img src="img/product/shop_details_add.jpg" alt=""></a>
                    </div>
                    <div class="related-product-wrap pb-95">
                        <div class="deal-day-top">
                            <div class="deal-day-title">
                                <h4 class="title">Viewers Also Liked</h4>
                            </div>
                            <div class="related-slider-nav">
                                <div class="slider-nav"></div>
                            </div>
                        </div>
                        <div class="row related-product-active">
                            <div class="col-xl-3">
                                <div class="exclusive-item exclusive-item-three text-center">
                                    <div class="exclusive-item-thumb">
                                        <a href="shop-details.html">
                                            <img src="img/product/td_product_img01.jpg" alt="">
                                            <img class="overlay-product-thumb" src="img/product/t_exclusive_product01.jpg"
                                                alt="">
                                        </a>
                                        <ul class="action">
                                            <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                            <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                            <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="exclusive-item-content">
                                        <h5><a href="shop-details.html">Farfetch Mulberry Belted</a></h5>
                                        <div class="exclusive--item--price">
                                            <del class="old-price">$69.00</del>
                                            <span class="new-price">$58.00</span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="exclusive-item exclusive-item-three text-center">
                                    <div class="exclusive-item-thumb">
                                        <a href="shop-details.html">
                                            <img src="img/product/td_product_img02.jpg" alt="">
                                            <img class="overlay-product-thumb" src="img/product/td_product_img05.jpg"
                                                alt="">
                                        </a>
                                        <ul class="action">
                                            <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                            <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                            <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="exclusive-item-content">
                                        <h5><a href="shop-details.html">Luxury Fashion Bag</a></h5>
                                        <div class="exclusive--item--price">
                                            <del class="old-price">$69.00</del>
                                            <span class="new-price">$29.00</span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="exclusive-item exclusive-item-three text-center">
                                    <div class="exclusive-item-thumb">
                                        <a href="shop-details.html">
                                            <img src="img/product/td_product_img03.jpg" alt="">
                                            <img class="overlay-product-thumb" src="img/product/t_exclusive_product04.jpg"
                                                alt="">
                                        </a>
                                        <ul class="action">
                                            <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                            <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                            <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="exclusive-item-content">
                                        <h5><a href="shop-details.html">Men's Lathers Jacket</a></h5>
                                        <div class="exclusive--item--price">
                                            <del class="old-price">$69.00</del>
                                            <span class="new-price">$58.00</span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="exclusive-item exclusive-item-three text-center">
                                    <div class="exclusive-item-thumb">
                                        <a href="shop-details.html">
                                            <img src="img/product/td_product_img04.jpg" alt="">
                                            <img class="overlay-product-thumb" src="img/product/td_product_img05.jpg"
                                                alt="">
                                        </a>
                                        <ul class="action">
                                            <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                            <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                            <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="exclusive-item-content">
                                        <h5><a href="shop-details.html">Women Brand T-shirt</a></h5>
                                        <div class="exclusive--item--price">
                                            <del class="old-price">$49.00</del>
                                            <span class="new-price">$21.00</span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="exclusive-item exclusive-item-three text-center">
                                    <div class="exclusive-item-thumb">
                                        <a href="shop-details.html">
                                            <img src="img/product/td_product_img02.jpg" alt="">
                                            <img class="overlay-product-thumb" src="img/product/td_product_img05.jpg"
                                                alt="">
                                        </a>
                                        <ul class="action">
                                            <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                            <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                            <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="exclusive-item-content">
                                        <h5><a href="shop-details.html">Luxury Fashion Bag</a></h5>
                                        <div class="exclusive--item--price">
                                            <del class="old-price">$69.00</del>
                                            <span class="new-price">$29.00</span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- shop-details-area-end -->
@endsection

@section('script')
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
    </script>
@endsection
