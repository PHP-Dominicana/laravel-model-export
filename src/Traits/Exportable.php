<?php

namespace PhpDominicana\LaravelModelExport\Traits;

use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelWriter;

trait Exportable
{
    public static function exportToExcel(?string $filePath = null): string
    {
        $model = new static;

        $filePath = $filePath !== null && $filePath !== '' && $filePath !== '0' ? $filePath : 'exports/'.class_basename($model).'_'.now()->timestamp.'.csv';

        try {
            $query = static::query();

            // Get columns from first row if none provided
            if (empty($columns)) {
                $first = $query->first();
                if (! $first) {
                    return false;
                }
                $columns = array_keys($first->getAttributes());
            }

            $writer = SimpleExcelWriter::create($filePath);
            static::chunk(1000, function ($items) use ($writer, $columns): void {
                foreach ($items as $item) {
                    $writer->addRow(collect($item->only($columns))->toArray());
                }
                flush(); // Flush the buffer every chunk
            });

            $writer->close();
            return $filePath;

        } catch (\Throwable $e) {
            Log::error('Export failed: '.$e->getMessage());
            return false;
        }
    }

    public static function streamDownload(?string $filePath = null): void
    {
        $model = new static;

        $filePath = $filePath !== null && $filePath !== '' && $filePath !== '0' ? $filePath : 'exports/'.class_basename($model).'_'.now()->timestamp.'.csv';

        try {
            $query = static::query();

            // Get columns from first row if none provided
            if (empty($columns)) {
                $first = $query->first();
                if (! $first) {
                    return;
                }
                $columns = array_keys($first->getAttributes());
            }

            $writer = SimpleExcelWriter::streamDownload($filePath);
            static::chunk(1000, function ($items) use ($writer, $columns): void {
                foreach ($items as $item) {
                    $writer->addRow(collect($item->only($columns))->toArray());
                }
                flush(); // Flush the buffer every chunk
            });

            $writer->toBrowser();

        } catch (\Throwable $e) {
            Log::error('Export failed: '.$e->getMessage());
        }
    }
}
