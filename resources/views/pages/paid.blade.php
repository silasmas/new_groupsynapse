@extends('layouts.template')

@section('style')
    <style>
        #Contenairephone {
            display: none;
            /* Caché par défaut */
        }
    </style>
@endsection
@section('content')
    @include('parties.banner', ['page' => 'Etat de la commande'])


    <!-- order-complete-area -->
    <section class="order-complete-area pattern-bg pt-100 pb-100" data-background="assets/img/bg/pattern_bg.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="order-complete-bg" data-background="assets/img/bg/order_comp_bg.png">
                        <div class="order-complete-content">
                            <h3><span>Etat de votre</span> Commande!</h3>
{{-- @dump($order_details["status"]) --}}
                            @if (isset($order_details))
                                @switch($order_details["status"])
                                    @case('Payée')
                                        <div class="check mb-25">
                                            <img src="{{ asset('assets/img/icon/2n.png') }}" alt="">
                                        </div>
                                        <p>{{ $order_details["message"]}}</p>
                                        <p>Référence : {{ $order_details["order_reference"] }}</p>
                                        <p>Montant : {{$order_details["amount"].$order_details["currency"] }} </p>
                                        <p>Moyen de paiement : {{ $order_details["channel"] }}</p>
                                        <a href="{{ route('home') }}" class="btn">CONTINUE LE SHOPPING</a>
                                    @break

                                    @case('En cours')
                                        <div class="check mb-25">
                                            <img src="{{ asset('assets/img/icon/1n.png') }}" alt="">
                                        </div>
                                        <p>{{ session('order_details.message') }}</p>
                                        <p>Référence : {{ $order_details["order_reference"] }}</p>
                                        <p>Montant : {{$order_details["amount"].$order_details["currency"] }} </p>
                                        <p>Moyen de paiement : {{ $order_details["channel"] }}</p>
                                        <a href="{{ route('home') }}" class="btn" onclick="check({{ $order_details['order'] }})">CONTINUE LE SHOPPING</a>
                                    @break

                                    @case('Annulée')
                                        <div class="check mb-25">
                                            <img src="{{ asset('assets/img/icon/3n.png') }}" alt="">
                                        </div>
                                        <div class="mb-10">
                                            <span>{{ session('order_details.message') }}</span><br>
                                            <span>Référence : {{ $order_details["order_reference"] }}</span><br>
                                            <span>Montant : {{$order_details["amount"].$order_details["currency"] }} </span><br>
                                            <span>Moyen de paiement : {{ $order_details["channel"] }}</span><br>

                                        </div>
                                        <a href="{{ route('home') }}" class="btn">CONTINUE LE SHOPPING</a>
                                    @break

                                    @default
                                @endswitch
                            @endif



                            <p class="get-ans">Trouvez rapidement des réponses claires et précises à toutes <a href="#">vos questions.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- order-complete-area-end -->
@endsection
