<?php

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->temporaryDirectory = new TemporaryDirectory(__DIR__.'/temp');

    $this->pathToCsv = $this->temporaryDirectory->path('test_user.csv');
    $this->pathToXlsx = $this->temporaryDirectory->path('test_user.xlsx');
});

it('can write a regular CSV', function () {
    // Arrange
    User::factory()->count(3)->create();

    $this->assertDatabaseCount('users', 3);

    // Act
    $path = User::exportToExcel($this->pathToCsv);

    // validate content
    expect(file_exists($path))->toBeTrue();
});
