<div
    x-data="{}"
    x-on:focus-first-global-search-result.stop="$el.querySelector('.fi-global-search-result-link')?.focus()"
    class="fi-global-search flex items-center justify-center flex-1"
>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_START) }}

    <div class="sm:relative w-full max-w-2xl">
        <x-filament-panels::global-search.field />

        @if ($results !== null)
            <x-filament-panels::global-search.results-container
                :results="$results"
            />
        @endif
    </div>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_END) }}
</div>
