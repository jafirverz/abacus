@extends('layouts.app')
@section('content')
<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
        @include('inc.account-sidebar-online')
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="#"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <h1 class="title-3">{{ $page->title }}</h1>
        <figure class="imgwrap-1">
          <img src="{{ asset(get_banner_by_page($page->id)->banner_image ?? '') }}" alt="" />
        </figure>
        <h2 class="title-2">Lesson 1: Lorem ipsum dolor sit amet, consetetur sadipscing elitr</h2>
        {!! $page->content ?? '' !!}
      </div>
    </div>
  </div>
</main>
@endsection