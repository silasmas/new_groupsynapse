<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Connexion à votre compte client (distinct du tableau de bord admin).
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('status') }}
        </div>
    @endif

    @if (!isset($step) || $step === 'email')
        {{-- Étape 1 : Saisir l'email --}}
        <form method="POST" action="{{ route('login.send-code') }}">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Adresse e-mail')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="exemple@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between mt-6">
                <x-primary-button type="submit">
                    Envoyer le code à 6 chiffres
                </x-primary-button>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-indigo-600 hover:underline dark:text-indigo-400">
                        Créer un compte
                    </a>
                @endif
            </div>
        </form>
    @else
        {{-- Étape 2 : Saisir le code --}}
        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Un code a été envoyé à <strong>{{ $email }}</strong>
        </p>
        <form method="POST" action="{{ route('login.verify-code') }}">
            @csrf
            <div>
                <x-input-label for="code" :value="__('Code à 6 chiffres')" />
                <x-text-input id="code" class="block mt-1 w-full text-center text-2xl tracking-[0.5em]" type="text" name="code" maxlength="6" pattern="[0-9]{6}" required autofocus placeholder="000000" inputmode="numeric" />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>
            <div class="block mt-4">
                <label for="remember" class="inline-flex items-center">
                    <input id="remember" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
                </label>
            </div>
            <div class="flex items-center justify-between mt-6">
                <x-primary-button type="submit">
                    Se connecter
                </x-primary-button>
                <a href="{{ route('login.back') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">
                    Utiliser une autre adresse
                </a>
            </div>
        </form>
    @endif

    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
        <p class="text-xs text-gray-500 dark:text-gray-400">
            Accès administrateur : <a href="{{ url('/admin') }}" class="underline">Tableau de bord</a>
        </p>
    </div>
</x-guest-layout>
