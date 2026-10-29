<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('demo:reset')]
#[Description('Setzt die Demo zurück: Datenbank neu aufbauen, Seed-Daten einspielen, Cache leeren')]
class DemoReset extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $this->call('cache:clear');

        $this->components->info('Demo wurde zurückgesetzt.');

        return self::SUCCESS;
    }
}
