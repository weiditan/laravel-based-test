<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\User\Entities\User;

class AuthController extends Controller
{
    public function login_page(Request $request): View
    {
        return view("login");
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::query()
            ->where("email", "=", $request->validated("email"))
            ->first();

        Auth::loginUsingId($user->id);
        return redirect(route("home"));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route("login"));
    }
}
