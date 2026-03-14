<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between gap-2">
                <span>Guide de démarrage</span>
                <x-filament::button
                    color="primary"
                    size="sm"
                    icon="heroicon-o-play"
                    onclick="typeof runGroupsynapseTour === 'function' && runGroupsynapseTour()"
                >
                    Lancer le tour guidé
                </x-filament::button>
            </div>
        </x-slot>

        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Bienvenue ! Ce guide vous aide à comprendre chaque section du tableau de bord. Cliquez sur une carte pour accéder directement à la section.
            </p>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($this->getSteps() as $step)
                    @php
                        $url = $step['url'] ?? null;
                        $hasRoute = $url !== null;
                    @endphp
                    @if($hasRoute)
                        <a href="{{ $url }}"
                           class="group flex flex-col rounded-xl border border-gray-200 dark:border-gray-700 p-4 transition-all hover:border-primary-500 hover:shadow-md dark:hover:border-primary-500 bg-white dark:bg-gray-800/50">
                    @else
                        <div class="flex flex-col rounded-xl border border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-800/30 opacity-75">
                    @endif
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 @if($hasRoute) group-hover:text-primary-600 dark:group-hover:text-primary-400 @endif">
                                        {{ $step['title'] }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $step['description'] }}
                                    </p>
                                </div>
                                @if($hasRoute)
                                    <span class="shrink-0 inline-flex items-center rounded-md bg-primary-50 dark:bg-primary-900/30 px-2.5 py-0.5 text-xs font-medium text-primary-700 dark:text-primary-300">
                                        →
                                    </span>
                                @endif
                            </div>
                    @if($hasRoute)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-4 p-3 rounded-lg bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800">
                <p class="text-sm text-primary-800 dark:text-primary-200">
                    <strong>Astuce :</strong> Utilisez la recherche globale (Ctrl+K ou Cmd+K) pour trouver rapidement un utilisateur, produit ou service.
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
