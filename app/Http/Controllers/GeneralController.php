<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeneralService;

class GeneralController extends Controller
{
    public function __construct(
        protected readonly GeneralService $generalService
    )
    {}

    public function clearCache()
    {
        return $this->generalService->clearCache();
    }

    public function runMigration()
    {
        return $this->generalService->runMigration();
    }

    public function seedRun()
    {
        return $this->generalService->seedRun();
    }
}
