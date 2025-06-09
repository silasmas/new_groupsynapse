 @extends('layouts.template')

 @section('style')
     <style>
         .activeTag {
             font-weight: bold;
             color: #ffffff !important;
             background-color: #FD0100 !important;
             /* padding: 5px 10px; */
             border-radius: 4px;
         }

         #overlay-blurer {
             position: fixed;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             backdrop-filter: blur(4px);
             background: rgba(255, 255, 255, 0.5);
             z-index: 9999;
             display: flex;
             justify-content: center;
             align-items: center;
         }

         .loaderer {
             border: 4px solid #f3f3f3;
             border-top: 4px solid #007bff;
             border-radius: 50%;
             width: 30px;
             height: 30px;
             animation: spin 0.8s linear infinite;
         }

         @keyframes spin {
             to {
                 transform: rotate(360deg);
             }
         }

         .input-error {
             border: 2px dashed red !important;
             background-color: #fff6f6;
         }

         .label-error {
             color: red;
             font-weight: bold;
         }

         .is-invalid {
             border-color: red !important;
             background-color: #fff6f6;
         }

         .error-bubble {
             color: red;
             font-size: 0.8rem;
             margin-top: 4px;
         }




         .different-address.checked label {
             font-weight: bold !important;
             color: #FD0100 !important;
         }

         .drop-zone {
             position: relative;
             border: 2px dashed #ccc;
             border-radius: 6px;
             padding: 20px;
             text-align: center;
             background-color: #fafafa;
             transition: all 0.3s ease-in-out;
             cursor: pointer;
             margin-bottom: 15px;
         }

         .drop-zone.dragover {
             background-color: #eef;
             border-color: #007bff;
         }

         .drop-zone p {
             color: #666;
             font-size: 14px;
             margin: 0;
         }

         .drop-zone .preview-container {
             position: relative;
             display: inline-block;
             max-width: 100%;
             margin-top: 10px;
         }

         .preview-container img {
             max-width: 100%;
             height: auto;
             border-radius: 5px;
             display: block;
             margin: 0 auto;
         }

         .drop-zone .preview img {
             max-width: 150px;
             max-height: 150px;
             object-fit: contain;
             border-radius: 8px;
             box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
         }

         .preview-container .file-name {
             font-size: 14px;
             color: #333;
             padding: 5px;
             word-break: break-all;
         }

         .remove-icon {
             position: absolute;
             top: 5px;
             right: 5px;
             background: rgba(220, 53, 69, 0.9);
             color: white;
             font-weight: bold;
             padding: 2px 6px;
             border-radius: 50%;
             cursor: pointer;
             font-size: 14px;
         }

         .remove-icon:hover {
             background-color: #c82333;
         }

         .input-error {
             border: 2px dashed red !important;
             background-color: #fff6f6;
         }

         .label-error {
             color: red;
             font-weight: bold;
         }

         input.is-invalid {
             border-color: #dc3545;
         }

         .invalid-feedback {
             color: #dc3545;
             font-size: 0.85em;
             display: none;
         }

         input.is-invalid+.invalid-feedback {
             display: block;
         }
     </style>
     <!-- Toastr CSS -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
 @endsection
 @section('content')
     @include('parties.banner', ['page' => 'Nos services'])
     <!-- checkout-area -->
     <section class="checkout-area pt-100 pb-100">
         <div class="container">
             <div class="row justify-content-center">


                 <div class="col-lg-12">
                     <div class="widget blog-sidebar-widget mb-20">

                         <div class="blog-sidebar-title mb-15">
                             <h5>Agent Bancaire</h5>
                         </div>
                         <div class="blog-sidebar-tag">
                             <ul>
                                 @forelse ($service as $tag)
                                     @php
                                         $libelle = match ($tag->slug) {
                                             'nouvelle-carte' => 'Créer ma carte bancaire',
                                             'renouveler-carte' => 'Renouveler ma carte',
                                             'recharge-carte' => 'Recharger ma carte',
                                             'compte-courant' => 'Ouvrir un compte courant',
                                             'compte-epargne' => 'Ouvrir un compte épargne',
                                             'compte-xpresse' => 'Activer mon compte XPress',
                                             'transaction-financiere' => 'Effectuer une transaction',
                                             default => 'Faire une demande',
                                         };
                                         $isActive = $tag->slug === $page ? 'activeTag' : '';
                                     @endphp
                                     <li><a class="{{ $isActive }}"
                                             href="{{ route('getService', ['slug' => $tag->slug]) }}">{{ $libelle }}</a>
                                     </li>
                                 @empty
                                 @endforelse
                             </ul>
                         </div>
                     </div>

                 </div>
             </div>
             <hr><br>
             <div class="row justify-content-center">
                 @switch ($page)
                     @case('nouvelle-carte')
                         @include('parties.forms.createCart')
                     @break

                     @case('renouveler-carte')
                         @include('parties.forms.renewCart')
                     @break

                     @case('recharge-carte')
                         @include('parties.forms.rechargeCart')
                     @break

                     @default
                         <p>Page not found</p>
                 @endswitch
                 @include('parties.barrPaieService')
             </div>
         </div>
     </section>
     <!-- checkout-area-end -->

     <!-- core-features -->
     <section class="core-features-area core-features-style-two">
         <div class="container">
             <div class="core-features-border">
                 <div class="row justify-content-center">
                     <div class="col-xl-3 col-lg-4 col-sm-6">
                         <div class="core-features-item mb-50">
                             <div class="core-features-icon">
                                 <img src="{{ asset('assets/img/icon/core_features01.png') }}" alt="">
                             </div>
                             <div class="core-features-content">
                                 <h6>Free Shipping On Over $ 50</h6>
                                 <span>Agricultural mean crops livestock</span>
                             </div>
                         </div>
                     </div>
                     <div class="col-xl-3 col-lg-4 col-sm-6">
                         <div class="core-features-item mb-50">
                             <div class="core-features-icon">
                                 <img src="{{ asset('assets/img/icon/core_features02.png') }}" alt="">
                             </div>
                             <div class="core-features-content">
                                 <h6>Membership Discount</h6>
                                 <span>Only MemberAgricultural livestock</span>
                             </div>
                         </div>
                     </div>
                     <div class="col-xl-3 col-lg-4 col-sm-6">
                         <div class="core-features-item mb-50">
                             <div class="core-features-icon">
                                 <img src="{{ asset('assets/img/icon/core_features03.png') }}" alt="">
                             </div>
                             <div class="core-features-content">
                                 <h6>Money Return</h6>
                                 <span>30 days money back guarantee</span>
                             </div>
                         </div>
                     </div>
                     <div class="col-xl-3 col-lg-4 col-sm-6">
                         <div class="core-features-item mb-50">
                             <div class="core-features-icon">
                                 <img src="{{ asset('assets/img/icon/core_features04.png') }}" alt="">
                             </div>
                             <div class="core-features-content">
                                 <h6>Online Support</h6>
                                 <span>30 days money back guarantee</span>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- core-features-end -->
 @endsection
 @section('script')
     <!-- Toastr JS -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
     <script>
         document.addEventListener("DOMContentLoaded", function() {
             // 1.1 Configuration de Toastr
             toastr.options = {
                 "closeButton": true,
                 "progressBar": true,
                 "positionClass": "toast-top-right",
                 "timeOut": "5000"
             };
             // 1.2 Création dynamique du loader (masqué par défaut)
             const overlay = document.createElement('div');
             overlay.id = 'overlay-blurer';
             overlay.innerHTML = `<div class="loaderer"></div>`;
         });





     </script>
 @endsection
