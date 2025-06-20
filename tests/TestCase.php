<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\Snapshots\MatchesSnapshots;

#[WithEnv('DB_CONNECTION', 'testing')]
#[WithMigration]
abstract class TestCase extends BaseTestCase
{
    //
    use MatchesSnapshots, RefreshDatabase, WithWorkbench;
}
