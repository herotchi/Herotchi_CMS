@extends('admin.layouts.app')
@section('title', '管理画面/大カテゴリ編集')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.first_category.list') }}">大カテゴリ一覧</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.first_category.detail', ['id' => $detail->id]) }}">大カテゴリ詳細</a></li>
        <li class="breadcrumb-item active" aria-current="page">大カテゴリ編集</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.first_category.update') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $detail->id }}">
        <div class="card-header">大カテゴリ編集</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label for="name" class="form-label">大カテゴリ名
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="name"
                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                        value="{{ old('name', $detail->name) }}" required>
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12 text-center my-2">
                    <button class="btn btn-primary w-50" type="submit">保存</button>
                    <a class="btn btn-secondary" href="{{ route('admin.first_category.detail', ['id' => $detail->id]) }}" role="button">戻る</a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection