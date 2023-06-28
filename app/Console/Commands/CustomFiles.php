<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CustomFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:hris {model} {--m} {controllerDir?} {viewDir?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command that will generate Model Migration Controller VueComponents';

    protected $modelDir = 'Models';
    
    protected $controllerDir = 'Admin';

    protected $viewDir = 'Admin';

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
        if($this->argument('controllerDir')) {
            $this->controllerDir = ucFirst($this->argument('controllerDir'));
        }

        if($this->argument('viewDir')) {
            $this->viewDir = strtolower($this->argument('viewDir'));
        }

        $this->model = ucfirst($this->argument('model'));

        if ($this->confirm('Do you wish to create' .' '. $this->model . ' '. 'Model?')) {
            $this->call('make:model', [
                'name' => $this->model,
            ]);
        }
        if ($this->confirm('Do you wish to create' .' '. $this->model . ' '. 'Controler?')) {
            $controllerDirectory = app_path('Http/Controllers/'.$this->controllerDir);
            $this->createDirectory($controllerDirectory);
            
            // Controller File
            $sourceControllerFile = app_path('Console/Stubs/CustomController.stub');
            $destinationControllerFile = app_path("Http/Controllers/{$this->controllerDir}/{$this->model}Controller.php");
            $msg = "Created {$this->model}Controller";
            $this->createFile($sourceControllerFile,$destinationControllerFile, $msg);
        }
        if ($this->confirm('Do you wish to create' .' '. $this->model . ' '. 'Form Request?')) {
            $this->call('make:request', [
                'name' => ucfirst($this->controllerDir) . '/' . $this->model . 'Request',
            ]);
        }
        if ($this->confirm('Do you wish to create' .' '. $this->model . ' '. 'Observer?')) {
            $this->call('make:observer', [
                'name' => $this->model . 'Observer',
                '--model' => $this->model
            ]);
        }
        if ($this->confirm('Do you wish to create' .' '. $this->model . ' '. 'Notification?')) {
            $this->call('make:notification', [
                'name' => $this->model . 'Notification',
            ]);
        }
        if ($this->confirm('Do you wish to create' .' '. $this->model . ' '. 'migration?')) {
            $this->createMigration();
        }
        if ($this->confirm('Do you wish to create the views')) {
            $this->createViews();
        }
        return Command::SUCCESS;
    }
    protected function createFile($dummySource, $destinationPath, $message, $folder = null)
    {
        $this->model = ucfirst($this->argument('model'));
        $pluralModel = Str::plural($this->model);
        $dummyFile = file_get_contents($dummySource);
        $toBeReplacedContent = str_replace(
            ['Dummy', 'Dummies','dummies','dummy'], 
            [$this->model, $pluralModel,strtolower($pluralModel), strtolower($this->model)], $dummyFile
        );
        file_put_contents($dummySource, $toBeReplacedContent);
        copy($dummySource, $destinationPath);
        file_put_contents($dummySource, $dummyFile);
        return $this->info($message);
    }

    protected function createDirectory($dir)
    {

        if (!is_dir($dir)) {

            mkdir($dir, 0755, true);
        }
    }
    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('model'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            resource_path('js/Pages'), $path,
        ]);
    }
    protected function createViews()
    {
        $folder = Str::snake(Str::pluralStudly(class_basename($this->model)));
        
        $pluralModel = Str::plural(ucfirst($this->argument('model')));

        $bladeFolder = ucwords($folder);
        
        $views = [
            'pages/Index.vue' => "{$this->viewDir}/{$bladeFolder}/Index.vue",
            'pages/Edit.vue' => "{$this->viewDir}/{$bladeFolder}/Edit.vue",
            'pages/Create.vue' => "{$this->viewDir}/{$bladeFolder}/Create.vue",
        ];
        foreach ($views as $key => $value) {
            $this->createDirectory($this->getViewPath($this->viewDir));
            if (file_exists($view = $this->getViewPath($value))) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            $sourceControllerFile = app_path("Console/Stubs/{$key}");
           
            $destinationControllerFile = $this->getViewPath("$value");
            $this->createDirectory($this->getViewPath("{$this->viewDir}/{$bladeFolder}"));
            $msg =  str_replace('.vue','', explode("/",$key)[1])  . " Vue Created";
            $this->createFile($sourceControllerFile,$this->getViewPath($value), $msg);
        }
    }
}
