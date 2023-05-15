@extends('layouts.app')

@section('content')
    <div class="main-wrap">
        <div class="bn-inner bg-get-image">
            @include('inc.banner')
        </div>
        <div class="container main-inner about-wrap-1">
            <h1 class="title-1 text-center">Marketplace</h1>
            @include('inc.breadcrumb')
            <div class="clearfix"></div>
            <div class="marketplace-holder">
                @include('marketplace.search')
                <div class="clearfix"></div>
                @php $statusArr = ['0'=>'', '1'=>'Processing', '2'=>'Reserved', '3'=>'Sold', '4'=>'Cancelled', '5'=>'Published']; @endphp
                @if(isset($mostViewedVehicles) && $mostViewedVehicles != "")
                <div class="title-wrap-2">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-md-8">
                            <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=1') }}">Most Viewed</a></h2>
                        </div>
                        <div class="col-lg-3 col-md-4 last">
                            <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=1') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row grid-2 break-375">
                @php $i = 0; @endphp
                @foreach($mostViewedVehicles as $key=>$item)
                @php $i++; @endphp
                @php 
                    $files = [];
                    if(isset($item->vehicle->vehicleDetail[0]['upload_file'])){
                        $files = json_decode($item->vehicle->vehicleDetail[0]['upload_file']);
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
                                    <h3>{{ $item->vehicle->vehicleDetail[0]['vehicle_make'].' '.$item->vehicle->vehicleDetail[0]['vehicle_model'] }}</h3>
                                    <p>Registered: {{ $item->vehicle->vehicleDetail[0]['orig_reg_date'] }}</p>
                                    <p>Views: {{ getViewCountByVehicleID($item->vehicle_id) }}</p>
                                    <p>Rank {{ $i }}</p>
                                    <p>Status: {{ $statusArr[$item->vehicle->status] }}</p>
                                </div>
                                <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                            </div>
                            <a href="{{ $item->vehicle_id }}/marketplace-details" class="link-fix">view details</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(isset($mostLikedVehicles))
                <div class="title-wrap-2">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=2') }}">Most Liked</a></h2>
                    </div>
                    <div class="col-lg-3 col-md-4 last">
                        <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=2') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                </div>
                <div class="row grid-2 break-375">
                @php 
                    $i = 0; 
                    $viewCountsArr = $mostLikedVehicles->map(function ($mostLikedVehicle) {
                        return getViewCountByVehicleID($mostLikedVehicle->vehicle_id);
                    });
                    $viewCountsArr = json_decode(json_encode($viewCountsArr), true);
                    rsort($viewCountsArr);
                @endphp
                @foreach($mostLikedVehicles as $key=>$item)
                @php $i++; @endphp
                @php 
                    $viewCount = getViewCountByVehicleID($item->vehicle_id);
                    $rank = array_search($viewCount, $viewCountsArr);
                    $files = [];
                    if(isset($item->vehicle->vehicleDetail[0]['upload_file'])){
                        $files = json_decode($item->vehicle->vehicleDetail[0]['upload_file']);
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
                                    <h3>{{ $item->vehicle->vehicleDetail[0]['vehicle_make'].' '.$item->vehicle->vehicleDetail[0]['vehicle_model'] }}</h3>
                                    <p>Registered: {{ $item->vehicle->vehicleDetail[0]['orig_reg_date'] }}</p>
                                    <p>Views: {{ $viewCount }}</p>
                                    <p>Rank {{ $rank + 1 }}</p>
                                    <p>Status: {{ $statusArr[$item->vehicle->status] }}</p>
                                </div>
                                <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                            </div>
                            <a href="{{ $item->vehicle_id }}/marketplace-details" class="link-fix">view details</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(isset($lowestPriceVehicles))
                <div class="title-wrap-2">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=3') }}">Price</a></h2>
                    </div>
                    <div class="col-lg-3 col-md-4 last">
                        <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=3') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                </div>
                <div class="row grid-2 break-375">
                @php 
                    $i = 0; 
                    $viewCountsArr = $lowestPriceVehicles->map(function ($lowestPriceVehicle) {
                        return getViewCountByVehicleID($lowestPriceVehicle->vehicle_id);
                    });
                    $viewCountsArr = json_decode(json_encode($viewCountsArr), true);
                    rsort($viewCountsArr);
                @endphp
                @foreach($lowestPriceVehicles as $key=>$item)
                @php $i++; @endphp
                @php 
                    $viewCount = getViewCountByVehicleID($item->vehicle_id);
                    $rank = array_search($viewCount, $viewCountsArr);
                    $files = [];
                    if(isset($item->upload_file)){
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
                                    <h3>{{ $item->vehicle_make.' '.$item->vehicle_model }}</h3>
                                    <p>Registered: {{ $item->orig_reg_date }}</p>
                                    <p>Views: {{ $viewCount }}</p>
                                    <p>Rank {{ $rank+1 }}</p>
                                    <p>Status: {{ $statusArr[$item->status] }}</p>
                                </div>
                                <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                            </div>
                            <a href="{{ $item->vehicle_id }}/marketplace-details" class="link-fix">view details</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(isset($depreciationWiseVehicles))
                <div class="title-wrap-2">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=4') }}">Depreciation</a></h2>
                    </div>
                    <div class="col-lg-3 col-md-4 last">
                        <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=4') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                </div>
                <div class="row grid-2 break-375">
                @php $i = 0; @endphp
                @foreach($depreciationWiseVehicles as $key=>$item)
                    @php 
                        $i = 0; 
                        $viewCountsArr = $depreciationWiseVehicles->map(function ($depreciationWiseVehicle) {
                            return getViewCountByVehicleID($depreciationWiseVehicle->vehicle_id);
                        });
                        $viewCountsArr = json_decode(json_encode($viewCountsArr), true);
                        rsort($viewCountsArr);
                    @endphp
                    @php 
                        $viewCount = getViewCountByVehicleID($item->vehicle_id);
                        $rank = array_search($viewCount, $viewCountsArr);
                        $files = [];
                        if(isset($item->upload_file)){
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
                                    <h3>{{ $item->vehicle_make.' '.$item->vehicle_model }}</h3>
                                    <p>Registered: {{ $item->orig_reg_date }}</p>
                                    <p>Views: {{ $viewCount }}</p>
                                    <p>Rank {{ $rank+1 }}</p>
                                    <p>Status: {{ $statusArr[$item->status] }}</p>
                                </div>
                                <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                            </div>
                            <a href="{{ $item->vehicle_id }}/marketplace-details" class="link-fix">view details</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(isset($ageWiseVehicles))
                <div class="title-wrap-2">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=5') }}">Age</a></h2>
                    </div>
                    <div class="col-lg-3 col-md-4 last">
                        <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=5') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                </div>
                <div class="row grid-2 break-375">
                @php 
                    $i = 0; 
                    $viewCountsArr = $ageWiseVehicles->map(function ($ageWiseVehicle) {
                        return getViewCountByVehicleID($ageWiseVehicle->vehicle_id);
                    });
                    $viewCountsArr = json_decode(json_encode($viewCountsArr), true);
                    rsort($viewCountsArr);
                @endphp
                @foreach($ageWiseVehicles as $key=>$item)
                    @php $i++; @endphp
                    @php 
                        $viewCount = getViewCountByVehicleID($item->vehicle_id);
                        $rank = array_search($viewCount, $viewCountsArr);
                        $files = [];
                        if(isset($item->upload_file)){
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
                                    <h3>{{ $item->vehicle_make.' '.$item->vehicle_model }}</h3>
                                    <p>Registered: {{ $item->orig_reg_date }}</p>
                                    <p>Views: {{ $viewCount }}</p>
                                    <p>Rank {{ $rank+1 }}</p>
                                    <p>Status: {{ $statusArr[$item->status] }}</p>
                                </div>
                                <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                            </div>
                            <a href="{{ $item->vehicle_id }}/marketplace-details" class="link-fix">view details</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(isset($latestVehicles))
                <div class="title-wrap-2">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=6') }}">New Listing</a></h2>
                    </div>
                    <div class="col-lg-3 col-md-4 last">
                        <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=&listing_status=6') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                </div>
                <div class="row grid-2 break-375">
                    @php $i = 0; @endphp
                    @foreach($latestVehicles as $key=>$item)
                        @php 
                            $i = 0; 
                            $viewCountsArr = $latestVehicles->map(function ($latestVehicle) {
                                return getViewCountByVehicleID($latestVehicle->detail['vehicle_id']);
                            });
                            $viewCountsArr = json_decode(json_encode($viewCountsArr), true);
                            rsort($viewCountsArr);
                        @endphp
                        @php
                            $viewCount = getViewCountByVehicleID($item->detail['vehicle_id']);
                            $rank = array_search($viewCount, $viewCountsArr);
                            $files = [];
                            if(isset($item->detail['upload_file'])){
                                $files = json_decode($item->detail['upload_file']);
                            }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-6 sp-col">
                            <div class="inner imgeffect">
                                <div class="met-compare">
                                <a href="#"><img src="{{ asset('images/material-compare.png') }}" class="icon-normal" alt="" /><img src="{{ asset('images/material-compare-hover.png') }}" class="icon-hover" alt="" /></a>
                                </div>
                                @if(count($files))
                                    <figure class="imgwrap"><img src="{{ asset($files[0]) }}" alt="" /></figure>
                                @else
                                    <figure class="imgwrap"><img src="{{ asset('/images/tempt/bg-dg.jpg') }}" alt="" /></figure>
                                @endif
                                <div class="descripts">
                                    <div class="content">
                                        <h3>{{ $item->detail['vehicle_make'].' '.$item->detail['vehicle_model'] }}</h3>
                                        <p>Registered: {{ $item->detail['orig_reg_date'] }}</p>
                                        <p>Views: {{ $viewCount }}</p>
                                        <p>Rank {{ $rank+1 }}</p>
                                        <p>Status: {{ $statusArr[$item->status] }}</p>
                                    </div>
                                    <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                                </div>
                                <a href="{{ $item->detail['vehicle_id'] }}/marketplace-details" class="link-fix">view details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                @if(isset($soldVehicles))
                <div class="title-wrap-2">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=3&listing_status=7') }}">Vehicle Sold</a></h2>
                    </div>
                    <div class="col-lg-3 col-md-4 last">
                        <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=3&listing_status=7') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                </div>
                <div class="row grid-2 break-375">
                    @php 
                        $i = 0; 
                        $viewCountsArr = $soldVehicles->map(function ($soldVehicle) {
                            return getViewCountByVehicleID($soldVehicle->vehicle_id);
                        });
                        $viewCountsArr = json_decode(json_encode($viewCountsArr), true);
                        rsort($viewCountsArr);
                    @endphp
                    @foreach($soldVehicles as $key=>$item)
                        @php $i++; @endphp
                        @php 
                            $viewCount = getViewCountByVehicleID($item->vehicle_id);
                            $rank = array_search($viewCount, $viewCountsArr);
                            $files = [];
                            if(isset($item->detail['upload_file'])){
                                $files = json_decode($item->detail['upload_file']);
                            }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-6 sp-col">
                            <div class="inner imgeffect">
                                <div class="met-compare">
                                <a href="#"><img src="{{ asset('images/material-compare.png') }}" class="icon-normal" alt="" /><img src="{{ asset('images/material-compare-hover.png') }}" class="icon-hover" alt="" /></a>
                                </div>
                                @if(count($files))
                                    <figure class="imgwrap"><img src="{{ asset($files[0]) }}" alt="" /></figure>
                                @else
                                    <figure class="imgwrap"><img src="{{ asset('/images/tempt/bg-dg.jpg') }}" alt="" /></figure>
                                @endif
                                <div class="descripts">
                                    <div class="content">
                                        <h3>{{ $item->detail['vehicle_make'].' '.$item->detail['vehicle_model'] }}</h3>
                                        <p>Registered: {{ $item->detail['orig_reg_date'] }}</p>
                                        <p>Views: {{ $viewCount }}</p>
                                        <p>Rank {{ $rank+1 }}</p>
                                        <p>Status: {{ $statusArr[$item->status] }}</p>
                                    </div>
                                    <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                                </div>
                                <a href="{{ $item->detail['vehicle_id'] }}/marketplace-details" class="link-fix">view details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                @if(isset($auctionVehicles))
                <div class="title-wrap-2">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <h2 class="title-2"><a href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=2&listing_status=8') }}">Auction Vehicles</a></h2>
                    </div>
                    <div class="col-lg-3 col-md-4 last">
                        <a class="btn-link" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type=&status=2&listing_status=8') }}">View All &nbsp; <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                </div>
                <div class="row grid-2 break-375">
                    @php 
                        $i = 0; 
                        $viewCountsArr = $auctionVehicles->map(function ($auctionVehicle) {
                            return getViewCountByVehicleID($auctionVehicle->vehicle_id);
                        });
                        $viewCountsArr = json_decode(json_encode($viewCountsArr), true);
                        rsort($viewCountsArr);
                    @endphp
                    @foreach($auctionVehicles as $key=>$item)
                        @php $i++; @endphp
                        @php 
                            $viewCount = getViewCountByVehicleID($item->vehicle_id);
                            $rank = array_search($viewCount, $viewCountsArr);
                            $files = [];
                            if(isset($item->detail['upload_file'])){
                                $files = json_decode($item->detail['upload_file']);
                            }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-6 sp-col">
                            <div class="inner imgeffect">
                                <div class="met-compare">
                                <a href="#"><img src="{{ asset('images/material-compare.png') }}" class="icon-normal" alt="" /><img src="{{ asset('images/material-compare-hover.png') }}" class="icon-hover" alt="" /></a>
                                </div>
                                @if(count($files))
                                    <figure class="imgwrap"><img src="{{ asset($files[0]) }}" alt="" /></figure>
                                @else
                                    <figure class="imgwrap"><img src="{{ asset('/images/tempt/bg-dg.jpg') }}" alt="" /></figure>
                                @endif
                                <div class="descripts">
                                    <div class="content">
                                        <h3>{{ $item->detail['vehicle_make'].' '.$item->detail['vehicle_model'] }}</h3>
                                        <p>Registered: {{ $item->detail['orig_reg_date'] }}</p>
                                        <p>Views: {{ $viewCount }}</p>
                                        <p>Rank {{ $rank+1 }}</p>
                                        <p>Status: {{ $statusArr[$item->status] }}</p>
                                    </div>
                                    <div class="view">view car <i class="fas fa-arrow-right"></i></div>
                                </div>
                                <a href="{{ $item->detail['vehicle_id'] }}/marketplace-details" class="link-fix">view details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                @if(isset($vehicleTypes))
                <div class="vehicle-types">
                    <div class="title-wrap-2">
                        <div class="row align-items-center">
                        <div class="col-lg-9 col-md-8">
                            <h2 class="title-2">Vehicle Types</h2>
                        </div>
                    </div>
                    </div>
                    <div class="row grid-2 break-375">
                        @foreach($vehicleTypes as $key=>$item)
                        <div class="col-lg-4 col-md-4 col-6 sp-col">
                            <div class="inner imgeffect">
                                <div class="descripts">
                                    <div class="content">
                                        <h3>{{ $item->title }}</h3>
                                        <p>{{ $item->content }}</p>
                                    </div>
                                    <div class="view">view all <i class="fas fa-arrow-right"></i></div>
                                </div>
                                @php $search_term = rawurlencode($item->title); @endphp
                                <a class="link-fix" href="{{ url('marketplace-search-results?make=&model=&price=&depreciation_price=&orig_reg_date=&engine_cc=&mileage=&vehicle_type='.$search_term.'&status=&listing_status=') }}">view details</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        
    </div>
@endsection

@push('footer-scripts')
<script>
    $(document).ready(function() {
        $('.title-2 a').css('color', '#333');
    });
</script>
@endpush