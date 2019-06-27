<?php

namespace StaticRoutesTests\Feature;

use StaticRoutesTests\TestCase;
use Webflorist\RouteTree\RouteAction;
use Webflorist\RouteTree\RouteNode;

class StaticRoutesGenerationTest extends TestCase
{

    public function test_static_routes_generation()
    {

        route_tree()->setRootNode(
            (new RouteNode())
                ->addAction(
                    (new RouteAction('get'))
                        ->setClosure(function () {
                            return "root";
                        })
                )
        );

        (new RouteNode('page'))
            ->addAction(
                (new RouteAction('get'))
                    ->setClosure(function () {
                        return "page";
                    })
            );

        route_tree()->generateAllRoutes();

        $this->artisan('static-routes:generate');

    }

}