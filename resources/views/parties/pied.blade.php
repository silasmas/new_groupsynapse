<!-- JS here -->
<script src="{{ asset('assets/js/vendor/jquery-3.5.0.min.js') }} "></script>
<script src="{{ asset('assets/js/popper.min.js') }} "></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }} "></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js') }} "></script>
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }} "></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }} "></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }} "></script>
<script src="{{ asset('assets/js/jquery.odometer.min.js') }} "></script>
<script src="{{ asset('assets/js/jquery.countdown.min.js') }} "></script>
<script src="{{ asset('assets/js/jquery.appear.js') }} "></script>
<script src="{{ asset('assets/js/slick.min.js') }} "></script>
<script src="{{ asset('assets/js/ajax-form.js') }} "></script>
<script src="{{ asset('assets/js/wow.min.js') }} "></script>
<script src="{{ asset('assets/js/aos.js') }} "></script>
<script src="{{ asset('assets/js/plugins.js') }} "></script>
<script src="{{ asset('assets/js/main.js') }} "></script>
<script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {


        // Appeler la méthode pour mettre à jour le panier
        @if (Auth::check())
            updateCartUI();
            updateFavorite();
        @endif

        // Recherche temps réel
        initGlobalSearch();
    });

    function initGlobalSearch() {
        var searchInput = document.getElementById('global-search-input');
        var searchDropdown = document.getElementById('search-results-dropdown');
        if (!searchInput || !searchDropdown) return;

        var debounceTimer;
        var loaderHtml = '<div class="p-3 text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="sr-only">Chargement...</span></div><span class="ml-2">Recherche en cours...</span></div>';

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            var q = this.value.trim();
            if (q.length < 2) {
                searchDropdown.style.display = 'none';
                return;
            }
            searchDropdown.innerHTML = loaderHtml;
            searchDropdown.style.display = 'block';

            debounceTimer = setTimeout(function() {
                fetch('{{ route("search") }}?q=' + encodeURIComponent(q) + '&limit=8')
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        var html = '';
                        var produits = data.produits || [];
                        var services = data.services || [];
                        var useAlternatives = produits.length === 0 && services.length === 0 && data.alternatives;

                        if (useAlternatives && data.suggestion) {
                            html += '<div class="p-2 border-bottom bg-light"><small class="text-muted">' + data.suggestion + '</small></div>';
                            produits = (data.alternatives.produits || []);
                            services = (data.alternatives.services || []);
                            if (data.alternatives.branches && data.alternatives.branches.length) {
                                html += '<div class="p-2 border-bottom"><strong>Branches</strong></div>';
                                data.alternatives.branches.forEach(function(b) {
                                    html += '<a href="' + b.url + '" class="d-flex align-items-center p-2 text-dark text-decoration-none" style="gap:10px;"><span style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:4px;color:#fff;font-weight:bold;">' + (b.name ? b.name.charAt(0).toUpperCase() : '?') + '</span><div><div>' + b.name + '</div><small class="text-muted">Branche</small></div></a>';
                                });
                            }
                        }

                        if (data.branches && data.branches.length) {
                            html += '<div class="p-2 border-bottom"><strong>Branches</strong></div>';
                            data.branches.forEach(function(b) {
                                html += '<a href="' + b.url + '" class="d-flex align-items-center p-2 text-dark text-decoration-none" style="gap:10px;"><span style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:4px;color:#fff;font-weight:bold;">' + (b.name ? b.name.charAt(0).toUpperCase() : '?') + '</span><div><div>' + b.name + '</div><small class="text-muted">Branche</small></div></a>';
                            });
                        }
                        if (produits.length) {
                            html += '<div class="p-2 border-bottom"><strong>Produits</strong></div>';
                            produits.forEach(function(p) {
                                var img = (p.imageUrls && p.imageUrls[0]) ? '<img src="' + p.imageUrls[0] + '" width="40" height="40" style="object-fit:cover;border-radius:4px;">' : '<span style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:4px;color:#fff;font-weight:bold;">' + (p.name ? p.name.charAt(0).toUpperCase() : '?') + '</span>';
                                var prix = p.soldePrice ? p.soldePrice : p.prix;
                                html += '<a href="' + p.url + '" class="d-flex align-items-center p-2 text-dark text-decoration-none" style="gap:10px;">' + img + '<div><div>' + p.name + '</div><small class="text-muted">' + (prix ? prix + ' ' + (p.currency || '$') : '') + '</small></div></a>';
                            });
                        }
                        if (services.length) {
                            html += '<div class="p-2 border-bottom"><strong>Services</strong></div>';
                            services.forEach(function(s) {
                                var img = s.image ? '<img src="' + s.image + '" width="40" height="40" style="object-fit:cover;border-radius:4px;">' : '<span style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:4px;color:#fff;font-weight:bold;">' + (s.name ? s.name.charAt(0).toUpperCase() : '?') + '</span>';
                                html += '<a href="' + s.url + '" class="d-flex align-items-center p-2 text-dark text-decoration-none" style="gap:10px;">' + img + '<div><div>' + s.name + '</div><small class="text-muted">' + (s.prix ? s.prix + ' ' + (s.currency || '$') : '') + '</small></div></a>';
                            });
                        }
                        if (!html) html = '<div class="p-3 text-muted">Aucun résultat</div>';
                        searchDropdown.innerHTML = html;
                        searchDropdown.style.display = 'block';
                    })
                    .catch(function() { searchDropdown.innerHTML = '<div class="p-3 text-muted">Erreur de recherche. Réessayez.</div>'; searchDropdown.style.display = 'block'; });
            }, 300);
        });

        searchInput.addEventListener('focus', function() {
            if (searchDropdown.innerHTML && searchDropdown.innerHTML.trim()) searchDropdown.style.display = 'block';
        });
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#global-search-wrap')) searchDropdown.style.display = 'none';
        });
    }

    $(document).on("click", ".remove-to-favorie", function(e) {
        e.preventDefault();
        let actionUrl = $(this).attr("href"); // URL d'ajout ou de suppression
        const link = $(this); // Lien cliqué
        const url = link.attr('href'); // URL de la requête

        // Trouver le conteneur parent qui contient l'id du produit
        const productElement = link.closest('div[id^="product-"]');

        // Vérification : Si aucun parent n'est trouvé, afficher une erreur
        if (!productElement.length) {
            console.error("Impossible de trouver l'élément parent avec l'id du produit.");
            return;
        }

        // Extraire l'id du produit
        const productId = productElement.attr('id').split('-')[1];

        $.ajax({
            url: actionUrl,
            method: "GET",
            success: function(data) {
                console.log(data)
                if (data.reponse) {
                    updateFavorite(); // Rafraîchir le panier après l'action
                    swal({
                        title: data.message,
                        icon: 'success'
                    });
                    // Met à jour le bloc produit avec le nouvel état
                    $.ajax({
                        url: `/favorie/update-block/${productId}`,
                        method: 'GET',
                        success: function(blockResponse) {
                            if (blockResponse.success) {
                                // bloc.html(blockResponse.html);
                                $(`#product-${productId}`).replaceWith(blockResponse
                                    .html);
                            }
                        },
                        error: function(xhr) {
                            console.error("Erreur lors de la mise à jour du bloc :",
                                xhr);
                        }
                    });
                } else {
                    swal({
                        title: data.message,
                        icon: 'error'
                    });
                }

            },
            error: function(xhr) {
                alert("Erreur lors de la modification du panier.");
            }
        });
    });
    $(document).on("click", ".add-to-favorie", function(e) {
        e.preventDefault();
        let actionUrl = $(this).attr("href"); // URL d'ajout ou de suppression
        const link = $(this); // Lien cliqué
        const url = link.attr('href'); // URL de la requête

        // Trouver le conteneur parent qui contient l'id du produit
        const productElement = link.closest('div[id^="product-"]');

        // Vérification : Si aucun parent n'est trouvé, afficher une erreur
        if (!productElement.length) {
            console.error("Impossible de trouver l'élément parent avec l'id du produit.");
            return;
        }

        // Extraire l'id du produit
        const productId = productElement.attr('id').split('-')[1];
        $.ajax({
            url: actionUrl,
            method: "GET",
            success: function(data) {
                console.log(data)
                if (data.reponse) {
                    updateFavorite(); // Rafraîchir le panier après l'action
                    // Met à jour le bloc produit avec le nouvel état
                    $.ajax({
                        url: `/favorie/update-block/${productId}`,
                        method: 'GET',
                        success: function(blockResponse) {
                            if (blockResponse.success) {
                                // bloc.html(blockResponse.html);
                                $(`#product-${productId}`).replaceWith(blockResponse
                                    .html);
                            }
                        },
                        error: function(xhr) {
                            console.error("Erreur lors de la mise à jour du bloc :",
                                xhr);
                        }
                    });
                    swal({
                        title: data.message,
                        icon: 'success'
                    });
                } else {
                    swal({
                        title: data.message,
                        icon: 'error'
                    });
                }

            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    alert('Vous devez être connecté pour accéder à cette page.');
                    window.location.href = '/login'; // Redirection vers la page de connexion
                } else {
                    console.error('Une erreur est survenue:', error);
                }
            }
        });
    });

    $(document).on("click", ".add-to-cart", function(e) {
        e.preventDefault();
        let actionUrl = $(this).attr("href"); // URL d'ajout ou de suppression


        $.ajax({
            url: actionUrl,
            method: "GET",
            success: function(data) {
                console.log(data)
                updateCartUI(); // Rafraîchir le panier après l'action
                swal({
                    title: data.message,
                    icon: 'success'
                });
            },
            error: function(xhr) {
                console.log(xhr)
                if (xhr.status === 401) {
                    swal({
                        title: "Vous devez être connecté pour accéder à cette page!!",
                        icon: 'error'
                    });
                    window.location.href = '/login'; // Redirection vers la page de connexion
                } else {
                    swal({
                        title: "Une erreur est survenue!!",
                        icon: 'error'
                    });
                }

            }
        });
    });
    $(document).on("click", ".remove-from-cart", function(e) {
        e.preventDefault();
        let id = $(this).attr("data-id"); // URL d'ajout ou de suppression
        let qty = $(this).attr("data-quantity"); // URL d'ajout ou de suppression
        // alert("cart.remove/"+id+"/"+qty)
        let actionUrl = "../cart/remove/" + id;
        $.ajax({
            url: actionUrl,
            method: "GET",
            success: function(data) {
                console.log(data)
                if (data.reponse) {
                    swal({
                        title: data.message,
                        icon: 'success'
                    });
                    updateCartUI(); // Rafraîchir le panier après l'action
                } else {
                    swal({
                        title: "Une erreur est survenue!!",
                        icon: 'error'
                    });
                }

            },
            error: function(xhr) {
                alert("Erreur lors de la modification du panier.");
            }
        });
    });

    function updateCartUI() {
        $.ajax({
            url: "{{ route('cart.details') }}", // URL pour obtenir les détails du panier
            method: "GET",
            success: function(response) {
                console.log(response);

                // Vérification : si le panier est vide
                if (!response.data || response.data.length === 0) {
                    $(".count").text("0");
                    $(".cart-total-price").text("");
                    $(".minicart").html(`
                    <li class="empty-cart">
                        <p>Votre panier est vide.</p>
                    </li>
                `);
                    return;
                }
                // Calcul du total du panier
                let cartCount = response.data.reduce((total, item) => total + item.quantite, 0);
                let subTotal = response.data.reduce((total, item) => total + item.prixTotal, 0);

                // Mettre à jour la quantité et le total
                $(".count").text(cartCount);
                $(".cart-total-price").text(subTotal.toFixed(2) + "$");

                // Mettre à jour le contenu du panier
                let $minicart = $(".minicart");
                $minicart.empty();

                response.data.forEach(function(item) {
                    var currency = item.produit.currency === "CDF" ? "FC" : "$";
                    let produit = item.produit;

                    // Initiales du produit (max 2 caractères)
                    let initials = (produit.name || '').trim().split(/\s+/).slice(0, 2)
                        .map(w => (w.charAt(0) || '').toUpperCase()).join('') || (produit.name || '?').charAt(0).toUpperCase();

                    $minicart.append(`<li class="d-flex align-items-start">
                                <div class="cart-img" style="width:80px;height:80px;flex-shrink:0;border-radius:6px;overflow:hidden;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;">
                                    <a href="/showProduct/${produit.slug}" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;text-decoration:none;">
                                        <span style="font-weight:bold;font-size:1.2rem;color:white;">${initials}</span>
                                    </a>
                                </div>
                                <div class="cart-content">
                                    <h4>
                                        <a href="/showProduct/${produit.slug}">${produit.name}</a>
                                    </h4>
                                    <div class="cart-price">
                                        <span class="new">${item.prixUnitaire}${currency}</span>
                                        <span> X ${item.quantite} </span>
                                    </div>
                                </div>
                                <div class="del-icon">
                                    <a class="remove-from-cart" data-id="${produit.id}" data-quantity="${item.quantite}">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            </li>`);


                });

                $minicart.append(`
                <li>
                    <div class="total-price">
                        <span class="f-left">Total:</span>
                        <span class="f-right">${subTotal.toFixed(2)}$</span>
                    </div>
                </li>
                <li>
                    <div class="checkout-link">
                        <a href="/cart">Voir le panier</a>
                        <a class="red-color" href="/checkout">Commander</a>
                    </div>
                </li>
            `);
            },
            error: function(xhr) {
                console.error("Erreur lors de la mise à jour du panier :", xhr.responseText);
            }
        });
    }



    function updateFavorite() {
        $.ajax({
            url: "{{ route('favorit.details') }}", // URL pour obtenir les détails des favoris
            method: "GET",
            success: function(response) {
                // Vérification si la réponse est valide
                if (response && response.status === "success") {
                    const favoritesData = response.data; // Récupération des données des favoris

                    // Vérification si le panier est vide
                    if (!favoritesData.items || favoritesData.favorites_count === 0) {
                        $(".favoriteCount").text("0");
                        return;
                    }

                    // Mise à jour du compteur des favoris
                    $(".favoriteCount").text(favoritesData.favorites_count);
                } else {
                    // Si le statut est "error" ou réponse inattendue
                    alert("Erreur : " + (response.message || "Réponse inattendue du serveur."));
                }
            },
            error: function(xhr) {
                // Gestion des erreurs
                let errorMessage = "Une erreur est survenue.";

                // Vérifie si une réponse JSON est disponible avec un message d'erreur
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    errorMessage = xhr.responseText;
                }

                // Affiche une erreur pour le développeur dans la console
                console.error("Erreur lors de la mise à jour des favoris :", xhr);

                // Affiche un message d'erreur lisible à l'utilisateur
                // alert("Erreur : " + errorMessage);
            }
        });
    }
