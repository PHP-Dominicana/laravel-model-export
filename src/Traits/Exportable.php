<?php

namespace PhpDominicana\LaravelModelExport\Traits;

trait Exportable
{
    public static function exportToCsv(?string $filePath = null): string
    {
        $model = new static;

        $filePath = $filePath !== null && $filePath !== '' && $filePath !== '0' ? $filePath : 'exports/'.class_basename($model).'_'.now()->timestamp.'.csv';

        $data = static::all();
        if ($data->isEmpty()) {
            return false;
        }

        $headers = array_keys($data->first()->getAttributes());

        $handle = fopen(storage_path("app/{$filePath}"), 'w');
        fputcsv($handle, $headers);

        foreach ($data as $item) {
            fputcsv($handle, $item->only($headers));
        }

        fclose($handle);

        return storage_path("app/{$filePath}");
    }
}
