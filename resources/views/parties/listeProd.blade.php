@php
    $currentProduit = $produitSingle ?? $p ?? null;
    $images = $currentProduit->getImageUrlsAttribute();
    $img1 = $images[0] ?? null;
    $img2 = $images[1] ?? $img1;
    $initials = getInitials($currentProduit->name);
    $inSlider = $inSlider ?? false;
    $colClass = $colClass ?? 'col-xl-4 col-lg-6 col-md-4 col-sm-6';
    $extraClasses = $extraClasses ?? '';
    $wrapperClass = $inSlider ? 'related-product-slide' : $colClass . ' ' . $extraClasses;
@endphp
    <div class="{{ $wrapperClass }}" id="product-{{  $currentProduit->id }}">
        <div class="exclusive-item exclusive-item-three text-center mb-50">
            <div class="exclusive-item-thumb" style="position:relative;">
                <a href="{{ route('showProduct', ['slug' => $currentProduit->slug]) }}">
                    <div style="position:relative;width:100%;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                        @if(!empty($img1))
                            <img src="{{ $img1 }}" alt="{{ $currentProduit->name }}" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" onload="this.parentElement.style.background='#fff'" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <span style="display:none;font-weight:bold;font-size:2.5rem;color:white;">{{ $initials }}</span>
                        @else
                            <span style="font-weight:bold;font-size:2.5rem;color:white;">{{ $initials }}</span>
                        @endif
                        @if(!empty($img2) && $img2 !== $img1)
                            <img class="overlay-product-thumb" src="{{ $img2 }}" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                        @endif
                    </div>
                </a>
                <ul class="action">
                    <li>
                        @if ($currentProduit->favories->isNotEmpty())
                            <a href="{{ route('removeFavorie', ['id' => $currentProduit->id,'qty'=>1]) }}" class="remove-to-favorie">
                                <i class="fas fa-heart text-danger"></i>
                            </a>
                        @else
                            <a href="{{ route('addFavorie', ['id' => $currentProduit->id]) }}" class="add-to-favorie">
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
                <ul class="action action-mobile">
                    <li>
                        @if ($currentProduit->favories->isNotEmpty())
                            <a href="{{ route('removeFavorie', ['id' => $currentProduit->id,'qty'=>1]) }}" class="remove-to-favorie">
                                <i class="fas fa-heart text-danger"></i>
                            </a>
                        @else
                            <a href="{{ route('addFavorie', ['id' => $currentProduit->id]) }}" class="add-to-favorie">
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
                <div class="product-extra-info">
                    @if($currentProduit->categories->isNotEmpty())
                        <p class="mb-1 small text-muted"><strong>Catégories :</strong> {{ $currentProduit->categories->pluck('name')->take(3)->implode(', ') }}</p>
                    @endif
                    @if($currentProduit->brand)
                        <p class="mb-1 small text-muted"><strong>Marque :</strong> {{ $currentProduit->brand }}</p>
                    @endif
                    @if($currentProduit->description)
                        <p class="mb-1 small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($currentProduit->description), 80) }}</p>
                    @endif
                    <div class="product-badges mt-1">
                        @if($currentProduit->isBestseler)
                            <span class="badge mr-1" style="background:#FD0100;color:#fff;">Bestseller</span>
                        @endif
                        @if($currentProduit->isNewArivale)
                            <span class="badge" style="background:#17a2b8;color:#fff;">Nouveauté</span>
                        @endif
                    </div>
                </div>
                @php
                    $avgRating = round($currentProduit->avg_rating ?? 0);
                    $avgRating = max(0, min(5, $avgRating));
                @endphp
                <div class="rating product-rating mt-2" data-rating="{{ $avgRating }}" title="{{ $avgRating }}/5" style="min-height:20px;">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $avgRating ? '' : '-o' }} {{ $i <= $avgRating ? 'text-warning' : 'text-secondary' }}" style="font-size:0.9rem;"></i>
                    @endfor
                </div>
            </div>
        </div>
    </div>


