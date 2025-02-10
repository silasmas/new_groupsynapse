@extends('layouts.template')

@section('content')
    @include('parties.banner', ['page' => 'Commande'])
    <section class="checkout-area pt-100 pb-100">
        <div class="container">
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
                                @forelse ($panier as $productId => $item)
                                    {{-- @dd($item) --}}
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
                                            <p>{{ Str::limit($item->produit->description, 20, '...') }}</p>
                                            {{-- <span>silas</span> --}}
                                        </td>
                                        <td class="product-price">
                                            {{ formatPrix($item->produit->prix,$item->produit->currency) }}
                                        </td>
                                        <td class="product-price">
                                            {{ $item->quantite }}
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
                </div>
                <div class="col-lg-4 col-md-8">
                    <aside class="shop-cart-sidebar checkout-sidebar">
                        <div class="shop-cart-widget">
                            <h6 class="title">Total du panier</h6>
                            <form action="#">
                                <ul>
                                    <li><span>Sous total :</span>{{ formatPrix() }}</li>
                                    <li>
                                        <span>SHIPPING</span>
                                        <div class="shop-check-wrap">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">FLAT RATE:
                                                    $15</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2">FREE
                                                    SHIPPING</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cart-total-amount"><span>TOTAL</span> <span class="amount">$ 151.00</span>
                                    </li>
                                </ul>
                                <div class="bank-transfer">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                                        <label class="custom-control-label" for="customCheck3">Direct Bank
                                            Transfer</label>
                                    </div>
                                </div>
                                <div class="bank-transfer">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck4">
                                        <label class="custom-control-label" for="customCheck4">Cash On Delivery</label>
                                    </div>
                                </div>
                                <div class="paypal-method">
                                    <div class="paypal-method-flex">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                                            <label class="custom-control-label" for="customCheck5">PayPal</label>
                                        </div>
                                        <div class="paypal-logo"><img src="img/images/paypal_logo.png" alt="">
                                        </div>
                                    </div>
                                    <p>Pay via PayPal; you can pay with your credit
                                        card if you don’t have a PayPal account</p>
                                </div>
                                <div class="paypal-method">
                                    <div class="paypal-method-flex">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck6">
                                            <label class="custom-control-label" for="customCheck6">Payments on
                                                Card</label>
                                        </div>
                                        <div class="paypal-logo"><img src="img/images/payment_card.png" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="payment-terms">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck7">
                                        <label class="custom-control-label" for="customCheck7">I have read and agree to
                                            the website terms
                                            and conditions *</label>
                                    </div>
                                </div>
                                <button class="btn">PROCEED TO CHECKOUT</button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

            <!-- core-features -->
            <section class="core-features-area core-features-style-two">
                <div class="container">
                    <div class="core-features-border">
                        <div class="row justify-content-center">
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="core-features-item mb-50">
                                    <div class="core-features-icon">
                                        <img src="{{ asset('assets/img/icon/core_features01.png') }}" alt="">
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
                                        <img src="{{ asset('assets/img/icon/core_features02.png') }}" alt="">
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
                                        <img src="{{ asset('assets/img/icon/core_features03.png') }}" alt="">
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
                                        <img src="{{ asset('assets/img/icon/core_features04.png') }}" alt="">
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
