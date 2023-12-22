@extends('admin.layouts.app')
@section('title', '管理画面/お知らせ一覧')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">お知らせ一覧</li>
    </ol>
</nav>
<div class="card">
    <form action="{{ route('admin.news.list') }}" method="GET" novalidate>
        <div class="card-header">お知らせ一覧</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-12">
                    <label for="title" class="form-label">タイトル</label>
                    <input type="text" id="title"
                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                        value="{{ old('title', $input['title']) }}">
                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                </div>

                <label class="form-label">リンク設定</label>
                <div class="btn-group mt-0">
                    @foreach(NewsConsts::LINK_FLG_LIST as $key => $value)
                    <input type="checkbox" class="btn-check" name="link_flg[]" id="link_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('link_flg')==$key || in_array($key, $input['link_flg'])) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('link_flg') ? ' is-invalid' : '' }}"
                        for="link_flg_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('link_flg') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('link_flg') }}</div>
                {{--<div class="mt-0{{ $errors->has('link_flg.*') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('link_flg.*') }}</div>--}}

                <div class="col-md-6">
                    <label for="release_date_from" class="form-label">公開日～</label>
                    <input type="date" id="release_date_from"
                        class="form-control{{ $errors->has('release_date_from') ? ' is-invalid' : '' }}" name="release_date_from"
                        value="{{ old('release_date_from', $input['release_date_from']) }}">
                    <div class="invalid-feedback">{{ $errors->first('release_date_from') }}</div>
                </div>

                <div class="col-md-6">
                    <label for="release_date_to" class="form-label">～公開日</label>
                    <input type="date" id="release_date_to"
                        class="form-control{{ $errors->has('release_date_to') ? ' is-invalid' : '' }}" name="release_date_to"
                        value="{{ old('release_date_to', $input['release_date_to']) }}">
                    <div class="invalid-feedback">{{ $errors->first('release_date_to') }}</div>
                </div>

                <label class="form-label">表示設定</label>
                <div class="btn-group mt-0">
                    @foreach(NewsConsts::RELEASE_FLG_LIST as $key => $value)
                    <input type="checkbox" class="btn-check" name="release_flg[]" id="release_flg_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('release_flg')==$key || in_array($key, $input['release_flg'])) checked @endif>
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
                    <th scope="col">タイトル</th>
                    <th>リンク設定</th>
                    <th>公開日</th>
                    <th>表示設定</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($lists as $list)
                <tr>
                    <td scope="rol">
                        <a href="{{ route('admin.news.detail', ['id' => $list->id]) }}">{{ $list->title }}</a>
                    </td>
                    <td>
                        {{ NewsConsts::LINK_FLG_LIST[$list->link_flg] }}
                    </td>
                    <td>
                        {{ $list->release_date->format('Y/m/d') }}
                    </td>
                    <td>
                        {{ NewsConsts::RELEASE_FLG_LIST[$list->release_flg] }}
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