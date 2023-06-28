<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;
use App\Enums\StaffType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class IsSupervisor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check())
        {
            return Inertia::render('Auth/Login', [
                'canResetPassword' => Route::has('password.request'),
                'status' => session('status'),
            ]);
        }else{
            if(Auth::user()->staff_type == StaffType::SUPERVISOR->value)
            {
                return $next($request);
            }else{
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login');
            }
        }
    }
}
