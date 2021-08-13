<?php

namespace App\Console\Commands;

class BachelorServiceGenerator extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bachelor:service {name : Class (singular) for example PaymentCard} {--application : Application Layer Service} {--domain : Domain Layer Service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for auto creating new bachelor service and service interface for model.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        if ($this->option('application')) {
            $this->createApplicationService($name);
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(config_path("stubs/services/Application{$type}.stub"));
    }

    protected function createApplicationService($name)
    {
        $serviceFolder = base_path("Bachelor/Application/Services");
        $serviceInterfaceFolder = base_path("Bachelor/Application/Services/Interfaces");

        if (! is_dir($serviceFolder)) {
            mkdir($serviceFolder);
        }

        if (! is_dir($serviceInterfaceFolder)) {
            mkdir($serviceInterfaceFolder);
        }

        // Interface name
        $interfaceTemplate = str_replace(['{{name}}'], [$name], $this->getStub('ServiceInterface'));
        $serviceTemplate = str_replace(['{{name}}'], [$name], $this->getStub('Service'));

        $path =  "$serviceInterfaceFolder/{$name}ServiceInterface.php";

        if (! file_exists($path)) {
            file_put_contents($path, $interfaceTemplate);
        }

        $path = "$serviceFolder/{$name}Service.php";
        if (! file_exists($path)) {
            file_put_contents($path, $serviceTemplate);
        }

        $this->info("Application Service created in $serviceFolder");
    }
}
