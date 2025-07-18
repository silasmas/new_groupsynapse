<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    @if ($shouldDisplay())
    <div class="alert alert-warning text-center py-3">
        ⚠️ Veuillez confirmer votre adresse email pour accéder à toutes les fonctionnalités.
        <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-warning ms-2">
            Renvoyer le lien
        </a>
    </div>
@endif
</div>
