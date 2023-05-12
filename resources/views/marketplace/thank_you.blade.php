@extends('layouts.app')

@section('content')
<?php
	$content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }
   
?>
@include('inc.banner')
<div class="container thanks-wrap">
	@isset($page->header)
	<h1>{{ $page->header }}</h1>
	@endisset
	@isset($page->content)
	{!! $page->content !!}
	@endisset

</div>

@endsection