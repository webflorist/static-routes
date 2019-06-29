<?php

namespace StaticRoutesTests\Feature;

use Illuminate\Routing\Router;
use StaticRoutesTests\TestCase;
use Webflorist\StaticRoutes\Exceptions\RouteGenerationException;

class StaticRoutesGenerationTest extends TestCase
{

    public function test_static_routes_generation()
    {

        $routes = [
            '' => 'root',
            'page' => 'page',
            'page/subpage' => 'subpage'
        ];

        foreach ($routes as $routeName => $routeContent) {
            $this->router->get($routeName, function() use($routeContent) {
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

    public function test_route_with_exception()
    {
        $this->expectException(RouteGenerationException::class);
        $this->expectExceptionMessage("Route with URI 'exception' threw Exception:'ErrorException:Undefined variable: undefinedVarialbe'");

        $this->router->get('exception', function() {
            return $undefinedVarialbe;
        });

        $this->artisan('static-routes:generate');


    }

}