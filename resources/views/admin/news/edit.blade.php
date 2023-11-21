@extends('admin.layouts.app')
@section('title', '管理画面/お知らせ編集')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.news.list') }}">お知らせ一覧</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.news.detail', ['id' => $detail->id]) }}">お知らせ詳細</a></li>
        <li class="breadcrumb-item active" aria-current="page">お知らせ編集</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.news.update') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $detail->id }}">
        <div class="card-header">お知らせ編集</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label for="title" class="form-label">タイトル
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="title"
                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                        value="{{ old('title', $detail->title) }}" required autofocus>
                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                </div>

                <label class="form-label">リンク設定
                    <span class="text-danger font-weight-bold">※</span>
                </label>
                <div class="btn-group mt-0">
                    @foreach(NewsConsts::LINK_FLG_LIST as $key => $value)
                    <input type="radio" class="btn-check" name="link_flg" id="link_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('link_flg', $detail->link_flg)==$key) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('link_flg') ? ' is-invalid' : '' }}"
                        for="link_flg_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('link_flg') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('link_flg') }}</div>
                
                <div class="col-md-12">
                    <label for="url" class="form-label">URL</label>
                    <input type="text" id="url"
                        class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url"
                        value="{{ old('url', $detail->url) }}">
                    <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="overview" class="form-label">概要</label>
                    <textarea id="overview"
                        class="form-control{{ $errors->has('overview') ? ' is-invalid' : '' }}" name="overview"
                        rows="4">{{ old('overview', $detail->overview) }}</textarea>
                    <div class="invalid-feedback">{{ $errors->first('overview') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="release_date" class="form-label">公開日
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="date" id="release_date"
                        class="form-control{{ $errors->has('release_date') ? ' is-invalid' : '' }}" name="release_date"
                        value="{{ old('release_date', $detail->release_date->format('Y-m-d')) }}">
                    <div class="invalid-feedback">{{ $errors->first('release_date') }}</div>
                </div>

                <label class="form-label">表示設定
                    <span class="text-danger font-weight-bold">※</span>
                </label>
                <div class="btn-group mt-0">
                    @foreach(NewsConsts::RELEASE_FLG_LIST as $key => $value)
                    <input type="radio" class="btn-check" name="release_flg" id="release_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('release_flg', $detail->release_flg)==$key) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('release_flg') ? ' is-invalid' : '' }}"
                        for="release_flg_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('release_flg') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('release_flg') }}</div>

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