<?php

namespace Webflorist\StaticRoutes\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class ClearCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'static-routes:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears previously generated static routes.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Router $router
     * @return mixed
     * @throws RouteGenerationException
     */
    public function handle()
    {
        $outputBasePath = config('static-routes.output_path');

        self::rrmdir($outputBasePath);

        $this->info("Static routes successfully cleared.");
    }

    /**
     * Recursively remove a directory.
     *
     * @param string $dir
     */
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
