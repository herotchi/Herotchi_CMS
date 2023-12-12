@extends('admin.layouts.app')
@section('title', '管理画面/ログイン情報変更')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">ログイン情報変更</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.user.login_update') }}" method="POST" novalidate>
        @csrf
        <div class="card-header">ログイン情報変更</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-12">
                    <label for="login_id" class="form-label">ログインID
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="login_id"
                        class="form-control{{ $errors->has('login_id') ? ' is-invalid' : '' }}" name="login_id"
                        value="{{ old('login_id', Auth::user()->login_id) }}" required>
                    <div class="invalid-feedback">{{ $errors->first('login_id') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="password" class="form-label">パスワード</label>
                    <input type="password" id="password"
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        placeholder="未入力の場合、ログインIDのみ変更されます" required>
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="password_confirmation" class="form-label">パスワード確認</label>
                    <input type="password" id="password_confirmation"
                        class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>
                    <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12 text-center my-2">
                    <button class="btn btn-primary w-50" type="submit">保存</button>
                    <a class="btn btn-secondary" href="{{ route('admin.top') }}" role="button">戻る</a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection