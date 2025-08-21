@extends('layouts.template')
@section('style')
    <!-- Assure-toi d’avoir Font Awesome dans le <head> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->

    <style>
        :root {
            --svc-bg: #ffffff;
            --svc-text: #111111;
            --svc-muted: #5e5e5e;
            --svc-primary: #e30613;
            /* Rouge du logo */
            --svc-primary-2: #111111;
            /* Noir profond */
            --svc-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            --svc-shadow-lg: 0 14px 40px rgba(0, 0, 0, .14);
            --svc-radius: 18px;
        }

        .services-area {
            position: relative;
        }

        .service-item {
            background: var(--svc-bg);
            border-radius: var(--svc-radius);
            box-shadow: var(--svc-shadow);
            padding: 28px 24px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .service-item:hover {
            transform: translateY(-6px);
            box-shadow: var(--svc-shadow-lg);
        }

        .service-icon {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            /* halo dégradé discret autour de l’icône */
            background: radial-gradient(120% 120% at 30% 30%, rgba(14, 165, 233, .18), rgba(34, 197, 94, .18) 60%, rgba(14, 165, 233, 0) 100%);
            position: relative;
            isolation: isolate;
        }

        .service-icon::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(14, 165, 233, .12), rgba(34, 197, 94, .12));
            filter: blur(6px);
            z-index: -1;
        }

        /* Icônes en rouge avec survol noir */
        .service-icon i {
            font-size: 30px;
            color: var(--svc-primary);
            transition: transform .25s ease, color .25s ease, text-shadow .25s ease;
        }

        .service-item:hover .service-icon i {
            transform: scale(1.08);
            color: var(--svc-primary-2);
            text-shadow: 0 4px 18px rgba(227, 6, 19, .35);
        }

        .service-content {
            text-align: center;
        }

        .service-content h5 {
            margin: 6px 0 6px;
            font-weight: 700;
            letter-spacing: .2px;
            color: var(--svc-text);
        }

        .service-content p {
            margin: 0;
            color: var(--svc-muted);
            line-height: 1.85;
            /* espace entre lignes confortable */
            font-size: 15.5px;
        }

        .service-content .btn {
            margin-top: 12px;
        }

        /* Boutons en rouge → noir au hover */
        .btn.btn-link {
            --_c: var(--svc-primary);
            color: var(--_c);
            font-weight: 600;
            text-decoration: none;
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn.btn-link::after {
            content: "\f061";
            /* fa-arrow-right */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 12px;
            transform: translateX(0);
            transition: transform .2s ease;
        }

        .btn.btn-link:hover {
            color: var(--svc-primary-2);
        }

        .btn.btn-link:hover::after {
            transform: translateX(4px);
        }

        /* Grille & espacements responsives (si pas de gap natif) */
        .services-area .row>[class*="col-"] {
            margin-bottom: 24px;
        }

        /* Mode sombre (optionnel) si tu ajoutes data-theme="dark" sur <html> ou le body */
        html[data-theme="dark"] {
            --svc-bg: #0f172a;
            /* slate-900 */
            --svc-text: #e5e7eb;
            --svc-muted: #94a3b8;
            --svc-shadow: 0 8px 24px rgba(0, 0, 0, .35);
            --svc-shadow-lg: 0 14px 40px rgba(0, 0, 0, .5);
        }

        /* Micro-animations à l’apparition (optionnel) */
        .service-item {
            opacity: 0;
            transform: translateY(8px);
            animation: svcIn .4s .05s both ease-out;
        }

        .service-item:nth-child(2) {
            animation-delay: .12s;
        }

        .service-item:nth-child(3) {
            animation-delay: .18s;
        }

        .service-item:nth-child(4) {
            animation-delay: .24s;
        }

        .service-item:nth-child(5) {
            animation-delay: .30s;
        }

        .service-item:nth-child(6) {
            animation-delay: .36s;
        }

        .service-item:nth-child(7) {
            animation-delay: .42s;
        }

        @keyframes svcIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
@section('content')
    @include('parties.banner', ['page' => 'A propos'])
    <!-- about-area -->
    <section class="about-area pt-100 pb-100">
        <div class="container">
            <div class="row align-items-xl-center">
                <div class="col-lg-6">
                    <div class="about-img">
                        <img src="{{ asset('assets/img/images/585x44.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h4 class="title">Pour la petite histoire</h4>
                        <p>Basé à Kinshasa, Groupe Synapse fournit des solutions digitales et des services optimisés dans
                            plusieurs secteurs d’activités, avec un accompagnement des experts pour chaque secteur.
                            Son but est de contribuer positivement au développement de la République Démocratique du Congo
                            ainsi que de l'Afrique dans la digitalisation des services au bénéfice des clients à tous les
                            niveaux (Particuliers comme Entreprises).

                            Groupe Synapse vous offre beaucoup d'opportunités pour palier a tous vos problèmes dans les
                            différents secteurs.</p>
                        <div class="our-mission-wrap">
                            <h4 class="title">Statistiques de Synapse dans secteur digital</h4>
                            <div class="our-mission-list">
                                <div class="mission-box">
                                    <div class="mission-icon">
                                        <i class="flaticon-project"></i>
                                    </div>
                                    <div class="mission-count">
                                        <h2><span class="odometer" data-count="100">00</span>+</h2>
                                        <span>Cash xpress mensuelle</span>
                                    </div>
                                </div>
                                <div class="mission-box">
                                    <div class="mission-icon">
                                        <i class="flaticon-revenue"></i>
                                    </div>
                                    <div class="mission-count">
                                        <h2><span class="odometer" data-count="250">00</span>M</h2>
                                        <span>Nombre des visiteurs</span>
                                    </div>
                                </div>
                                {{-- <div class="mission-box">
                                <div class="mission-icon">
                                    <i class="flaticon-quality"></i>
                                </div>
                                <div class="mission-count">
                                    <h2><span class="odometer" data-count="379">00</span>+</h2>
                                    <span>Awards</span>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->

    <!-- features-area -->
    <section class="features-area theme-bg pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center section-title mb-70">
                        <span class="sub-title">Pourquoi Nous Choisir</span>
                        <h2 class="title">Une expérience qui fait la différence</h2>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <!-- Livraison rapide -->
                <div class="col-lg-4 col-md-6">
                    <div class="features-wrap-item mb-30">
                        <div class="features-icon">
                            <i class="flaticon-shuttle"></i>
                        </div>
                        <div class="features-content">
                            <h5>Livraison Rapide à Domicile</h5>
                            <p>Recevez vos commandes directement chez vous en un temps record, avec un service fiable et
                                soigné.</p>
                            <div class="features-item-list">
                                <ul>
                                    <li>Expédition express</li>
                                    <li>Suivi de colis en temps réel</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paiement sécurisé -->
                <div class="col-lg-4 col-md-6">
                    <div class="features-wrap-item mb-30">
                        <div class="features-icon">
                            <i class="flaticon-secure-payment"></i>
                        </div>
                        <div class="features-content">
                            <h5>Paiement 100% Sécurisé</h5>
                            <p>Effectuez vos achats en toute tranquillité grâce à nos solutions de paiement protégées et
                                fiables.</p>
                            <div class="features-item-list">
                                <ul>
                                    <li>Support 24/7</li>
                                    <li>Garantie remboursement sous 15 jours</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support client -->
                <div class="col-lg-4 col-md-6">
                    <div class="features-wrap-item mb-30">
                        <div class="features-icon">
                            <i class="flaticon-24-hours-support"></i>
                        </div>
                        <div class="features-content">
                            <h5>Assistance Client 24/7</h5>
                            <p>Notre équipe reste disponible jour et nuit pour répondre à vos questions et vous accompagner
                                à chaque étape.</p>
                            <div class="features-item-list">
                                <ul>
                                    <li>Conseillers disponibles en ligne</li>
                                    <li>Accompagnement personnalisé</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- features-area-end -->

    <section class="services-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center section-title mb-60">
                        <span class="sub-title">Nos Services</span>
                        <h2 class="title">Découvrez ce que nous proposons</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Agent Bancaire -->
                <div class="col-xl-4 col-md-6">
                    <div class="text-center service-item">
                        <div class="mb-20 service-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="service-content">
                            <h5>Agent Bancaire</h5>
                            <p>Effectuez vos dépôts, retraits, ouvertures de compte ou recharges de carte prépayée sans
                                passer par une agence bancaire.</p>
                            {{-- <a href="#" class="btn btn-link">En savoir plus…</a> --}}
                            <a href="{{ route('services') }}" class="btn" style="background: #FD0100; color:#FFF">En savoir plus</a>
                        </div>
                    </div>
                </div>

                <!-- Energie & Energie renouvelable -->
                <div class="col-xl-4 col-md-6">
                    <div class="text-center service-item">
                        <div class="mb-20 service-icon">
                            <i class="fas fa-solar-panel"></i>
                        </div>
                        <div class="service-content">
                            <h5>Énergie & Renouvelable</h5>
                            <p>Conception et installation électrique fiable pour vos besoins résidentiels et industriels,
                                avec un engagement durable.</p>
                           <a href="{{ route('contact') }}" class="btn" style="background: #FD0100; color:#FFF">Nous contacter</a>
                        </div>
                    </div>
                </div>

                <!-- Technologie -->
                <div class="col-xl-4 col-md-6">
                    <div class="text-center service-item">
                        <div class="mb-20 service-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="service-content">
                            <h5>Technologie</h5>
                            <p>Des solutions innovantes en matériel et services IT pour transformer vos projets et booster
                                vos performances.</p>
                           <a href="{{ route('contact') }}" class="btn" style="background: #FD0100; color:#FFF">Nous contacter</a>
                        </div>
                    </div>
                </div>

                <!-- Téléphonie -->
                <div class="col-xl-4 col-md-6">
                    <div class="text-center service-item">
                        <div class="mb-20 service-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="service-content">
                            <h5>Téléphonie</h5>
                            <p>Vente et réparation d’accessoires pour Android & Apple. Large gamme de téléphones
                                disponibles.</p>
                           <a href="{{ route('contact') }}" class="btn" style="background: #FD0100; color:#FFF">Nous contacter</a>
                        </div>
                    </div>
                </div>

                <!-- e-Services -->
                <div class="col-xl-4 col-md-6">
                    <div class="text-center service-item">
                        <div class="mb-20 service-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="service-content">
                            <h5>e-Services</h5>
                            <p>Des solutions électroniques rapides et fiables : services bancaires, achats, alimentation,
                                santé, et plus encore.</p>
                           <a href="{{ route('contact') }}" class="btn" style="background: #FD0100; color:#FFF">Nous contacter</a>
                        </div>
                    </div>
                </div>

                <!-- Import & Export -->
                <div class="col-xl-4 col-md-6">
                    <div class="text-center service-item">
                        <div class="mb-20 service-icon">
                            <i class="fas fa-ship"></i>
                        </div>
                        <div class="service-content">
                            <h5>Import & Export</h5>
                            <p>Transport et logistique internationale (containers, RORO) avec une orientation 100%
                                satisfaction client.</p>
                           <a href="{{ route('contact') }}" class="btn" style="background: #FD0100; color:#FFF">Nous contacter</a>
                        </div>
                    </div>
                </div>

                <!-- Alimentaire -->
                <div class="col-xl-4 col-md-6">
                    <div class="text-center service-item">
                        <div class="mb-20 service-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <div class="service-content">
                            <h5>Alimentaire</h5>
                            <p>Conseils et vente de produits alimentaires essentiels pour la santé et le bien-être au
                                quotidien.</p>
                           <a href="{{ route('contact') }}" class="btn" style="background: #FD0100; color:#FFF">Nous contacter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
