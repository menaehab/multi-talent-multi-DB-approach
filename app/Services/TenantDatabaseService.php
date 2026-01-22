<?php

namespace App\Services;

class TenantDatabaseService
{
    public function createDB($databaseName)
    {
        \DB::statement("CREATE DATABASE " . $databaseName);
    }
}
