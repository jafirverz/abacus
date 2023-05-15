@extends('layouts.app')

@section('content')
<?php
	$content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }
   
?>


			<div class="main-wrap">				
				<div class="bn-inner bg-get-image">
					@include('inc.banner')
				</div>  
				<div class="container main-inner about-wrap-1">
					<h1 class="title-1 text-center">About Us</h1>
                    @include('inc.breadcrumb')
                    @php
            	    $seocontent = json_decode($page->json_content);
            	    @endphp
            	    <div style="margin-bottom: 20px">
                    {!! $seocontent->section_4 ?? '' !!}
                    </div>
                    @isset($page->content)
					<div class="row align-items-center">
						{!! $page->content !!}
					</div>
                    @endisset 
					<div class="maxw-850 ml-auto mr-auto">
						 @isset($content['section_1'])
                         {!! $content['section_1'] !!}
                         @endisset 
					</div>
					<div class="row align-items-center">
						@isset($content['section_2'])
                         {!! $content['section_2'] !!}
                         @endisset 
					</div>
				</div>
				<div class="about-wrap-2">
					<div class="container">
						@isset($content['section_3'])
                         {!! $content['section_3'] !!}
                         @endisset 
					</div>
				</div>
			</div>
@endsection
@push('footer-scripts')
<script>
	var authUser = '{{ Auth::check() ? "true" : "false" }}';
	if(authUser=="true"){
		$('.auth-check').css('display','none');
	}else{
		$('.auth-check').css('display','');
	}
</script>
@endpush