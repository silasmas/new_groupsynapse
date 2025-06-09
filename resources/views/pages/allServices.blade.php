 @extends('layouts.template')

 @section('content')
     @include('parties.banner', ['page' => 'Nos services'])

     <!-- blog-area -->
     <section class="blog-area pt-100 pb-100">
         <div class="container">
             <div class="row justify-content-center">
                 @forelse ($services as $s)
                 @php
    $libelle = match($s->slug) {
        'nouvelle-carte' => 'Créer ma carte bancaire',
        'renouveler-carte' => 'Renouveler ma carte',
        'recharge-carte' => 'Recharger ma carte',
        'compte-courant' => 'Ouvrir un compte courant',
        'compte-epargne' => 'Ouvrir un compte épargne',
        'compte-xpresse' => 'Activer mon compte XPress',
        'transaction-financiere' => 'Effectuer une transaction',
        default => 'Faire une demande'
    };
@endphp

                     <div class="col-lg-6 col-md-8">
                         <div class="blog-post-item s-blog-post-item classic-blog-post">
                             <div class="blog-thumb">
                                 <a href="blog-details.html"><img src="{{ asset('storage/' . $s->image) }}" alt=""></a>
                             </div>
                             <div class="blog-post-content">
                                 <ul class="blog-overlay-tag">
                                     <li><a href="#">{{ $s->categories->name }}</a></li>
                                 </ul>
                                 <h4><a href="{{ route('showService', ['slug' => $s->slug]) }}">{{ $s->name }}</a></h4>
                                 <div class="blog-post-meta">
                                     <ul>
                                         <li><i class="far fa-user"></i>Par : <a href="#">{{ config('app.name')  }}</a></li>
                                         <li><i class="fas fa-users"></i> Clients satisfaits : +100</li>
                                     </ul>
                                 </div>
                                  <p>{{ Str::limit($s->description, 120) }}</p>
                                 <div class="s-blog-post-bottom">
                                     <a class="read-more" href="{{ route('getService', ['slug'=>$s->slug]) }}"> {{ $libelle }} <i class="fas fa-plus"></i></a>
                                     {{-- <div class="classic-blog-share">
                                         <a href="#"><i class="fab fa-facebook-square"></i></a>
                                         <a href="#"><i class="fab fa-twitter-square"></i></a>
                                         <a href="#"><i class="fab fa-pinterest-square"></i></a>
                                     </div> --}}
                                 </div>
                             </div>
                         </div>
                     </div>

                 @empty
                 @endforelse

             </div>
         </div>
     </section>
     <!-- blog-area-end -->


 @endsection
