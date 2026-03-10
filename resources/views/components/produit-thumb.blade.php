@props(['produit', 'class' => ''])
@php
    $images = $produit->getImageUrlsAttribute();
    $img1 = $images[0] ?? null;
    $img2 = $images[1] ?? $img1;
    $initials = getInitials($produit->name);
@endphp
<div class="produit-thumb-wrapper" style="position:relative;width:100%;aspect-ratio:1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
    @if(!empty($img1))
        <img src="{{ $img1 }}" alt="{{ $produit->name }}" class="img-main {{ $class }}"
            style="width:100%;height:100%;object-fit:cover;"
            onerror="this.style.display='none';if(this.nextElementSibling){this.nextElementSibling.style.display='flex';}">
        <span class="produit-initials" style="display:none;position:absolute;inset:0;align-items:center;justify-content:center;font-weight:bold;font-size:2.5rem;color:white;">{{ $initials }}</span>
    @else
        <span class="produit-initials" style="display:flex;position:absolute;inset:0;align-items:center;justify-content:center;font-weight:bold;font-size:2.5rem;color:white;">{{ $initials }}</span>
    @endif
</div>
@if(!empty($img2) && $img2 !== $img1)
    <img class="overlay-product-thumb {{ $class }}" src="{{ $img2 }}" alt="" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity .3s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
@endif
