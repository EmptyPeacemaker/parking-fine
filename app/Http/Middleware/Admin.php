<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;

class Admin
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
        if (Role::where('id',auth()->id())->where('role_id',1)->first())return $next($request);
        return redirect(route('index'));
    }
}
