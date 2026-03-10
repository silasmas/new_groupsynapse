@extends('layouts.template')

@section('style')
<style>
    .profile-btn {
        background-color: #FD0101 !important;
        color: #000 !important;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    .profile-btn:hover {
        background-color: #000 !important;
        color: #fff !important;
    }
    .btn-danger.profile-btn {
        background-color: #FD0101 !important;
        color: #000 !important;
    }
    .btn-danger.profile-btn:hover {
        background-color: #000 !important;
        color: #fff !important;
    }
</style>
@endsection

@section('content')
    @include('parties.banner', ['page' => 'Mon profil'])
    <!-- profile-area -->
    <section class="shop-details-area pt-100 pb-100">
        <div class="container">
            @if (session()->has('retour'))
                <div class="alert {{ session()->get('retour')['reponse'] == true ? 'alert-success' : 'alert-danger' }}">
                    {{ session()->get('retour')['message'] }}
                </div>
            @endif
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">
                    {{ __('Profil mis à jour avec succès.') }}
                </div>
            @endif
            @if (session('status') === 'password-updated')
                <div class="alert alert-success">
                    {{ __('Mot de passe mis à jour avec succès.') }}
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="shop-details-content">
                        @include('profile.partials.update-profile-information-form')
                        <hr class="my-5">
                        @include('profile.partials.update-password-form')
                        <hr class="my-5">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- profile-area-end -->
@endsection

@section('script')
@if($errors->userDeletion->isNotEmpty())
<script>
    $(document).ready(function() {
        $('#confirmUserDeletionModal').modal('show');
    });
</script>
@endif
@endsection
