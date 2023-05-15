@php $banner= get_banner_by_page($page->id) @endphp
@if($banner)

<div class="bn-inner bg-get-image">
					<img class="bgimg" src="{{ asset($banner->banner_image) }}" alt="{{ $page->title ?? '' }}" />
</div> 
@endif