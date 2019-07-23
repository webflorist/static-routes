<?php

namespace Webflorist\StaticRoutes\Crawlers;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;

class HttpRequestCrawler extends TestCase
{
    /**
     * HttpRequestCrawler constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        parent::__construct();
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