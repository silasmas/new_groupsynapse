@extends('layouts.template')

@section('style')
    <!-- Dans <head> (si pas déjà présent) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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

        #comment-loader-overlay { position:fixed;inset:0;background:rgba(255,255,255,0.7);display:none;align-items:center;justify-content:center;z-index:9999; }
        #comment-loader-overlay.show { display:flex; }
        .comment-loader-spinner { border:4px solid #f3f3f3;border-top:4px solid #FD0100;border-radius:50%;width:40px;height:40px;animation:spin .8s linear infinite; }
        .btn-loading { position:relative;pointer-events:none; }
        .btn-loading .btn-spinner { display:inline-block;width:1em;height:1em;border:2px solid currentColor;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;margin-right:6px;vertical-align:middle; }

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
    @include('parties.banner', ['page' => 'Detail du service'])

    <section class="blog-details-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-post-item s-blog-post-item blog-details-wrap">
                        <div class="blog-thumb mb-25">
                            <img src="{{ asset('assets/img/blog/blog_details_thumb.jpg') }} " alt="">
                            <ul class="blog-overlay-tag">
                                <li><a href="#">{{ $services->categories->name }}</a></li>
                            </ul>
                        </div>
                        <div class="blog-post-content">
                            <div class="blog-post-meta">
                                <ul>
                                    <li><i class="far fa-calendar-alt"></i> November 14, 2020</li>

                                    <li id="show-all-comments-btn2" style="cursor: pointer;"><i class="far fa-comment"></i>{{ $services->comments->count() }} Commentaires</li>

                                </ul>
                            </div>
                            <h4>{{ $services->name }}</h4>
                            <p>
                                {{ $services->description }}
                            </p>
                            <blockquote>
                                <div class="quote-icon">
                                    <img src="{{ asset('assets/img/icon/quote.png') }}" alt="">
                                </div>
                                Whether you are a business owner, professional or freelancer, offers you multiple ways to
                                get paid online by
                                international excellent online payment clients and global ...
                            </blockquote>
                            <div class="details-img-wrap">
                                <div class="details-img-col">
                                    <img src="{{ asset('assets/img/blog/blog_details_img01.jpg') }}" alt="">
                                </div>
                                <div class="details-img-col">
                                    <img src="{{ asset('assets/img/blog/blog_details_img02.jpg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-comment mb-60">
                        <h5 class="b-details-inner-title mb-35"><span
                                id="comments-count">{{ $services->comments->count() }}</span> Commentaires</h5>
                        <ul id="comment-list" class="comment-list">

                        </ul>
                        {{-- Bouton “Voir tous” --}}
                        <div id="service-comment-actions" class="mt-4"></div>
                    </div>
                    {{-- <div class="comment-reply-box">
                        <h5 class="b-details-inner-title mb-35">Leave a comment</h5>
                        <form action="#" class="comment-form">
                            <textarea name="message" id="comment-message" placeholder="Your Comment"></textarea>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" placeholder="Your Name*">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" placeholder="Your Email*">
                                </div>
                            </div>
                            <div class="comment-check-box">
                                <input type="checkbox" id="comment-check">
                                <label for="comment-check">Save my name and email in this browser for the next time I
                                    comment.</label>
                            </div>
                            <button class="btn">Submit</button>
                        </form>
                    </div> --}}
                    {{-- Assurez-vous d’avoir <meta name="csrf-token" content="{{ csrf_token() }}"> dans <head> --}}
                    <div class="comment-reply-box">
                        <h5 class="b-details-inner-title mb-35">Laisser un commentaire</h5>

                        <form id="comment-form" data-type="service" {{-- "service" ou "product" --}} data-id="{{ $services->id }}"
                            {{-- l’ID du service ou du produit --}} class="comment-form">

                            @csrf

                            {{-- Note (étoiles) --}}
                            <div class="mb-3">
                                <label class="d-inline-block mb-2 mr-2">Votre note</label>
                                <div class="rating-input d-inline-flex" data-rating="0" style="vertical-align:middle;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star-o" data-value="{{ $i }}" style="cursor:pointer;font-size:1.5rem;color:#d4a017;"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="comment-rating" value="0">
                            </div>
                            {{-- Texte du commentaire --}}
                            <textarea name="body" id="comment-message" placeholder="Votre commentaire" required></textarea>

                            @guest
                                <div class="row">
                                    {{-- Nom du visiteur --}}
                                    <div class="col-md-6">
                                        <input type="text" name="guest_name" placeholder="Votre nom *" required>
                                    </div>
                                    {{-- E-mail du visiteur --}}
                                    <div class="col-md-6">
                                        <input type="email" name="guest_email" placeholder="Votre e-mail *" required>
                                    </div>
                                </div>
                            @endguest

                            <div class="comment-check-box">
                                <input type="checkbox" id="comment-save-info">
                                <label for="comment-save-info">
                                    Enregistrer mon nom et mon e-mail dans ce navigateur pour la prochaine fois que je
                                    commenterai.
                                </label>
                            </div>

                            <button type="submit" class="btn">Envoyer</button>
                        </form>
                    </div>

                </div>
                <div class="col-lg-4 col-md-8">
                    <aside class="blog-sidebar">
                        {{-- <div class="widget blog-sidebar-widget mb-50">
                            <form action="#" class="sidebar-search-form">
                                <input type="text" placeholder="Search...">
                                <button><i class="fas fa-search"></i></button>
                            </form>
                        </div> --}}
                        <div class="widget blog-sidebar-widget">
                            <div class="blog-sidebar-title mb-15">
                                <h5>Obtenir un service</h5>
                            </div>
                            <div class="blog-sidebar-tag">
                                <ul>
                                    @forelse ($allServices as $tag)
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
                                            $isActive = $tag->slug === $services->slug ? 'activeTag' : '';
                                        @endphp
                                        <li><a class="{{ $isActive }}"
                                                href="{{ route('getService', ['slug' => $tag->slug]) }}">{{ $libelle }}</a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
        <div id="comment-loader-overlay"><div class="comment-loader-spinner"></div></div>
        {{-- Modal Bootstrap pour afficher tous les commentaires --}}
        <div class="modal fade" id="allCommentsModal" tabindex="-1" aria-labelledby="allCommentsModalLabel"
            aria-hidden="true" data-backdrop="true" data-keyboard="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="allCommentsModalLabel">Tous les commentaires</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" style="font-size:1.5rem;opacity:.7;"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <ul id="all-comment-list" class="list-unstyled mb-0">
                            {{-- JS injectera ici la liste complète --}}
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Votre formulaire ici… -->


    <!-- En bas de page, après l’inclusion de toastr.min.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('comment-form');
            const list = document.getElementById('comment-list'); // la <ul> des commentaires
            const allList = document.getElementById('all-comment-list');
            const btnAll2 = document.getElementById('show-all-comments-btn2');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            // Configuration générale de Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
            };

            // ─── Fonction générique de création d’un <li> de commentaire ───
            function createCommentItem(c) {
                // 1) on décide la limite de caractères pour l’aperçu
                const maxLen = 100;
                let text = c.body;
                let truncated = false;

                if (text.length > maxLen) {
                    text = text.slice(0, maxLen) + '... ';
                    truncated = true;
                }

                // 2) construction du <li> - contenu aligné avec le nom (pas sous l'avatar)
                const initials = c.initials || (c.author_name ? c.author_name.slice(0,2).toUpperCase() : '?');
                const avatarHtml = c.has_avatar
                    ? '<img src="'+c.avatar_url+'" alt="'+c.author_name+'" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';"><span style="display:none;width:100%;height:100%;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;font-weight:bold;color:#fff;font-size:0.9rem;">'+initials+'</span>'
                    : '<span style="width:100%;height:100%;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;font-weight:bold;color:#fff;font-size:0.9rem;">'+initials+'</span>';
                const ellipsisHtml = (c.can_delete && c.id) ? '<div class="comment-options-dropdown" style="position:relative;"><button type="button" class="comment-ellipsis-btn" title="Options" aria-label="Options"><i class="fas fa-ellipsis-h"></i></button><div class="comment-dropdown-menu" style="display:none;position:absolute;right:0;top:100%;background:#fff;border:1px solid #ddd;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:100;min-width:140px;margin-top:4px;"><a href="#" class="comment-opt-modifier d-block px-3 py-2 text-dark" style="text-decoration:none;"><i class="fas fa-edit mr-2"></i>Modifier</a><a href="#" class="comment-opt-supprimer d-block px-3 py-2 text-danger" style="text-decoration:none;"><i class="fas fa-trash mr-2"></i>Supprimer</a></div></div>' : '';
                const headerHtml = ellipsisHtml ? '<div class="d-flex justify-content-between align-items-start w-100"><h5 class="mb-1">'+c.author_name+' <span class="comment-date text-muted small">'+c.date+'</span></h5>'+ellipsisHtml+'</div>' : '<h5 class="mb-1">'+c.author_name+' <span class="comment-date text-muted small">'+c.date+'</span></h5>';
                const li = document.createElement('li');
                if (c.id) li.dataset.commentId = c.id;
                li.innerHTML = '<div class="single-comment d-flex" style="align-items:flex-start;"><div class="comment-avatar-img flex-shrink-0" style="width:50px;height:50px;min-width:50px;border-radius:50%;overflow:hidden;display:flex;align-items:center;justify-content:center;margin-right:12px;">'+avatarHtml+'</div><div class="flex-grow-1" style="min-width:0;">'+headerHtml+'<p class="comment-body mb-0">'+text+(truncated ? '<a href="#" class="read-more">Voir plus</a>' : '')+'</p></div></div>';
                const bodyEl = li.querySelector('.comment-body');
                const shortText = text;
                function showMore() {
                    bodyEl.innerHTML = c.body.replace(/</g,'&lt;').replace(/>/g,'&gt;') + ' <a href="#" class="read-less">Voir moins</a>';
                    bodyEl.querySelector('.read-less').addEventListener('click', function(e) { e.preventDefault(); showLess(); });
                }
                function showLess() {
                    bodyEl.innerHTML = shortText.replace(/</g,'&lt;').replace(/>/g,'&gt;') + ' <a href="#" class="read-more">Voir plus</a>';
                    bodyEl.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); showMore(); });
                }
                if (truncated) li.querySelector('.read-more').addEventListener('click', function(e) { e.preventDefault(); showMore(); });
                if (c.can_delete && c.id) {
                    const btn = li.querySelector('.comment-ellipsis-btn');
                    const menu = li.querySelector('.comment-dropdown-menu');
                    btn.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); const isOpen = menu.style.display === 'block'; menu.style.display = isOpen ? 'none' : 'block'; if (!isOpen) setTimeout(() => { const h = (ev) => { if (!li.contains(ev.target)) { menu.style.display = 'none'; document.removeEventListener('click', h); } }; document.addEventListener('click', h); }, 0); });
                    li.querySelector('.comment-opt-modifier').addEventListener('click', function(e) {
                        e.preventDefault(); menu.style.display = 'none';
                        const savedScrollY = window.scrollY || window.pageYOffset;
                        const oldHtml = bodyEl.innerHTML;
                        bodyEl.innerHTML = '<textarea class="form-control comment-edit-textarea" rows="5" style="width:100%;min-height:80px;">' + c.body.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</textarea><div class="mt-2"><button type="button" class="btn btn-sm btn-success comment-save-edit">Enregistrer</button> <button type="button" class="btn btn-sm btn-secondary comment-cancel-edit">Annuler</button></div>';
                        const textarea = bodyEl.querySelector('.comment-edit-textarea');
                        setTimeout(function(){ window.scrollTo(0, savedScrollY); }, 0);
                        bodyEl.querySelector('.comment-cancel-edit').onclick = () => { bodyEl.innerHTML = oldHtml; if (truncated) { const moreLink = bodyEl.querySelector('.read-more'); if (moreLink) moreLink.addEventListener('click', function(ev) { ev.preventDefault(); showMore(); }); } };
                        bodyEl.querySelector('.comment-save-edit').onclick = () => {
                            const newBody = textarea.value.trim();
                            if (!newBody) return;
                            const saveBtn = bodyEl.querySelector('.comment-save-edit');
                            const origText = saveBtn.innerHTML;
                            saveBtn.disabled = true;
                            saveBtn.innerHTML = '<span class="btn-spinner"></span> Enregistrement...';
                            fetch(window.location.origin+'/'+form.dataset.type+'/'+form.dataset.id+'/comments/'+c.id, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }, body: JSON.stringify({ body: newBody }) })
                                .then(r => r.json()).then(data => {
                                    saveBtn.disabled = false;
                                    saveBtn.innerHTML = origText;
                                    if (data.success) {
                                        c.body = data.body;
                                        const shortT = data.body.length > 100 ? data.body.slice(0,100) + '... ' : data.body;
                                        bodyEl.innerHTML = shortT + (data.body.length > 100 ? '<a href="#" class="read-more">Voir plus</a>' : '');
                                        if (data.body.length > 100) { const ml = bodyEl.querySelector('.read-more'); if (ml) ml.addEventListener('click', function(ev) { ev.preventDefault(); showMore(); }); }
                                        toastr.success('Commentaire modifié.');
                                    } else toastr.error(data.message || 'Erreur');
                                }).catch(() => { saveBtn.disabled = false; saveBtn.innerHTML = origText; toastr.error('Erreur.'); });
                        };
                    });
                    li.querySelector('.comment-opt-supprimer').addEventListener('click', function(e) {
                        e.preventDefault(); menu.style.display = 'none';
                        swal({ title: "Supprimer ce commentaire ?", text: "Cette action est irréversible.", icon: "warning", buttons: { cancel: "Annuler", confirm: "Supprimer" }, dangerMode: true }).then((willDelete) => {
                            if (willDelete) {
                                const loader = document.getElementById('comment-loader-overlay');
                                if (loader) loader.classList.add('show');
                                fetch(window.location.origin+'/'+form.dataset.type+'/'+form.dataset.id+'/comments/'+c.id, { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' } })
                                    .then(r => r.json()).then(data => {
                                        if (loader) loader.classList.remove('show');
                                        if (data.success) { li.remove(); loadLastFiveComments(); toastr.success('Commentaire supprimé.'); } else toastr.error(data.message || 'Erreur');
                                    }).catch(() => { if (loader) loader.classList.remove('show'); toastr.error('Erreur lors de la suppression.'); });
                            }
                        });
                    });
                }

                // 3) gestion du “Voir plus”
                return li;
            }
            // Fonction qui va récupérer et afficher les 5 derniers commentaires
            async function loadLastFiveComments() {
                try {
                    // 1. Construction de l’URL de l’endpoint “latest”
                    const type = form.dataset.type;
                    const id = form.dataset.id;
                    const url = `${window.location.origin}/${type}/${id}/comments/latest`;

                    // 2. Requête GET
                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) {
                        throw new Error('Erreur ' + res.status);
                    }

                    // 3. Lecture du JSON
                    const data = await res.json();
                    const comments = Array.isArray(data) ? data : (data.comments || []);
                    const total = data.total ?? comments.length;

                    // 4. Vide la liste actuelle
                    list.innerHTML = '';

                    // 5. Pour chaque commentaire, on crée un <li> et on l’ajoute
                    comments.forEach(c => list.appendChild(createCommentItem(c)));

                    const actionsEl = document.getElementById('service-comment-actions');
                    if (actionsEl) {
                        if (total > 7) {
                            actionsEl.innerHTML = '<p class="mb-0">Vos avis comptent ! <a href="#" id="service-show-all-link" class="text-decoration-none font-weight-bold" style="color:#FD0100;">Découvrir l\'ensemble des avis</a></p>';
                            actionsEl.querySelector('#service-show-all-link').addEventListener('click', function(e){ e.preventDefault(); var o=document.getElementById('comment-loader-overlay');if(o){o.classList.add('show');} loadAllComments(); });
                        } else {
                            actionsEl.innerHTML = '';
                        }
                    }
                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger les commentaires.');
                }
            }
            // ─── Charger **tous** les commentaires dans le modal ──────────
            async function loadAllComments() {
                const loader = document.getElementById('comment-loader-overlay');
                try {
                    const type = form.dataset.type;
                    const id = form.dataset.id;
                    const res = await fetch(`${window.location.origin}/${type}/${id}/comments/all`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) throw new Error('Statut ' + res.status);

                    const comments = await res.json();

                    allList.innerHTML = '';
                    comments.forEach(c => allList.appendChild(createCommentItem(c)));

                    $('#allCommentsModal').modal('show');

                } catch (err) {
                    console.error(err);
                    toastr.error('Impossible de charger tous les commentaires.');
                } finally {
                    if (loader) loader.classList.remove('show');
                }
            }

            // ─── Gestion des étoiles de notation ─────────────────────────────────
            const ratingInput = document.querySelector('.rating-input');
            const ratingHidden = document.getElementById('comment-rating');
            if (ratingInput) {
                const stars = ratingInput.querySelectorAll('i[data-value]');
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const val = parseInt(this.dataset.value);
                        ratingHidden.value = val;
                        ratingInput.dataset.rating = val;
                        stars.forEach((s, i) => {
                            s.classList.toggle('fa-star', i < val);
                            s.classList.toggle('fa-star-o', i >= val);
                            s.classList.toggle('text-warning', i < val);
                            s.classList.toggle('text-muted', i >= val);
                        });
                    });
                });
            }

            // Appel initial pour précharger les 5 derniers dès le chargement de la page
            loadLastFiveComments();

            form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && submitBtn.disabled) return;
                    const origBtnText = submitBtn ? submitBtn.innerHTML : '';
                    if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="btn-spinner"></span> Envoi...'; }

                    // 1. Lecture des données du formulaire
                    const type = form.dataset.type; // "service" ou "product"
                    const id = form.dataset.id; // ID de l’entité
                    const body = document.getElementById('comment-message').value.trim();

                    let guestName = null;
                    let guestEmail = null;
                    @guest
                    guestName = form.querySelector('input[name="guest_name"]').value.trim();
                    guestEmail = form.querySelector('input[name="guest_email"]').value.trim();
                @endguest

                // 2. Construction de l’URL
                const url = `${window.location.origin}/${type}/${id}/comments`;

                // 3. Préparation du payload
                const rating = parseInt(document.getElementById('comment-rating')?.value || 0);
                const payload = {
                    body: body,
                    rating: rating >= 1 && rating <= 5 ? rating : null
                }; @guest payload.guest_name = guestName; payload.guest_email = guestEmail;
            @endguest

            // 4. Envoi de la requête AJAX
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                })
                .then(response => {
                    console.log(response);
                    if (response.ok) {
                        return response.json();
                    }
                    // En cas d’erreurs de validation, Laravel renvoie { errors: {...} }
                    return response.json().then(errData => Promise.reject(errData));
                })
                .then(data => {
                    console.log(data);
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = origBtnText; }
                    // 2️⃣ Recharge les 5 derniers commentaires pour voir immédiatement le nouveau
                    loadLastFiveComments();

                    // 🔟 Réinitialisation du formulaire
                    form.reset();
                    const rh = document.getElementById('comment-rating');
                    const ri = document.querySelector('.rating-input');
                    if (rh) rh.value = 0;
                    if (ri) {
                        ri.dataset.rating = '0';
                        ri.querySelectorAll('i[data-value]').forEach((s, i) => {
                            s.classList.remove('fa-star', 'text-warning');
                            s.classList.add('fa-star-o', 'text-muted');
                        });
                    }
                    // Affichage du toast de succès
                    toastr.success('Commentaire publié sans recharger la page !');
                    // TODO : mettre à jour dynamiquement la liste des commentaires
                })
                .catch(err => {
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = origBtnText; }
                    if (err.errors) {
                        // Affichage des messages de validation
                        for (let field in err.errors) {
                            err.errors[field].forEach(msg => toastr.error(msg));
                        }
                    } else {
                        toastr.error('Une erreur est survenue. Veuillez réessayer plus tard.');
                    }
                });
        });
        // ─── Click sur “Voir tous” ───────────────────────────────────
        if (btnAll2) btnAll2.addEventListener('click', function(){ var o=document.getElementById('comment-loader-overlay');if(o){o.classList.add('show');} loadAllComments(); });

        // Appel initial au chargement de la page
        loadLastFiveComments();
        });
    </script>
@endsection
