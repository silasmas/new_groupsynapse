<section class="mb-5">
    <h4 class="mb-3 text-danger">{{ __('Supprimer le compte') }}</h4>
    <p class="text-muted mb-4">
        {{ __('Une fois votre compte supprimé, toutes vos données et ressources seront définitivement effacées. Avant de procéder, pensez à télécharger toute information que vous souhaitez conserver.') }}
    </p>

    <button type="button" class="btn btn-danger profile-btn btn-sm" data-toggle="modal" data-target="#confirmUserDeletionModal">
        {{ __('Supprimer le compte') }}
    </button>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Confirmer la suppression') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">
                            {{ __('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.') }}
                        </p>
                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="{{ __('Entrez votre mot de passe') }}" required>
                            @if($errors->userDeletion->has('password'))
                                <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Annuler') }}</button>
                        <button type="submit" class="btn btn-danger profile-btn">{{ __('Supprimer le compte') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
