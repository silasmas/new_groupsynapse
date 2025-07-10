<div class="col-lg-8">
    <div class="checkout-wrap">
        <h5 class="title">Veuillez remplir le formulaire ci-dessous pour renouveler votre carte</h5>
        <small>
            <b>Note :</b> Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires. Assurez-vous de
            fournir des informations
            valides pour éviter des retards dans le traitement de votre demande.
            <p class="text-danger">Le frais du renouvelement de la carte est de {{ $serv->prix . '' . $serv->currency }}</p>
        </small>
        <form action="#" class="checkout-form" id="formpaie">
            <div class="row">
                <div class="col-sm-6" hidden>
                    <div class="form-grp">
                        <label for="fName">Service <span>*</span></label>
                        <input type="text" value="{{ $page }}" required id="cservice" name="service">
                    </div>
                </div>
                <div class="col-sm-6" hidden>
                    <div class="form-grp">
                        <label for="fName">reference </label>
                        <input type="text" value="" id="creference" name="reference">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-grp">
                        <label for="fName">Nom et Prenom <span>*</span></label>
                        <input type="text" required id="cnom" name="nom">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-grp">
                        <label for="lName">Email <span>*</span></label>
                        <input type="email" required id="cemail" name="email">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-grp">
                        <label for="phone">Numero de telephon <span>*</span></label>
                        <input type="text" required id="cphone" name="phone" placeholder="Ex : 24382XXXXX">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-grp">
                        <label for="phone">Premier depos (ce montant est obligatoire et doit être minumum 5$)
                            <span>*</span></label>
                        <input type="text" required id="cpremier" name="premierDepos"
                            placeholder="Ecrivez que le montant (Ex : 5,10,20...)">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-grp">
                        <label for="cName">Pièce d’identité valide <span>*</span> <small>lisible (CNI, passeport ou
                                permis)</small></label>
                        <input type="file" id="cpiece" name="piece">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-grp">
                        <label for="cName">Photo d’identité <span>*</span></label>
                        <input type="file" id="cphoto" name="photo">
                    </div>
                </div>
                <div class="col-3">
                    <div class="different-address custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="clivraison" name="livraison">
                        <label class="custom-control-label" for="clivraison">livraison à domicile?</label>
                    </div>
                </div>
                <div class="col-9 mb-20" id="adresse-group">
                    <label class="mb-10">Frais de livraison : 5$</label>
                    <div class="form-grp mb-0">
                        <label for="address"> Adresse de livraison <small>(Optionel)</small></label>
                        <textarea name="adresse" id="cadresse" placeholder="Votre adresse de livraison"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" id="btnSoumisson" class="btn">Soumettre la demande</button>
            <button type="submit" id="btnModifier" class="btn btn-warning d-none">Modifier la demande</button>
        </form>
    </div>
</div>

