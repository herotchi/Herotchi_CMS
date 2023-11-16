@extends('layouts.app')
@section('title', '管理画面/メディア編集')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.media.list') }}">メディア一覧</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.media.detail', ['id' => $detail->id]) }}">メディア詳細</a></li>
        <li class="breadcrumb-item active" aria-current="page">メディア編集</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.media.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $detail->id }}">
        <div class="card-header">メディア編集</div>
        <div class="card-body">
            <div class="row g-3">

                <label class="form-label">メディア設定
                    <span class="text-danger font-weight-bold">※</span>
                </label>
                <div class="btn-group mt-0">
                    @foreach(MediaConsts::MEDIA_FLG_LIST as $key => $value)
                    <input type="radio" class="btn-check" name="media_flg" id="media_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('media_flg', $detail->media_flg)==$key) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('media_flg') ? ' is-invalid' : '' }}"
                        for="media_flg_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('media_flg') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('media_flg') }}</div>

                <div class="col-md-12">
                    <label for="image" class="form-label">メディア画像
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <img src="{{ asset($detail->image) }}">
                    <input type="file" id="image"
                        class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image"
                        value="{{ old('image', $detail->image) }}">
                    <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="alt" class="form-label">代替テキスト
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="alt"
                        class="form-control{{ $errors->has('alt') ? ' is-invalid' : '' }}" name="alt"
                        value="{{ old('alt', $detail->alt) }}" required autofocus>
                    <div class="invalid-feedback">{{ $errors->first('alt') }}</div>
                </div>
                
                <div class="col-md-12">
                    <label for="url" class="form-label">URL</label>
                    <input type="text" id="url"
                        class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url"
                        value="{{ old('url', $detail->url) }}">
                    <div class="invalid-feedback">{{ $errors->first('url') }}</div>
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