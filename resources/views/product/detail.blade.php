@extends('layouts.app')
@section('title', $detail->name)

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('top') }}">TOP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.list') }}">製品情報一覧</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $detail->name }}</li>
    </ol>
</nav>

<div class="card">
    <img src="{{ asset($detail->image) }}" class="card-img-top">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <p class="text-secondary mb-1">
                    {{ $detail->first_category->name }},{{ $detail->second_category->name }}
                </p>
                <h5>{{ $detail->name }}</h5>
            </li>
            <li class="list-group-item">
                <span>{!! nl2br(e($detail->detail)) !!}</span>
            </li>
        </ul>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-12 text-center my-2">
                <a class="btn btn-secondary w-50" href="{{ route('product.list') }}" role="button">戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection