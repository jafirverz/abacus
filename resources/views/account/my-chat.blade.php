@extends('layouts.app')

@section('header-script')

@endsection
<link href="{{ asset('chat/plugins.css') }}" rel="stylesheet" />
<link href="{{ asset('chat/main.css') }}" rel="stylesheet" />
@section('content')

<div class="main-wrap">
    <div class="bn-inner bg-get-image">
        <img class="bgimg" src="{{ asset('chat/images/tempt/bn-message.jpg') }}" alt="message" />
    </div>
    <div class="container main-inner">
        <div class="row message-wrap">
            <div class="col-lg-4 message-sidebar" >
                <form class="message-search" method="post" action="{{route('search.message')}}">
                    @csrf
                    <input type="text" name="searchMessage" class="form-control" placeholder="Search messages here" />
                    <button type="submit" class="btnsearch"><i class="fas fa-search"></i></button>
                </form>

                <form class="tab-search" method="post" name="filtersearch" action="{{route('search.message')}}">
                    @csrf
                    <input type="hidden" name="tabMessage" id="tabMessage" value="" />
                </form>
                
                <div class="message-inbox" id="chatListAll">
                    <div class="message-inbox-head open">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                                @if(isset($_REQUEST['tab_status']))
                                {{ getTabStatus($_REQUEST['tab_status']) ?? ''}}
                                @else
                                Inbox
                                @endif
                            </a>
                            <div class="dropdown-menu">
                                @if(getTabStatus())
                                @foreach(getTabStatus() as $key => $value)
                                <a onclick="tabFilter({{ $key }})" class="dropdown-item tab-item" data-title="{{ $key }}" href="javascript:void()">{{ $value }}</a>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- <div class="unread"><a href="#">1 unread chat</a></div> -->
                    </div>
                    <div class="message-inbox-content">
                        <div class="vscroll">
                            @if(sizeof($allChat) > 0)
                            @foreach($allChat as $details)
                            @php
                            $loggedUserId = Auth::user()->id;
                            if($loggedUserId == $details->buyer_id){
                                $blockUserId = $details->seller_id;
                            }else{
                                $blockUserId = $details->buyer_id;
                            }
                            $userDetails = \App\User::where('id', $blockUserId)->first();
                            @endphp
                            <div class="msg-list">
                                <div class="group">
                                    <span class="date">{{date('d/m/Y', strtotime($details->allChat->last()->created_at ?? ''))}}</span>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"><i
                                                class="fas fa-ellipsis-h icon"></i></a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript::void(0);" onclick="reportUser('{{$blockUserId}}', '{{$details->id}}')">Report</a>
                                            <a class="dropdown-item" href="javascript::void(0);" onclick="blockUser('{{$blockUserId}}', '{{$details->id}}')">Block user</a>
                                            <a class="dropdown-item" href="javascript::void(0);" onclick="deleteChat('{{$blockUserId}}', '{{$details->id}}')">Delete chat</a>
                                        </div>
                                    </div>
                                </div>
                                <figure class="bg-get-image">
                                    @if(empty($userDetails->profile_picture))
                                    <img class="bgimg" src="{{ asset('chat/images/tempt/img-user-1.jpg') }}" alt="" />
                                    @else 
                                    <img class="bgimg" src="{{ asset($userDetails->profile_picture) }}" alt="" />
                                    @endif
                                </figure>
                                <div class="descript">
                                    @php
                                    $sellerId = '';
                                    $vechileModel = \App\VehicleDetail::where('vehicle_id', $details->vehicle_main_id)->first();
                                    $vehicle_make = $vechileModel->vehicle_make;
                                    $vehicle_model = $vechileModel->vehicle_model;
                                    if(Auth::user()->id == $details->buyer_id){
                                        $sellerId = $details->seller_id;
                                        $sellerDetail = \App\User::where('id', $sellerId)->first();
                                        $name = $sellerDetail->name ?? '';
                                    }elseif(Auth::user()->id == $details->seller_id){
                                        $sellerId = $details->buyer_id;
                                        $buyerDetail = \App\User::where('id', $sellerId)->first();
                                        $name = $buyerDetail->name ?? '';
                                    }
                                    $chatNotification = \App\ChatMessage::where('chat_id', $details->id)->where('sender_id', '!=', Auth::user()->id)->where('new_chat', 1)->count();
                                    @endphp

                                    <h4>{{$name ?? ''}}
                                        @if($chatNotification) <span style="color:red; font-weight: bold;"> ({{$chatNotification}} unread chat) </span> @endif
                                    </h4>
                                    

                                    <h3>{{$vehicle_make ?? ''}} {{$vehicle_model ?? ''}}</h3>
                                    <!-- <p>Here's a different photo, kindly...</p> -->

                                    @if(!empty($details->offer_amount) && $details->accept_reject_offer == 1 && $details->cancel_offer_buyer != 1 && $details->revise_offer_status != 2)
                                        <div class="status-wrap"><strong class="st-accept">ACCEPTED</strong>
                                            @php 
                                            if(!empty($details->offer_amount)){
                                                $offerAmount = number_format($details->offer_amount);
                                            }else{
                                                $offerAmount = '';
                                            }
                                            @endphp
                                            @if(Auth::user()->id == $details->buyer_id)
                                            <span class="type">You offered S${{$offerAmount}} </span>
                                            @else
                                            <span class="type" style="color:red;">Offered  </span> S${{$offerAmount}}
                                            @endif
                                        </div>

                                    @elseif(!empty($details->offer_amount) && ($details->revise_offer_status == 2 || $details->accept_reject_offer == 2))
                                        <div class="status-wrap"><strong class="st-reject">REJECTED</strong>
                                            @php 
                                            if(!empty($details->offer_amount)){
                                                $offerAmount1 = number_format($details->offer_amount);
                                            }else{
                                                $offerAmount1 = '';
                                            }
                                            @endphp
                                            @if(Auth::user()->id == $details->buyer_id)
                                            <span class="type">You offered S${{ $offerAmount1}}</span>
                                            @else
                                            <span class="type" style="color:red;">Offered </span> S${{ $offerAmount1}}
                                            @endif
                                        </div>

                                    @elseif(!empty($details->offer_amount))
                                        <div class="status-wrap">
                                            @php 
                                            if(!empty($details->offer_amount)){
                                                $offerAmount2 = number_format($details->offer_amount);
                                            }else{
                                                $offerAmount2 = '';
                                            }
                                            @endphp
                                            @if(Auth::user()->id == $details->buyer_id)
                                            <span class="type">You offered S${{$offerAmount2}}</span>
                                            @else
                                            <span class="type" style="color:red;">Offered </span> S${{$offerAmount2}}
                                            @endif
                                        </div>

                                    @else
                                        <div class="status-wrap"><span class="type">No offer yet</span></div>
                                    @endif
                                </div>

                                @php
                                $carId = $details->vehicle_main_id;
                                $vehicleDetail = \App\VehicleDetail::where('vehicle_id', $carId)->first();
                                $image = json_decode($vehicleDetail->upload_file, true);
                                if(sizeof($image)> 0){
                                    $imagePath = $image[0];
                                }
                                @endphp
                                <a class="link-fix" href="{{route('chat.details', ['id'=>$details->vehicle_main_id, 'buyerId' => $details->buyer_id])}}">View details</a>
								<a class="icon-car bg-get-image" data-fancybox href="{{ asset($imagePath) }}"  data-toggle="modal" data-target="#myModal{{ $details->vehicle_main_id }}">
									<img class="bgimg" src="{{ asset($imagePath) }}" alt="" />
								</a>
                                <!-- Modal -->
                                <div id="myModal{{ $details->vehicle_main_id }}" class="modal fade pp-car" role="dialog">
                                    <div class="modal-dialog">
                                
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
											<button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
											<div class="mb-20 text-center"><img class="" src="{{ asset($imagePath) }}" alt="" /></div>
                                            <div class="table-responsive alternate-table tb-info">
                                                <table>
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Vehicle Make</strong></td>
                                                                <td><strong>Vehicle Model</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ ucwords($vehicleDetail->vehicle_make) }}</td>
                                                                <td>{{ ucwords($vehicleDetail->vehicle_model) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Original Registration Date</strong></td>
                                                                <td><strong>First Registration Date</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ date('d-m-Y', strtotime($vehicleDetail->orig_reg_date)) }}</td>
                                                                <td>{{ date('d-m-Y', strtotime($vehicleDetail->first_reg_date)) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Year of Manufacture</strong></td>
                                                                <td><strong>Primary Color</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ date('d-m-Y', strtotime($vehicleDetail->year_of_mfg)) }}</td>
                                                                <td>{{ ucwords($vehicleDetail->primary_color) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Open Market Value</strong></td>
                                                                <td><strong>Minimum PARF Benefit</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ '$'.number_format($vehicleDetail->open_market_value) }}</td>
                                                                <td>{{ '$'.number_format($vehicleDetail->min_parf_benefit) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Quota Premium</strong></td>
                                                                <td><strong>COE Expiry Date</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ '$'.number_format($vehicleDetail->quota_premium) }}</td>
                                                                <td>{{ date('d-m-Y', strtotime($vehicleDetail->coe_expiry_date)) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Road Tax Expiry Date</strong></td>
                                                                <td><strong>No. of Transfers</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ date('d-m-Y', strtotime($vehicleDetail->road_tax_expiry_date)) }}</td>
                                                                <td>{{ $vehicleDetail->no_of_transfers }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Vehicle Scheme</strong></td>
                                                                <td><strong>COE Category</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ ucwords($vehicleDetail->vehicle_scheme) }}</td>
                                                                <td>{{ ucwords($vehicleDetail->coe_category) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Vehicle Type</strong></td>
                                                                <td><strong>Propellent</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ ucwords($vehicleDetail->vehicle_type) }}</td>
                                                                <td>{{ ucwords($vehicleDetail->propellant) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Vehicle CO2 Emission Rate</strong></td>
                                                                <td><strong>Max Unladen Weight</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ round($vehicleDetail->co2_emission_rate) }}</td>
                                                                <td>{{ number_format($vehicleDetail->max_unladden_weight).' Kg' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Engine Capacity</strong></td>
                                                                <td><strong>Power Rate</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ number_format($vehicleDetail->engine_cc).' CC' }}</td>
                                                                <td>{{ round($vehicleDetail->power_rate) }}</td>
                                                            </tr>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                
                                    </div>
                                </div>
                                {{-- <a class="link-fix" href="{{route('chat.details', ['id'=>$details->vehicle_main_id, 'buyerId' => $details->buyer_id])}}">View details</a> --}}
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 message-content">
                <div class="message-chat-bx">

                    @if(!empty(Request::segment(2) && Request::segment(3)))
                    <div class="msg-bx">
                        {{--
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"><i
                                    class="fas fa-ellipsis-h icon"></i></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Report</a>
                                <a class="dropdown-item" href="#">Block user</a>
                                <a class="dropdown-item" href="#">Delete chat</a>
                            </div>
                        </div>
                        --}}
                        <figure class="bg-get-image">
                            <img class="bgimg" src="images/tempt/img-user-6.jpg" alt="" />
                        </figure>
                        @php
                        if(empty($chatDetails)){
                            $sellerName1 =  \App\VehicleMain::where('id', $carId)->first();
                            if($sellerName1){
                                $userDetail = \App\User::where('id', $sellerName1->seller_id)->first();
                                $name = $userDetail->name;
                            }else{
                                $name = '';
                            }
                            $userDetail = \App\User::where('id', $sellerName1->seller_id)->first();
                        }else{
                            if(Auth::user()->id == $chatDetails->buyer_id){
                                $sellerId = $chatDetails->seller_id;
                                $sellerDetail = \App\User::where('id', $sellerId)->first();
                                $name = $sellerDetail->name ?? '';
                            }elseif(Auth::user()->id == $chatDetails->seller_id){
                                $sellerId = $chatDetails->buyer_id;
                                $buyerDetail = \App\User::where('id', $sellerId)->first();
                                $name = $buyerDetail->name ?? '';
                            }
                            
                            $userDetail = \App\User::where('id', $sellerId)->first();
                        }

                        @endphp
                        <div class="descript">
                            <h3>{{$name ?? ''}}</h3>
                            <div>Online {{$userDetail->updated_at->diffForHumans() ?? ''}}</div>
                            <div class="verify"><i class="far fa-check-circle"></i> Verified</div>
                        </div>
                    </div>
                    @endif

                    @if($carDetails)
                    @php 
                    $vehicleDetail = \App\VehicleDetail::where('vehicle_id', $carDetails->id)->first();
                    $image = json_decode($vehicleDetail->upload_file, true);
                    if(sizeof($image)> 0){
                        $imagePath = $image[0];
                        $fullPath = asset($imagePath);
                    }else{
                        $fullPath = '';
                    }
                    @endphp
                    <div class="msg-action">
                        <figure class="bg-get-image">
                            <img class="bgimg" src="{{ asset($fullPath) }}" alt="" />
                        </figure>
                        <div class="descript">
                            <div class="row">
                                <div class="col-md-4">
                                    <h3>{{$carDetails->vehicleDetail->first()->vehicle_make ?? ''}} {{$carDetails->vehicleDetail->first()->vehicle_model ?? ''}}</h3>
                                    <div class="type">S${{number_format($carDetails->vehicleDetail->first()->price ?? '')}}</div>
                                </div>
                                @php
                                if($carDetails->seller_id != Auth::user()->id){
                                    $buyerId = Auth::user()->id;
                                }else{
                                    $buyerId = '';
                                }
                                @endphp


                                <div class="col-md-8 last">
                                    <a class="btn-7" href="{{url('chat/details', ['id' => $carDetails->id, 'buyerId' => $buyerId])}}">Make
                                        Offer</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(sizeof($allChat) > 0)

                    <div class="message-chat-list vscroll" id="chatList">

                        @if($chatDetails) 
                        @foreach($chatDetails->allChat as $chat)
                        @php
                        if(Auth::user()->id == $chat->sender_id){
                            $class = 'me';
                        }else{
                            $class = 'customer';
                        }
                        @endphp

                        <div class="{{$class}}">
                            <div class="content">
                                <figure class="bg-get-image">
                                    <img class="bgimg" src="images/tempt/img-user-1.jpg" alt="" />
                                </figure>
                                <div class="descript">
                                    {{$chat->messages}}
                                </div>
                            </div>
                        </div>

                        @endforeach
                    @else
                    <div class="">
                        <div class="content">
                            <figure class="bg-get-image">
                                <img class="bgimg" src="images/tempt/img-user-1.jpg" alt="" />
                            </figure>
                            <div class="descript">
                            </div>
                        </div>
                    </div>
                    @endif


                    </div>
                    @endif

                    @php
                    if(empty($chatDetails->buyer_id)){
                        if(Auth::user()->id != $carDetails->seller_id){
                            $buyerId = Auth::user()->id;
                        }
                    }else{
                        $buyerId = $chatDetails->buyer_id;
                    }
                    @endphp

                    <form method="post" id="chatForm">
                        @csrf
                        <div class="message-chat-input">
                            <input type="hidden" name="carDetail" value="{{$carDetails->id}}">
                            <input type="hidden" name="buyer" value="{{$buyerId}}">
                            <input type="hidden" name="seller" value="{{$carDetails->id}}">
                            <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                            <textarea class="form-control" id="messend" cols="30" rows="4" name="chatText" placeholder="Type here..."></textarea>
                            <button type="button" class="icon" onclick="submitform();"><i
                                    class="far fa-paper-plane"></i></button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer-js')
