<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {
  
    protected $auth;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

   public function handle($request, Closure $next)
{
       if ($this->auth->check() or $request->is("auth/login") or $request->is("auth/register"))
       {
                return $next($request);
       } else
       {
                return redirect()->guest('auth/login');
       }
}

}
