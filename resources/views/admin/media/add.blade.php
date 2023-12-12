@extends('admin.layouts.app')
@section('title', '管理画面/メディア登録')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">メディア登録</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.media.insert') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="card-header">メディア登録</div>
        <div class="card-body">
            <div class="row g-3">

            <label class="form-label">メディア設定
                    <span class="text-danger font-weight-bold">※</span>
                </label>
                <div class="btn-group mt-0">
                    @foreach(MediaConsts::MEDIA_FLG_LIST as $key => $value)
                    <input type="radio" class="btn-check" name="media_flg" id="media_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('media_flg')==$key) checked @endif required>
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
                    <input type="file" id="image"
                        class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image"
                        value="{{ old('image') }}" required>
                    <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="alt" class="form-label">代替テキスト
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="alt"
                        class="form-control{{ $errors->has('alt') ? ' is-invalid' : '' }}" name="alt"
                        value="{{ old('alt') }}" required>
                    <div class="invalid-feedback">{{ $errors->first('alt') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="url" class="form-label">URL
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="url"
                        class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url"
                        value="{{ old('url') }}" required>
                    <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                </div>

                <label class="form-label">表示設定
                    <span class="text-danger font-weight-bold">※</span>
                </label>
                <div class="btn-group mt-0">
                    @foreach(NewsConsts::RELEASE_FLG_LIST as $key => $value)
                    <input type="radio" class="btn-check" name="release_flg" id="release_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('release_flg')==$key) checked @endif required>
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