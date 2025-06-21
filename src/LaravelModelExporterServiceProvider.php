<?php

namespace PhpDominicana\LaravelModelExport;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use PhpDominicana\LaravelModelExport\Writers\SimpleJsonWriter;
use Spatie\SimpleExcel\SimpleExcelWriter;

class LaravelModelExporterServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        // Load routes, views, migrations, etc.
        Builder::macro('exportToExcel', function (?string $path = null): string {
            /** @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $this */
            $model = $this->getModel();
            $path ??= storage_path('app/export_'.class_basename($model).'_'.now()->timestamp.'.csv');

            $writer = SimpleExcelWriter::create($path);

            $this->lazyById()->each(function ($row) use ($writer): void {
                $writer->addRow($row->toArray());
            });

            $writer->close();

            return $path;
        });

        Builder::macro('exportToJson', function (?string $path = null): string {
            /** @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $this */
            $model = $this->getModel();
            $path ??= storage_path('app/export_'.class_basename($model).'_'.now()->timestamp.'.csv');

            $writer = SimpleJsonWriter::create($path);

            $this->lazyById()->each(function ($row) use ($writer): void {
                $writer->write($row->toArray());
            });

            $writer->close();

            return $path;
        });

        Builder::macro('streamDownload', function (?string $path = null): void {
            /** @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $this */
            $model = $this->getModel();
            $path ??= storage_path('app/export_'.class_basename($model).'_'.now()->timestamp.'.csv');

            $writer = SimpleExcelWriter::streamDownload($path);
            $this->lazyById()
                ->chunk(1000)
                ->each(function ($chunk) use ($writer): void {
                    $writer->addRows($chunk->all());
                    flush(); // Flush the buffer every 1000 rows
                });

            $writer->toBrowser();
        });
    }

    public function register(): void
    {
        // Bind classes or services
    }
}
