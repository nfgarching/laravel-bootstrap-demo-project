{{-- Erwartet: $contacts (Paginator mit ->sortable()), $request, $cities, $statusEnum --}}
<x-table.filter class="mb-3">
    <x-table.filter.cnt_per_page route="demo.core.components" :request="$request" />
    <x-table.filter.search field="search" table="Kontakte" :oldval="$request->search" />
    <x-table.filter.dropdown field="city" label="Ort" :options="$cities" :oldval="$request->city" />
    <x-table.filter.dropdown.enum field="status" label="Status" :enum="$statusEnum" :oldval="$request->status" />
    <x-table.filter.dropdown.bool field="newsletter" label="Newsletter" :oldval="$request->newsletter" />
</x-table.filter>

<x-form :action="route('demo.core.components')" method="GET">
    @php
        $colspan = 6;
        $token = 'contacts';
        $toggleCollapse = true;
        $toggleChecks = true;
    @endphp

    <x-table :acc_id="$token" class="table-sm table-hover align-middle" :$colspan :$toggleChecks>
        @forelse ($contacts as $contact)
            @if ($loop->first)
                <x-slot:header>
                    <x-table.head.sort field="name" label="Name" width="30%" />
                    <x-table.head.sort field="city" label="Ort" width="20%" />
                    <x-table.head.sort field="status" label="Status" width="20%" />
                    <th>Newsletter</th>
                    <th></th>
                </x-slot:header>
            @endif

            <x-table.row :acc_id="$token" :row_id="$contact->id" :$toggleCollapse :$toggleChecks>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->city }}</td>
                <td><span class="badge text-bg-light border">{{ $contact->status->label() }}</span></td>
                <td>{!! $contact->newsletter ? '<i class="bi bi-check-lg text-success"></i>' : '' !!}</td>

                <x-slot:row2>
                    <td colspan="{{ $colspan - 2 }}">
                        <x-desc.list :item="$contact->only(['email', 'memo', 'created_at'])" />
                    </td>
                </x-slot:row2>
            </x-table.row>
        @empty
            <tr>
                <td colspan="{{ $colspan }}">Keine Kontakte gefunden.</td>
            </tr>
        @endforelse

        <x-slot:footer>
            <span class="small text-body-secondary">Markierte Zeilen werden als checks[] übertragen.</span>
        </x-slot:footer>
    </x-table>
</x-form>

{{ $contacts->links() }}
