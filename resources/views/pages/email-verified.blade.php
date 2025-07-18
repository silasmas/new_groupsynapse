<x-guest-layout>
    <div class="w-full max-w-md mx-auto mt-20 text-center p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-green-600 mb-4">✅ Adresse email vérifiée avec succès !</h2>
        <p class="mb-6 text-gray-700">Votre adresse email a bien été confirmée. Vous pouvez maintenant vous connecter à votre compte.</p>
        <a href="{{ route('login') }}" class="inline-block px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Se connecter
        </a>
    </div>
</x-guest-layout>
