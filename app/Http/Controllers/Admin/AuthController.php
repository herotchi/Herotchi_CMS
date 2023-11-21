<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function show_login()
    {
        return view('admin.auth.show_login');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('login_id', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.top');
        }

        return back()->withErrors([
            'password' => 'ログイン情報が間違っています。'
        ]);
    }


    public function logout()
    {
        var_dump(__LINE__);
    }
}
