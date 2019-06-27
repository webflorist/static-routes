<?php

namespace Webflorist\StaticRoutes\Crawlers;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;

class HttpRequestCrawler extends TestCase
{
    /**
     * HttpRequestCrawler constructor.
     */
    public function __construct($app)
    {
        parent::__construct();
        $this->app = $app;
    }


    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        return $this->app;
    }

}