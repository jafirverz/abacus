@if(get_sliders())
<div id="slider" class="banner">
@php 
$slider_images=get_sliders()->slider_images ; 
$slider_images=json_decode($slider_images);
@endphp
@foreach($slider_images as $slider)					
                    <div class="item">
						<div class="bg" style="background-image: url('{{ asset($slider->slider_image) }}');"><img class="bgimg" src="{{ asset($slider->slider_image) }}" alt="" /></div>
						<div class="caption">
							<div class="container">
								<div class="content">
									{!! $slider->caption !!}
								</div>
							</div>
						</div>
					</div>
           
@endforeach					
</div>
@endif