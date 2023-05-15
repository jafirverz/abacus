@extends('layouts.app')

@section('content')
<?php
	$content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }
   
?>
@include('inc.banner')
<div class="pt-40 pb-40">
	<div class="container">
		<h2 class="title-2 text-center">{{ $page->title ?? '' }}</h2>
		@if($testimonials->count())
		<div class="slick slick-1 slick-small slick-box slick-dot">
			@foreach($testimonials as $testimonial)
			<div>
				<div class="list-3">
					<figure class="bg-get-image"><img class="bgimg" src="{{ asset($testimonial->picture) }}" alt=""></figure>
					<div class="list-3--content" data-mh="mh-content">
						<div class="descripts" data-mh="mh-text">“{{ $testimonial->content ?? "" }}”</div>
						<div class="row">
							<div class="col-5">
								<span>{{ $testimonial->name ?? "" }}</span>
							</div>
							<div class="col-7 text-right">
								<span>@if($testimonial->created_at){{ $testimonial->created_at->format('d M Y, h.iA') }}@endif</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
</div>
<div class="bg-get-image bg-cover pt-40 pb-40">
	@isset($content['section_1_picutre'])
		<img class="bgimg" src="{{ $content['section_1_picutre'] ?? '' }}" alt="">
	@endisset
	<div class="container" >
		<div class="row">
			<div class="col-xl-5 offset-xl-7 col-md-6 offset-md-6">
				<form action="{{ route('testimonial-submit') }}" name="form-enquiry" id="testimonial-form" method="post"
					enctype="multipart/form-data" class="form-log">
					@csrf
					@include('inc.messages')
					@isset($content['section_1_title'])
					<h3 class="title-2 text-center">{{ $content['section_1_title'] ?? '' }}</h3>
					@endisset
					<div class="form-group">
						<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Your Name *" />
						@if ($errors->has('name'))
						<span class="text-danger">&nbsp;{{ $errors->first('name') }}</span>
						@endif
					</div>
					<div class="form-group">
					<textarea class="form-control" name="content" placeholder="Description *" />{{ old('content') }}</textarea>
					@if ($errors->has('content'))
					<span class="text-danger">&nbsp;{{ $errors->first('content') }}</span>
					@endif
					</div>
					<label class="upload">
						<input type="file" name="picture">
						<span class="name">Upload Your Photo</span>
						<span class="btn-2">Upload</span>
						<small class="text-muted">{{ fileReadText(['png', 'jpg'], '2MB', '380x200') }}</small>
					</label>
					@if ($errors->has('picture'))
					<span class="text-danger">&nbsp;{{ $errors->first('picture') }}</span>
					@endif
					<!-- Google reCAPTCHA widget -->
					<div class="google-recaptcha">
						<div class="g-recaptcha" data-callback="setResponse" data-size="invisible"
							data-sitekey="{{config('system_settings')->recaptcha_site_key}}"></div>
						<input type="hidden" id="captcha-response" name="captcha_response" />
					
					</div>
					<!-- Google reCAPTCHA widget -->
					<button class="btn-2 btn-c btn-full" type="submit">Share</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('footer-scripts')
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback" async defer></script>
<script>
	var onloadCallback = function() {
		grecaptcha.execute();
	};
	
	function setResponse(response) { 
		document.getElementById('captcha-response').value = response; 
	}
	<?php if($errors->count()>0) { ?>
	$('html, body').animate({
	scrollTop: $("#testimonial-form").offset().top
	}, 800);
	<?php } ?>
</script>
@endpush