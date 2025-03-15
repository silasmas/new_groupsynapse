@extends('layouts.template')

@section('content')
    @include('parties.banner', ['page' => 'Panier'])
    <!-- shop-cart-area -->
    <section class="shop-cart-area wishlist-area pt-100 pb-100">
        <div class="container">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="table-responsive-xl">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail"></th>
                                    <th class="product-name">Produit</th>
                                    <th class="product-price">Prix Unitaire</th>
                                    <th class="product-quantity">Quantité</th>
                                    <th class="product-subtotal">Sous total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $productId => $item)
                                    {{-- @dd($item->prixTotal) --}}
                                    <tr id="fav-row-{{ $item->produit->id }}">
                                        <td class="product-thumbnail">
                                            <a href="{{ route('cart.remove', ['id' => $item->produit->id, 'qty' => $item->quantite]) }}"
                                                data-id="{{ $item->produit->id }}" class="wishlist-remove card-remouve">
                                                <i class="flaticon-cancel-1"></i></a>
                                            <a href="{{ route('showProduct', ['slug' => $item->produit->slug]) }}">
                                                <img width="100" src="{{ asset($item->produit->first_image) }}"
                                                    alt=""></a>
                                        </td>
                                        <td class="product-name">
                                            <h4><a
                                                    href="{{ route('showProduct', ['slug' => $item->produit->slug]) }}">{{ $item->produit->name }}</a>
                                            </h4>
                                            <p>{{ Str::limit($item->produit->desc, 50, '...') }}</p>
                                            {{-- <span>65% poly, 35% rayon</span> --}}
                                        </td>
                                        <td class="product-price">
                                            {{ formatPrix($item->produit->prix,$item->produit->currency) }}
                                        </td>
                                        <td class="product-quantity">
                                            <div class="cart-plus">
                                                <form action="#">
                                                    <div class="cart-plus-minus">
                                                        <a data-qty="{{ $item->quantite }}" data-type="moins"
                                                            href="{{ route('cart.update', ['id' => $item->produit->id, 'qty' => 1, 'type' => 'moins']) }}"
                                                            class="dec qtybutton add-to-cart-btn">-</a>
                                                        <input type="text" value="{{ $item->quantite }}">
                                                        <a data-qty="{{ $item->quantite }}" data-type="plus"
                                                            href="{{ route('cart.update', ['id' => $item->produit->id, 'qty' => 1, 'type' => 'plus']) }}"
                                                            class="inc qtybutton add-to-cart-btn">+</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="product-subtotal"><span>
                                            {{ formatPrix($item->prixTotal) }}

                                        </span></td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="shop-cart-bottom mt-20">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="cart-coupon">
                                    {{-- <form action="#">
                                        <input type="text" placeholder="Enter Coupon Code...">
                                        <button class="btn">Apply Coupon</button>
                                    </form> --}}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="continue-shopping">
                                    <a href="{{ route('shop') }}" class="btn">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <aside class="shop-cart-sidebar">
                        <div class="shop-cart-widget">
                            <h6 class="title">Totals du panier</h6>
                            <form action="#">
                                {{-- @dd($total) --}}
                                <ul>
                                    {{-- <li id="grantTotale1"><span>SUBTOTAL</span> {{ formatPrix($total) }}</li> --}}
                                    <li>
                                        <span>Livraison</span>
                                        <div class="shop-check-wrap">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Montant :  $15</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2">LIVRAISON GRATUITE</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cart-total-amount"><span>TOTAL</span> <span class="amount"
                                            id="grantTotale">{{ formatPrix($total) }}</span>
                                    </li>
                                </ul>
                            <button class="btn" onclick="event.preventDefault(); window.location.href = '/checkout';">COMMANDER</button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- shop-cart-area-end -->

    <!-- core-features -->
    <section class="core-features-area core-features-style-two">
        <div class="container">
            <div class="core-features-border">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="assets/img/icon/core_features01.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Free Shipping On Over $ 50</h6>
                                <span>Agricultural mean crops livestock</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="assets/img/icon/core_features02.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Membership Discount</h6>
                                <span>Only MemberAgricultural livestock</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="assets/img/icon/core_features03.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Money Return</h6>
                                <span>30 days money back guarantee</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="assets/img/icon/core_features04.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Online Support</h6>
                                <span>30 days money back guarantee</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- core-features-end -->

    <!-- limited-offer-area -->
    {{-- <section class="limited-offer-area" data-background="{{ asset('assets/img/bg/limited_offer_bg.jpg') }}">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="limited-offer-left">
                        <div class="limited-offer-title">
                            <span class="sub-title">exclusive offer</span>
                            <h2 class="title">Smart Watch Bracelet</h2>
                        </div>
                        <div class="limited-offer-disc">
                            <img src="img/images/limited_offer_discount.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-5">
                    <div class="limited-offer-action">
                        <a href="#" class="btn">limited time offer</a>
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
        <div class="limited-overlay-img"><img src="{{ asset('asstes/img/images/limited_offer_img.png') }}" alt=""></div>
    </section> --}}
@endsection
@section('script')
    <script>

        $(document).on("click", ".card-remouve", function(e) {
            e.preventDefault();
            let actionUrl = $(this).attr("href"); // URL pour supprimer l'article
            let productId = $(this).data('id');
            let row = $('#fav-row-' + productId);


            $.ajax({
                url: actionUrl,
                method: "GET",
                success: function(response) {
                    console.log(response);
                    if (response.reponse) {
                        row.fadeOut(500, function() {
                            $(this).remove();
                            if ($(".card-remouve").length === 0) {
                                $(".table tbody").append(
                                    '<tr id="empty-cart-message"><td colspan="5">Votre panier est vide.</td></tr>'
                                );
                            }
                        });
                        updateCartTotal(response)
                        updateCartUI();
                        swal({
                            title: response.message,
                            icon: 'success'
                        });
                    } else {
                        swal({
                            title: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    alert("Erreur lors de la suppression du produit.");
                }
            });
        });
        $(document).on("click", ".add-to-cart-btn", function(e) {
            e.preventDefault();

            let type = $(this).data("type");
            let qty = $(this).data("qty");
            if (type == "moins" && qty - 1 < 1) {
                swal({
                    title: "La quantité ne peut être inferieur à 1",
                    icon: 'error'
                });
                return;
            }
             handleCartUpdate($(this));


        });

        function handleCartUpdate(button) {
            let actionUrl = button.attr("href");
            console.log(" valeur :" + actionUrl )
            $.ajax({
                url: actionUrl,
                method: "GET",
                success: function(response) {
                    console.log("Donnée : " + response.total);

                    if (response.reponse) {
                        updateCartUI();
                        updateCartRow(button, response);

                        swal({
                            title: response.message,
                            icon: 'success'
                        });
                    } else {
                        swal({
                            title: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    alert("Erreur lors de la mise à jour du panier.");
                }
            });
        }

        function updateCartRow(button, response) {
            let productId = button.closest("tr").attr("id").split("-")[2];

            let row = $('#fav-row-' + productId);
            let grt = $('#grantTotale');
            let grt1 = $('#grantTotale1');

            console.log(" valeur ROXW :" + row)
            let quantityInput = row.find("input[type='text']");
            console.log(" valeur input :" + quantityInput.val())
            let subtotalCell = row.find(".product-subtotal span");
            console.log(" valeur update :" + response.qty)
            quantityInput.val(response.qty);
            console.log(" valeur subtotal :" + response.total.toFixed(2))
            subtotalCell.text(response.total.toFixed(2) + " $");
            updateCartTotal(response);
        }
        // Fonction pour recalculer le total du panier
        function updateCartTotal(response) {
            if ($('#grantTotale').length === 0) {
                console.error("Les éléments #grantTotale ou #grantTotale1 sont introuvables dans le DOM.");
            } else {
                console.log(" valeur grand :" + response.grandTotal)
                $('#grantTotale').text(parseFloat(response.grandTotal).toFixed(2) + " $").trigger('change');
                $('#grantTotale1').text(parseFloat(response.grandTotal).toFixed(2) + " $").trigger('change');
            }
        }
    </script>
@endsection
