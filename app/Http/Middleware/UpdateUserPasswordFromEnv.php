<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdateUserPasswordFromEnv
{
    public function handle(Request $request, Closure $next)
    {
        $username = config('custom_auth.user');
        $password = config('custom_auth.password');

        $user = User::where('username', $username)->first();

        if ($user && !Hash::check($password, $user->password)) {
            $user->password = Hash::make($password);
            $user->save();
        }

        return $next($request);
    }
}
