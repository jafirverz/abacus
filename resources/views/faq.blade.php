@extends('layouts.app')

@section('content')
<div class="main-wrap">				
				@include('inc.banner') 
				<div class="container main-inner">
					<h1 class="title-1 text-center">{!! $page->title !!}</h1>
                    @include('inc.breadcrumb')
                    @if($faqs->count())
					<div class="accordion">
						<div class="card">
                           <?php  $i=0;?>
                           @foreach($faqs as $key=> $faq)
                           <?php  $i++;?>
							<div class="card-header">
								<button @if($i!=1) class="collapsed"  @endif type="button" data-toggle="collapse" data-target="#faq-<?=$i?>">{{ $faq->title }}</button>
							</div>
							<div id="faq-<?=$i?>" class="collapse @if($i==1) show @endif">
								<div class="card-body document">
									{!! $faq->content !!}
                               </div>
							</div>
                           @endforeach 
						</div>
					</div>
                    @else
				     <h2> Sorry! FAQ not available</h2>
				    @endif
				</div>
			</div>
@endsection