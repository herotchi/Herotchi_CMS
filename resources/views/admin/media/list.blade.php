@extends('admin.layouts.app')
@section('title', '管理画面/メディア一覧')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">メディア一覧</li>
    </ol>
</nav>
<div class="card">
    <form action="{{ route('admin.media.list') }}" method="GET" novalidate>
        <div class="card-header">メディア一覧</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-12">
                    <label for="alt" class="form-label">代替テキスト</label>
                    <input type="text" id="alt"
                        class="form-control{{ $errors->has('alt') ? ' is-invalid' : '' }}" name="alt"
                        value="{{ old('alt', $input['alt']) }}">
                    <div class="invalid-feedback">{{ $errors->first('alt') }}</div>
                </div>

                <label class="form-label">メディア設定</label>
                <div class="btn-group mt-0">
                    @foreach(MediaConsts::MEDIA_FLG_LIST as $key => $value)
                    <input type="checkbox" class="btn-check" name="media_flg[]" id="media_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('media_flg')==$key || in_array($key, $input['media_flg'])) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('media_flg') ? ' is-invalid' : '' }}"
                        for="media_flg_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('media_flg') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('media_flg') }}</div>
                <div class="mt-0{{ $errors->has('media_flg.*') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('media_flg.*') }}</div>

                <label class="form-label">表示設定</label>
                <div class="btn-group mt-0">
                    @foreach(MediaConsts::RELEASE_FLG_LIST as $key => $value)
                    <input type="checkbox" class="btn-check" name="release_flg[]" id="release_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('release_flg')==$key || in_array($key, $input['release_flg'])) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('release_flg') ? ' is-invalid' : '' }}"
                        for="release_flg_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('release_flg') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('release_flg') }}</div>
                <div class="mt-0{{ $errors->has('release_flg.*') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('release_flg.*') }}</div>

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
        <div class="row">
            @foreach ($lists as $list)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a class="link-underline link-underline-opacity-0" href="{{ route('admin.media.detail', ['id' => $list->id]) }}">
                    <div class="card text-bg-light">
                        <img src="{{ asset($list->image) }}" class="card-img-top w-100 h-auto" alt="{{ $list->alt }}">
                        <div class="card-body">
                            <p class="card-text">メディア設定：{{ MediaConsts::MEDIA_FLG_LIST[$list->media_flg] }}</p>
                            <p class="card-text">表示設定：{{ MediaConsts::RELEASE_FLG_LIST[$list->release_flg] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        {{ $lists->withQueryString() }}
    </div>
</div>
@endsection