<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:class {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command makes a new class in the app/Services directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Services/' . str_replace('\\', '/', $name) . '.php');
        
        // Create the directory if it doesn't exist
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Create the file
        $this->info('Creating ' . $name . ' class...');
        if ($this->createFile($path)) {
            $this->info('Class ' . $name . ' created successfully.');
        } else {
            $this->error('Class ' . $name . ' already exists.');
        }
    }

    /**
     * Create the file at the given path.
     *
     * @param string $path
     * @return bool
     */
    protected function createFile($path)
    {
        if (file_exists($path)) {
            return false;
        }

        $filesystem = new Filesystem();
        $filesystem->put($path, $this->getClassTemplate());

        return true;
    }

    /**
     * Get the class template.
     *
     * @return string
     */
    protected function getClassTemplate()
    {
        return "<?php\n\nnamespace App\Services;\n\nclass NewClass\n{\n    //\n}\n";
    }
}