@extends('admin.layouts.app')
@section('title', '管理画面/中カテゴリCSV登録')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">中カテゴリCSV登録</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.second_category.csv_import') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="card-header">中カテゴリCSV登録</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-12">
                    <label><a href="{{ asset('storage/second_category/format.csv') }}" download="中カテゴリCSV登録フォーマット.csv">フォーマットをダウンロード</a></label>
                </div>

                <label class="form-label">文字コード
                    <span class="text-danger font-weight-bold">※</span>
                </label>
                <div class="btn-group mt-0">
                    @foreach(FirstCategoryConsts::CSV_CODE_LIST as $key => $value)
                    <input type="radio" class="btn-check" name="code" id="code_{{ $key }}"
                        value="{{ $key }}" autocomplete="off" @if(old('code')==$key) checked @endif>
                    <label class="btn btn-outline-success form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
                        for="code_{{ $key }}">{{ $value }}</label>
                    @endforeach
                </div>
                <div class="mt-0{{ $errors->has('code') ? ' is-invalid' : '' }}"></div>
                <div class="invalid-feedback">{{ $errors->first('code') }}</div>

                <div class="col-md-12">
                    <label for="csv_file" class="form-label">CSVファイル
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="file" id="csv_file"
                        class="form-control{{ $errors->has('csv_file') ? ' is-invalid' : '' }}" name="csv_file"
                        value="{{ old('csv_file') }}">
                    @if ($errors->has('csv_file'))
                    @foreach ($errors->all() as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>

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