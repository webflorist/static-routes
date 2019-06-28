<?php

namespace StaticRoutesTests\Feature;

use Illuminate\Routing\Router;
use StaticRoutesTests\TestCase;

class StaticRoutesGenerationTest extends TestCase
{

    public function test_static_routes_generation()
    {

        /** @var Router $router */
        $router = app(Router::class);

        $routes = [
            '' => 'root',
            'page' => 'page',
            'page/subpage' => 'subpage'
        ];

        foreach ($routes as $routeName => $routeContent) {
            $router->get($routeName, function() use($routeContent) {
                return $routeContent;
            });
        }

        $this->artisan('static-routes:generate');

        $outputBasePath = config('static-routes.output_path');

        foreach ($routes as $routeName => $routeContent) {

            $outputFile = $outputBasePath . '/' . $routeName . '/index.html';

            $this->assertFileExists($outputFile);

            $this->assertEquals(
                $routeContent,
                file_get_contents($outputFile)
            );

        }

    }

}