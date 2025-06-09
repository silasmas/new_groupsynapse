<div class="col-lg-8">
    <div class="checkout-wrap">
        <h5 class="title">Veuillez remplir le formulaire ci-dessous pour recharger votre carte</h5>
        <form action="#" class="checkout-form" id="formRecharge" method="POST">
            <div class="row">
                <div class="col-sm-6" hidden>
                    <div class="form-grp">
                        <label for="fName">Service <span>*</span></label>
                        <input type="text" value="{{ $page }}" id="cservice" name="service">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-grp">
                        <label for="rid">ID de la carte (10 chiffre) <span>*</span></label>
                        <input type="text" name="rid" id="rid" maxlength="10" pattern="\d{10}"
                            title="Veuillez entrer l'ID de carte valide de 10 chiffres."
                            placeholder="Veuillez entrer l'ID de carte valide de 10 chiffres.">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-grp">
                        <label for="rnumCarte">4 dernier chiffre <span>*</span></label>
                        <input type="text" id="rnumCarte" name="rnumCarte" maxlength="4" pattern="\d{4}"
                            title="Veuillez entrer les 4 derniers chiffres de la carte."
                            placeholder="Veuillez entrer les 4 derniers chiffres de la carte.">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-grp">
                        <label for="rmontant">Montant (En dollard )<span>*</span></label>
                        <input type="text" id="rmontant" name="rmontant"
                            title="Veuillez entrer le Montant (5,10,20...)."
                            placeholder="Veuillez entrer le Montant (5,10,20...).">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <button type="submit" id="btnSoumission" class="btn" disabled>Envoyer</button>
            </div>
        </form>
    </div>
</div>
@section('script')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const formInfo = document.getElementById('formRecharge');
            const btnSoumission = document.getElementById('btnSoumission');
            const paiementSection = document.getElementById('paiement-section');
            const btnPaiement = document.getElementById('btn-paiement');
            if (!btnSoumission) {
                console.warn("❗ Le bouton #btnSoumission n'a pas été trouvé dans le DOM.");
                toastr.warning("❗ Le bouton #btnSoumission n'a pas été trouvé dans le DOM.");

                return;
            }

            // ======================================
            // 4. Soumission du formulaire principal
            // ======================================
            formInfo.addEventListener('submit', function(e) {
                e.preventDefault();



                // 4.5 Envoi du formulaire via AJAX
                const formData = new FormData(formInfo);
                fetch("{{ route('init.recharge') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // 5. Réponse success
                            paiementSection.style.opacity = 1;
                            paiementSection.style.pointerEvents = 'auto';
                            btnPaiement.removeAttribute('disabled');

                            // 5.1 Afficher les informations de la carte
                            document.getElementById('affId').innerHTML = "ID de la carte : <b>" + data
                                .idCarte + "</b>";
                            // 5.1 Afficher les informations de la carte
                            document.getElementById('affNumCarte').innerHTML =
                                "4 dernier chiffre de la carte : <b>" + data.numero_carte + "</b>";
                            document.getElementById('affMontant').innerHTML = "Montant : <b>" + data
                                .montant + " " + data.currency + "</b>";


                            document.getElementById('referenceCreate').value = data.reference;

                            document.getElementById('total').value = data.montant;
                            document.getElementById('slug').value = data.slug;
                            document.getElementById('currency').value = data.currency;
                            // 5.1 Afficher le bouton Modifier
                            $("#formRecharge")[0].reset();

                            // 5.2 Initialiser le bloc paiement
                            paiement();

                            toastr.success(
                                "✅ Informations enregistrées. Vous pouvez passer à la caisse.");
                        } else {
                            // 6. Réponse avec erreurs
                            let messages = [];
                            const fieldLabels = {
                                rid: "ID de la carte",
                                rnumCarte: "4 dernier Numéro de la carte",
                                rmontant: "Montant",
                            };

                            if (data.errors) {
                                for (const field in data.errors) {
                                    const label = fieldLabels[field] || field;
                                    const input = document.querySelector(`[name="${field}"] `);
                                    const msg = data.errors[field].join(', ');
                                    messages.push(`<b> ${label} </b> : ${msg}`);

                                    if (input) {
                                        input.classList.add('is-invalid');
                                        insertBubble(input, msg);
                                    }
                                }
                            } else {
                                messages.push(data.message || "Erreur inconnue.");
                            }
                            toastr.error(messages.join('<br>'));
                        }
                    })
                    .catch(err => {
                        toastr.error("Erreur serveur ou réseau.");
                        console.error(err);
                    })
                    .finally(() => {
                        // Nettoyage du loader
                        document.getElementById('overlay-blurer')?.remove();
                    });
            });

            // Messages d'erreur personnalisés
            const messagesErreur = {
                rid: "L'ID de la carte doit contenir exactement 10 chiffres.",
                rnumCarte: "Les 4 derniers chiffres de la carte sont requis.",
                rmontant: "Veuillez entrer un montant valide supérieur à 0.",
                cservice: "Service requis."
            };
            // État : la vérification ne commence qu'après interaction utilisateur
            let validationActive = false;
            // Fonction de validation des champs requis
            function verifierChamps() {
                if (!validationActive) return;
                const champs = ['rid', 'rnumCarte', 'rmontant', 'cservice'];
                let formulaireValide = true;

                champs.forEach(id => {
                    const input = document.getElementById(id);
                    const feedback = input.nextElementSibling;
                    const valeur = input.value.trim();
                    let estValide = true;

                    // Validation personnalisée par champ
                    if (id === 'rid') {
                        estValide = /^\d{10}$/.test(valeur);
                    } else if (id === 'rnumCarte') {
                        estValide = /^\d{4}$/.test(valeur);
                    } else if (id === 'rmontant') {
                        estValide = /^\d+$/.test(valeur) && parseInt(valeur) > 0;
                    } else if (id === 'cservice') {
                        estValide = valeur !== '';
                    }

                    if (!estValide) {
                        formulaireValide = false;
                        input.classList.add('is-invalid');
                        feedback.textContent = messagesErreur[id] || 'Champ invalide';
                    } else {
                        input.classList.remove('is-invalid');
                        feedback.textContent = '';
                    }
                });

                btnSoumission.disabled = !formulaireValide;
            }

            // Sur chaque champ, écoute le premier input pour activer la validation
            ['rid', 'rnumCarte', 'rmontant', 'cservice'].forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', () => {
                        if (!validationActive) {
                            validationActive =
                            true; // Activer la vérification après la première saisie
                        }
                        verifierChamps(); // Et lancer la vérification en direct
                    });
                }
            });
            // Lancer la vérification au chargement
            verifierChamps();

            // Affiche une bulle rouge sous le champ en erreur
            function insertBubble(input, message) {
                const bubble = document.createElement('div');
                bubble.className = 'error-bubble';
                bubble.style.color = 'red';
                bubble.style.fontSize = '0.8rem';
                bubble.style.marginTop = '4px';
                bubble.innerText = message;

                const parent = input.closest('.form-grp') || input.parentNode;
                parent.appendChild(bubble);
            }

        });
    </script>
@endsection
