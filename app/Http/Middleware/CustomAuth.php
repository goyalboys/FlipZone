<?php

namespace App\Http\Middleware;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use Closure;

class CustomAuth
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

        //echo $request->path();
        if (!Session::get('active_user')) 
        {
            return redirect('login');
           
        }
        else{
            if(Session::get('type_user')=="merchant")
            {
                redirect('merchant_dashboard');
            }
            else{
                redirect('/');

            }
             
        }
        return $next($request);
    }
}