<script>
    function tabFilter(val) {
        $("#tabMessage").val(val);
        $(".tab-search").submit();
    }
</script>
<script>
    setInterval("my_function();",15000);

    function my_function(){
        if($('.modal').hasClass('show')) {
        } else {
            $('#chatList').load(location.href + " #chatList>*", "");
            $('#chatListAll').load(location.href + " #chatListAll>*", "");
            $('#tab_filter').load(location.href + " #tab_filter>*", "");
        }
        // $('#chatList').load(location.href + " #chatList>*", "");
        // $('#chatListAll').load(location.href + " #chatListAll>*", "");
        // $('#tab_filter').load(location.href + " #tab_filter>*", "");
    }

    function reportUser(userId, chatId){
        $.ajax({
            type: "POST",
            url: '{{route("report.user")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{userId:userId, chatId:chatId},

            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    $('#sucmsg').html(msg.message);
                    //location.reload();
                    window.location = '/my-chats';
                }
            }
        });
    }

    function blockUser(userId, chatId){
        $.ajax({
            type: "POST",
            url: '{{route("block.user")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{userId:userId, chatId:chatId},

            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    $('#sucmsg').html(msg.message);
                    //location.reload();
                    window.location = '/my-chats';
                }
            }
        });
    }

    function deleteChat(userId, chatId){
        $.ajax({
            type: "POST",
            url: '{{route("delete.chat")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{userId:userId, chatId:chatId},

            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    $('#sucmsg').html(msg.message);
                    location.reload();
                    // window.location = '/my-chats';
                }
            }
        });
    }

    function submitform() {
        $.ajax({
            method: "POST",
            url: '{{route("save.chat")}}',
            data: new FormData($("form#chatForm")[0]),
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    $('#messend').val('');
                    location.reload();
                }
            }
        });
    }

    $("#messend").keypress(function (e) {
        if(e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            submitform();
            // $(this).closest("form").submit();
        }
    });
</script>
@endsection
