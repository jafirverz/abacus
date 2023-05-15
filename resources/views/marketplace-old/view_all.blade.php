@extends('layouts.app')

@section('content')
    <div class="main-wrap">
        <div class="bn-inner bg-get-image">
            @include('inc.banner')
        </div>
        <div class="container main-inner about-wrap-1">
            <h1 class="title-1 text-center">{{ $title }}</h1>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/car/marketplace')}}">Marketplace</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ul>
            <div class="clearfix"></div>
            <div class="marketplace-holder">
                @include('marketplace.search')
                <div class="clearfix"></div>

                @if(isset($all_items))
                <div class="title-wrap-2">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-md-8">
                            <h2 class="title-2">{{ $section_title }}</h2>
                        </div>
                    </div>
                </div>
                @if($section_title != 'Vehicle Types')
                <div class="row grid-2 break-375">
                    @php $i = 0; $statusArr = ['0'=>'', '1'=>'Processing', '2'=>'Reserved', '3'=>'Sold', '4'=>'Cancelled', '5'=>'Published']; @endphp
                    @foreach($all_items as $key=>$item)
                    @php $i++; @endphp
                    @php 
                        $files = [];
                        if(isset($item->detail['upload_file'])){
                            $files = json_decode($item->detail['upload_file']);
                        }elseif(isset($item->upload_file)){
                            $files = json_decode($item->upload_file);
                        }
                    @endphp
                    <div class="col-lg-3 col-md-4 col-6 sp-col">
                        <div class="inner imgeffect">
                            <div class="met-compare">
                            <a href="#"><img src="{{ asset('/images/material-compare.png') }}" class="icon-normal" alt="" />
                            <img src="{{ asset('/images/material-compare-hover.png') }}" class="icon-hover" alt="" /></a>
                            </div>
                            @if(count($files))
                                <figure class="imgwrap"><img src="{{ asset($files[0]) }}" alt="" /></figure>
                            @else
                                <figure class="imgwrap"><img src="{{ asset('/images/tempt/bg-dg.jpg') }}" alt="" /></figure>
                            @endif
                            <div class="descripts">
                                <div class="content">
                                    @if(isset($item->detail))
                                    <h3>{{ $item->detail['vehicle_make'].' '.$item->detail['vehicle_model'] }}</h3>
                                    <p>Registered: {{ $item->detail['orig_reg_date'] }}</p>
                                    <p>Views: {{ getViewCountByVehicleID($item->detail['vehicle_id']) }}</p>
                                    @else
                                    <h3>{{ $item->vehicle_make.' '.$item->vehicle_model }}</h3>
                                    <p>Registered: {{ $item->orig_reg_date }}</p>
                                    <p>Views: {{ getViewCountByVehicleID($item->vehicle_id) }}</p>
                                    @endif
                                    <p>Rank {{ $i }}</p>
                                    <p>Status: {{ $statusArr[$item->status] }}</p>
                                </div>
                                <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                            </div>
                            @if(isset($item->detail))
                            <a href="{{ '/car/'.$item->detail['vehicle_id'] }}/marketplace-details" class="link-fix">view details</a>
                            @else
                            <a href="{{ '/car/'.$item->vehicle_id }}/marketplace-details" class="link-fix">view details</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <div class="row grid-2 break-375">
                        @foreach($all_items as $key=>$item)
                        <div class="col-lg-4 col-md-4 col-6 sp-col">
                            <div class="inner imgeffect">
                                <div class="descripts">
                                    <div class="content">
                                        <h3>{{ $item->title }}</h3>
                                        <p>{{ $item->content }}</p>
                                    </div>
                                    <div class="view">view all <i class="fas fa-arrow-right"></i></div>
                                </div>
                                <a href="/car/marketplace/view-all/vehicle-type" class="link-fix">view details</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
                {{ $all_items->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')

@endpush