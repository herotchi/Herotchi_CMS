@extends('layouts.app')
@section('title', '管理画面/製品編集')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.product.list') }}">製品一覧</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.product.detail', ['id' => $detail->id]) }}">製品詳細</a></li>
        <li class="breadcrumb-item active" aria-current="page">製品編集</li>
    </ol>
</nav>

<div class="card">
    <form action="{{ route('admin.product.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $detail->id }}">
        <div class="card-header">製品編集</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-12">
                    <label for="first_category_id" class="form-label">大カテゴリ名
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <select id="first_category_id" class="form-select{{ $errors->has('first_category_id') ? ' is-invalid' : '' }}"
                        name="first_category_id">
                        <option value="">---</option>
                        @foreach($firstCategories as $firstCategory)
                        <option value="{{ $firstCategory->id }}" @if(old('first_category_id', $detail->first_category_id)==$firstCategory->id) selected="selected" @endif>
                            {{ $firstCategory->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">{{ $errors->first('first_category_id') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="second_category_id" class="form-label">中カテゴリ名
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <select id="second_category_id" class="form-select{{ $errors->has('second_category_id') ? ' is-invalid' : '' }}"
                        name="second_category_id">
                        <option value="">---</option>
                    </select>
                    <div class="invalid-feedback">{{ $errors->first('second_category_id') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="name" class="form-label">製品名
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <input type="text" id="name"
                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                        value="{{ old('name', $detail->name) }}" required autofocus>
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="image" class="form-label">製品画像
                        <span class="text-danger font-weight-bold">※</span>
                    </label>
                    <img src="{{ asset($detail->image) }}">
                    <input type="file" id="image"
                        class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image"
                        value="{{ old('image', $detail->image) }}">
                    <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                </div>

                <div class="col-md-12">
                    <label for="detail" class="form-label">概要</label>
                    <textarea id="detail"
                        class="form-control{{ $errors->has('detail') ? ' is-invalid' : '' }}" name="detail"
                        rows="4">{{ old('detail', $detail->detail) }}</textarea>
                    <div class="invalid-feedback">{{ $errors->first('detail') }}</div>
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
<script>
const firstSelect = document.getElementById('first_category_id');
const secondSelect = document.getElementById('second_category_id');

const secondCategories = {{ Js::from($secondCategories) }};
const optionsByFirst = {};

secondCategories.forEach(secondCategory => {
    
    if (!optionsByFirst[secondCategory.first_category_id]) {
        optionsByFirst[secondCategory.first_category_id] = [];
    }

    optionsByFirst[secondCategory.first_category_id].push({value: secondCategory.id, text: secondCategory.name});
});

document.addEventListener('DOMContentLoaded', function() {
    const firstOption = firstSelect.value;
    if (firstOption) {
        const secondOptions = optionsByFirst[firstOption];

        secondSelect.innerHTML = '';

        const newOption = document.createElement('option');
        newOption.value = '';
        newOption.text = '---';
        secondSelect.appendChild(newOption);

        secondOptions.forEach(item => {
            const newOption = document.createElement('option');
            newOption.value = item.value;
            newOption.text = item.text;
            if (@json(old('second_category_id', $detail->second_category_id)) == item.value) {
                newOption.setAttribute('selected', 'selected');
            }
            secondSelect.appendChild(newOption);
        });
    } else {
        secondSelect.innerHTML = '';

        const newOption = document.createElement('option');
        newOption.value = '';
        newOption.text = '---';
        secondSelect.appendChild(newOption);
    }
});

firstSelect.addEventListener('change', function() {
    const firstOption = firstSelect.value;
    if (firstOption) {
        const secondOptions = optionsByFirst[firstOption];

        secondSelect.innerHTML = '';

        const newOption = document.createElement('option');
        newOption.value = '';
        newOption.text = '---';
        secondSelect.appendChild(newOption);

        secondOptions.forEach(item => {
            const newOption = document.createElement('option');
            newOption.value = item.value;
            newOption.text = item.text;
            secondSelect.appendChild(newOption);
        });
    } else {
        secondSelect.innerHTML = '';

        const newOption = document.createElement('option');
        newOption.value = '';
        newOption.text = '---';
        secondSelect.appendChild(newOption);
    }
});
</script>
@endsection