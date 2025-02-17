<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || auth()->user()->level !== 'superadmin') {
            return redirect()->route('login'); //jangan lupa berikan name pada route loginnya
        } else {
            $allowedPrefix = auth()->user()->hak_akses;
            $currentPrefix = $request->route()->getPrefix();
            if (in_array('/dashboard', $allowedPrefix)) {
                $allowedPrefix[] = 'dashboard';
            } 

            if (in_array($currentPrefix, $allowedPrefix) || $currentPrefix == '') {
                return $next($request);
            } else {
                return redirect()->route($this->convertToArrayKey($allowedPrefix[0]));
                // throw new UnauthorizedHttpException('Unauthorized');
            }
        }
    }

    private function convertToArrayKey($value) {
        // Remove leading and trailing slashes
        $value = trim($value, '/');

        // Replace internal slashes with dots
        $value = str_replace('/', '.', $value);

        // Replace dashes with underscores
    $value = str_replace('-', '_', $value);

        return $value;
    }
}
