<?php

namespace App\Http\Middleware;

use App\Events\CompanyConfigured;
use App\Events\PanelConfigured;
use App\Models\Company;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigureCurrentPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        PanelConfigured::dispatch();

        return $next($request);
    }
}
