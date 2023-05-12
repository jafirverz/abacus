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

        {{-- <div id="detail-fix">
         <div class="container"> --}}
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
                                            <td>${{ number_format($vehicle->detail['price']) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Depreciation</strong></td>
                                            <td>@if($vehicle->detail['depreciation_price']) {{ '$'.number_format($vehicle->detail['depreciation_price']).'/year' }} @endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mileage</strong></td>
                                            <td>{{ number_format($vehicle->detail['mileage']) }} km</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Road Tax</strong></td>
                                            @php $road_tax_formula = calculateRoadTax(strtolower($vehicle->detail['propellant']), $vehicle->detail['engine_cc'], $vehicle->detail['orig_reg_date'], $vehicle->detail['price']); @endphp
                                            <td>{{ '$'.number_format($road_tax_formula).'/year' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Remaining COE</strong></td>
                                            @php $remainingCoe = calculateRemainingCoe($vehicle->detail['coe_expiry_date']); @endphp
                                            <td>{{ $remainingCoe }} Left</td>
                                        </tr>
                                        <tr>
                                            @php
                                            $cur_date1=date('Y-m-d');
                                            $dateDiff = dateDiff(date('Y-m-d', strtotime($vehicle->detail['coe_expiry_date'])), $cur_date1);
                                            $noofmonths = $dateDiff / 30;
                                            if($noofmonths > 84){
                                                $noofmonths = 84;
                                            }else{
                                                $noofmonths = $noofmonths;
                                            }
                                            $omv = $vehicle->detail['open_market_value'] ?? 0;
                                            if($omv > 20000){
                                                $aaa = 0.6;
                                            }else{
                                                $aaa = 0.7;
                                            }
                                            $interestRate = $lowestInt->interest / 100;
                                            @endphp
                                            <td><strong>Monthly Installment From</strong></td>
                                            @php $monthlyInstallment = calculateMonthlyInstallmentNew($vehicle->detail['price'], $interestRate, $noofmonths, $aaa); @endphp
                                            <td>{{ '$'.number_format($monthlyInstallment) }}</td>
                                        </tr>
                                        @php
                                            $cur_date=strtotime(date('Y-m-d'));
                                            $cur_date1=date('Y-m-d');
                                            $orig_reg_date=strtotime($vehicle->detail['orig_reg_date']);
                                            $deregistarionValue = 0;
                                            $dateDiff = dateDiff(date('Y-m-d', strtotime($vehicle->detail['orig_reg_date']. ' + 3652 days')), $cur_date1);
                                            if($dateDiff >= 1 && $dateDiff < 366){
                                                $calPercent = 50;
                                                $coeRebate = 0;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 366 && $dateDiff < 731){
                                                $calPercent = 55;
                                                $coeRebate = 10;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 731 && $dateDiff < 1096){
                                                $calPercent = 60;
                                                $coeRebate = 20;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 1096 && $dateDiff < 1461){
                                                $calPercent = 65;
                                                $coeRebate = 30;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 1461 && $dateDiff < 1826){
                                                $calPercent = 70;
                                                $coeRebate = 40;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 1826 && $dateDiff < 2191){
                                                $calPercent = 75;
                                                $coeRebate = 50;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 2191 && $dateDiff < 2556){
                                                $calPercent = 75;
                                                $coeRebate = 60;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 2556 && $dateDiff < 2921){
                                                $calPercent = 75;
                                                $coeRebate = 70;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 2921 && $dateDiff < 3286){
                                                $calPercent = 75;
                                                $coeRebate = 80;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 3286 && $dateDiff < 3650){
                                                $calPercent = 75;
                                                $coeRebate = 80;
                                                $under10 = 1;
                                            }else{
                                                $under10 = 2;
                                                $calPercent = 0;
                                                $coeRebate = 0;
                                                if($dateDiff <=  5478){
                                                    $cattt = 15;
                                                    $noOfDaysLefe = $dateDiff - 5478;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 1826 * $noOfDaysLefe;
                                                }elseif($dateDiff > 5478 && $dateDiff < 7305){
                                                    $cantt = 20;
                                                    $noOfDaysLefe = $dateDiff - 7304;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 3652 * $noOfDaysLefe;
                                                }elseif($dateDiff > 7305 && $dateDiff < 9131){
                                                    $cantt = 25;
                                                    $noOfDaysLefe = $dateDiff - 8809;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 1826 * $noOfDaysLefe;
                                                }else{
                                                    $cantt = 30;
                                                    $noOfDaysLefe = $dateDiff - 10956;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 3652 * $noOfDaysLefe;
                                                    
                                                }
                                            }
                                            if($under10 == 1){
                                                $actualARFPaid = $vehicle->detail['min_parf_benefit'] * 2;
                                                $prfdd = ($actualARFPaid*$calPercent)/100;

                                                if($coeRebate != 80){
                                                    $quu = $vehicle->detail['quota_premium']/3652;
                                                    $quu1 = $dateDiff * $quu;
                                                }else{
                                                    $quu1 = ($vehicle->detail['quota_premium'] * $coeRebate) / 100;
                                                }

                                                $deregistarionValue = $prfdd + $quu1;
                                                $deregistarionValue = '$'. number_format($deregistarionValue);
                                            }else{
                                                $deregistarionValue = '-';
                                            }
                                            @endphp
                                        <tr>
                                            
                                            <td><strong>Estimated Deregistration Value</strong></td>

                                            <td>{{ $deregistarionValue }}
                                                
                                            </td>
                                        
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="tablevalueinfo">
                                <p>- Value differs if the car is registered under Category E (Open Category) COEs.<br>
                                - Note that the body value of the vehicle is not included in the deregistration value.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 sp-col">
                            @php
                                if(isset($loggedUserID)){
                                    $is_liked = is_vehicle_liked($loggedUserID, $vehicle->detail['vehicle_id']);
                                    $is_reported = is_vehicle_reported($loggedUserID, $vehicle->detail['vehicle_id']);
                                }else{
                                    $is_liked = '';
                                    $is_reported = '';
                                }
                                if(Auth::user()){
                                    $chatDetails = \App\Chat::where('vehicle_main_id', $vehicle->detail['vehicle_id'])->where('buyer_id', Auth::user()->id)->first();
                                    if($chatDetails){
                                        $urlchat = '/chat/details/'.$vehicle->detail['vehicle_id'].'/'. Auth::user()->id;
                                    }else{
                                        $urlchat = '/my-chats/'.$vehicle->detail['vehicle_id'].'/'. Auth::user()->id;
                                    }

                                }else{
                                    session()->put('previous_url',Request::path());
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
                                <li><a href="{{ url('loan?vehicle-id='.$vehicle->detail['vehicle_id']) }}"><i class="far fa-clipboard-list-check"></i> Apply Loan</a></li>
                                <li><a href="{{url('/insurance')}}"><i class="fas fa-shield-alt"></i> Get Insurance Quote</a></li>
                                {{-- @if(isset($is_reported) && $is_reported==1) <li class="active"><a href="{{url('/marketplace-details/report/'.$vehicle->detail['vehicle_id'])}}"><strong><i class="fas fa-exclamation-circle"></i> Reported</strong></a></li>
                                @else <li><a href="{{url('/marketplace-details/report/'.$vehicle->detail['vehicle_id'])}}"><strong><i class="fas fa-exclamation-circle"></i> Report</strong></a></li> @endif --}}
                                <!-- <li><a href="#"><i class="fas fa-files-medical"></i> Add to Compare List</a></li> -->
                                <li>
                                <a href="https://www.instagram.com?url={{url('/car/'.$vehicle->detail['vehicle_id'].'/marketplace-details/')}}" target="_BLANK"><i class="fab fa-instagram"></i>Instagram</a>
                                <a href="https://www.facebook.com/sharer.php?u={{url('/car/'.$vehicle->detail['vehicle_id'].'/marketplace-details/')}}" target="_BLANK"><i class="fab fa-facebook"></i>Facebook</a>
                                <a title="Google+" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&su={{ $vehicle->detail['vehicle_make'].' '.$vehicle->detail['vehicle_model'] }}&body={{url('/car/'.$vehicle->detail['vehicle_id'].'/marketplace-details/')}}" target="_BLANK"><i class="fab fa-google"></i>Gmail</a>
                                </li>
                                <li><a target="_blank" href="{{ url('car/print/'.$vehicle->detail['vehicle_id'].'/marketplace-details') }}"><i class="fas fa-print"></i> Download & Print</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="print-me"></div>
                </div>
            </div>
         {{-- </div>
        </div> --}}

        <div class="clearfix"></div>
            <div class="row detail-mid-wrap">
                <div class="col-lg-12">
                    <div class="title-4">
                    <h2><strong>Vehicle Details</strong></h2>
                    </div>
                    <div class="table-responsive alternate-table tb-info">
                        <table>
                            <tbody>
                                <tr>
                                    <td><strong>Vehicle Make</strong></td>
                                    <td>{{ ucwords($vehicle->detail['vehicle_make']) }}</td>
                                    <td><strong>Vehicle Model</strong></td>
                                    <td>{{ ucwords($vehicle->detail['vehicle_model']) }}</td>

                                </tr>
                                <tr>
                                    <td><strong>Original Registration Date</strong></td>
                                    <td>{{ date('j M Y',strtotime($vehicle->detail['orig_reg_date'])) }}</td>
                                    <td><strong>First Registration Date</strong></td>
                                    <td>{{ date('j M Y',strtotime($vehicle->detail['first_reg_date'])) }}</td>

                                </tr>
                                <tr>
                                    <td><strong>Year of Manufacture</strong></td>
                                    <td>{{ $vehicle->detail['year_of_mfg'] }}</td>
                                    <td><strong>Primary Color</strong></td>
                                    <td>{{ ucwords($vehicle->detail['primary_color']) }}</td>

                                </tr>
                                <tr>
                                    <td><strong>Open Market Value</strong></td>
                                    <td>{{ '$'.number_format($vehicle->detail['open_market_value']) }}</td>
                                    <td><strong>Minimum PARF Benefit</strong></td>
                                    <td>{{ '$'.number_format($vehicle->detail['min_parf_benefit']) }}</td>

                                </tr>
                                <tr>

                                    <td><strong>Quota Premium</strong></td>
                                    <td>{{ '$'.number_format($vehicle->detail['quota_premium']) }}</td>
                                    <td><strong>COE Expiry Date</strong></td>
                                    <td>{{ date('j M Y',strtotime($vehicle->detail['coe_expiry_date'])) }}</td>
                                </tr>
                                <tr>

                                    <td><strong>Road Tax Expiry Date</strong></td>
                                    <td>{{ date('j M Y',strtotime($vehicle->detail['road_tax_expiry_date'])) }}</td>
                                    <td><strong>No. of Transfers</strong></td>
                                    <td>{{ $vehicle->detail['no_of_transfers'] }}</td>
                                </tr>
                                <tr>

                                    <td><strong>Vehicle Scheme</strong></td>
                                    <td>{{ ucwords($vehicle->detail['vehicle_scheme']) }}</td>
                                    <td><strong>COE Category</strong></td>
                                    <td>{{ ucwords($vehicle->detail['coe_category']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vehicle Type</strong></td>
                                    <td>{{ ucwords($vehicle->detail['vehicle_type']) }}</td>
                                    <td><strong>Propellent</strong></td>
                                    <td>{{ ucwords($vehicle->detail['propellant']) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vehicle CO2 Emission Rate</strong></td>
                                    <td>{{ $vehicle->detail['co2_emission_rate'] }} g/km</td>
                                    <td><strong>Max Unladen Weight</strong></td>
                                    <td>{{ number_format($vehicle->detail['max_unladden_weight']).' Kg' }}</td>

                                </tr>
                                <tr>
                                    <td><strong>Engine Capacity</strong></td>
                                    <td>{{ number_format($vehicle->detail['engine_cc']).' CC' }}</td>
                                    <td><strong>Power Rate</strong></td>
                                    <td>{{ $vehicle->detail['power_rate'] }} KW</td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row detail-mid-wrap">
                <div class="col-lg-12">
                    <h2><strong>Features</strong></h2>
                    @if(isset($vehicle->specification) && $vehicle->specification != 'null')
                    @php 
                    $specificationn = json_decode($vehicle->specification);
                    @endphp
                    <ul class="tag-list">
                        @foreach ($specificationn as $item)
                        <li><a href="javascript::void(0);">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                    <h2><strong>Additional Accessories</strong></h2>
                    @if(isset($vehicle->additional_accessories) && $vehicle->additional_accessories != 'null')
                    @php 
                    $addiaccess = json_decode($vehicle->additional_accessories);
                    @endphp
                    <ul class="tag-list">
                        @foreach ($addiaccess as $item)
                        <li><a href="javascript::void(0);">{{ $item }}</a></li>
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
                                    <td>${{ number_format($downPayment) }}</td>
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
                                    <td>${{ number_format($loanAmount) }}</td>
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
                                    <td><a href="{{ url('loan') }}" target="_blank">{{$lowestInt->title}} - {{$lowestInt->interest}}%</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Maximum Loan Tenor (Months)</strong></td>
                                </tr>
                                @php
                                $dateDiff = dateDiff(date('Y-m-d', strtotime($vehicle->detail['coe_expiry_date'])), $cur_date1);
                                $noofmonths = $dateDiff / 30;
                                if($noofmonths > 84){
                                    $noofmonths = 84;
                                }else{
                                    $noofmonths = $noofmonths;
                                }
                                @endphp
                                <tr>
                                    <td>{{ round($noofmonths) }}</td>
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
                <li><a href="{{ url('loan?vehicle-id='.$vehicle->detail['vehicle_id']) }}"><strong><i class="fas fa-clone"></i> Apply Loan</strong></a></li>
                <li><a href="{{url('/insurance')}}"><strong><i class="fas fa-shield-alt"></i> Get Insurance Quote</strong></a></li>
                @if(isset($is_reported) && $is_reported==1)
                <li class="active"><a  data-toggle="modal" data-target="#myModal" href="javascript::void()"><strong><i class="fas fa-exclamation-circle"></i> Reported</strong></a></li>
                @else
                <li><a  data-toggle="modal" data-target="#myModal" href="javascript::void()"><strong><i class="fas fa-exclamation-circle"></i> Report</strong></a></li>
                @endif
            </ul>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <form method="POST" action="{{url('/marketplace-details/report')}}">
            @csrf
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Report Car</h4>
            </div>
            <div class="modal-body">

              <textarea required name="comments" class="form-control">@if(Auth::user() && isset($is_reported) && isset(getReportByCar($vehicle->detail['vehicle_id'])->comments)) {{ getReportByCar($vehicle->detail['vehicle_id'])->comments ?? '' }}  @endif</textarea>
              <input type="hidden" name="car_id" value="{{ $vehicle->detail['vehicle_id'] }}">
              <br>
              <button class="btn-1 minw-190" type="submit">SUBMIT <i class="fas fa-arrow-right"></i></button>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          </form>

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
