<?php

namespace App\Livewire\Demo;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Nfgarching\Core\Traits\ListingTrait;
use Nfgarching\Core\Traits\MainTrait;

/**
 * Listing auf Basis von ListingTrait und den Partials unter core::listing.*.
 */
class ContactListing extends Component
{
    use ListingTrait, MainTrait;

    public bool $showEmpty = false;

    public function mount(): void
    {
        $this->build_main();

        $this->table = 'contacts';
        $this->pageTitle = __('Kontakte suchen …');
        $this->pageLimit = 5;
        $this->sortField = 'id';
        $this->sortAsc = true;
        $this->sortFields = ['id', 'name', 'city'];
    }

    public function showNoData(): void
    {
        $this->search = 'zzz-gibt-es-nicht';
        $this->showEmpty = false;
    }

    public function render(): View
    {
        return view('demo.core.examples.listing.contacts', [
            'rows' => $this->build_rows(Contact::query()),
        ]);
    }
}
