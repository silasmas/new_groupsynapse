@props(['src' => null, 'alt' => '', 'initials' => '', 'width' => 38, 'height' => 38, 'class' => ''])
@php
    $hasImage = !empty($src);
@endphp
<div class="avatar-image-wrapper" style="width:{{ $width }}px;height:{{ $height }}px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:6px;overflow:hidden;flex-shrink:0;">
    @if($hasImage)
        <img {{ $attributes->merge(['class' => $class]) }} src="{{ $src }}" width="{{ $width }}" height="{{ $height }}" alt="{{ $alt }}"
            onerror="this.style.display='none';if(this.nextElementSibling){this.nextElementSibling.style.display='flex';}">
        <span class="avatar-initials" style="display:none;font-weight:bold;font-size:{{ min($width, $height) * 0.4 }}px;color:white;">{{ $initials }}</span>
    @else
        <span class="avatar-initials" style="font-weight:bold;font-size:{{ min($width, $height) * 0.4 }}px;color:white;">{{ $initials }}</span>
    @endif
</div>
