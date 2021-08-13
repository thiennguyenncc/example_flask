<?php
namespace App\Console\Commands;

class BachelorRepositoryGenerator extends BachelorBaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bachelor:repository {domain : Domain folder (singular) for example PaymentManagement} {name : Class (singular) for example PaymentProviderFactory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for auto creating new bachelor repository and repository interface for model.';

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
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $this->repository($domain, $name);
    }

    protected function getStub($type)
    {
        return file_get_contents(config_path("stubs/repositories/{$type}Repository.stub"));
    }

    protected function repository($domain, $name)
    {
        $domainPath = base_path("Bachelor/Port/Secondary/Database/{$domain}");
        $modelPath = base_path("Bachelor/Port/Secondary/Database/{$domain}/{$name}");
        $interfaceDirPath = "$modelPath/Interfaces";
        $repositoryDirPath = "$modelPath/Repository";


        if (! is_dir($domainPath)) {
            mkdir($domainPath);
        }

        if (! is_dir($modelPath)) {
            mkdir($modelPath);
        }

        if (! is_dir($interfaceDirPath)) {
            mkdir($interfaceDirPath);
        }

        if (! is_dir($repositoryDirPath)) {
            mkdir($repositoryDirPath);
        }

        // Interface name
        $interfaceTemplate = str_replace(['{{interfaceName}}'], [$name], $this->getStub('Interface'));
        $eloquentTemplate = str_replace(['{{eloquentName}}'], [$name], $this->getStub('Eloquent'));

        $interfaceTemplate = str_replace(['{{domainName}}'], [$domain], $interfaceTemplate);
        $eloquentTemplate = str_replace(['{{domainName}}'], [$domain], $eloquentTemplate);

        //$path = app_path("/Http/Repositories/{$name}/{$name}Repository.php");
        $path =  "$interfaceDirPath/{$name}Interface.php";

        if (! file_exists($path)) {
            file_put_contents($path, $interfaceTemplate);
        }

        $path = "$repositoryDirPath/{$name}Repository.php";
        if (! file_exists($path)) {
            file_put_contents($path, $eloquentTemplate);
        }

        $this->info("Repository created in $domainPath");
    }
}
