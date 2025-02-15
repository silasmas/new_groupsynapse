@extends('layouts.template')

@section('style')
    <style>
        #Contenairephone {
            display: none;
            /* Caché par défaut */
        }
    </style>
@endsection
@section('content')
    @include('parties.banner', ['page' => 'Commande'])
    <section class="checkout-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                @if (!empty($panier) && isset($panier['data'][0]))
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
                                    @forelse ($panier["data"] as $item)
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
                                                {{ is_solde($item->produit->isSpecialOffer, $item->produit->prix, $item->produit->soldePrice) }}
                                                {{-- {{ formatPrix($item->produit->prix,$item->produit->currency) }} --}}
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
                                <form id="formpaie" action="{{ route('caisse') }}" method="POST"
                                    onsubmit="submitForm(event)">
                                    @csrf
                                    <ul>
                                        <li><span>Sous total :</span>{{ formatPrix($panier['total']) }}</li>
                                        {{-- <li>
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
                                    </li> --}}
                                        <li class="cart-total-amount"><span>TOTAL</span> <span
                                                class="amount">{{ formatPrix($panier['total']) }}</span>
                                        </li>
                                    </ul>
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-sm-12 mb-10">
                                                <div class="form-grp">
                                                    <label>Moyen de paiement*</label>
                                                    <select required class="custom-select" name="channel" id="channel">
                                                        <option value="" selected>Selectionnez un moyen de paiement
                                                        </option>
                                                        <option value="mobile_money">Mobile money</option>
                                                        <option value="card">Carte bancaire</option>
                                                        {{-- <option value="California">Cash</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" id="Contenairephone">
                                                <div class="form-grp">
                                                    <label>Numéro de téléphone :</label>
                                                    <input class="custom-select " name="phone" type="text"
                                                        id="phone">
                                                    <input class="custom-select d-none" value="{{ $panier['total'] }}"
                                                        name="total" type="text" id="total">
                                                    <input class="custom-select d-none"
                                                        value="{{ $panier['data'][0]->produit->currency }}" name="currency"
                                                        type="text" id="currency">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="payment-terms">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" required class="custom-control-input"
                                                    id="customCheck7">
                                                <label class="custom-control-label" for="customCheck7">J'ai lu et j'accepte
                                                    les
                                                    conditions générales
                                                    du site Web*</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn">PASSER À LA CAISSE</button>
                                </form>
                            </div>
                        </aside>
                    </div>
                @else

                    <section class="error-area pt-80 pb-100">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-10">
                                    <div class="error-content text-center">
                                        <div class="error_txt">OUPS!</div>
                                        <h5>Aucune commande</h5>
                                        <p class="text-danger">Le panier est vide.</p>

                                        <a href="{{ route('mesAchats') }}" class="btn btn-fill-out">Voir ses commandes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

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
        document.addEventListener("DOMContentLoaded", function() {


            const selectElement = document.getElementById("channel");
            const extraFieldContainer = document.getElementById("Contenairephone");
            const extraField = document.getElementById("phone");

            selectElement.addEventListener("change", function() {
                if (this.value === "mobile_money") {
                    extraFieldContainer.style.display = "block";
                    extraField.setAttribute("required", "true");
                } else {
                    extraFieldContainer.style.display = "none";
                    extraField.removeAttribute("required");
                    extraField.value = ""; // Efface la valeur si caché
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const selectPayment = document.getElementById("channel"); // Sélecteur du moyen de paiement
            const phoneContainer = document.getElementById("Contenairephone"); // Conteneur de l'input téléphone
            const phoneInput = document.getElementById("phone"); // Input téléphone
            const checkboxTerms = document.getElementById("customCheck7"); // Case à cocher des conditions générales
            const submitButton = document.querySelector("button.btn"); // Bouton de soumission

            // Fonction pour mettre à jour la visibilité de l'input téléphone et l'état du bouton
            function updateFormState() {
                // Vérifie si Mobile Money est sélectionné pour afficher ou cacher le champ téléphone
                if (selectPayment.value === "mobile_money") {
                    phoneContainer.style.display = "block";
                    phoneInput.required = true; // Rend le champ obligatoire
                } else {
                    phoneContainer.style.display = "none";
                    phoneInput.required = false; // Retire l'obligation de remplir le champ
                    phoneInput.value = ""; // Réinitialise la valeur si caché
                }

                // Active ou désactive le bouton submit en fonction de la case cochée
                submitButton.disabled = !checkboxTerms.checked;
            }

            // Vérifier l'état initial au chargement
            updateFormState();

            // Écoute les changements sur le select (moyen de paiement)
            selectPayment.addEventListener("change", updateFormState);

            // Écoute les changements sur la case à cocher des conditions générales
            checkboxTerms.addEventListener("change", updateFormState);
        });



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
                                    '<tr id="empty-cart-message"><td colspan = "5"> Votre panier est vide.</td></tr>'
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
