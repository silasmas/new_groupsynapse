@forelse ($produits as $p)
    @include('parties.listeProd', compact('p'))
@empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Aucun produit trouvé.</p>
    </div>
@endforelse