@section('script')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ============================================================
            // 1. Initialisation des éléments DOM et des variables globales
            // ============================================================
            const livraisonCheckbox = document.getElementById('clivraison');
            const adresseGroup = document.getElementById('adresse-group');
            const cpremier = document.getElementById('cpremier');
            const adresseField = document.getElementById('cadresse').closest('.form-grp');
            const formInfo = document.querySelector('.checkout-form');
            const paiementSection = document.getElementById('paiement-section');
            const btnPaiement = document.getElementById('btn-paiement');
            const fileInputs = ['cpiece', 'cphoto'];

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


            // ========================================
            // 2. Gestion de l'affichage de l'adresse
            // ========================================
            function toggleAdresseDisplay() {
                const adresseInput = document.getElementById('cadresse');

                if (livraisonCheckbox.checked) {
                    adresseGroup.style.display = 'block';
                    adresseInput.setAttribute('required', 'required'); // rendre obligatoire
                } else {
                    adresseGroup.style.display = 'none';
                    adresseInput.removeAttribute('required'); // retirer l'obligation
                    adresseInput.value = ''; // optionnel : vider le champ
                }
            }

            toggleAdresseDisplay(); // 2.1 Initialisation au chargement
            livraisonCheckbox.addEventListener('change', toggleAdresseDisplay); // 2.2 Réactivité

            // ============================================
            // 3. Drag & Drop : gestion des fichiers upload
            // ============================================
            fileInputs.forEach(id => {
                const input = document.getElementById(id);
                const dropZone = document.createElement('div');
                dropZone.className = 'drop-zone';
                dropZone.innerHTML = `
            <p>Glissez votre fichier ici ou cliquez pour sélectionner</p>
            <div class="preview"></div>`;

                input.style.display = 'none';
                input.parentNode.insertBefore(dropZone, input);
                dropZone.appendChild(input);

                // 3.1 Clic = ouvrir le file input
                dropZone.addEventListener('click', () => input.click());

                // 3.2 Drag / Drop
                dropZone.addEventListener('dragover', e => {
                    e.preventDefault();
                    dropZone.classList.add('dragover');
                });
                dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
                dropZone.addEventListener('drop', e => {
                    e.preventDefault();
                    dropZone.classList.remove('dragover');
                    const file = e.dataTransfer.files[0];
                    validateAndPreview(file, input, dropZone);
                });

                // 3.3 Changement normal
                input.addEventListener('change', () => {
                    const file = input.files[0];
                    validateAndPreview(file, input, dropZone);
                });
            });

            // ======================================
            // 4. Soumission du formulaire principal
            // ======================================
            formInfo.addEventListener('submit', function(e) {
                e.preventDefault();

                // 4.1 Nettoyage visuel
                document.querySelectorAll('.is-invalid, .input-error, .label-error, .error-bubble').forEach(
                    el => {
                        el.classList.remove('is-invalid', 'input-error', 'label-error');
                        if (el.classList.contains('error-bubble')) el.remove();
                    });

                // 4.2 Validation des champs requis
                const requiredFields = ['cnom', 'cemail', 'cphone', 'cpiece', "cpremier"];
                let valid = true;
                let messages = [];

                requiredFields.forEach(id => {
                    const field = document.getElementById(id);
                    const value = field?.value?.trim();
                    if (!value) {
                        valid = false;
                        messages.push(`Le champ "${field.name}" est requis.`);

                        if (field.type === 'file') {
                            field.closest('.drop-zone')?.classList.add('input-error');
                            const labelEl = field.closest('.form-grp')?.querySelector('label');
                            labelEl?.classList.add('label-error');
                            insertBubble(field, 'Ce champ est requis.');
                        } else {
                            field.classList.add('is-invalid');
                            insertBubble(field, 'Ce champ est requis.');
                        }
                    }
                });

                // 4.3 Validation e-mail
                const email = document.getElementById('cemail');
                if (email.value && !/\S+@\S+\.\S+/.test(email.value)) {
                    valid = false;
                    email.classList.add('is-invalid');
                    insertBubble(email, 'Adresse email invalide.');
                    messages.push("Adresse email invalide.");
                }

                // 4.4 Stop si invalide
                if (!valid) {
                    toastr.warning("Corrigez les erreurs du formulaire.");
                    return;
                }

                // 4.5 Envoi du formulaire via AJAX
                const formData = new FormData(formInfo);
                fetch("{{ route('init.service') }}", {
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

                            document.getElementById('total').value = data.total;
                            document.getElementById('slug').value = data.slug;
                            document.getElementById('currency').value = data.currency;
                            document.getElementById('totalAff').textContent = data.total + data
                                .currency;
                            document.getElementById('afficheLivraison').textContent = data.livraison +
                                data.currency;
                            document.getElementById('afficheDepos').textContent = data.premier + data
                                .currency;
                            document.getElementById('sousTotal').textContent = data.total + data
                                .currency;
                            document.getElementById('creference').value = data.id;
                            document.getElementById('referenceCreate').value = data.reference;

                            // 5.1 Afficher le bouton Modifier
                            const btnModifier = document.getElementById('btnModifier');
                            btnModifier.classList.remove('d-none');
                            btnModifier.dataset.userId = data.id;

                            // 5.2 Initialiser le bloc paiement
                            paiement();

                            toastr.success(
                                "✅ Informations enregistrées. Vous pouvez passer à la caisse.");
                        } else {
                            // 6. Réponse avec erreurs
                            let messages = [];
                            const fieldLabels = {
                                nom: "Nom et prénom",
                                email: "Adresse e-mail",
                                phone: "Numéro de téléphone",
                                piece: "Pièce d’identité",
                                photo: "Photo d’identité",
                                adresse: "Adresse de livraison",
                                livraison: "Livraison",
                                service: "Service",
                                premierDepos: "Premier dépôt"
                            };

                            if (data.errors) {
                                for (const field in data.errors) {
                                    const label = fieldLabels[field] || field;
                                    const input = document.querySelector(`[name="${field}"]`);
                                    const msg = data.errors[field].join(', ');
                                    messages.push(`<b>${label}</b> : ${msg}`);

                                    if (input) {
                                        if (input.type === 'file') {
                                            input.closest('.drop-zone')?.classList.add('input-error');
                                            input.closest('.form-grp')?.querySelector('label')
                                                ?.classList.add('label-error');
                                            insertBubble(input, msg);
                                        } else {
                                            input.classList.add('is-invalid');
                                            insertBubble(input, msg);
                                        }
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

            // ==================================================
            // 7. Fonctions utilitaires
            // ==================================================

            // 7.1 Affiche une bulle rouge sous le champ en erreur
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

            // 7.2 Fonction pour gérer la logique du paiement (Mobile money, CGU)
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

            // 7.3 Valide et affiche l'aperçu du fichier uploadé
            function validateAndPreview(file, input, container) {
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                const maxSize = 2 * 1024 * 1024;
                const preview = container.querySelector('.preview');

                preview.innerHTML = '';

                if (file) {
                    if (!allowedTypes.includes(file.type)) {
                        toastr.warning("Format non supporté (JPG, PNG, PDF)");
                        input.value = '';
                        return;
                    }

                    if (file.size > maxSize) {
                        toastr.warning("Fichier trop volumineux (max 2 Mo)");
                        input.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        let content = '';
                        if (file.type.startsWith('image/')) {
                            content = `<img src="${e.target.result}" alt="aperçu fichier">`;
                        } else {
                            content = `<div class="file-name">${file.name}</div>`;
                        }

                        preview.innerHTML = `
                    <div class="preview-container">
                        ${content}
                        <span class="remove-icon" title="Supprimer">×</span>
                    </div>
                `;

                        preview.querySelector('.remove-icon').addEventListener('click', () => {
                            input.value = '';
                            preview.innerHTML = '';
                        });
                    };
                    reader.readAsDataURL(file);
                }
            }

            // 8. Réinitialisation dynamique du formulaire
            function resetForm() {

                // 🧼 Réinitialise le formulaire HTML natif
                formInfo.reset();

                // 🔄 Réinitialise l’affichage de l’adresse
                toggleAdresseDisplay();

                // 🔄 Vide les aperçus des fichiers
                fileInputs.forEach(id => {
                    const input = document.getElementById(id);
                    const preview = input.closest('.drop-zone')?.querySelector('.preview');
                    if (preview) preview.innerHTML = '';
                });

                // 🧽 Supprime les erreurs visuelles
                document.querySelectorAll('.is-invalid, .input-error, .label-error, .error-bubble')
                    .forEach(el => {
                        el.classList.remove('is-invalid', 'input-error', 'label-error');
                        if (el.classList.contains('error-bubble')) el.remove();
                    });

                // 🔒 Réinitialise la section paiement
                paiementSection.style.opacity = 0.5;
                paiementSection.style.pointerEvents = 'none';
                btnPaiement.setAttribute('disabled', true);

                // ❌ Masque le bouton modifier
                document.getElementById('btnModifier')?.classList.add('d-none');

                // 🔄 Vide les champs cachés de paiement
                ['total', 'slug', 'currency'].forEach(id => {
                    const field = document.getElementById(id);
                    if (field) field.value = '';
                });

                // 🧾 Vide l'affichage des totaux
                ['totalAff', 'afficheLivraison', 'afficheDepos', 'sousTotal'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = '';
                });

                toastr.info("Formulaire réinitialisé.");


            }


        });
    </script>


@endsection
