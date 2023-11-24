<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\LoginRequest;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    //
    public function login()
    {
        return view('admin.user.login');
    }


    public function login_update(LoginRequest $request)
    {
        DB::transaction(function () use ($request) {

            $model = new User();
            $model->updateLogin($request->validated());
        });

        return redirect()->route('admin.top')->with('msg_success', 'ログイン情報を変更しました。');
    }
}
