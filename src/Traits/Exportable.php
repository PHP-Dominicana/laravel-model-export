<?php

namespace PhpDominicana\LaravelModelExport\Traits;

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

    public static function exportToJson(?string $filePath = null): string
    {
        return static::query()->exportToJson($filePath);
    }

    public static function exportToPdf(?string $filePath = null)
    {
        return static::query()->exportToPdf($filePath);
    }
}
