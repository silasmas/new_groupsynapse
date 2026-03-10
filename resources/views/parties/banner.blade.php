   <!-- breadcrumb-area -->
   <section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('assets/img/bg/breadcrumb_bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2>{{ $page }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @if(!empty($breadcrumb) && is_array($breadcrumb))
                                @foreach($breadcrumb as $item)
                                    @if(!empty($item['url']))
                                        <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                                    @else
                                        <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                                    @endif
                                @endforeach
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

