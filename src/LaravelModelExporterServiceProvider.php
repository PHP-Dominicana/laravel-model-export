<?php

namespace PhpDominicana\LaravelModelExport;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LaravelModelExporterServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Load routes, views, migrations, etc.
        Log::info("YourPackage booted!");
    }

    public function register()
    {
        // Bind classes or services
    }
}
