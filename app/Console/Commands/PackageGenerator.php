<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PackageGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package {package}';

    protected $packageDir = 'packages/hris';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate Package Folder';

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
        $this->package = strtolower($this->argument('package'));

        $this->createDirectoryList();
        
        $this->createFiles();

        return $this->info("Package Created Successfully!");
    }
    protected function createDirectoryList()
    {
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package)); // main directory
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src')); // src
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/Http/Controllers/Admin')); // Admin controllers
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/Http/Controllers/Staff')); // Staff controllers
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/Http/Controllers/Supervisor')); // Supervisor controllers
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/database/migrations')); // migrations
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/Models')); // models
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/Observers')); // observers
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/Notifications')); // notifications
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/Requests')); // requests
        $this->createDirectory(base_path($this->packageDir . '/' . $this->package . '/src/routes')); // routes
    }
    protected function createFiles()
    {
        $files = [
            [
                'name' => 'composer.json',
                'app_path' => app_path('Console/Stubs/package/composer.json'),
                'base_path' => base_path($this->packageDir . '/' . $this->package)."/composer.json"
            ],
            [
                'name' => 'web.php',
                'app_path' => app_path('Console/Stubs/package/web.php'),
                'base_path' => base_path($this->packageDir . '/' . $this->package)."/src/routes/web.php"
            ],
            [
                'name' => 'Service Provider',
                'app_path' => app_path('Console/Stubs/package/DummyServiceProvider.php'),
                'base_path' => base_path($this->packageDir . '/' . $this->package)."/src/{$this->package}ServiceProvider.php"
            ],
            [
                'name' => 'Requests Form',
                'app_path' => app_path('Console/Stubs/package/DummyRequest.php'),
                'base_path' => base_path($this->packageDir . '/' . $this->package)."/src/Requests/{$this->package}Request.php"
            ],
            [
                'name' => 'Observer',
                'app_path' => app_path('Console/Stubs/package/DummyObserver.php'),
                'base_path' => base_path($this->packageDir . '/' . $this->package)."/src/Observers/{$this->package}Observer.php"
            ],
            [
                'name' => 'Notification',
                'app_path' => app_path('Console/Stubs/package/DummyNotification.php'),
                'base_path' => base_path($this->packageDir . '/' . $this->package)."/src/Notifications/{$this->package}Notification.php"
            ]
        ];
        foreach($files as $file)
        {
            if(!file_exists($file['base_path']))
            {
                if($this->confirm('Do you wish to create '.$file['name']))
                    $this->createFile($file['app_path'], $file['base_path'], '');
                continue;
            }
            if ($this->confirm('File Exist!, Do you wish to overwrite '.$file['name'])) {
                $this->createFile($file['app_path'], $file['base_path'], '');
            }
        }
    }
    protected function createFile($dummySource, $destinationPath, $message, $folder = null)
    {
        $this->package = ucfirst($this->argument('package'));
        $pluralPackage = Str::plural($this->package);
        $dummyFile = file_get_contents($dummySource);
        $toBeReplacedContent = str_replace(
            ['Dummy', 'Dummies','dummies','dummy', 'DUMMY'], 
            [$this->package, $pluralPackage,strtolower($pluralPackage), strtolower($this->package), strtoupper($this->package)], $dummyFile
        );
        file_put_contents($dummySource, $toBeReplacedContent);
        copy($dummySource, $destinationPath);
        file_put_contents($dummySource, $dummyFile);
        return $this->info($message);
    }
    protected function createDirectory($dir)
    {
        if (!is_dir($dir)) 
            mkdir($dir, 0755, true);
    }
}
