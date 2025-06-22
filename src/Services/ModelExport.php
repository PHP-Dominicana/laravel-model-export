<?php

namespace PhpDominicana\LaravelModelExport\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

class ModelExport
{
    protected Builder|Collection|LazyCollection $source;

    /**
     * @var array<int, string>|null
     */
    protected ?array $only = null;

    /**
     * @var array<int, string>
     */
    protected array $transformations = [];

    public static function from(Builder|Collection|LazyCollection $source): static
    {
        $instance = new static;
        $instance->source = $source;

        return $instance;
    }

    public function only(array $columns): static
    {
        $this->only = $columns;

        return $this;
    }

    public function transform(string $column, callable $callback): static
    {
        $this->transformations[$column] = $callback;

        return $this;
    }

    protected function processRow(array $row): array
    {
        $data = $this->only !== null && $this->only !== [] ? array_intersect_key($row, array_flip($this->only)) : $row;

        foreach ($this->transformations as $column => $callback) {
            if (isset($data[$column])) {
                $data[$column] = $callback($data[$column]);
            }
        }

        return $data;
    }

    public function toPdf(string $filename = 'export.pdf'): Response
    {
        $data = $this->getLazyCollection()->map(function ($model): array {
            return $this->processRow($model->toArray());
        });

        $pdf = Pdf::loadView('laravel-model-export::exports.default', ['rows' => $data]);

        return $pdf->download($filename);
    }

    protected function getLazyCollection(): LazyCollection
    {
        if ($this->source instanceof Builder) {
            return $this->source->lazy();
        }

        if ($this->source instanceof LazyCollection) {
            return $this->source;
        }

        return LazyCollection::make($this->source);
    }
}
