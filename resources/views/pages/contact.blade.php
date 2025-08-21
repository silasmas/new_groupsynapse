@extends('layouts.template')

@section('content')
    @include('parties.banner', ['page' => 'Contact'])
    <!-- contact-area -->
    <section class="contact-area primary-bg pt-100 pb-70">
        <div class="container">
            <div class="contact-wrap-padding">
               <div class="row justify-content-center">
    <!-- Adresse -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
        <div class="text-center contact-info-box mb-30">
            <div class="contact-box-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="contact-info-content">
                <h5>Notre Adresse</h5>
                <p>Local 81, Immeuble Botour, Avenue de la presse, Kinshasa / Gombe</p>
            </div>
        </div>
    </div>

    <!-- Téléphone -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
        <div class="text-center contact-info-box mb-30">
            <div class="contact-box-icon">
                <i class="fas fa-phone"></i>
            </div>
            <div class="contact-info-content">
                <h5>Téléphone</h5>
                <p><a href="tel:+243999930158">+243 99 99 30 158</a></p>
            </div>
        </div>
    </div>

    <!-- Email -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
        <div class="text-center contact-info-box mb-30">
            <div class="contact-box-icon">
                <i class="fas fa-envelope-open"></i>
            </div>
            <div class="contact-info-content">
                <h5>Email</h5>
                <p><a href="mailto:info@groupsynapse.ord">info@groupsynapse.ord</a></p>
            </div>
        </div>
    </div>

    <!-- Fax -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
        <div class="text-center contact-info-box mb-30">
            <div class="contact-box-icon">
                <i class="fas fa-fax"></i>
            </div>
            <div class="contact-info-content">
                <h5>Fax</h5>
                <p><a href="tel:+243819901290">+243 81 99 01 290</a></p>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </section>
    <!-- contact-area-end -->
    <!-- contact-area -->
    <section class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7 col-md-9">
                    <div class="text-center contact-title mb-60">
    <div class="text-center section-title">
        <span class="sub-title">PARLONS-EN</span>
        <h2 class="title">Envoyez-nous un message</h2>
    </div>
    <p>Nous sommes toujours heureux d’échanger avec vous. N’hésitez pas à nous écrire si vous avez des questions ou besoin d’aide et de soutien.</p>
</div>

                </div>
            </div>
            <div class="contact-wrap-padding">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-form">
                            <form id="contact-form">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-grp">
                                            <input type="text" name="first_name" placeholder="Prénom*" required>
                                            <i class="far fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-grp">
                                            <input type="text" name="last_name" placeholder="Nom*" required>
                                            <i class="far fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-grp">
                                            <input type="email" name="email" placeholder="Votre email*" required>
                                            <i class="far fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-grp">
                                            <input type="text" name="phone" placeholder="Téléphone*" required>
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                <textarea name="message" placeholder="Votre message..."></textarea>
                                <button type="submit" class="btn">Envoyer</button>
                            </form>
                            <div id="contact-success" style="display:none;" class="mt-2 alert alert-success"></div>
                            <div id="contact-error" style="display:none;" class="mt-2 alert alert-danger"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="contact-map">
                            <img src="{{ asset('assets/img/images/map.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-area-end -->
@endsection

@section('script')
    <script>
        document.getElementById('contact-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const successDiv = document.getElementById('contact-success');
            const errorDiv = document.getElementById('contact-error');

            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';

            try {
                const response = await fetch("{{ route('contact.store') }}", {
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
                    for (let field in result.errors) {
                        errorDiv.innerHTML += result.errors[field].join('<br>') + '<br>';
                    }
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.innerText = result.message || 'Erreur inconnue.';
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                errorDiv.innerText = 'Erreur réseau. Veuillez réessayer.';
                errorDiv.style.display = 'block';
            }
        });
    </script>

    @endsection
