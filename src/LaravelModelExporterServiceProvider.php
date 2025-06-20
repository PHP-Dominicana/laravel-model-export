<?php

namespace PhpDominicana\LaravelModelExport;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Spatie\SimpleExcel\SimpleExcelWriter;

class LaravelModelExporterServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        // Load routes, views, migrations, etc.
        Builder::macro('exportToExcel', function (?string $path = null) {
            /** @var \Illuminate\Database\Eloquent\Builder $this */
            $model = $this->getModel();
            $path ??= storage_path('app/export_'.class_basename($model).'_'.now()->timestamp.'.csv');

            $writer = SimpleExcelWriter::create($path);

            $this->lazyById()->each(function ($row) use ($writer): void {
                $writer->addRow($row->toArray());
            });

            $writer->close();

            return $path;
        });

        Builder::macro('streamDownload', function (?string $path = null) {
            /** @var \Illuminate\Database\Eloquent\Builder $this */
            $model = $this->getModel();
            $path ??= storage_path('app/export_'.class_basename($model).'_'.now()->timestamp.'.csv');

            $writer = SimpleExcelWriter::streamDownload($path);

            $this->lazyById()->chunk(1000, function ($items) use ($writer): void {
                foreach ($items as $item) {
                    $writer->addRow($item->toArray());
                }
                flush(); // Flush the buffer every chunk
            });

            $writer->toBrowser();
        });
    }

    public function register(): void
    {
        // Bind classes or services
    }
}
