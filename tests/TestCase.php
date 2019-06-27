<?php

namespace StaticRoutesTests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Webflorist\RouteTree\RouteTreeServiceProvider;
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
            RouteTreeServiceProvider::class,
            StaticRoutesServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app',
            [
                'locale' => 'de',
                'locales' => [
                    'de' => 'Deutsch',
                    'en' => 'English'
                ]
            ]);

    }


}