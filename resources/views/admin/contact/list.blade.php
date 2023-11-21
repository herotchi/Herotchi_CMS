@extends('admin.layouts.app')
@section('title', '管理画面/お問い合わせ一覧')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">お問い合わせ一覧</li>
    </ol>
</nav>
<div class="card">
    <form action="{{ route('admin.contact.list') }}" method="GET" novalidate>
        <div class="card-header">お問い合わせ一覧</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label for="no" class="form-label">お問い合わせ番号</label>
                    <input type="text" id="no"
                        class="form-control{{ $errors->has('no') ? ' is-invalid' : '' }}" name="no"
                        value="{{ old('no', $input['no']) }}" autofocus>
                    <div class="invalid-feedback">{{ $errors->first('no') }}</div>
                </div>

                <div class="col-md-6">
                    <label for="mail_body" class="form-label">お問い合わせ内容</label>
                    <input type="text" id="mail_body"
                        class="form-control{{ $errors->has('mail_body') ? ' is-invalid' : '' }}" name="mail_body"
                        value="{{ old('mail_body', $input['mail_body']) }}" autofocus>
                    <div class="invalid-feedback">{{ $errors->first('mail_body') }}</div>
                </div>

                <div class="col-md-6">
                    <label for="created_at_from" class="form-label">投稿日～</label>
                    <input type="date" id="created_at_from"
                        class="form-control{{ $errors->has('created_at_from') ? ' is-invalid' : '' }}" name="created_at_from"
                        value="{{ old('created_at_from', $input['created_at_from']) }}">
                    <div class="invalid-feedback">{{ $errors->first('created_at_from') }}</div>
                </div>

                <div class="col-md-6">
                    <label for="created_at_to" class="form-label">～投稿日</label>
                    <input type="date" id="created_at_to"
                        class="form-control{{ $errors->has('created_at_to') ? ' is-invalid' : '' }}" name="created_at_to"
                        value="{{ old('created_at_to', $input['created_at_to']) }}">
                    <div class="invalid-feedback">{{ $errors->first('created_at_to') }}</div>
                </div>

                <label class="form-label">ステータス</label>
                <div class="btn-group mt-0">
                    @foreach(ContactConsts::STATUS_LIST as $key => $value)
                    <input type="checkbox" class="btn-check" name="status[]" id="status_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('status')==$key || in_array($key, $input['status'])) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                        for="status_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('status') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('status') }}</div>

            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12 text-center my-2">
                    <button class="btn btn-primary w-50" type="submit">検索</button>
                    <a class="btn btn-secondary" href="{{ route('admin.top') }}" role="button">戻る</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card mt-4">
    <div class="card-header text-end">
        {{ $lists->links('vendor.pagination.bootstrap-5_number') }}
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">氏名</th>
                    <th>メールアドレス</th>
                    <th>投稿日</th>
                    <th>ステータス</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($lists as $list)
                <tr>
                    <td scope="rol">
                        <a href="{{ route('admin.contact.detail', ['id' => $list->id]) }}">{{ $list->name }}</a>
                    </td>
                    <td>
                        {{ $list->mail_address }}
                    </td>
                    <td>
                        {{ $list->created_at->format('Y/m/d') }}
                    </td>
                    <td>
                    {{ ContactConsts::STATUS_LIST[$list->status] }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $lists->withQueryString() }}
    </div>
</div>
@endsection