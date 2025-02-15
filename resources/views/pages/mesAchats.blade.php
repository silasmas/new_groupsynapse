@extends('layouts.template')

@section('content')
    @include('parties.banner', ['page' => 'Mes achats'])
    <!-- wishlist-area -->
    <section class="wishlist-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                        <div class="table-responsive-xl">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Photos</th>
                                        <th class="product-name">Nom</th>
                                        <th class="product-price">Prix</th>
                                        <th class="product-quantity">Quantité</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-add-to-cart">Status</th>
                                        <th class="product-add-to-cart">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($commandes as $fav)
                                    @forelse ($fav->produits as $item)

                                        <tr id="fav-row-{{ $item->id }}">
                                            <td class="product-thumbnail">
                                                <a href="{{ route('removeFavorie', ['id' => $item->id]) }}"
                                                    data-id="{{ $item->id }}"
                                                    class="wishlist-remove remove-favorie-btn">
                                                    <i class="flaticon-cancel-1"></i>
                                                </a>
                                                <a href="{{ route('showProduct', ['slug' => $item->slug]) }}">
                                                    <img height="100" width="100" src="{{ asset($item->getFirstImageAttribute()) }}" alt=""></a>
                                            </td>
                                            <td class="product-name" style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                            title="{{ $item->description }}">
                                                <h4><a
                                                        href="{{ route('showProduct', ['slug' => $item->slug]) }}">{{ $item->name }}</a>
                                                </h4>
                                                <span>{{Str::limit($item->description, 100, '...')  }}</span>
                                                {{-- <span>65% poly, 35% rayon</span> --}}
                                            </td>
                                            <td class="product-price">{{ $item->pivot->prix_unitaire.$item->currency}}</td>
                                            <td class="product-price text-center">{{ $item->pivot->quantite}}</td>
                                            <td class="product-price">{{ $item->pivot->prix_total.$item->currency}}</td>
                                            <td class="product-stock-status text-center text-success">{{ $fav->etat}}</td>
                                           <td
                                                class="product-price text-center">
                                                <span>{{ $fav->created_at->diffForHumans() }}</span>
                                            </td>
                                            {{-- <td class="product-add-to-cart">
                                                <a href="{{ route('cart.add', ['id' => $fav->id,"qty"=>1]) }}" data-id="{{ $fav->id }}"
                                                    class="btn add-to-cart-btn add-to-cart-fav">Ajouter au panier</a>
                                            </td> --}}
                                        </tr>
                                        @empty

                                        @endforelse
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                </div>
            </div>
        </div>
    </section>
    <!-- wishlist-area-end -->
@endsection
