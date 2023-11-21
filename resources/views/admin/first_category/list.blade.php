@extends('admin.layouts.app')
@section('title', '管理画面/大カテゴリ一覧')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">大カテゴリ一覧</li>
    </ol>
</nav>
<div class="card">
    <form action="{{ route('admin.first_category.list') }}" method="GET" novalidate>
        <div class="card-header">大カテゴリ一覧</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-12">
                    <label for="name" class="form-label">大カテゴリ名</label>
                    <input type="text" id="name"
                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                        value="{{ old('name', $input['name']) }}" autofocus>
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                </div>

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
                    <th scope="col">大カテゴリ名</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($lists as $list)
                <tr>
                    <td scope="rol">
                        <a href="{{ route('admin.first_category.detail', ['id' => $list->id]) }}">{{ $list->name }}</a>
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