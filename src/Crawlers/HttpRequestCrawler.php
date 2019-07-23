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
     * Set environment of $this->app.
     *
     * @param string $environment
     */
    public function setAppEnvironment(string $environment) {
        $this->app['env'] = $environment;
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