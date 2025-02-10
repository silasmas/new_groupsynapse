<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{config('app.name') }} | {{isset($titre)?$titre:""}}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/sweetalert/sweetalert.css') }}">
        @yield("style")
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
