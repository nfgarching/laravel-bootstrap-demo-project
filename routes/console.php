<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('demo:reset')
    ->dailyAt('04:00')
    ->timezone('Europe/Berlin')
    ->withoutOverlapping();
