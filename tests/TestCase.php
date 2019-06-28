<?php

namespace StaticRoutesTests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Webflorist\StaticRoutes\StaticRoutesServiceProvider;

/**
 * Class TestCase
 * @package StaticRoutesTests
 */
class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [
            StaticRoutesServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {

    }


}