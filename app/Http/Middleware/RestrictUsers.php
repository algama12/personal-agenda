<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictUsers
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedEmails = config('app.allowed_users');

        // Filter out empty/null values
        $allowedEmails = array_filter($allowedEmails, fn($email) => !empty($email));

        // If no emails configured, allow all users
        if (empty($allowedEmails)) {
            return $next($request);
        }

        if (!in_array(auth()->user()->email, $allowedEmails)) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'No tienes permiso para acceder a esta aplicacion.');
        }

        return $next($request);
    }
}
