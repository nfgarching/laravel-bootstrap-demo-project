<?php

namespace App\Models;

use App\Enums\ContactStatus;
use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kyslik\ColumnSortable\Sortable;
use Nfgarching\Core\Models\Prop;
use Nfgarching\Core\Traits\Searchable;

/**
 * Demo-Kontakt mit erfundenen Daten; Träger der polymorphen Props.
 */
#[Fillable(['name', 'email', 'city', 'status', 'newsletter', 'memo'])]
class Contact extends Model
{
    /** @use HasFactory<ContactFactory> */
    use HasFactory, Searchable, Sortable;

    /**
     * Spalten für den search()-Scope aus Nfgarching\Core\Traits\Searchable.
     *
     * @var list<string>
     */
    public array $searchable = ['name', 'email', 'city', 'memo'];

    /**
     * Spalten, nach denen kyslik/column-sortable sortieren darf.
     *
     * @var list<string>
     */
    public array $sortable = ['id', 'name', 'city', 'status'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ContactStatus::class,
            'newsletter' => 'boolean',
        ];
    }

    /**
     * @return MorphMany<Prop, $this>
     */
    public function props(): MorphMany
    {
        return $this->morphMany(Prop::class, 'model');
    }

    /**
     * Anzeigetext für die Listing-Partials des Packages (listing.table.row1).
     */
    public function getSuchbegriff(): string
    {
        return "{$this->name} ({$this->city})";
    }

    /**
     * Mehrzeiliger Text für das Livewire-Modal modal.multi.
     */
    public function get_multi(): string
    {
        return implode("\n", array_filter([
            $this->name,
            $this->email,
            $this->city,
            $this->status?->label(),
            $this->memo,
        ]));
    }
}
