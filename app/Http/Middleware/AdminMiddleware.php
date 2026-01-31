<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserModel;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $user = UserModel::find($request->session()->get('user_id'));

        if (!$user || $user->role != 1) {
            return redirect('/');
        }

        return $next($request);
    }
}
