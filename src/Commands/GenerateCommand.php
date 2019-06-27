<?php

namespace Webflorist\StaticRoutes\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Webflorist\StaticRoutes\Crawlers\HttpRequestCrawler;

class GenerateCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'static-routes:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates static routes.';

    /**
     * @var HttpRequestCrawler
     */
    private $crawler;

    /**
     * Create a new command instance.
     *
     * @param HttpRequestCrawler $crawler
     */
    public function __construct()
    {

        parent::__construct();
        $this->crawler = new HttpRequestCrawler(app()->make(Kernel::class)->bootstrap());
    }

    /**
     * Execute the console command.
     *
     * @param Router $router
     * @return mixed
     */
    public function handle(Router $router)
    {
        foreach ($router->getRoutes()->getRoutesByMethod()['GET'] as $route) {

            /** @var Route $route */

            dd(
                $this->crawler->call(
                    'GET',
                    $route->uri()
                )
            );
            dd($route->uri);

        }
    }
}
