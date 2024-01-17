@extends('admin.layouts.app')
@section('title', '管理画面/お知らせ詳細')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.news.list') }}">お知らせ一覧</a></li>
        <li class="breadcrumb-item active" aria-current="page">お知らせ詳細</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">お知らせ詳細</div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h5>タイトル</h5>
                <span>{{ $detail->title }}</span>
            </li>
            <li class="list-group-item">
                <h5>リンク設定</h5>
                <span>{{ NewsConsts::LINK_FLG_LIST[$detail->link_flg] }}</span>
            </li>
            @if ($detail->link_flg == NewsConsts::LINK_FLG_ON)
            <li class="list-group-item">
                <h5>URL</h5>
                <span>{{ $detail->url }}</span>
            </li>
            @else 
            <li class="list-group-item">
                <h5>概要</h5>
                <span>{!! nl2br(e($detail->overview)) !!}</span>
            </li>
            @endif
            <li class="list-group-item">
                <h5>公開日</h5>
                <span>{{ $detail->release_date->format('Y/m/d') }}</span>
            </li>
            <li class="list-group-item">
                <h5>表示設定</h5>
                <span>{{ NewsConsts::RELEASE_FLG_LIST[$detail->release_flg] }}</span>
            </li>
        </ul>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-12 text-center my-2">
                <a class="btn btn-primary w-50" href="{{ route('admin.news.edit', ['id' => $detail->id]) }}" role="button">編集</a>
                <a class="btn btn-secondary" href="{{ route('admin.news.list') }}" role="button">戻る</a>
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
            <form method="POST" action="{{ route('admin.news.delete') }}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{ $detail->id }}">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">お知らせ削除</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>※お知らせを削除します。よろしいですか？</span>
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