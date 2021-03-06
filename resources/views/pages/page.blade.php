@extends('layouts.default')

@section('meta_data')
<meta name="title" description="{{ $page->meta_title }}">
<meta name="description" description="{{ $page->meta_description }}">
@endsection

@section('page_title')
{{ $page->title }}&nbsp;|
@endsection

@section('header')

@if($page->slug === 'home')
{{-- TODO: Add gradient --}}
<header class="header header--home">
@else
<header class="header" style="background-color: {{ $page->header_background_color }};">
@endif
  <div class="header__content">
    <h2>{{ $page->header_title }}</h2>
    <p>{{ $page->header_content }}</p>
  </div>
</header>
@endsection

@section('content')
  @if(!$posts)
    {{-- Just page content --}}
    {!! $page->general_content !!}
  @elseif(count($posts) > 0)
  <div class="page">
    <ul class="page__post-content">
      @foreach ($posts as $post)
      <li class="page__post-content__post">
        <div class="page__post-content__post__image-wrapper">
          <a href="/{{ $slug_base }}/{{ $post->slug }}">
            @php
              $src = $post->image;
              $is_https = preg_match('/^https?:\/\//', $src);
            @endphp
            @if($is_https)
            <img src="{{ $post->image }}" alt="{{ $post->title ?? $post->name }}">
            @else
              <img src="{{ Voyager::image($post->thumbnail('small')) }}" alt="{{ $post->title ?? $post->name }}">
            @endif
          </a>
        </div>
        <a href="/{{ $slug_base }}/{{ $post->slug }}">
          <div class="page__post-content__post__content">
            @if( isset($post->categories))
              @foreach( $post->categories as $category )
                <span class="category">{{ $category->name }}</span>
              @endforeach
            @endif
            <h3>{{ $post->title ?? $post->name }}</h3>
            @if( $post->author )
              <em>Written by {{ $post->author->name }}</em>
            @endif
            <div class="page__post-content__post__content__bottom">
              @if($post->tutorials)
              <span class="page__post-content__post__content__bottom__total">{{ count($post->tutorials) }} Tutorials</span>
              @endif
              <span class="page__post-content__post__content__bottom__date">
                @php
                echo date('M d, Y', strtotime($post->published_date))
                @endphp
              </span>
            </div>
          </div>
        </a>
      </li>
      @endforeach
    </ul>
    {{ $posts->links() }}
  </div>
  @else
    <strong>Sorry, there are no available posts</strong>
  @endif
@endsection