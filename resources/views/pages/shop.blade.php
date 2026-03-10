@extends('layouts.template')
@section('style')
    <style>
        li.active a {
            color: red !important;
        }
        .shop-top-meta .view-toggle {
            display: flex;
            overflow: hidden;
            border-radius: 4px;
        }
        .shop-top-meta .view-toggle li {
            margin: 0;
        }
        .shop-top-meta .view-toggle li a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 0;
            color: #2d2d2d;
            transition: all 0.3s;
            overflow: hidden;
            box-sizing: border-box;
        }
        .shop-top-meta .view-toggle li:first-child a { border-radius: 4px 0 0 4px; }
        .shop-top-meta .view-toggle li:last-child a { border-radius: 0 4px 4px 0; }
        .shop-top-meta .view-toggle li:only-child a { border-radius: 4px; }
        .shop-top-meta .view-toggle li.active a,
        .shop-top-meta .view-toggle li.active a i {
            background: #FD0100 !important;
            color: #fff !important;
        }
        .shop-top-meta .view-toggle li a:hover {
            background: #FD0100;
            color: #fff;
        }
        .shop-top-meta .view-toggle li a:hover i {
            color: #fff !important;
        }
        #listeP.list-view .col-xl-4 { flex: 0 0 100%; max-width: 100%; }
        #listeP.list-view .exclusive-item-three {
            display: flex;
            flex-direction: row;
            text-align: left;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: box-shadow 0.3s, transform 0.3s;
        }
        #listeP.list-view .exclusive-item-three:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }
        #listeP.list-view .exclusive-item-three .exclusive-item-thumb {
            flex: 0 0 280px;
            max-width: 280px;
            margin-right: 25px;
            margin-bottom: 0;
        }
        #listeP.list-view .exclusive-item-three .exclusive-item-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        #listeP.list-view .exclusive-item-three .action {
            left: 0;
            right: auto;
            width: 280px;
        }
        .product-extra-info { display: none; }
        #listeP.list-view .product-extra-info { display: block; }
        .exclusive-item-three .action li a {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        .exclusive-item-three .action li a:hover,
        .exclusive-item-three .action li a:hover i {
            color: #fff !important;
        }
        .pagination-wrap {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .pagination-wrap nav {
            width: 100%;
        }
        .pagination-wrap .pagination {
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }
        .pagination-wrap .page-item .page-link {
            min-width: 40px;
            text-align: center;
            border-radius: 4px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pagination-wrap .page-item.active .page-link {
            background: #FD0100;
            border-color: #FD0100;
            color: #fff;
        }
        .shop-loading {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        .shop-content-wrap { position: relative; min-height: 200px; }
        #listeP .exclusive-item-three {
            transition: box-shadow 0.3s, transform 0.3s;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            padding-bottom: 28px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        #listeP .exclusive-item-three .exclusive-item-content {
            padding: 20px 24px 0;
        }
        #listeP:not(.list-view) .exclusive-item-three:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
    </style>
@endsection
@section('content')
    @include('parties.banner', ['page' => 'Nos Produits'])
    <div class="shop-area gray-bg pt-100 pb-100">
        <div class="custom-container-two">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 order-2 order-lg-0">
                    <aside class="shop-sidebar">
                        <div class="widget shop-widget mb-30">
                            <div class="shop-widget-title">
                                <h6 class="title">Catégories de produits</h6>
                            </div>
                            <div class="shop-cat-list">
                                <ul>
                                    <li class="{{ !request()->get('categorie') || request()->get('categorie') === 'all' ? 'active' : '' }}">
                                        <a href="#" class="categorie-item" data-id="all">Toutes</a>
                                        <span>{{ $totalSansCategorie ?? $produits->total() }}</span>
                                    </li>
                                    @forelse ($categories->take(10) as $cat)
                                        <li class="{{ request()->get('categorie') == $cat->id ? 'active' : '' }}">
                                            <a class="categorie-item" href="#" data-id="{{ $cat->id }}">{{ $cat->name }}</a>
                                            <span>{{ $cat->produits_count ?? 0 }}</span>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="widget">
                            <div class="shop-widget-banner special-offer-banner">
                                <a href=""><img src="{{ asset('assets/img/product/sidebar_banner_ad.jpg') }}" alt=""></a>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="shop-top-meta mb-40">
                        <p class="show-result">Affichage de <span id="shop-from">{{ $produits->firstItem() ?? 0 }}</span> à <span id="shop-to">{{ $produits->lastItem() ?? 0 }}</span> sur <span id="shop-total">{{ $produits->total() }}</span> résultats</p>
                        <div class="shop-meta-right">
                            <ul class="view-toggle">
                                <li class="active" data-view="grid"><a href="#" title="Vue grille"><i class="flaticon-grid"></i></a></li>
                                <li data-view="list"><a href="#" title="Vue liste"><i class="flaticon-list"></i></a></li>
                            </ul>
                            <form id="shop-sort-form" class="d-inline">
                                <select name="sort" class="custom-select shop-sort-select">
                                    <option value="">Tri par défaut</option>
                                    <option value="nouveautes" {{ request('sort') === 'nouveautes' ? 'selected' : '' }}>Nouveautés</option>
                                    <option value="prix_asc" {{ request('sort') === 'prix_asc' ? 'selected' : '' }}>Prix croissant</option>
                                    <option value="prix_desc" {{ request('sort') === 'prix_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                    <option value="nom_asc" {{ request('sort') === 'nom_asc' ? 'selected' : '' }}>Nom A - Z</option>
                                    <option value="nom_desc" {{ request('sort') === 'nom_desc' ? 'selected' : '' }}>Nom Z - A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="shop-content-wrap">
                        <div class="row" id="listeP">
                            @forelse ($produits as $p)
                                @include('parties.listeProd', compact('p'))
                            @empty
                                <div class="col-12 text-center py-5">
                                    <p class="text-muted">Aucun produit trouvé.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="pagination-wrap mt-4">
                            {{ $produits->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
(function() {
    const baseUrl = '{{ route("shop") }}';
    const listeP = document.getElementById('listeP');
    const paginationWrap = document.querySelector('.pagination-wrap');
    const shopContentWrap = document.querySelector('.shop-content-wrap');

    function getParams() {
        const u = new URL(window.location.href);
        return {
            categorie: u.searchParams.get('categorie') || 'all',
            sort: u.searchParams.get('sort') || '',
            nbr: u.searchParams.get('nbr') || '',
            q: u.searchParams.get('q') || '',
            page: u.searchParams.get('page') || '1'
        };
    }

    function buildUrl(params) {
        const p = getParams();
        Object.assign(p, params);
        const search = new URLSearchParams();
        if (p.categorie && p.categorie !== 'all') search.set('categorie', p.categorie);
        if (p.sort) search.set('sort', p.sort);
        if (p.nbr) search.set('nbr', p.nbr);
        if (p.q) search.set('q', p.q);
        if (p.page && p.page !== '1') search.set('page', p.page);
        return baseUrl + (search.toString() ? '?' + search.toString() : '');
    }

    function loadShop(extraParams) {
        const url = buildUrl(extraParams || {});
        const loader = document.createElement('div');
        loader.className = 'shop-loading';
        loader.innerHTML = '<div class="spinner-border text-danger" role="status"><span class="sr-only">Chargement...</span></div>';
        shopContentWrap.style.position = 'relative';
        shopContentWrap.appendChild(loader);

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                listeP.innerHTML = data.html;
                if (data.pagination) paginationWrap.innerHTML = data.pagination;
                document.getElementById('shop-from').textContent = data.from || 0;
                document.getElementById('shop-to').textContent = data.to || 0;
                document.getElementById('shop-total').textContent = data.total || 0;
                history.replaceState({}, '', url);
                bindPagination();
            })
            .catch(() => { if (loader.parentNode) loader.remove(); })
            .finally(() => { if (loader.parentNode) loader.remove(); });
    }

    function bindPagination() {
        paginationWrap.querySelectorAll('a.page-link[href]').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (!href || href === '#') return;
                const u = new URL(href, window.location.origin);
                loadShop({ page: u.searchParams.get('page') || '1' });
            });
        });
    }

    document.querySelectorAll('.categorie-item').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id || this.closest('[data-id]')?.dataset?.id;
            if (!id) return;
            loadShop({ categorie: id, page: '1' });
            document.querySelectorAll('.shop-cat-list li').forEach(li => li.classList.remove('active'));
            this.closest('li').classList.add('active');
        });
    });

    document.querySelector('.shop-sort-select')?.addEventListener('change', function() {
        loadShop({ sort: this.value || '', page: '1' });
    });

    document.querySelectorAll('.view-toggle li').forEach(li => {
        li.addEventListener('click', function(e) {
            e.preventDefault();
            const view = this.dataset.view;
            document.querySelectorAll('.view-toggle li').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            if (view === 'list') listeP.classList.add('list-view');
            else listeP.classList.remove('list-view');
        });
    });

    bindPagination();
})();
</script>
@endsection
