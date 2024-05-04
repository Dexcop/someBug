<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\DataController;

class RefreshSessionData
{
    /**
     * Handle an incoming request.
     *
     * This middleware refreshes session data on every request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $dataController = new DataController();
        $data = $dataController->show();
        $data = $data->reverse();  // Optionally reverse the data if needed

        // Store the updated data in the session
        session(['data' => $data]);

        return $next($request);
    }
}
