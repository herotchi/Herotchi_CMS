@extends('layouts.app')
@section('title', 'TOP')

@section('content')
<div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
        @foreach($carousels as $carousel)
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" aria-label="Slide {{ $loop->index }}" @if($loop->first) class="active" aria-current="true" @endif></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($carousels as $carousel)
        <div class="carousel-item @if($loop->first) active @endif">
            <img src="{{ asset($carousel->image) }}" class="d-block w-100" alt="{{ $carousel->alt }}">
        </div>    
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
@endsection