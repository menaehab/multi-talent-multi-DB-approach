<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantDatabaseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        if ($host && $host !== "multi-tenancy-custom-multi.test") {
            $tenant = Tenant::where('subdomain', $host)->first();
            if ($tenant) {
                // configure the database connection for the tenant
                app(TenantDatabaseService::class)->connectToDB($tenant);

            } else {
                // Handle case where tenant is not found (optional)
                abort(404, 'Tenant not found.');
            }
        }
        return $next($request);
    }
}
