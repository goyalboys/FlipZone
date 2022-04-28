<?php

namespace App\Http\Middleware;

use Session;
use Illuminate\Support\Facades\Redirect;
use Closure;
use Illuminate\Support\Facades\Auth;

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
        
      /* dd(Auth::User());
        if(!Auth::check())
        {
            echo "hello";
            //return "hello";
        }
        echo "hi";
*/
        //echo $request->path();
        if (!Session::get('active_user')) 
        {
            return redirect('login');
           
        }
        else{
            if(Session::get('type_user')=="merchant")
            {
                redirect('dashboard');
            }
            else{
                redirect('/');

            }
        }
        return $next($request);
    }
}
