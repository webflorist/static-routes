<?php

namespace StaticRoutesTests\Feature;

use StaticRoutesTests\TestCase;
use Webflorist\RouteTree\RouteAction;
use Webflorist\RouteTree\RouteNode;

class StaticRoutesGenerationTest extends TestCase
{

    public function test_static_routes_generation()
    {

        $routes = [
            'de' => 'root',
            'en' => 'root',
            'de/page' => 'page',
            'en/page' => 'page'
        ];

        route_tree()->setRootNode(
            $rootNode = (new RouteNode())
                ->addAction(
                    (new RouteAction('get'))
                        ->setClosure(function () {
                            return "root";
                        })
                )
        );

        (new RouteNode('page', $rootNode))
            ->addAction(
                (new RouteAction('get'))
                    ->setClosure(function () {
                        return "page";
                    })
            );

        route_tree()->generateAllRoutes();

        $this->artisan('static-routes:generate');

        $outputBasePath = config('static-routes.output_path');

        foreach ($routes as $routeName => $routeContent) {

            $outputFile = $outputBasePath . '/' . $routeName . '.html';

            $this->assertFileExists($outputFile);

            $this->assertEquals(
                $routeContent,
                file_get_contents($outputFile)
            );

        }


    }

}