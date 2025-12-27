<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeHelper extends Command
{
    protected $signature = 'make:helper {name}';
    protected $description = 'Create a new helper class';

    public function handle()
    {
        $name = $this->argument('name');
        $className = Str::studly($name);
        
        // Buat folder Helpers jika belum ada
        $helperDir = app_path('Helpers');
        if (!is_dir($helperDir)) {
            mkdir($helperDir, 0755, true);
        }

        $filePath = $helperDir . '/' . $className . '.php';

        if (file_exists($filePath)) {
            $this->error("Helper {$className} sudah ada!");
            return;
        }

        $stub = <<<'STUB'
<?php

namespace App\Http\Helpers;

class {CLASS}
{
    //
}
STUB;

        $content = str_replace('{CLASS}', $className, $stub);
        file_put_contents($filePath, $content);

        $this->info("Helper {$className} berhasil dibuat di app/Helpers/{$className}.php");
    }
}
