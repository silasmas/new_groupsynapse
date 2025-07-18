@extends('layouts.template')

@section('content')
    @include('parties.banner', ['page' => 'Contact'])
    <!-- contact-area -->
    <section class="contact-area primary-bg pt-100 pb-70">
        <div class="container">
            <div class="contact-wrap-padding">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="contact-info-box text-center mb-30">
                            <div class="contact-box-icon">
                                <i class="flaticon-placeholder"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>Our Location</h5>
                                <p>W898 RTower Stat, Suite 56 Brockland, CA 9622 United States</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="contact-info-box text-center mb-30">
                            <div class="contact-box-icon">
                                <i class="flaticon-mail"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>Our Email</h5>
                                <p>Email Us: Support@info.Com</p>
                                <p>Vanamsupport.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="contact-info-box text-center mb-30">
                            <div class="contact-box-icon">
                                <i class="flaticon-telephone"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>Phone Number</h5>
                                <p>Contacr Numbers: 458-965-3224</p>
                                <p>458-965-3224</p>
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
                    <div class="contact-title text-center mb-60">
    <div class="section-title text-center">
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
                            <div id="contact-success" style="display:none;" class="alert alert-success mt-2"></div>
                            <div id="contact-error" style="display:none;" class="alert alert-danger mt-2"></div>
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
