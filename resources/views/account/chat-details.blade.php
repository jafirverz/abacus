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
                            @if($allChat)
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
                                            <a class="dropdown-item" href="#">Report</a>
                                            <a class="dropdown-item" href="javascript::void(0);" onclick="blockUser('{{$blockUserId}}', '{{$details->id}}')">Block user</a>
                                            <a class="dropdown-item" href="javascript::void(0);" onclick="deleteChat('{{$loggedUserId}}', '{{$details->id}}')">Delete chat</a>
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

                                    <h4>{{$name ?? ''}} @if($chatNotification) <span style="color:red; font-weight: bold;"> ({{$chatNotification}} unread chat) </span>@endif</h4>

                                    <h3>{{$vehicle_make ?? ''}} {{$vehicle_model ?? ''}}</h3>
                                    <!-- <p>Here's a different photo, kindly...</p> -->
                                    @php
                                    if(!empty($details->revise_offer_amount) && $details->revise_offer_status == 0){
                                        $offerAmount = $details->revise_offer_amount;
                                    }else{
                                        $offerAmount = $details->offer_amount;
                                    }
                                    @endphp

                                    @if(!empty($details->offer_amount) && $details->accept_reject_offer == 1 && $details->cancel_offer_buyer != 1 && $details->revise_offer_status != 2)
                                    <div class="status-wrap"><strong class="st-accept">ACCEPTED</strong>
                                        @if(Auth::user()->id == $details->buyer_id)
                                        @php 
                                        if(!empty($offerAmount)){
                                            $offerAmount = number_format($offerAmount);
                                        }else{
                                            $offerAmount = '';
                                        }
                                        @endphp
                                        <span class="type">You offered S${{$offerAmount}}</span>
                                        @else
                                        <span class="type" style="color:red;">Offered </span> S${{$offerAmount}}
                                        @endif
                                    </div>

                                    @elseif(!empty($details->offer_amount) && ($details->revise_offer_status == 2 || $details->accept_reject_offer == 2))
                                    <div class="status-wrap"><strong class="st-reject">REJECTED</strong>
                                        @if(Auth::user()->id == $details->buyer_id)
                                        @php 
                                        if(!empty($offerAmount)){
                                            $offerAmount = number_format($offerAmount);
                                        }else{
                                            $offerAmount = '';
                                        }
                                        @endphp
                                        <span class="type">You offered S${{$offerAmount}}</span>
                                        @else
                                        <span class="type" style="color:red;">Offered </span> S${{$offerAmount}}
                                        @endif
                                    </div>

                                    @elseif(!empty($details->offer_amount))
                                    <div class="status-wrap">
                                        @if(Auth::user()->id == $details->buyer_id)
                                        @php 
                                        if(!empty($offerAmount)){
                                            $offerAmount = number_format($offerAmount);
                                        }else{
                                            $offerAmount = '';
                                        }
                                        @endphp
                                        <span class="type">You offered S${{$offerAmount}}</span>
                                        @else
                                        <span class="type" style="color:red;">Offered </span> S${{$offerAmount}}
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
                                    $fullPath = asset($imagePath);
                                }else{
                                    $fullPath = '';
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
                        <div class="alldisplay">All chats are displayed</div>
                    </div>
                </div>
            </div>


            <div class="col-lg-8 message-content">
                <div class="notebx"><strong>Note:</strong> By sharing your mobile number with the Buyer, you are
                    consenting the Buyer to contact you directly, in accordance with the standards set out in the
                    Singapore Personal Data Protection Act 2012.</div>
                <div class="message-chat-bx">
                    @php
                        $loggedUserId = Auth::user()->id;
                        if($loggedUserId == $chatDetails->buyer_id){
                            $blockUserId = $chatDetails->seller_id;
                        }else{
                            $blockUserId = $chatDetails->buyer_id;
                        }

                    @endphp
                    <div class="msg-bx">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"><i
                                    class="fas fa-ellipsis-h icon"></i></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Report</a>
                                <a class="dropdown-item" href="javascript::void(0);" onclick="blockUser('{{$blockUserId}}','{{$chatDetails->id}}')">Block user</a>
                                <a class="dropdown-item" href="javascript::void(0);" onclick="deleteChat('{{$loggedUserId}}','{{$chatDetails->id}}')">Delete chat</a>
                            </div>
                        </div>
                        @php
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
                        @endphp

                        @if(!empty($userDetail->profile_picture))
                        <figure class="bg-get-image">
                            <img class="bgimg" src="{{ asset($userDetail->profile_picture) }}" alt="" />
                        </figure>
                        @else
                        <figure class="bg-get-image">
                            <img class="bgimg" src="{{ asset('chat/images/tempt/img-user-1.jpg') }}" alt="" />
                        </figure>
                        @endif
                        
                        <div class="descript">
                            <h3>{{$name ?? ''}}</h3>
                            <div>Online {{$userDetail->updated_at->diffForHumans() ?? ''}}</div>
                            <div class="verify"><i class="far fa-check-circle"></i> Verified</div>
                        </div>
                    </div>
                    
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
                                <!-- // For seller accept reject button if offer amount is available start -->
                                @if(Auth::user()->id == $carDetails->seller_id && !empty($chatDetails->offer_amount))
                                <div class="col-md-6" id="changeofferamount">
                                    <h3>{{$carDetails->vehicleDetail->first()->vehicle_make ?? ''}} {{$carDetails->vehicleDetail->first()->vehicle_model ?? ''}}</h3>
                                    @php
                                    if(!empty($chatDetails->revise_offer_amount) && $chatDetails->revise_offer_status == 0){
                                        $offerAmount = $chatDetails->revise_offer_amount;
                                    }else{
                                        $offerAmount = $chatDetails->offer_amount;
                                    }
                                    if(!empty($offerAmount)){
                                        $offerAmount = number_format($offerAmount);
                                    }else{
                                        $offerAmount = '';
                                    }
                                    @endphp
                                    <div class="type">{{$chatDetails->user->name ?? ''}}   offered<strong> S${{$offerAmount}}</strong></div>
                                </div>

                                    @if(($chatDetails->accept_reject_offer == 1 && $chatDetails->revise_offer_buyer == 1 && $chatDetails->revise_offer_status == 0) || ($chatDetails->accept_reject_offer == 2 && $chatDetails->revise_offer_buyer == 1 && $chatDetails->revise_offer_status == 0))
                                    <!-- // If offer accepted by seller and revised offer is there -->
                                    <div class="col-md-6 last">
                                        <div class="action-row">
                                            <div class="actions">
                                                <a class="btn-7" href="javascript::void();" onclick="acceptrejectRevisedOffer('1', '{{$chatDetails->id}}')">Accept</a>
                                                <a class="btn-8 ml-10" href="javascript::void();" onclick="acceptrejectRevisedOffer('2', '{{$chatDetails->id}}')">Reject</a>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($chatDetails->accept_reject_offer == 0)
                                    <!-- // For new offer to accept for seller -->
                                    <div class="col-md-6 last">
                                        <div class="action-row">
                                            <div class="actions">
                                                <a class="btn-7" href="javascript::void();" onclick="acceptrejectOffer('1', '{{$chatDetails->id}}')">Accept</a>
                                                <a class="btn-8 ml-10" href="javascript::void();" onclick="acceptrejectOffer('2', '{{$chatDetails->id}}')">Reject</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @else
                                <!-- // For buyer -->
                                <div class="col-md-4">
                                    <h3>{{$carDetails->vehicleDetail->first()->vehicle_make ?? ''}} {{$carDetails->vehicleDetail->first()->vehicle_model ?? ''}}</h3>
                                    <div>S${{number_format($carDetails->vehicleDetail->first()->price)}}</div>
                                </div>
                                @endif
                                <!-- // For seller accept reject button if offer amount is available end -->

                                <!-- // IF offer amount is empty start -->
                                @if(Auth::user()->id != $carDetails->seller_id && empty($chatDetails->offer_amount))
                                <form method="post" action="{{route('saveOffer')}}">
                                    @csrf
                                    <input type="hidden" name="offerAmtCarId" value="{{$carDetails->id}}">
                                    <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                    <div class="col-md-12 last">
                                        <div class="action-row">
                                            <div class="price-input">
                                                <span class="append">S$</span>
                                                <input type="text" id="offeramount" class="form-control" name="offeramount" placeholder="Enter amount" value="" />
                                            </div>
                                            <div class="actions">
                                                <button type="submit" class="btn-7">Make Offer</button>
                                                <span class="line">|</span>
                                                <a class="lnk" href="#">Edit Offer</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif

                                <!-- // IF offer amount is empty end -->

                                <!-- // If offer placed by buyer start -->
                                @if(Auth::user()->id != $carDetails->seller_id && !empty($chatDetails->offer_amount))
                                <form method="post" action="{{route('saveOffer')}}">
                                    @csrf
                                    <input type="hidden" name="offerAmtCarId" value="{{$carDetails->id}}">
                                    <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                    <div class="col-md-12 last">
                                        <div class="action-row">


                                            <div class="price-input" id="editOfferAmount" style="display: none;">
                                                <span class="append">S$</span>
                                                <input type="text" class="form-control" id="rofferamount" name="offeramount" value="{{$chatDetails->offer_amount}}" placeholder="Enter amount" value="" />
                                            </div>

                                            @if($chatDetails->accept_reject_offer == 1)
                                            <!-- // For buyer If offer accepted by seller -->

                                            @if(Auth::user()->id != $carDetails->seller_id && !empty($chatDetails->offer_amount) && $chatDetails->accept_reject_offer == 1 && $chatDetails->revise_offer_buyer == 0)
                                            <!-- // Offer not revised once for buyer and SP agreemnet is not clicked by seller -->
                                            <div class="col-md-12 last">
												<div class="action-row">
													<div class="actions">
                                                        @if(empty($chatDetails->sp_agreement))
														<a class="btn-7" href="#offerpp" data-toggle="modal">Revise Offer</a>
                                                        <a class="btn-8 ml-10" href="#canceloffer" data-toggle="modal">Cancel Offer</a>
                                                        @endif

													</div>
												</div>
											</div>
                                            @elseif(Auth::user()->id != $carDetails->seller_id && !empty($chatDetails->offer_amount) && $chatDetails->accept_reject_offer == 1 && $chatDetails->revise_offer_buyer == 1)
                                            <!-- // Buyer has revised the offer -->
                                            <div class="col-md-6 last">
												<div class="action-row">
													<div class="actions">
                                                        @if(empty($chatDetails->sp_agreement))
														<a class="btn-7" href="#offerpp1" data-toggle="modal">Revise Offer</a>
														<a class="btn-8 ml-10" href="#canceloffer" data-toggle="modal">Cancel Offer</a>
                                                        @endif
													</div>
												</div>
											</div>
                                            @endif


                                            <!-- // Revise offer -->
                                            <div id="offerpp" class="modal pp-offer" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                                        <p id="sucmsg"></p>

                                                            <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                                            <div class="pp-offer-content">
                                                                <h3>Please key in revise offer</h3>
                                                                <div class="price-input" style="margin: 0 auto;">
                                                                    <span class="append">S$</span>
                                                                    <input type="text" name="reviseAmount" id="reviseAmount" class="form-control" placeholder="Enter amount" />
                                                                </div>
                                                                <div class="ppoutput">
                                                                    <button type="button" class="btn-7"onclick="reviseOffer('{{$chatDetails->id}}');">Submit</button>
                                                                    <a class="btn-8 ml-10" href="#" data-dismiss="modal">Cancel</a>
                                                                </div>
                                                            </div>
                                                        <div class="ppnote">*Please note that you are only allowed to revise accepted offer <strong>once</strong>.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- // End -->

                                            <!-- // Revise offer once -->
                                            <div id="offerpp1" class="modal pp-offer" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                                        <p id="sucmsg"></p>

                                                            <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                                            <div class="pp-offer-content">
                                                                <h3>Oh no, our system shows that this is the second time you are revising the accepted offer.</h3>

                                                            </div>
                                                            <div class="ppoutput text-center">
                                                                <a class="btn-8 ml-10" href="javascript::void(0);" onclick="redirectTowhatsapp();" target="_blank" data-dismiss="modal">Contact DIY Cars Support Team for Assistance</a>
                                                                <a class="btn-8 ml-10" href="#" data-dismiss="modal">Cancel</a>
                                                            </div>
                                                        <div class="ppnote">*Please note that you are only allowed to revise accepted offer <strong>once</strong>.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- // End -->

                                            <!-- // Cancel offer if accepted by seller after seller accept -->
                                            <div id="canceloffer" class="modal pp-offer" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                                        <div class="pp-offer-content">
                                                            <p id="sucmsg"></p>
                                                            <h3>Are you sure you want to cancel the offer?</h3>

                                                                <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                                                <div class="ppoutput">
                                                                    <button type="button" class="btn-7" onclick="cancelOrder('{{$chatDetails->id}}')">Yes</button>
                                                                    <a class="btn-8 ml-10" href="#" data-dismiss="modal">No</a>
                                                                </div>
                                                        </div>
                                                        <!-- <div class="ppnote">*Please note that you are only allowed to revise accepted offer <strong>once</strong>.</div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- // End -->


                                            @else
                                                <!-- // Cancel offer if buyer made offer before seller accept -->
                                                @if($chatDetails->accept_reject_offer != 2 && $chatDetails->revise_offer_buyer != 1)
                                                <div class="actions">
                                                    <button type="submit" class="btn-7" id="editOfferButton" style="display: none;">Make Offer</button>
                                                    <span class="line">|</span>
                                                    <a class="lnk" href="javascript::void();" onclick="showOffer();">Edit Offer</a>
                                                    <span class="line">|</span>
                                                    <a class="lnk" href="#cancelofferbuyer" data-toggle="modal">Cancel Offer</a>
                                                </div>

                                                @else
                                                <!-- // Revise offer -->
                                                <div id="offerpp" class="modal pp-offer" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                                            <p id="sucmsg"></p>

                                                                <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                                                <div class="pp-offer-content">
                                                                    <h3>Please key in revise offer</h3>
                                                                    <div class="price-input">
                                                                        <span class="append">S$</span>
                                                                        <input type="text" name="reviseAmount" id="reviseAmount" class="form-control" placeholder="Enter amount" />
                                                                    </div>
                                                                    <div class="ppoutput">
                                                                        <button type="button" class="btn-7"onclick="reviseOffer('{{$chatDetails->id}}');">Submit</button>
                                                                        <a class="btn-8 ml-10" href="#" data-dismiss="modal">Cancel</a>
                                                                    </div>
                                                                </div>
                                                            <div class="ppnote">*Please note that you are only allowed to revise accepted offer <strong>once</strong>.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- // End -->

                                                <!-- // Cancel offer if accepted by seller after seller accept -->
                                                <div id="canceloffer" class="modal pp-offer" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                                            <div class="pp-offer-content">
                                                                <p id="sucmsg"></p>
                                                                <h3>Are you sure you want to cancel the offer?</h3>

                                                                    <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                                                    <div class="ppoutput">
                                                                        <button type="button" class="btn-7" onclick="cancelOrder('{{$chatDetails->id}}')">Yes</button>
                                                                        <a class="btn-8 ml-10" href="#" data-dismiss="modal">No</a>
                                                                    </div>
                                                            </div>
                                                            <!-- <div class="ppnote">*Please note that you are only allowed to revise accepted offer <strong>once</strong>.</div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- // End -->

                                                <!-- // Revise offer once -->
                                            <div id="offerpp1" class="modal pp-offer" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                                        <p id="sucmsg"></p>

                                                            <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                                            <div class="pp-offer-content">
                                                                <h3>Oh no, our system shows that this is the second time you are revising the accepted offer.</h3>

                                                            </div>
                                                            <div class="ppoutput text-center">
                                                                <a class="btn-8 ml-10" href="#" data-dismiss="modal">Support DIY Cars Support Team for Assistance</a>
                                                                <a class="btn-8 ml-10" href="#" data-dismiss="modal">Cancel</a>
                                                            </div>
                                                        <div class="ppnote">*Please note that you are only allowed to revise accepted offer <strong>once</strong>.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- // End -->
                                                    @if($chatDetails->revise_offer_buyer == 0)
                                                    <div class="col-md-6 last">
                                                        <div class="action-row">
                                                            <div class="actions">
                                                                <a class="btn-7" href="#offerpp" data-toggle="modal">Revise Offer</a>
                                                                <a class="btn-8 ml-10" href="#canceloffer" data-toggle="modal">Cancel Offer</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <!-- // Buyer has revised the offer -->
                                                    <div class="col-md-6 last">
                                                        <div class="action-row">
                                                            <div class="actions">
                                                                <a class="btn-7" href="#offerpp1" data-toggle="modal">Revise Offer</a>
                                                                <a class="btn-8 ml-10" href="#canceloffer" data-toggle="modal">Cancel Offer</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endif

                                            <div id="cancelofferbuyer" class="modal pp-offer" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                                        <div class="pp-offer-content">
                                                            <p id="sucmsg"></p>
                                                            <h3>Are you sure you want to cancel the offer?</h3>

                                                                <input type="hidden" name="chatId" value="{{$chatDetails->id}}">
                                                                <div class="ppoutput">
                                                                    <button type="button" class="btn-7" onclick="cancelOrder('{{$chatDetails->id}}')">Yes</button>
                                                                    <a class="btn-8 ml-10" href="#" data-dismiss="modal">No</a>
                                                                </div>
                                                        </div>
                                                        <!-- <div class="ppnote">*Please note that you are only allowed to revise accepted offer <strong>once</strong>.</div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- // End -->
                                            @endif

                                        </div>
                                    </div>
                                </form>
                                @endif
                                <!-- // If offer placed by buyer End -->
                            </div>
                        </div>
                    </div>
                    @endif


                    <!-- // For buyer if offer accepted by seller -->
                    @if(Auth::user()->id != $carDetails->seller_id && !empty($chatDetails->offer_amount) && !empty($chatDetails->accept_reject_offer == 1))
                    <div class="msg-items">
                        @if($seller_particular)

                        <div class="item">
                            <a href="{{ url('forms/form-details/view/'.strtotime($seller_particular->created_at).'/'.$seller_particular->id) }}"><img src="{{asset('chat/images/tempt/ico-1.png')}}" alt="" /> Review &amp; <br/>Accept S&amp;P
                            </a>
                        </div>
                        @else
                        <div class="item">
                            <img src="{{asset('chat/images/tempt/ico-1.png')}}" alt="" /> Review &amp; <br/>Accept S&amp;P
                        </div>
                        @endif
                        <div class="item">
                            <a href="{{url('insurance')}}" target="_blank">
                            <img src="{{asset('chat/images/tempt/ico-2.png')}}" alt="" /> Apply <br/>Insurance
                            </a>
                        </div>
                        <div class="item">
                            <a href="{{url('loan')}}" target="_blank">
                            <img src="{{asset('chat/images/tempt/ico-3.png')}}" alt="" /> Apply Loan
                            </a>
                        </div>


                            @if($chatDetails->revise_offer_status == 2)
                            <div class="item">
                                <a href="javascript::void(0);" ><img src="{{asset('chat/images/tempt/ico-4.png')}}" alt="" /> Request for <br/>STA Inspection</a>
                            </div>
                            @else

                                <div class="item">
                                    <a href="javascript::void(0);" onclick="stainspection('{{$chatDetails->id}}')"><img src="{{asset('chat/images/tempt/ico-4.png')}}" alt="" /> Request for <br/>STA Inspection</a>
                                </div>

                            @endif

                        <div class="item">
                            <a href="https://www.sgcarmart.com/warranty/index.php" target="_blank"><img src="{{asset('chat/images/tempt/ico-5.png')}}" alt="" /> Purchase <br/>sgCarMart Warranty</a>
                        </div>
                    </div>
                    @endif
                    <!-- // For seller if offer accepted by seller -->
                    @if(Auth::user()->id == $carDetails->seller_id && !empty($chatDetails->offer_amount) && !empty($chatDetails->accept_reject_offer == 1))
                    <div class="msg-items">
                        @if($seller_particular)
                        <a href="{{ url('forms/form-details/view/'.strtotime($seller_particular->created_at).'/'.$seller_particular->id) }}" class="item" >
                            <img class="orignal" src="{{asset('chat/images/tempt/ico-1.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-1-hover.png')}}" alt="" /> Create Sales &amp; <br/>Purchase Agreement
                        </a>
                        @else
                            @if($chatDetails->revise_offer_status == 2)
                            <a href="javascript::void(0);" class="item" data-toggle="modal">
                                <img class="orignal" src="{{asset('chat/images/tempt/ico-1.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-1-hover.png')}}" alt="" /> Create Sales &amp; <br/>Purchase Agreement
                            </a>
                            @else
                            <a href="#ppagreement" class="item" data-toggle="modal">
                                <img class="orignal" src="{{asset('chat/images/tempt/ico-1.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-1-hover.png')}}" alt="" /> Create Sales &amp; <br/>Purchase Agreement
                            </a>
                            @endif
                        @endif
                        <a href="{{url('forms/Autolink_Full_Settlement_Form.pdf')}}" target="_blank" class="item">
                            <img class="orignal" src="{{asset('chat/images/tempt/ico-2.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-2-hover.png')}}" alt="" /> Check Full <br/> Settlement
                        </a>

                        @php
                        $timestamp = strtotime(date("Y-m-d h:i:s A"));
                        $day = date('D', $timestamp);
                        $timee = date('H', strtotime(date("Y-m-d h:i:s A")));
                        @endphp

                        @if($day != 'Sat' || $day != 'Sun')
                            @if(!empty($chatDetails->sta_inspection) && empty($chatDetails->sta_inspection_date))
                                {{--
                                @if($timee >= 9 && $timee <= 17)
                                <a href="#ppsta" class="item" data-toggle="modal">
                                    <img class="orignal" src="{{asset('chat/images/tempt/ico-4.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-4-hover.png')}}" alt="" /> STA Inspection
                                </a>
                                @else
                                <a href="javascript::void(0);" class="item">
                                    <img class="orignal" src="{{asset('chat/images/tempt/ico-4.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-4-hover.png')}}" alt="" /> STA Inspection
                                </a>
                                @endif
                                --}}
                                <a href="#ppsta" class="item" data-toggle="modal">
                                    <img class="orignal" src="{{asset('chat/images/tempt/ico-4.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-4-hover.png')}}" alt="" /> STA Inspection
                                </a>
                            @else
                            <a href="javascript::void(0);" class="item">
                                <img class="orignal" src="{{asset('chat/images/tempt/ico-4.png')}}" alt="" /><img class="hover" src="{{asset('chat/images/tempt/ico-4-hover.png')}}" alt="" /> STA Inspection
                            </a>
                            @endif
                        @endif

                    </div>
                    <div id="ppagreement" class="modal pp-agreement" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                <p>You will need <strong>Buyer’s Email Address</strong> and <strong>Mobile Number</strong> to complete and send the Sales and Purchase Agreement.</p>
                                <p>Do you have the required information?</p>
                                <div class="ppoutput">
                                    <button type="button" onclick="buyerInfo('{{$chatDetails->id}}',1, '{{$chatDetails->vehicle_main_id}}')" class="btn-7">Yes</button>
                                    <button type="button" onclick="buyerInfo('{{$chatDetails->id}}',2, '{{$chatDetails->vehicle_main_id}}')" class="btn-8">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="ppsta" class="modal pp-sta" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                <div class="row sp-col-30">
                                    <div class="col-sm-7 sp-col">
                                        <div id="datesta"><input class="hidden" type="text" name="datesta" /></div>
                                    </div>
                                    <div class="col-sm-5 sp-col last">
                                        <div>
                                            <!-- <div class="date">Wednesday, October 12</div> -->
                                            <div id="timesta"><input class="hidden" type="text" name="timesta" /></div>
                                            <div class="ppoutput">
                                                <button type="button" class="btn-7" onclick="confirmBooking('{{$chatDetails->id}}')">Confirm Booking</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($chatDetails->sta_inspection) && empty($chatDetails->sta_inspection_date))
                    <div class="msg-note">
                        Note: The Buyer has requested an STA Inspection. <a href="#ppsta" class="item" data-toggle="modal"><strong>Click here</strong></a> to make an appointment.
                    </div>
                    @endif
                    @endif

                    <div class="message-chat-list vscroll" id="chatList">

                        @foreach($chatDetails->allChat as $chat)
                        @php
                        $class = '';
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
                                    {!! nl2br($chat->messages) !!}
                                </div>
                                <div class="dateTimeChat">
                                    
                                    {!! htmlspecialchars_decode(date('j M Y', strtotime($chat->created_at))) !!} - {!! date('h:i A', strtotime($chat->created_at)); !!}
                                    
                                </div>
                            </div>
                        </div>

                        @endforeach


                        <!-- // For buyer start -->
                        @if(!empty($chatDetails->buyer_info == 2) && ($chatDetails->buyer_id == Auth::user()->id))
                        <div class="msg-note">
                            <p>DIY Cars support team:</p>
                            <p>The Seller is about to create a Sales and Purchase Agreement. The Seller needs your email address and mobile number to complete and send the Sales and Purchase Agreement to you.</p>

                            <p>Please share your email address and mobile number with the Seller here. Thank you!</p>
                        </div>
                        @endif
                        <!-- // For buyer end -->
                        @if(!empty($chatDetails->sta_inspection) && !empty($chatDetails->sta_inspection_date) && ($chatDetails->approved_by_admin == 1 ))
                            @php
                            $insDate = explode(' ', $chatDetails->sta_inspection_date);
                            @endphp
                            <div class="msg-note">
                                Note: An STA Inspection has been booked for {{date('d-m-Y', strtotime($insDate[0]))}} at {{date('g:i A', strtotime($insDate[1]))}}
                            </div>

                        @endif
                    </div>
                    <form method="post" id="chatForm">
                        @csrf
                        <div class="message-chat-input">
                            <input type="hidden" name="carDetail" value="{{$carDetails->id}}">
                            <input type="hidden" name="buyer" value="{{$chatDetails->buyer_id}}">
                            <input type="hidden" name="seller" value="{{$carDetails->id}}">
                            <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                            <textarea class="form-control" cols="30" rows="4" name="chatText"
                                placeholder="Type here..." id="messend"></textarea>
                            <button type="button" class="icon" onclick="submitform();"><i
                                    class="far fa-paper-plane"></i></button>
                        </div>
                    </form>
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
    setInterval("my_function();",5000);

    function my_function(){
        if($('.modal').hasClass('show')) {
        } else {
            $('#chatList').load(location.href + " #chatList>*", "");
            $('#chatListAll').load(location.href + " #chatListAll>*", "");
            $('#changeofferamount').load(location.href + " #changeofferamount>*", "");
        }
        // $('#chatList').load(location.href + " #chatList>*", "");
        // $('#chatListAll').load(location.href + " #chatListAll>*", "");
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
                    // $('#chatList').load('#chatList');
                }
            }
        });
    }

    function showOffer(){
        $('#editOfferAmount').show();
        $('#editOfferButton').show();
    }

    function acceptrejectOffer(val, chatId){
        $.ajax({
            method: "POST",
            url: '{{route("save.sellerApprove")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{val:val, chatId:chatId},
            // cache: false,
            // async: true,
            // contentType: false,
            // processData: false,
            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    location.reload();
                }
            }
        });
    }

    function acceptrejectRevisedOffer(val, chatId){
        $.ajax({
            method: "POST",
            url: '{{route("save.sellerApproveRevised")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{val:val, chatId:chatId},
            // cache: false,
            // async: true,
            // contentType: false,
            // processData: false,
            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    location.reload();
                }
            }
        });
    }

    $(function () {
        $("#offeramount,#rofferamount").on('keyup', function () {
            // $(this).val(numberWithCommas(parseFloat($(this).val().replace(/,/g, ""))));
            if($(this).val() == ''){
            }else{
                $(this).val(numberWithCommas(parseFloat($(this).val().replace(/,/g, ""))));
            }
        });
    });
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function cancelOrder(chatId){
        $.ajax({
            method: "POST",
            url: '{{route("cancel.offer")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{chatId:chatId},

            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    $('#sucmsg').html(msg.message);
                    location.reload();
                }
            }
        });
    }

    function reviseOffer(chatId){
        let reviseAmount = $('#reviseAmount').val();
        $.ajax({
            type: "POST",
            url: '{{route("revise.offer")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{chatId:chatId, reviseAmount: reviseAmount},

            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    $('#sucmsg').html(msg.message);
                    location.reload();
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

    function stainspection(chatId){
        $.ajax({
            type: "POST",
            url: '{{route("stainspection")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{chatId:chatId},

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

    function buyerInfo(chatId, status, carId){
        $.ajax({
            type: "POST",
            url: '{{route("buyerInfo")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{chatId:chatId, status:status},

            success: function (msg) {
                console.log(msg);
                if (msg.success == '200') {
                    $('#sucmsg').html(msg.message);
                    // location.reload();
                    if(status == 1){
                        window.location = '/forms/form-details/'+carId;
                    }else{
                        location.reload();
                    }
                    
                }
            }
        });
    }

    function confirmBooking(chatId){
        let datebooking  = $('#datesta input').val();
        let timebooking = $('#timesta input').val();
        var n = datebooking.split('-');
        var yearr = n[2];
        var monthh = n[1];
        var dayy = n[0];
        var formattedDate = monthh + '/' + dayy + '/' + yearr;
        var d = new Date(formattedDate)
        let selectedDate = d.getDay();

        var tt = timebooking.split(':');
        var hourr = tt[0];
        
        if(selectedDate > 0 && selectedDate <= 5){
            if(hourr < 8 ){
                alert('Please select time between 8AM - 8PM');
                return false;
            }
            if(hourr > 20){
                alert('Please select time between 8AM - 8PM');
                return false;
            }
        }
        if(selectedDate == 6){
            if(hourr < 8 ){
                alert('Please select time between 8AM - 5PM');
                return false;
            }
            if(hourr > 17){
                alert('Please select time between 8AM - 5PM');
                return false;
            }
        }
        $.ajax({
            type: "POST",
            url: '{{route("confirmBooking")}}',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{chatId:chatId, datebooking:datebooking, timebooking:timebooking},

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

    $('.ppclose').on('click', function(){
        location.reload();
    });

    $("#messend").keypress(function (e) {
        if(e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            submitform();
            // $(this).closest("form").submit();
        }
    });

    function redirectTowhatsapp(){
        window.open('https://api.whatsapp.com/send?phone=+6589393383&text=phone=+6589393383&text=Hi%20DIY%20Cars%20Support,%20my%20name%20is...%20', '_blank');
    }
</script>
@endsection