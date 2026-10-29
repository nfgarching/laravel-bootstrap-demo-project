{{-- View der Livewire-Komponente App\Livewire\Demo\ContactListing (ListingTrait) --}}
<div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <x-button type="outline-secondary" class="btn-sm" click="reset_search">Alle Kontakte</x-button>
        <x-button type="outline-secondary" class="btn-sm" click="showNoData">Zustand „keine Daten“</x-button>
        <x-button type="outline-secondary" class="btn-sm" click="$toggle('showEmpty')">Zustand „leer“</x-button>
    </div>

    <x-card>
        {{-- Kartenkopf: Suche, Sortier-Dropdown und Select-Umschalter --}}
        @include('core::listing.card.headerLeft')

        <x-slot name="headerRight">
            <span class="badge text-bg-secondary">{{ $rows->total() }} Treffer</span>
        </x-slot>

        @if ($showEmpty)
            {{-- core::listing.empty ist derzeit eine leere Datei --}}
            @include('core::listing.empty')
            <p class="text-body-secondary small mb-0">core::listing.empty rendert (noch) nichts.</p>
        @else
            {{-- Tabellenansicht: Zeile 1 + aufklappbare Zeile 2 je Datensatz --}}
            <x-table class="table-sm" id="accordion-{{ $token }}">
                @forelse ($rows as $row)
                    @include('core::listing.table.row1')
                    @include('core::listing.table.row2')
                    @if ($loop->last && $rows->lastPage() > 1)
                        @include('core::listing.table.footer')
                    @endif
                @empty
                    @include('core::listing.nodata')
                @endforelse
            </x-table>
        @endif
    </x-card>
</div>
