@extends('layout.master')

{{-- Metadata --}}
@section('title', config('app.name'))
@section('description', '')
@section('canonical', config('app.url'))
@section('class', 'news')
@section('content')
<section class="news-detail">
    <div class="news-detail__header">
        <div class="news-header__bg" style="background-image: url('{{ asset($news->image_url) }}');"></div>
        <div class="news-header__overlay"></div> <!-- overlay nuevo -->
    </div>

    <div class="container">
        <div class="news-detail__content">
            
            <!-- Fecha -->
            <div class="news-detail__date">
                <span class="news-detail__day">{{ \Carbon\Carbon::parse($news->dcreated_at)->format('d') }}</span> 
                <span class="news-detail__month">{{ ucfirst(\Carbon\Carbon::parse($news->dcreated_at)->locale('es')->translatedFormat('F')) }}</span> 
                <span class="news-detail__year">{{ \Carbon\Carbon::parse($news->dcreated_at)->format('Y') }}</span>
            </div>

            <h1 class="news-detail__title">{{ $news->title }}</h1>

            <div class="news-detail__text">
                {!! $news->description !!}
            </div>
            
            <div class="news-gallery">
                <img src="{{ asset($news->image_url) }}" alt="{{ $news->image_url }}">
            </div>

        </div>
    </div>
</section>


@endsection