@extends('admin.layouts.app')
@section('title', '管理画面/ログイン')
<style>
html,
body {
    height: 100%;
}

body {
    display: flex;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
}

.no-header {
    width: 100%;
    max-width: 360px;
    padding: 15px;
    margin: auto;
}
</style>
@section('content')
<div class="no-header">
    <div class="text-center">
        <img class="mb-4" src="{{ asset('img/Herotchi_CMS.png') }}" alt="" width="57" height="57">
        <h1 class="h3 mb-3 fw-normal">管理画面ログイン</h1>
    </div>
    <form method="POST" action="{{ route('admin.auth.login') }}" novalidate>
        @csrf
        <div class="row g-3">
            <div class="col-12">
               <input type="text" id="login_id" 
                    class="form-control{{ $errors->has('login_id') ? ' is-invalid' : '' }}" 
                    name="login_id" value="{{ old('login_id') }}" 
                    placeholder="ログインID" required>
                <div class="invalid-feedback">{{ $errors->first('login_id') }}</div>
            </div>
            <div class="col-12">
                <input type="password" id="password" 
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                name="password" placeholder="パスワード" required>
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">ログイン</button>
            </div>
        </div>
    </form>
</div>


@endsection