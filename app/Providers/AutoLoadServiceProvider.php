<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AutoLoadServiceProvider extends ServiceProvider
{
    /*
     * List all the paths to register
     */
    private $paths = [
        '/features/Http/*'
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->getPaths() as $path)
            // Used to autoload
            foreach (glob(base_path() . $path.'/*.php') as $file)
                require_once($file);
    }

    /**
     * Get the list of all the paths to register
     *
     * @return array
     */
    protected function getPaths()
    {
        return $this->paths;
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
