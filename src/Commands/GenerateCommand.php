<?php

namespace Webflorist\StaticRoutes\Commands;

use Illuminate\Console\Command;
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
        $this->crawler = new HttpRequestCrawler(app());
    }

    /**
     * Execute the console command.
     *
     * @param Router $router
     * @return mixed
     */
    public function handle(Router $router)
    {
        $outputBasePath = config('static-routes.output_path');

        self::rrmdir($outputBasePath);

        foreach ($router->getRoutes()->getRoutesByMethod()['GET'] as $route) {

            $outputFile = $outputBasePath . '/' . $route->uri . '/index.html';
            $outputPath = substr($outputFile, 0, strrpos($outputFile, '/'));

            if (!file_exists($outputPath)) {
                mkdir($outputPath, 0777, true);
            }

            $content = $this->crawler->call(
                'GET',
                $route->uri()
            )->content();

            file_put_contents($outputFile, $content);

        }
    }

    static function rrmdir(string $dir) : void
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                        self::rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
    }
}
