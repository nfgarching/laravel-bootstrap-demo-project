<?php

use App\Demo\ExamplePackage\ExampleServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\DemoServiceProvider;

return [
    AppServiceProvider::class,
    DemoServiceProvider::class,
    ExampleServiceProvider::class,
];
