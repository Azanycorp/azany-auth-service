<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Traits\HttpResponse;

class GeneralService
{
    use HttpResponse;

    public function clearCache()
    {
        Artisan::call('optimize:clear');
        return $this->success(null, 'cached files cleared!');
    }

    public function runMigration()
    {
        Artisan::call('migrate', ['--force' => true]);
        return $this->success(['output' => Artisan::output()], 'migrations run successfully!');
    }

    public function seedRun()
    {
        $seederClass = Str::studly(request()->input('class'));

        if (! class_exists("Database\\Seeders\\{$seederClass}")) {
            return $this->error(null, "Seeder class '{$seederClass}' not found in Database\\Seeders namespace.");
        }

        try {
            Artisan::call('db:seed', [
                '--class' => $seederClass,
                '--force' => true,
            ]);

            return $this->success(['output' => Artisan::output()], "{$seederClass} executed successfully.");
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 404);
        }
    }
}
