@extends('layouts.app')

@section('content')
    <div class="main-wrap">
        <div class="bn-inner bg-get-image">
            @include('inc.banner')
        </div>
        <div class="container main-inner about-wrap-1">
            <h1 class="title-1 text-center">Marketplace Details</h1>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/car/marketplace')}}">Marketplace</a></li>
                <li class="breadcrumb-item active">{{ $vehicle->detail['vehicle_make'].' '.$vehicle->detail['vehicle_model'] }}</li>
            </ul>
            <div class="clearfix"></div>
            <div class="marketplace-holder marketplace-detail">
                @include('marketplace.search')
                <div class="clearfix"></div>
            </div>

            <div class="row detail-wrap">
                <div class="col-lg-6 order-lg-1 detail-image">
                    @php
                        $files = [];
                        if(isset($vehicle->detail['upload_file'])){
                            $files = json_decode($vehicle->detail['upload_file']);
                        }
                    @endphp
                    <div class="slider-for">
                        @if(count($files))
                            @foreach($files as $key=>$filepath)
                            <div class="item">
                                <a class="fancybox" data-fancybox="images" href="{{ asset($filepath) }}">
                                    <img src="{{ asset($filepath) }}" alt="" />
                                </a>
                            </div>
                            @endforeach
                        @else
                            <div class="item">
                                <a class="fancybox" data-fancybox="images" href="{{ asset('images/tempt/bg-dg.jpg') }}">
                                    <img src="{{ asset('images/tempt/bg-dg.jpg') }}" alt="" />
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="slider-nav">
                        @if(count($files))
                            @foreach($files as $key=>$filepath)
                            <div class="item">
                                <div class="inner bg-get-image">
                                    <img class="bgimg" src="{{ asset($filepath) }}" alt="" />
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="item">
                                <div class="inner bg-get-image">
                                    <img class="bgimg" src="{{ asset('images/tempt/bg-dg.jpg') }}" alt="" />
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="col-lg-6 order-lg-12 detail-descripts">

                        <div class="title-5">
                        <h1>{{ $vehicle->detail['vehicle_make'].' '.$vehicle->detail['vehicle_model'] }}</h1>
                        </div>

                    <div class="row sp-col-10">
                        <div class="col-md-8 sp-col">
                            <div class="table-responsive alternate-table tb-info">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><strong>Price</strong></td>
                                            <td><strong>${{ number_format($vehicle->detail['price']) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Depreciation</strong></td>
                                            <td>@if($vehicle->detail['depreciation_price']) {{ '$'.$vehicle->detail['depreciation_price'].'k/year' }} @endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mileage</strong></td>
                                            <td>{{ number_format($vehicle->detail['mileage']) }} km</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Road Tax</strong></td>
                                            @php $road_tax_formula = calculateRoadTax(strtolower($vehicle->detail['propellant']), $vehicle->detail['engine_cc'], $vehicle->detail['orig_reg_date'], $vehicle->detail['price']); @endphp
                                            <td>{{ '$'.$road_tax_formula.'/year' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Remaining COE</strong></td>
                                            @php $remainingCoe = calculateRemainingCoe($vehicle->detail['coe_expiry_date']); @endphp
                                            <td>{{ $remainingCoe }} Left</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Monthly Installment From</strong></td>
                                            @php $monthlyInstallment = calculateMonthlyInstallment($vehicle->detail['price'], 0.0188, 84); @endphp
                                            <td>{{ '$'.$monthlyInstallment }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 sp-col">
                            @php
                                if(isset($loggedUserID)){
                                    $is_liked = is_vehicle_liked($loggedUserID, $vehicle->detail['vehicle_id']);
                                    //$is_reported = is_vehicle_reported($loggedUserID, $vehicle->detail['vehicle_id']);
                                }else{
                                    $is_liked = '';
                                    //$is_reported = '';
                                }
                                if(Auth::user()){
                                    $chatDetails = \App\Chat::where('vehicle_main_id', $vehicle->detail['vehicle_id'])->where('buyer_id', Auth::user()->id)->first();
                                    if($chatDetails){
                                        $urlchat = '/chat/details/'.$vehicle->detail['vehicle_id'].'/'. Auth::user()->id;
                                    }else{
                                        $urlchat = '/my-chats/'.$vehicle->detail['vehicle_id'].'/'. Auth::user()->id;
                                    }

                                }else{
                                    $urlchat = '/login';
                                }
                                $checkLoggedSeller = \App\VehicleMain::where('seller_id', $loggedUserID)->where('id', $vehicle->detail['vehicle_id'])->first();
                            @endphp
                            @if($checkLoggedSeller)
                            <div id="offerpp1" class="modal pp-offer" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                        <p id="sucmsg"></p>

                                            <div class="pp-offer-content">
                                                <h3>You are the seller for this car.</h3>
                                                <!-- <form method="post" id="gotochat" action="{{url($urlchat)}}">
                                                    @csrf
                                                </form> -->

                                            </div>
                                            <div class="ppoutput text-center">
                                                <a class="btn-8 ml-10" href="#" data-dismiss="modal">Cancel</a>
                                            </div>

                                    </div>
                                </div>
                            </div>
                            @else 
                            <div id="offerpp1" class="modal pp-offer" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                        <p id="sucmsg"></p>

                                            <div class="pp-offer-content">
                                                <h3>Would you like to go to the chat platform with seller?</h3>
                                                <!-- <form method="post" id="gotochat" action="{{url($urlchat)}}">
                                                    @csrf
                                                </form> -->

                                            </div>
                                            <div class="ppoutput text-center">
                                                <button type="button" class="btn-8 ml-10" onclick="redirectToChat('{{url($urlchat)}}')">Yes</button>
                                                <!-- <a class="btn-8 ml-10" href="{{url($urlchat)}}" data-dismiss="modal">Yes</a> -->
                                                <a class="btn-8 ml-10" href="#" data-dismiss="modal">Cancel</a>
                                            </div>

                                    </div>
                                </div>
                            </div>
                            @endif
                            <ul id="nav" class="nav-1 hide-991">
                                <!-- <li><a href="#"><i class="fas fa-plus-circle"></i> Compare</a></li> -->
                                @if(isset($is_liked) && $is_liked==1) <li class="active"><a href="{{url('/marketplace-details/like/'.$vehicle->detail['vehicle_id'])}}"><i class="fas fa-heart"></i>Unlike</a></li>
                                @else <li><a href="{{url('/marketplace-details/like/'.$vehicle->detail['vehicle_id'])}}"><i class="fas fa-heart"></i>Like</a></li> @endif
                                <li href="#offerpp1" data-toggle="modal"><a href="javascript::void(0);"><i class="fas fa-comment-alt-lines"></i> Chat</a></li>
                                <li><a href="{{url('/loan')}}"><i class="far fa-clipboard-list-check"></i> Apply Loan</a></li>
                                <li><a href="{{url('/insurance')}}"><i class="fas fa-shield-alt"></i> Get Insurance Quote</a></li>
                                {{-- @if(isset($is_reported) && $is_reported==1) <li class="active"><a href="{{url('/marketplace-details/report/'.$vehicle->detail['vehicle_id'])}}"><strong><i class="fas fa-exclamation-circle"></i> Reported</strong></a></li>
                                @else <li><a href="{{url('/marketplace-details/report/'.$vehicle->detail['vehicle_id'])}}"><strong><i class="fas fa-exclamation-circle"></i> Report</strong></a></li> @endif --}}
                                <!-- <li><a href="#"><i class="fas fa-files-medical"></i> Add to Compare List</a></li> -->
                                <!-- <li><a href="#"><i class="fas fa-share-alt"></i> Share</a></li> -->
                                <li><a href="javascript:void(0)"  class="printMe"><i class="fas fa-print"></i> Download & Print</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="print-me"></div>
                </div>
            </div>


        <div class="clearfix"></div>
            <div class="row detail-mid-wrap">
                <div class="col-lg-8 order-lg-1 detail-image">
                    <div class="title-4">
                    <h2><strong>Vehicle Details</strong></h2>
                    </div>
                    <div class="table-responsive alternate-table tb-info">
                        <table>
                            <tbody>
                                <tr>
                                    <td><strong>Vehicle Make</strong></td>
                                    <td><strong>COE Category</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ ucwords($vehicle->detail['vehicle_make']) }}</td>
                                    <td>{{ ucwords($vehicle->detail['coe_category']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Year of Manufacture</strong></td>
                                    <td><strong>Propellent</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ $vehicle->detail['year_of_mfg'] }}</td>
                                    <td>{{ ucwords($vehicle->detail['propellant']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>First Registration Date</strong></td>
                                    <td><strong>Max Unladen Weight</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ $vehicle->detail['first_reg_date'] }}</td>
                                    <td>{{ $vehicle->detail['max_unladden_weight'].' Kg' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>COE Expiry Date</strong></td>
                                    <td><strong>Road Tax Expiry Date</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ $vehicle->detail['coe_expiry_date'] }}</td>
                                    <td>{{ $vehicle->detail['road_tax_expiry_date'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vehicle Type</strong></td>
                                    <td><strong>Primary Color</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ ucwords($vehicle->detail['vehicle_type']) }}</td>
                                    <td>{{ ucwords($vehicle->detail['primary_color']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vehicle CO2 Emission Rate</strong></td>
                                    <td><strong>Original Registration Date</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ $vehicle->detail['co2_emission_rate'] }}</td>
                                    <td>{{ $vehicle->detail['orig_reg_date'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Engine Capacity</strong></td>
                                    <td><strong>Minimum PARF Benefit</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ $vehicle->detail['engine_cc'].' CC' }}</td>
                                    <td>{{ '$'.number_format($vehicle->detail['min_parf_benefit']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vehicle Model</strong></td>
                                    <td><strong>Quota Premium</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ ucwords($vehicle->detail['vehicle_model']) }}</td>
                                    <td>{{ '$'.number_format($vehicle->detail['quota_premium']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Open Market Value</strong></td>
                                    <td><strong>Power Rate</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ '$'.number_format($vehicle->detail['open_market_value']) }}</td>
                                    <td>{{ $vehicle->detail['power_rate'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>No. of Transfers</strong></td>
                                    <td><strong>Vehicle Scheme</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ $vehicle->detail['no_of_transfers'] }}</td>
                                    <td>{{ ucwords($vehicle->detail['vehicle_scheme']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-12 detail-descripts">
                    <h2><strong>Specifications</strong></h2>
                    @if(get_specifications())
                    <ul class="tag-list">
                        @foreach (get_specifications() as $key=>$item)
                        <li><a href="#">{{ $item->specification }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                    <h2><strong>Additional Accessories</strong></h2>
                    @if(get_attributes())
                    <ul class="tag-list">
                        @foreach (get_attributes() as $key=>$item)
                        <li><a href="#">{{ $item->attribute_title }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                    <h2><strong>Seller's Comment</strong></h2>
                    <textarea class="seller-comment">{{ $vehicle->seller_comment }}</textarea>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="title-4 mt-30">
                    <h2><strong>Financial</strong></h2>
                    </div>
            <div class="row detail-mid-wrap">
                <div class="col-lg-6 order-lg-1 detail-image">

                    <div class="table-responsive alternate-table tb-info">
                        <table>
                            <tbody>
                                <tr>
                                    <td><strong>Purchase Price</strong></td>
                                </tr>
                                <tr>
                                    <td>${{ number_format($vehicle->detail['price']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Minimum Down Payment</strong></td>
                                </tr>
                                <tr>
                                    @php 
                                    $ovm = $vehicle->detail['open_market_value'];
                                    if($ovm <= 20000){
                                        $downPayment = $vehicle->detail['price'] * 0.3;
                                    }else{
                                        $downPayment = $vehicle->detail['price'] * 0.4;
                                    }
                                    @endphp
                                    <td>{{ $downPayment }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Maximum Loan Amount</strong></td>
                                </tr>
                                <tr>
                                    @php 
                                    $ovm = $vehicle->detail['open_market_value'];
                                    if($ovm <= 20000){
                                        $loanAmount = $vehicle->detail['price'] * 0.7;
                                    }else{
                                        $loanAmount = $vehicle->detail['price'] * 0.6;
                                    }
                                    @endphp
                                    <td>${{ $loanAmount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="col-lg-6 order-lg-12 detail-descripts">
                    <div class="table-responsive alternate-table tb-info">
                        <table>
                            <tbody>
                                <tr>
                                    <td><strong>Lowest Interest Rate</strong></td>
                                </tr>
                                <tr>
                                    <td>OCBC - 1.88%</td>
                                </tr>
                                <tr>
                                    <td><strong>Maximum Loan Tenor (Months)</strong></td>
                                </tr>
                                <tr>
                                    <td>84</td>
                                </tr>
                                <tr>
                                    <td><strong>Monthly Installment</strong></td>
                                </tr>
                                <tr>
                                    <td>${{ number_format($monthlyInstallment) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>

            <ul class="tag-list tag-icon-list">
                <li><a href="#offerpp1" data-toggle="modal" ><strong><i class="fas fa-comment-alt-lines"></i> Chat</strong></a></li>
                <li><a href="{{url('/loan')}}"><strong><i class="fas fa-clone"></i> Apply Loan</strong></a></li>
                <li><a href="{{url('/insurance')}}"><strong><i class="fas fa-shield-alt"></i> Get Insurance Quote</strong></a></li>
                {{-- @if(isset($is_reported) && $is_reported==1) <li class="active"><a href="{{url('/marketplace-details/report/'.$vehicle->detail['vehicle_id'])}}"><strong><i class="fas fa-exclamation-circle"></i> Reported</strong></a></li>
                @else <li><a href="{{url('/marketplace-details/report/'.$vehicle->detail['vehicle_id'])}}"><strong><i class="fas fa-exclamation-circle"></i> Report</strong></a></li> @endif --}}
            </ul>
        </div>
    </div>

@endsection

@push('footer-scripts')
<script>
    $(function () {
        $(document).on('click', 'a.printMe', function(){ //alert('hi');
            //$(".main-inner").print();
            //Copy the element you want to print to the print-me div.
            $(".main-inner").clone().appendTo("#print-me");
            //Apply some styles to hide everything else while printing.
            $("body").addClass("printing");
            //Print the window.
            window.print();
            //Restore the styles.
            $("body").removeClass("printing");
            //Clear up the div.
            $("#print-me").empty();
        });
    });
    function redirectToChat(url){
        window.location.href =  url;
    }
</script>
@endpush
