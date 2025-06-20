<?php

namespace PhpDominicana\LaravelModelExport\Traits;

use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelWriter;

trait Exportable
{
    public static function exportToExcel(?string $filePath = null): string
    {
        return static::query()->exportToExcel($filePath);
    }

    public static function streamDownload(?string $filePath = null): void
    {
        static::query()->streamDownload($filePath);
    }
}
