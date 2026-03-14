<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} | {{ $titre ?? '' }}</title>
        @php
            $metaTitle = ($titre ?? '') ? config('app.name') . ' | ' . $titre : config('app.name');
            $metaDescription = $metaDescription ?? config('seo.defaults.description');
            $metaImage = $metaImage ?? asset('assets/img/logo/logosynapse.png');
            $metaUrl = $metaUrl ?? url()->current();
        @endphp
        <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($metaDescription), 160) }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="{{ $metaUrl }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="{{ $metaType ?? config('seo.defaults.type') }}">
        <meta property="og:url" content="{{ $metaUrl }}">
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($metaDescription), 200) }}">
        <meta property="og:image" content="{{ $metaImage }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="{{ $twitterCard ?? config('seo.defaults.twitter_card') }}">
        <meta name="twitter:url" content="{{ $metaUrl }}">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($metaDescription), 200) }}">
        <meta name="twitter:image" content="{{ $metaImage }}">
        <meta name="twitter:image:alt" content="{{ $metaTitle }}">

		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/logosynapse.png') }}">
        <!-- Place favicon.ico in the root directory -->


		<!-- CSS here -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/default.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }} ">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/sweetalert/sweetalert.css') }}">
        @yield("style")
        @if($gaId = config('services.google_analytics.measurement_id'))
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
        @endif
    </head>
    <body>


        <!-- preloader  -->
        <div id="preloader">
            <div id="ctn-preloader" class="ctn-preloader">
                <div class="animation-preloader">
                    <div class="spinner"></div>
                    <div class="txt-loading">
                        <span data-text-preloader="G" class="letters-loading">
                            G
                        </span>
                        <span data-text-preloader="R" class="letters-loading">
                            R
                        </span>
                        <span data-text-preloader="O" class="letters-loading">
                            O
                        </span>
                        <span data-text-preloader="U" class="letters-loading">
                            U
                        </span>
                        <span data-text-preloader="P" class="letters-loading">
                            P
                        </span>
                        <span data-text-preloader="S" class="letters-loading">
                            S
                        </span>
                        <span data-text-preloader="Y" class="letters-loading">
                            Y
                        </span>
                        <span data-text-preloader="N" class="letters-loading">
                            N
                        </span>
                        <span data-text-preloader="A" class="letters-loading">
                            A
                        </span>
                        <span data-text-preloader="P" class="letters-loading">
                            P
                        </span>
                        <span data-text-preloader="S" class="letters-loading">
                            S
                        </span>
                        <span data-text-preloader="E" class="letters-loading">
                            E
                        </span>
                    </div>
                </div>
                <div class="loader">
                    <div class="row">
                        <div class="col-3 loader-section section-left">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-left">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-right">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-right">
                            <div class="bg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- preloader end -->


		<!-- Scroll-top -->
        <button class="scroll-top scroll-to-target" data-target="html">
            <i class="fas fa-angle-up"></i>
        </button>
        <!-- Scroll-top-end-->
