<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabelle für Nfgarching\Core\Models\Prop (Struktur laut Package-README).
 * Das Package bringt nur einen Entwurf (*.todo) mit, daher legt die App sie an.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('props', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('key')->nullable();
            $table->string('state')->nullable();
            $table->string('type')->nullable();
            $table->string('label')->nullable();
            $table->string('value')->nullable();
            $table->json('data')->nullable();
            $table->text('memo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('props');
    }
};
