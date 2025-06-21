<?php

namespace PhpDominicana\LaravelModelExport\Writers;

final class SimpleJsonWriter
{
    public static function create(string $path): JsonWriter
    {
        return new JsonWriter($path);
    }
}
