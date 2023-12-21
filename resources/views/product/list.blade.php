@extends('layouts.app')
@section('title', '製品一覧')

@section('content')
<nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('top') }}">TOP</a></li>
        <li class="breadcrumb-item active" aria-current="page">製品一覧</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-3">
        <div class="card mb-3">
            <form action="{{ route('product.list') }}" method="GET" novalidate>
                <div class="card-header">キーワード検索</div>
                <div class="card-body">
                    <input type="text" id="keyword"
                        class="form-control{{ $errors->has('keyword') ? ' is-invalid' : '' }}" name="keyword"
                        value="{{ old('keyword', $input['keyword']) }}">
                    <div class="invalid-feedback">{{ $errors->first('keyword') }}</div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary w-100" type="submit">検索</button>
                </div>
            </form>
        </div>
        <div class="card mb-3">
            <div class="accordion" id="category">
                @foreach($firstCategoryIds as $firstCategoryId)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#first_category_{{ $firstCategoryId }}" aria-expanded="false" aria-controls="first_category_{{ $firstCategoryId }}">
                            {{ $firstCategories[$firstCategoryId]->name }}
                        </button>
                    </h2>
                    <div id="first_category_{{ $firstCategoryId }}" class="accordion-collapse collapse" data-bs-parent="#category">
                        <div class="accordion-body">
                            <div class="list-group">
                                @foreach($secondCategories[$firstCategoryId] as $secondCategory)
                                @if(in_array($secondCategory->id, $secondCategoryIds, true))
                                <a href="{{ route('product.list', ['first_category_id' => $firstCategoryId, 'second_category_id' => $secondCategory->id]) }}" class="list-group-item list-group-item-action">
                                    {{ $secondCategory->name }}
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-body">
                <p class="card-text">
                    検索条件：
                    @if($input['keyword'])
                    {{ $input['keyword'] }}
                    @elseif($input['first_category_id'] && $input['second_category_id'])
                    {{ $firstCategoryName }},
                    {{ $secondCategoryName }}
                    @else
                    なし
                    @endif
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-header text-end">
                {{ $products->links('vendor.pagination.bootstrap-5_number') }}
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-xxl-3 col-lg-4 col-md-6 mb-3">
                        <a class="link-underline link-underline-opacity-0" href="{{ route('product.detail', ['id' => $product->id]) }}">
                            <div class="card">
                                <img src="{{ asset($product->image) }}" class="card-img-top w-100 h-auto">
                                <div class="card-body">
                                    <p class="card-text mb-1 text-secondary fs-6">
                                        <small>
                                            {{ $product->first_category->name }},
                                            {{ $product->second_category->name }}
                                        </small>
                                    </p>
                                    <p class="card-text"><b>{{ $product->name }}</b></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                {{ $products->withQueryString() }}
            </div>
        </div>
    </div>
</div>



@endsection