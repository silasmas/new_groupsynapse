<section class="mb-5">
    <h4 class="mb-3">{{ __('Informations du profil') }}</h4>
    <p class="text-muted mb-4">
        {{ __('Mettez à jour vos informations de profil et votre adresse e-mail.') }}
    </p>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group mb-3">
            <label for="name" class="form-label">{{ __('Nom') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="phone" class="form-label">{{ __('Téléphone') }}</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+243 99 99 30 158">
            @error('phone')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="sexe" class="form-label">{{ __('Sexe') }}</label>
            <select id="sexe" name="sexe" class="form-control">
                <option value="">{{ __('-- Sélectionner --') }}</option>
                <option value="M" {{ old('sexe', $user->sexe) == 'M' ? 'selected' : '' }}>{{ __('Masculin') }}</option>
                <option value="F" {{ old('sexe', $user->sexe) == 'F' ? 'selected' : '' }}>{{ __('Féminin') }}</option>
                <option value="Autre" {{ old('sexe', $user->sexe) == 'Autre' ? 'selected' : '' }}>{{ __('Autre') }}</option>
            </select>
            @error('sexe')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="pays" class="form-label">{{ __('Pays') }}</label>
            <input type="text" id="pays" name="pays" class="form-control" value="{{ old('pays', $user->pays) }}" placeholder="RD Congo">
            @error('pays')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="adresse" class="form-label">{{ __('Adresse') }}</label>
            <textarea id="adresse" name="adresse" class="form-control" rows="2" placeholder="{{ __('Votre adresse principale') }}">{{ old('adresse', $user->adresse) }}</textarea>
            @error('adresse')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="adresse_livraison" class="form-label">{{ __('Adresse de livraison') }}</label>
            <textarea id="adresse_livraison" name="adresse_livraison" class="form-control" rows="2" placeholder="{{ __('Adresse pour les livraisons') }}">{{ old('adresse_livraison', $user->adresse_livraison) }}</textarea>
            @error('adresse_livraison')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn profile-btn btn-sm">{{ __('Enregistrer') }}</button>
    </form>
</section>
