@extends('layouts.app')
@section('title', 'お問い合わせ')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">お問い合わせ</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('contact.confirm') }}" method="POST" novalidate>
        @csrf
        <div class="card-header">お問い合わせ</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-12">
                    <label for="name" class="form-label">氏名
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="name"
                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                        value="{{ old('name') }}" required>
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="mail_address" class="form-label">メールアドレス
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="email" id="mail_address"
                        class="form-control{{ $errors->has('mail_address') ? ' is-invalid' : '' }}" name="mail_address"
                        value="{{ old('mail_address') }}" required>
                    <div class="invalid-feedback">{{ $errors->first('mail_address') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="mail_body" class="form-label">お問い合わせ内容
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <textarea id="mail_body"
                        class="form-control{{ $errors->has('mail_body') ? ' is-invalid' : '' }}" name="mail_body"
                        rows="4" required>{{ old('mail_body') }}</textarea>
                    <div class="invalid-feedback">{{ $errors->first('mail_body') }}</div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" id="user_policy"
                            class="form-check-input text-center{{ $errors->has('user_policy') ? ' is-invalid' : '' }}"
                            name="user_policy" value="yes" {{ old('user_policy') ? 'checked' : 'disabled="disabled"' }} 
                            required>
                        <label class="form-check-label" for="user_policy">
                            <span class="text-info text-decoration-underline" data-bs-toggle="modal"
                                data-bs-target="#user_policy_modal">利用規約</span>に同意する
                        </label>
                        <div class="invalid-feedback">{{ $errors->first('user_policy') }}</div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12 text-center my-2">
                    <button class="btn btn-primary w-50" type="submit">確認</button>
                    <a class="btn btn-secondary" href="{{ route('admin.top') }}" role="button">戻る</a>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- モーダルの設定 -->
<div class="modal fade" id="user_policy_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="user_policy_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content text-start">
            <div class="modal-body">
                @include('layouts.terms_of_use_block')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="userPolicy()">閉じる</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function userPolicy() {
        $('input[name="user_policy"]').prop("disabled", false);
    }
</script>
@endsection