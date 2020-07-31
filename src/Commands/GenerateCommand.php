<?php

namespace Webflorist\StaticRoutes\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
use Webflorist\FormFactory\FormFactory;
use Webflorist\StaticRoutes\Crawlers\HttpRequestCrawler;
use Webflorist\StaticRoutes\Exceptions\RouteGenerationException;

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
     * @var Router
     */
    private $router;

    /**
     * @var Request
     */
    private $request;

    /**
     * Create a new command instance.
     *
     * @param Router $router
     * @param Request $request
     */
    public function __construct(Router $router, Request $request)
    {
        parent::__construct();
        $this->router = $router;
        $this->request = $request;
    }

    /**
     * Execute the console command.
     *
     * @param Router $router
     * @return mixed
     * @throws RouteGenerationException
     */
    public function handle(Router $router, Request $request)
    {
        // Set environment to production.
        config()->set('app.env', 'production');
        app()['env'] = 'production';

        // Set debug to false
        config()->set('app.debug', false);

        // Set a pseudo-config key to let application know,
        // a static generation is happening.
        config()->set('static-routes.is_generating', true);

        $outputBasePath = config('static-routes.output_path');

        Artisan::call('static-routes:clear');

        foreach ($this->router->getRoutes()->getRoutesByMethod()['GET'] as $route) {
            /** @var Route $route */

            $uri = $route->uri();

            if ($this->uriIsExcluded($uri)) {
                $this->line("$uri: excluded via config.");
                continue;
            }

            $response = $this->getResponse($uri);

            if (!is_null($response->exception)) {
                $exceptionInfo = get_class($response->exception).':'.$response->exception->getMessage();
                throw new RouteGenerationException("Route with URI '$uri' threw Exception:'$exceptionInfo'");
            }

            if ($response->isRedirection()) {
	            // TODO: Handle redirections.
                $this->line("$uri: excluded due to redirection.");
                continue;
            }

            file_put_contents(
                $this->getOutputFile($outputBasePath, $uri),
                $response->content()
            );

            $this->info("$uri: generated successfully.");

        }

        $this->info("Static routes generation successfully completed.");
    }

    /**
     * Check if $uri is excluded via config.
     *
     * @param string $uri
     * @return bool
     */
    private function uriIsExcluded(string $uri)
    {
        foreach (config('static-routes.excluded_paths') as $excludedPath) {
            if ($uri === $excludedPath) {
                return true;
            }
            if (strpos($uri,$excludedPath.'/') === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $outputBasePath
     * @param string $uri
     * @return string
     */
    protected function getOutputFile(string $outputBasePath, string $uri): string
    {
        $outputFile = "$outputBasePath/$uri/index.html";
        $outputPath = substr($outputFile, 0, strrpos($outputFile, '/'));

        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0777, true);
        }
        return $outputFile;
    }

    /**
     * @param string $uri
     * @return Response
     */
    protected function getResponse(string $uri)
    {

        // Reload formfactory singleton.
        app()->forgetInstance('Webflorist\FormFactory\FormFactory');

        $request = Request::create($uri);
        $request->headers->set('HOST',
            $this->request->headers->get('HOST')
        );
        /** @var Response $response */
        $response = $response = app()->handle($request);
        return $response;
    }
}
