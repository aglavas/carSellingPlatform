<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Parse validation errors array from validation errors string
     *
     * @param string $validationErrors
     * @return array
     */
    public function parseValidationErrorArray(string $validationErrors)
    {
        $validationErrors = preg_replace('/Line <b>\d<\/b>: /', 'XXlinereplacedXX', $validationErrors);

        $validationErrorsArray = explode('XXlinereplacedXX', $validationErrors);

        $validationErrorsArray = array_filter($validationErrorsArray);

        return $validationErrorsArray;
    }
}
