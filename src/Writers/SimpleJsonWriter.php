<?php

namespace PhpDominicana\LaravelModelExport\Writers;

class SimpleJsonWriter
{
    public static function create(string $path): JsonWriter
    {
        return new JsonWriter($path);
    }
}
