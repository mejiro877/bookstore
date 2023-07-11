<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //未ログイン
        if (!session()->has('member_no')) {
            return redirect(url('ecsite/menu'));
        }
        return $next($request);
    }
}
