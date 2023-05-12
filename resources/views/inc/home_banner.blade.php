@if($sliders->count())
<div class="home-banner slick slick-big text-center">
	@foreach($sliders as $item)
	<div class="bg-get-image flex-center">
		<img class="bgimg" src="{{ asset($item->slider_images) }}" alt="car" />
		<div class="container">
			{!! $item->content ?? '' !!}
			<a href="{{ $item->link ?? '' }}" class="btn-c btn-2">{{ $item->link_label }}</a>
		</div>
	</div>
	@endforeach
</div>
@endif