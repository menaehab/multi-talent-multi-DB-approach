<?php

namespace App\Services;

class TenantDatabaseService
{
    public function createDB($databaseName)
    {
        \DB::statement("CREATE DATABASE " . $databaseName);
    }

    public function connectToDB($tenant)
    {
        $database = $tenant->database;
        config()->set('database.connections.tenant.database', $database);
        \DB::purge('tenant');
        \DB::reconnect('tenant');
    }
}
