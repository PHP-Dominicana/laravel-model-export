<?php

use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\TemporaryDirectory\TemporaryDirectory;

beforeEach(function () {
    $this->temporaryDirectory = new TemporaryDirectory(__DIR__.'/temp');

    $this->pathToCsv = $this->temporaryDirectory->path('test.csv');
    $this->pathToXlsx = $this->temporaryDirectory->path('test.xlsx');
});

it('can write a regular CSV', function () {
    SimpleExcelWriter::create($this->pathToCsv)
        ->addRow([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ])
        ->addRow([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);

    $this->assertMatchesFileSnapshot($this->pathToCsv);
});
