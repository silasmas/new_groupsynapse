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
        @if(Auth::check())
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
            $(".cart-total-price").text(subTotal.toFixed(2) + " $");

            // Mettre à jour le contenu du panier
            let $minicart = $(".minicart");
            $minicart.empty();

            response.data.forEach(function(item) {
                let produit = item.produit;  // Récupération des détails du produit
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
                                <span class="new">${item.prixUnitaire} $</span>
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
                        <span class="f-right">${subTotal.toFixed(2)} $</span>
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
@yield('script')
</body>

</html>
