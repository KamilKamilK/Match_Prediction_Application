<?php

namespace Tests;

use App\Models\Prediction;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function prediction()
    {
        return Prediction::factory()->create();
    }
}