</script>
<script>
    function submitForm(event) {
        event.preventDefault(); // Empêche la soumission par défaut

        const form = event.target; // Récupère le formulaire
        const submitButton = form.querySelector("button.btn"); // Sélectionne le bouton submit
        const checkboxTerms = document.getElementById("customCheck7"); // Vérifie la case à cocher

        if (!checkboxTerms.checked) {
            alert("Veuillez accepter les conditions générales avant de continuer.");
            return;
        }

        // Désactive le bouton pour éviter la double soumission
        submitButton.disabled = true;
        submitButton.textContent = "Traitement en cours...";

        // Récupération des données du formulaire
        let formData = new FormData(form);

        // Envoi AJAX avec Fetch API
        fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Indique que c'est une requête AJAX
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content') // CSRF Token pour Laravel
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.reponse) {
                    swal({
                        title: data.message,
                        icon: 'success'
                    });
                    if (data.type == "mobile") {
                        check(data.orderNumber)
                    } else {
                        swal({
                            title: "Veuillez patienter, vous serez rediriger pour payer par carte bancaire...",
                            icon: 'warning'
                        });
                        window.location.href = data.redirect_url; // Redirection vers la page de confirmation
                    }
                } else {
                    swal({
                        title: data.message,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error("Erreur AJAX :", error);
                swal({
                    title: "Une erreur est survenue. Veuillez réessayer.",
                    icon: 'error'
                });

                // alert("Une erreur est survenue. Veuillez réessayer.");
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = "PASSER À LA CAISSE";
            });
    }

    function check(reference) {
        const transactionReference = reference; // Référence de la transaction à surveiller
        let attempts = 0; // Nombre de tentatives effectuées
        const maxAttempts = 7; // Maximum de tentatives avant arrêt automatique
        let isStopped = false; // Drapeau pour éviter les exécutions multiples
        let logSent = false; // 🛡️ Empêche les logs multiples
        let successTriggered = false;



        // Préparation de la notification sonore
        const audioSuccess = new Audio('/sounds/success.mp3');
        const audioerror = new Audio('/sounds/error.mp3');

        /**
         * Arrête les vérifications et affiche un message visuel (SweetAlert)
         */

        const stopChecking = (message, icon = 'info') => {
            if (isStopped) return;
            isStopped = true;
            clearInterval(interval);

            swal({
                title: "État de la transaction",
                text: message,
                icon: icon
            });
        };

        /**
         * Fonction pour journaliser chaque tentative côté serveur (optionnelle mais utile)
         */
        const logAttempt = (status, message) => {
            if (logSent) return; // 🛑 Ne log qu’une seule fois
            logSent = true;

            $.post('/logTransactionAttempt', {
                reference: transactionReference,
                status: status,
                message: message,
                _token: document.querySelector('meta[name="csrf-token"]').content
            });
        };


        /**
         * Démarre la boucle de vérification toutes les 5 secondes
         */
        const interval = setInterval(() => {
            if (isStopped) return;

            attempts++;
            console.log(`🔁 Tentative ${attempts}/${maxAttempts} pour ${transactionReference}`);

            $.ajax({
                url: '/checkTransactionStatus',
                method: 'GET',
                data: {
                    reference: transactionReference
                },
                success: function(response) {
                    console.log("✅ Réponse :", response);

                    // Enregistrement d'une tentative côté serveur (utile pour audit)
                    logAttempt(response.status, response.message || 'Réponse sans message');

                    if (response.reponse === true) {
                        if (response.status == "0") {
                            if (successTriggered) return; // ✅ Stoppe tout si déjà traité
                            successTriggered = true; // 🛡️ Active la protection

                            stopChecking(response.message || "Transaction effectuée avec succès !",
                                'success');
                            toastr.success("✅ Transaction effectuée avec succès !");

                            // 🔊 Lecture du son une seule fois
                            audioSuccess.currentTime = 0;
                            audioSuccess.play();

                            $("#formpaie")[0].reset();

                            setTimeout(() => {
                                location.reload();
                            }, 10000);
                            return;
                        }


                        if (response.status == "2" && attempts >= maxAttempts - 1) {
                            audioerror.currentTime = 0; // redémarre le son si déjà joué
                            audioerror.play();
                            // ⚠️ Paiement en attente trop longtemps
                            stopChecking(response.message || "Transaction non confirmée.",
                                'warning');
                            showTransactionPopup(response.orderNumber, response.message, 'warning');
                            return;
                        }
                    }

                    if (response.reponse === false && response.status == "1") {
                        audioerror.currentTime = 0; // redémarre le son si déjà joué
                        audioerror.play();
                        // ❌ Paiement refusé
                        stopChecking(response.message || "Paiement refusé.", 'error');
                        return;
                    }

                    if (!response.reponse && attempts >= maxAttempts) {
                        audioerror.currentTime = 0; // redémarre le son si déjà joué
                        audioerror.play();
                        // ❌ Paiement non confirmé après N tentatives
                        stopChecking(response.message || "Le paiement n'a pas été confirmé.",
                            'error');
                        return;
                    }

                    if (response.redirect_url) {
                        // 🔁 Redirection immédiate
                        clearInterval(interval);
                        isStopped = true;
                        window.location.href = response.redirect_url;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(`❌ Erreur AJAX: ${textStatus}, ${errorThrown}`);

                    if (attempts >= maxAttempts) {
                        stopChecking(
                            "Impossible de vérifier le statut de la transaction. Veuillez réessayer.",
                            'error');
                    }

                }
            });
        }, 5000);
    }

    function showTransactionPopup(orderNumber, message, icon) {
        swal({
            title: "État de la transaction",
            text: message,
            icon: icon,
            buttons: {
                cancel: "Annuler",
                confirm: {
                    text: "Réessayer",
                    value: "retry",
                }
            }
        }).then((value) => {
            if (value === "retry") {
                // L'utilisateur a cliqué sur "Réessayer"
                check(orderNumber);
            } else {
                // L'utilisateur a cliqué sur "Annuler"
                swal("Annulé", "Vous pouvez réessayer plus tard.", "info");
            }
        });
    }
    // Fonction pour gérer la logique du paiement (Mobile money, CGU)
    function paiement() {
        const selectPayment = document.getElementById("channel");
        const phoneContainer = document.getElementById("Contenairephone");
        const phoneInput = document.getElementById("phone");
        const checkboxTerms = document.getElementById("customCheck7");
        const submitButton = document.querySelector("button.btn");

        function updateFormState() {
            if (selectPayment.value === "mobile_money") {
                phoneContainer.style.display = "block";
                phoneInput.required = true;
            } else {
                phoneContainer.style.display = "none";
                phoneInput.required = false;
                phoneInput.value = "";
            }
            submitButton.disabled = !checkboxTerms.checked;
        }

        updateFormState();
        selectPayment.addEventListener("change", updateFormState);
        checkboxTerms.addEventListener("change", updateFormState);
    }
</script>
<script>
document.getElementById('newsletter-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const successDiv = document.getElementById('newsletter-success');
    const errorDiv = document.getElementById('newsletter-error');

    // Réinitialise les messages
    successDiv.style.display = 'none';
    errorDiv.style.display = 'none';
    errorDiv.innerHTML = '';

    try {
        const response = await fetch("{{ route('newsletter.subscribe') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        });

        const result = await response.json();

        if (response.ok) {
            successDiv.innerText = result.message;
            successDiv.style.display = 'block';
            form.reset();
        } else if (response.status === 422) {
            // Validation errors
            let messages = '';
            for (let field in result.errors) {
                messages += result.errors[field].join('<br>') + '<br>';
            }
            errorDiv.innerHTML = messages;
            errorDiv.style.display = 'block';
        } else {
            errorDiv.innerText = result.message || 'Erreur inconnue.';
            errorDiv.style.display = 'block';
        }
    } catch (error) {
        errorDiv.innerText = 'Une erreur réseau est survenue.';
        errorDiv.style.display = 'block';
    }
});
</script>


@yield('script')



</body>

</html>
