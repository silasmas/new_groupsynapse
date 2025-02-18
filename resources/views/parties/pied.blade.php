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
    });

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
                $(".count").text(response.data.length);
                $(".cart-total-price").text(subTotal.toFixed(2) +"$" );

                // Mettre à jour le contenu du panier
                let $minicart = $(".minicart");
                $minicart.empty();

                response.data.forEach(function(item) {
                    var currency=item.produit.curreny=="CDF"?"FC":"$";
                    let produit = item.produit; // Récupération des détails du produit
                    console.log(produit.first_image);
                    $minicart.append(`
                    <li class="d-flex align-items-start">
                        <div class="cart-img">
                            <a href="/produit/${produit.id}">
                                <img src="../${produit.first_image}" width="100" height="100" alt="">
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
                    </li>
                `);
                });

                $minicart.append(`
                <li>
                    <div class="total-price">
                        <span class="f-left">Total:</span>
                        <span class="f-right">${subTotal.toFixed(2)}${currency} $</span>
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
        // Déclaration des variables pour la gestion de la vérification
        const transactionReference = reference; // Référence de la transaction
        let attempts = 0; // Compteur de tentatives
        const maxAttempts = 7; // Nombre maximum de tentatives avant arrêt

        // Fonction pour arrêter la vérification et afficher un message
        const stopChecking = (message, icon = 'info') => {
            clearInterval(interval); // Arrête l'intervalle de vérification
            attempts = maxAttempts; // Définit les tentatives au maximum

            // Affiche une alerte avec SweetAlert2
            swal({
                title: "État de la transaction",
                text: message,
                icon: icon
            });
        };

        // Démarrage de l'intervalle pour vérifier le statut de la transaction toutes les 5 secondes
        const interval = setInterval(() => {
            attempts++; // Incrémente le compteur de tentatives
            console.log(`Vérification ${attempts}/${maxAttempts} pour la transaction: ${transactionReference}`);

            // Requête AJAX pour interroger le statut de la transaction
            $.ajax({
                url: '/checkTransactionStatus', // Route qui vérifie le statut côté serveur
                method: 'GET',
                data: {
                    reference: transactionReference
                }, // Envoi de la référence de la transaction
                success: function(response) {
                    console.log("Réponse reçue :", response);

                    if (response.reponse === true) {
                        if (response.status == "0") {
                            // Paiement validé, arrêter la vérification
                            stopChecking(response.message || "Achat effectué avec succès !",
                                'success');

                            // Réinitialiser le formulaire de paiement
                            $("#formpaie")[0].reset();

                            // Attendre 10 secondes (10000 millisecondes) avant d'actualiser
                            setTimeout(() => {
                                location.reload(); // Actualiser la page
                            }, 10000);
                        } else if (response.status == "2" && attempts >= maxAttempts - 1) {
                            // Paiement validé, arrêter la vérification
                            stopChecking(response.message || "", 'warning');
                            showTransactionPopup(response.orderNumber, response.message, 'warning')
                            // window.location.href = "{{ route('home') }}";
                        }

                    } else if (response.reponse === false && response.status == "1") {
                        // Nombre maximum de tentatives atteint, arrêter la vérification
                        stopChecking(response.message, 'error');
                    } else if (!response.reponse && attempts >= maxAttempts) {
                        // Nombre maximum de tentatives atteint, arrêter la vérification
                        stopChecking(response.message || "Le paiement n'a pas été confirmé.",
                            'error');
                    } else if (response.redirect_url) {
                        // Redirection vers la page de confirmation si définie dans la réponse
                        window.location.href = response.redirect_url;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(`Erreur AJAX: ${textStatus}, ${errorThrown}`);

                    if (attempts >= maxAttempts) {
                        // Arrêter après plusieurs erreurs consécutives
                        stopChecking(
                            "Impossible de vérifier le statut de la transaction. Veuillez réessayer.",
                            'error');
                    }
                }
            });
        }, 5000); // Vérification toutes les 5 secondes
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
</script>
@yield('script')
</body>

</html>
