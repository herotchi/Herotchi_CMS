@extends('layouts.app')
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
                <span><a href="{{ $detail->url }}" target="_blank" rel="noopener noreferrer">{{ $detail->url }}</a></span>
            </li>
            @else 
            <li class="list-group-item">
                <h5>概要</h5>
                <span>{!! nl2br(e($detail->overview)) !!}</span>
            </li>
            @endif
            <li class="list-group-item">
                <h5>公開日</h5>
                <span>{{ $detail->release_date }}</span>
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
            </div>
        </div>
    </div>
</div>

@endsection