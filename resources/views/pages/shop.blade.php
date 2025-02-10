@extends('layouts.template')
@section('style')
    <style>
        li.active {}

        li.active a {
            color: red !important;
        }
    </style>
@section('content')
    @include('parties.banner', ['page' => 'Nos Produits'])
    <!-- shop-area -->
    <div class="shop-area gray-bg pt-100 pb-100">
        <div class="custom-container-two">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 order-2 order-lg-0">
                    <aside class="shop-sidebar">
                        <div class="widget shop-widget mb-30">
                            <div class="shop-widget-title">
                                <h6 class="title">Product Categories</h6>
                            </div>
                            <div class="shop-cat-list">
                                <ul>
                                    <li class="{{ request()->get('categorie') === 'all' ? 'active' : '' }}">
                                        <a href="#" class="categorie-item"
                                            data-id="all">Toutes</a><span>{{ $produits->total() }}</span>
                                    </li>
                                    @forelse ($categories->take(6) as $cat)
                                        <li class="{{ request()->get('categorie') == $cat->id ? 'active' : '' }}">
                                            <a class="categorie-item" href="#"
                                                data-id="{{ $cat->id }}">{{ $cat->name }}</a>
                                            <span>{{ $cat->produits->count() }}</span>
                                        </li>

                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>



                        <div class="widget">
                            <div class="shop-widget-banner special-offer-banner">
                                <a href="">
                                    <img src="{{ asset('assets/img/product/sidebar_banner_ad.jpg') }}" alt=""></a>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="shop-top-meta mb-40">
                        <p class="show-result">Showing Products 1-12 Of 10 Result</p>
                        <div class="shop-meta-right">
                            <ul>
                                <li class="active"><a href="#"><i class="flaticon-grid"></i></a></li>
                                <li><a href="#"><i class="flaticon-list"></i></a></li>
                            </ul>
                            <form action="#">
                                <select class="custom-select">
                                    <option selected="">Default Sorting</option>
                                    <option>Free Shipping</option>
                                    <option>Best Match</option>
                                    <option>Newest Item</option>
                                    <option>Size A - Z</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="row" id="listeP">
                        @forelse ($produits as $p)
                            @include('parties.listeProd', compact('p'))
                        @empty
                        @endforelse
                    </div>
                    <div class="pagination-wrap">
                        <ul>
                            {{ $produits->links('pagination::bootstrap-5') }}
                          </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop-area-end -->

@endsection
@section('script')
    <script>
        const sortByPrice = document.querySelector('#sortByPrice')
        const nbr = document.querySelector('#sortByNbr')



        const catItems = document.querySelectorAll('.categorie-item')
        catItems.forEach(element => {
            element.onclick = (event) => {
                event.preventDefault();
                let {
                    id
                } = event.target.dataset
                if (!id) {
                    id = event.target.parentNode.dataset.id
                }
                const urlParams = new URLSearchParams(window.location.search)
                urlParams.set("categorie", id)
                const newLink = window.location.origin + window.location.pathname + "?" + urlParams.toString();
                window.location.href = newLink;
            }
        });
    </script>
@endsection
