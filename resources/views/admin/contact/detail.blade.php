@extends('admin.layouts.app')
@section('title', '管理画面/お問い合わせ詳細')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.contact.list') }}">お問い合わせ一覧</a></li>
        <li class="breadcrumb-item active" aria-current="page">お問い合わせ詳細</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.contact.status_update') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $detail->id }}">
        <div class="card-header">お問い合わせ詳細</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h5>お問い合わせ番号</h5>
                    <span>{{ $detail->no }}</span>
                </li>
                <li class="list-group-item">
                    <h5>投稿日</h5>
                    <span>{{ $detail->created_at->format('Y/m/d H:i:s') }}</span>
                </li>
                <li class="list-group-item">
                    <h5>氏名</h5>
                    <span>{{ $detail->name }}</span>
                </li>
                <li class="list-group-item">
                    <h5>メールアドレス</h5>
                    <span>{{ $detail->mail_address }}</span>
                </li>
                <li class="list-group-item">
                    <h5>お問い合わせ内容</h5>
                    <span>{!! nl2br(e($detail->mail_body)) !!}</span>
                </li>
                <li class="list-group-item">
                    <h5>ステータス</h5>
                    <select id="status" class="form-select{{ $errors->has('status') ? ' is-invalid' : '' }}"
                        name="status">
                        <option value="">---</option>
                        @foreach(ContactConsts::STATUS_LIST as $key => $value)
                        <option value="{{ $key }}" @if(old('status', $detail->status)==$key) selected="selected" @endif>
                            {{ $value }}</option>
                        @endforeach
                    </select>
                </li>
            </ul>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12 text-center my-2">
                    <button class="btn btn-primary w-50" type="submit">ステータス更新</button>
                    <a class="btn btn-secondary" href="{{ route('admin.contact.list') }}" role="button">戻る</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection