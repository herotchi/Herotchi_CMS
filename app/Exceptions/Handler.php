<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, \Throwable $e)
    {
        if ($e instanceof TokenMismatchException) {
            // 公開側と管理側で遷移先を切り替える
            if (Auth::check()) { // ログイン済みは管理側ログインページに飛ばす
                return redirect()->route("admin.auth.show_login");
            } else { // 非ログインは公開側トップページに飛ばす
                return redirect()->route("top");
            }
        }
        return parent::render($request, $e);
    }
}
