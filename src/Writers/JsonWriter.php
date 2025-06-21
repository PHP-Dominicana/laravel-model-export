<?php

namespace PhpDominicana\LaravelModelExport\Writers;

final class JsonWriter
{
    private bool $first = true;

    private readonly \SplFileObject $stream;

    public function __construct(string $output = 'php://output')
    {
        $this->stream = new \SplFileObject($output, 'w');
        $this->stream->fwrite("[\n");
    }

    public function write(array|object $data): void
    {
        if (! $this->first) {
            $this->stream->fwrite(",\n");
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        $this->stream->fwrite($json);
        $this->first = false;
    }

    public function close(): void
    {
        $this->stream->fwrite("\n]\n");
    }
}
