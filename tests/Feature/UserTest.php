<?php

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->temporaryDirectory = new TemporaryDirectory(__DIR__.'/temp');

    $this->pathToCsv = $this->temporaryDirectory->path('test_user.csv');
    $this->pathToXlsx = $this->temporaryDirectory->path('test_user.xlsx');
    $this->pathToJson = $this->temporaryDirectory->path('test_user.json');
    $this->pathToPdf = $this->temporaryDirectory->path('testuser.pdf');
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

it('can write a regular Excel', function () {
    // Arrange
    User::factory()->count(3)->create();

    $this->assertDatabaseCount('users', 3);

    // Act
    $path = User::exportToExcel($this->pathToXlsx);

    // validate content
    expect(file_exists($path))->toBeTrue();
});

it('can write a regular JSON', function () {
    // Arrange
    User::factory()->count(3)->create();

    $this->assertDatabaseCount('users', 3);

    // Act
    $path = User::exportToJson($this->pathToJson);

    // validate content
    expect(file_exists($path))->toBeTrue();
});

it('can write a regular PDF', function () {
    // Arrange
    User::factory()->count(3)->create();

    $this->assertDatabaseCount('users', 3);

    // Act
    $response = User::exportToPdf('export.pdf');

    $this->assertTrue(
        $response->headers->get('Content-Type') === 'application/pdf'
    );

    // validate content
    ob_start();
    $response->sendContent();
    $pdf = ob_get_clean();

    $this->assertNotEmpty($pdf);
    $this->assertStringContainsString('%PDF-', $pdf);
});
