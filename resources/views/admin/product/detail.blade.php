@extends('layouts.app')
@section('title', '管理画面/製品詳細')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.product.list') }}">製品一覧</a></li>
        <li class="breadcrumb-item active" aria-current="page">製品詳細</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">製品詳細</div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h5>大カテゴリ名</h5>
                <span>{{ $detail->first_category->name }}</span>
            </li>
            <li class="list-group-item">
                <h5>中カテゴリ名</h5>
                <span>{{ $detail->second_category->name }}</span>
            </li>
            <li class="list-group-item">
                <h5>製品名</h5>
                <span>{{ $detail->name }}</span>
            </li>
            <li class="list-group-item">
                <h5>製品画像</h5>
                <img src="{{ asset($detail->image) }}">
            </li>
            <li class="list-group-item">
                <h5>製品詳細</h5>
                <span>{!! nl2br(e($detail->detail)) !!}</span>
            </li>
            <li class="list-group-item">
                <h5>表示設定</h5>
                <span>{{ ProductConsts::RELEASE_FLG_LIST[$detail->release_flg] }}</span>
            </li>
        </ul>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-12 text-center my-2">
                <a class="btn btn-primary w-50" href="{{ route('admin.product.edit', ['id' => $detail->id]) }}" role="button">編集</a>
                <a class="btn btn-secondary" href="{{ route('admin.product.list') }}" role="button">戻る</a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteModal">削除</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.product.delete') }}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{ $detail->id }}">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">製品削除</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>※製品を削除します。よろしいですか？</span>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger w-50">削除する</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">戻る</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection