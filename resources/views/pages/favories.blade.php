@extends('layouts.template')

@section('content')
    @include('parties.banner', ['page' => 'Favorie'])
    <!-- wishlist-area -->
    <section class="wishlist-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-10">
                    @if (session()->has('favories') && session()->get('favories') !== null)
                        <div class="table-responsive-xl">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail"></th>
                                        <th class="product-name">Nom</th>
                                        <th class="product-price">Prix</th>
                                        {{-- <th class="product-quantity">QUANTITY</th>
                                        <th class="product-subtotal">SUBTOTAL</th> --}}
                                        <th class="product-stock-status">Stock</th>
                                        <th class="product-add-to-cart"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse (session()->get("favories") as $fav)
                                    @dump($fav->imageUrls[1])
                                        <tr id="fav-row-{{ $fav->id }}">
                                            <td class="product-thumbnail">
                                                <a href="{{ route('removeFavorie', ['id' => $fav->id]) }}"
                                                    data-id="{{ $fav->id }}"
                                                    class="wishlist-remove remove-favorie-btn">
                                                    <i class="flaticon-cancel-1"></i>
                                                </a>
                                                <a href="{{ route('showProduct', ['slug' => $fav->slug]) }}"><img
                                                        src="{{ asset('storage/'.$fav->imageUrls[0]) }}" alt=""></a>
                                            </td>
                                            <td class="product-name">
                                                <h4><a
                                                        href="{{ route('showProduct', ['slug' => $fav->slug]) }}">{{ $fav->name }}</a>
                                                </h4>
                                                <p>{{ $fav->decription }}</p>
                                                {{-- <span>65% poly, 35% rayon</span> --}}
                                            </td>
                                            <td class="product-price">{{ $fav->prix }}</td>
                                           <td
                                                class="product-stock-status {{ $fav->isAvalable ? 'text-success' : 'text-danger' }}">
                                                <span>{{ $fav->isAvalable ? 'Disponible' : 'En riputre' }}</span>
                                            </td>
                                            <td class="product-add-to-cart">
                                                <a href="{{ route('cart.add', ['id' => $fav->id,"qty"=>1]) }}" data-id="{{ $fav->id }}"
                                                    class="btn add-to-cart-btn add-to-cart-fav">Ajouter au panier</a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <section class="error-area pt-80 pb-100">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-md-10">
                                        <div class="error-content text-center">
                                            <div class="error_txt">OUPS!</div>
                                            <h5>favories vide</h5>
                                            <p>
                                                Vous n'avez pas des produits en favories
                                            </p>

                                            <a href="{{ route('home') }}" class="btn btn-fill-out">Accueil</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- wishlist-area-end -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $(".btnp").on("click", function() {
                alert("ok");
                var $button = $(this);
                var oldValue = $button.parent().find("input").val();
                if ($button.text() == "+") {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                $button.parent().find("input").val(newVal);
            });
        });
        $(document).on("click", ".remove-favorie-btn", function(e) {
            e.preventDefault();
            let actionUrl = $(this).attr("href"); // URL d'ajout ou de suppression
            let favorieId = $(this).data('id');
            let row = $('#fav-row-' + favorieId);
            $.ajax({
                url: actionUrl,
                method: "GET",
                success: function(data) {
                    console.log(data)
                    if (data.reponse) {
                        updateFavorite(); // Rafraîchir le panier après l'action
                        swal({
                            title: data.message,
                            icon: 'success'
                        });
                        row.fadeOut(500, function() {
                            $(this).remove();
                            if ($('.remove-favorie-btn').length === 0) {
                                $('#wishlist-table tbody').append(
                                    '<tr id="empty-fav-message"><td colspan="5">Votre liste de favoris est vide.</td></tr>'
                                );
                            }
                        });
                    } else {
                        swal({
                            title: data.message,
                            icon: 'error'
                        });
                    }

                },
                error: function(xhr) {
                    alert("Erreur lors de la modification du panier.");
                }
            });
        });
        $(document).on("click", ".add-to-cart-fav", function(e) {
            e.preventDefault();
            let actionUrl = $(this).attr("href"); // URL d'ajout ou de suppression
            let favorieId = $(this).data('id');

            $.ajax({
                url: actionUrl,
                method: "GET",
                success: function(data) {
                    console.log(data)
                    swal({
                        title: data.message,
                        icon: 'success'
                    });
                    updateCartUI(); // Rafraîchir le panier après l'action

                },
                error: function(xhr) {
                    // alert("Erreur lors de la modification du panier.");
                    swal({
                        title: "Erreur lors de la modification du panier.",
                        icon: 'error'
                    });
                }
            });
        });
    </script>
@endsection
