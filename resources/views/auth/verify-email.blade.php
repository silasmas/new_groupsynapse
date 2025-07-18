<!-- Toast de notification -->
<div id="toast-notification" class="toast" style="position: fixed; bottom: 20px; right: 20px; display: none; z-index: 9999; background: #28a745; color: white; padding: 10px 20px; border-radius: 5px;">
    📩 Lien de vérification envoyé avec succès !
</div>
<style>
.toast {
    animation: slideUp 0.5s ease;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n’avez pas reçu l’email, nous serons heureux de vous en renvoyer un.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Un nouveau lien de vérification a été envoyé à l’adresse email que vous avez fournie lors de l’inscription.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Renvoyer l’email de vérification') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('toast-notification');

        @if (session('status') == 'verification-link-sent')
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 4000); // Masquer après 4 secondes
        @endif
    });
</script>
