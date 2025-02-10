@php
    $currentProduit = $produitSingle ?? $p ?? null;
@endphp
    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6" id="product-{{  $currentProduit->id }}">
        <div class="exclusive-item exclusive-item-three text-center mb-50">
            <div class="exclusive-item-thumb">
                <a href="{{ route('showProduct', ['slug' => $currentProduit->slug]) }}">
                    <img src="{{ asset($currentProduit->imageUrls()[3]) }}" alt="">
                    <img class="overlay-product-thumb" src="{{ asset($currentProduit->imageUrls()[4]) }}" alt="">
                </a>
                <ul class="action">
                    <li>
                        @if ($currentProduit->favories->isNotEmpty())
                            <a href="{{ route('removeFavorie', ['id' => $currentProduit->id,'qty'=>1]) }}" class="remove-to-favorie">
                                {{-- <i class="flaticon-heart text-danger"></i> --}}
                                <i class="fas fa-heart  text-danger"></i>
                            </a>
                        @else
                            <a href="{{ route('addFavorie', ['id' => $currentProduit->id]) }}" class="add-to-favorie">
                                {{-- <i class="flaticon-heart-outline text-secondary"></i> --}}
                                <i class="far fa-heart text-secondary"></i>
                            </a>
                        @endif
                    </li>
                    <li><a class="add-to-cart" href="{{ route('cart.add', ['id' => $currentProduit->id,"qty"=>1]) }}">
                        <i class="flaticon-supermarket"></i></a></li>
                    <li><a href="{{ route('showProduct', ['slug' => $currentProduit->slug]) }}">
                        <i class="flaticon-witness"></i></a>
                    </li>
                </ul>
            </div>
            <div class="exclusive-item-content">
                <h5><a href="{{ route('showProduct', ['slug' => $currentProduit->slug]) }}">{{ $currentProduit->name }}</a></h5>
                <div class="exclusive--item--price">

                        {!!  formatPrix3($currentProduit->isSpecialOffer ,$currentProduit->prix ,$currentProduit->soldePrice,$currentProduit->currency) !!}

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


