<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Traits\HttpResponse;

class GeneralService
{
    use HttpResponse;

    public function __construct(private readonly \Illuminate\Contracts\Console\Kernel $kernel)
    {}

    public function clearCache()
    {
        $this->kernel->call('optimize:clear');
        return $this->success(null, 'cached files cleared!');
    }

    public function runMigration()
    {
        $this->kernel->call('migrate', ['--force' => true]);
        return $this->success(['output' => $this->kernel->output()], 'migrations run successfully!');
    }

    public function seedRun($request)
    {
        $seederClass = Str::studly($request->input('class'));

        if (! class_exists("Database\\Seeders\\{$seederClass}")) {
            return $this->error(null, "Seeder class '{$seederClass}' not found in Database\\Seeders namespace.");
        }

        try {
            $this->kernel->call('db:seed', [
                '--class' => $seederClass,
                '--force' => true,
            ]);

            return $this->success(['output' => $this->kernel->output()], "{$seederClass} executed successfully.");
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 404);
        }
    }
}
