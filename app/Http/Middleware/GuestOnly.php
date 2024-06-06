<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuestOnly
{
    public function handle($request, Closure $next)
    {
        // Проверка, что пользователь не авторизован как соискатель или работодатель
        if (Auth::guard('web')->check() || Auth::guard('company')->check()) {
            // Можно перенаправить пользователя на другую страницу
            return redirect()->back()->with('error', 'Этот маршрут недоступен для авторизованных пользователей.');
        }

        return $next($request);
    }
}
