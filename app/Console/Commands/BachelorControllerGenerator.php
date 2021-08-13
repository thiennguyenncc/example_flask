<?php
namespace App\Console\Commands;

class BachelorControllerGenerator extends BachelorBaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bachelor:controller {name : Class (singular) for example PaymentCard} {--api}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for auto creating new bachelor api controller.';

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

        if ($this->option('api')) {
            $this->createApi($name);
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(config_path("stubs/controllers/{$type}Controller.stub"));
    }

    public function createApi($name)
    {
        $apiFolderPath = base_path("Bachelor/Port/Primary/WebApi/Controllers/Api");
        $apiFilePath = "$apiFolderPath/{$name}Controller.php";

        // Create Folder if not exist
        if (! is_dir($apiFolderPath)) {
            mkdir($apiFolderPath);
        }

        if (! file_exists($apiFilePath)) {
            $apiControllerTemplate = str_replace([
                '{{name}}'
            ], [
                $name
            ], $this->getStub('Api'));

            file_put_contents($apiFilePath, $apiControllerTemplate);

            return $this->info("Api controller created at $apiFilePath");
        }

        $this->info("Api controller already exists at $apiFilePath");
    }
}
