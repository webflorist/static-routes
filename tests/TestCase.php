<?php

namespace StaticRoutesTests;

use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Webflorist\StaticRoutes\StaticRoutesServiceProvider;

/**
 * Class TestCase
 * @package StaticRoutesTests
 */
class TestCase extends BaseTestCase
{

    /**
     * @var Router
     */
    protected $router;

    protected function getPackageProviders($app)
    {
        return [
            StaticRoutesServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->router = $app[Router::class];
    }


}