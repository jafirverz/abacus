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
            <div class="col-lg-4 message-sidebar">
                <form class="message-search">
                    <input type="text" class="form-control" placeholder="Search messages here" />
                    <button type="submit" class="btnsearch"><i class="fas fa-search"></i></button>
                </form>
                <div class="message-inbox">								
                    <div class="message-inbox-head open">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">Inbox</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Inbox</a>
                                <a class="dropdown-item" href="#">Selling</a>
                                <a class="dropdown-item" href="#">Buying</a>
                                <a class="dropdown-item" href="#">Archived</a>
                            </div>
                        </div>
                        <div class="unread"><a href="#">1 unread chat</a></div>
                    </div>
                    <div class="message-inbox-content">									
                        <div class="vscroll">

                            @foreach($allChats as $chatlist)
                            <div class="msg-list">
                                <div class="group">
                                    <span class="date">10/13/21</span>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"><i class="fas fa-ellipsis-h icon"></i></a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Report</a>
                                            <a class="dropdown-item" href="#">Block user</a>
                                            <a class="dropdown-item" href="#">Delete chat</a>
                                        </div>
                                    </div>											
                                </div>
                                <figure class="bg-get-image">
                                    <img class="bgimg" src="images/tempt/img-user-1.jpg" alt="" />
                                </figure>
                                <div class="descript">
                                    <h4>mschanandlerbong</h4>
                                    <h3>BMW 1 Series 328i</h3>
                                    <p>Here's a different photo, kindly...</p>
                                    <div class="status-wrap"><span class="type">You offered S$46,500</span></div>
                                </div>
                                <div class="icon-car bg-get-image">
                                    <img class="bgimg" src="images/tempt/ico-car.jpg" alt="" />
                                </div>
                                <a class="link-fix" href="#">View details</a>
                            </div>
                            @endforeach
                            
                        </div>
                        <div class="alldisplay">All chats are displayed</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 message-content">
                <div class="notebx"><strong>Note:</strong> By sharing your mobile number with the Buyer, you are consenting the Buyer to contact you directly, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.</div>
                <div class="message-chat-bx">
                    <div class="msg-bx">									
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"><i class="fas fa-ellipsis-h icon"></i></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Report</a>
                                <a class="dropdown-item" href="#">Block user</a>
                                <a class="dropdown-item" href="#">Delete chat</a>
                            </div>
                        </div>
                        <figure class="bg-get-image">
                            <img class="bgimg" src="images/tempt/img-user-1.jpg" alt="" />
                        </figure>
                        <div class="descript">
                            <h3>mschanandlerbong</h3>
                            <div>Online 3 hours ago</div>
                            <div class="verify"><i class="far fa-check-circle"></i> Verified</div>
                        </div>
                    </div>
                    <div class="msg-action">	
                        <figure class="bg-get-image">
                            <img class="bgimg" src="images/tempt/ico-car.jpg" alt="" />
                        </figure>
                        <div class="descript">
                            <div class="row">
                                <div class="col-md-4">
                                    <h3>BMW 1 Series 328i</h3>
                                    <div>S$50,500</div>
                                </div>
                                <div class="col-md-8 last">
                                    <div class="action-row">
                                        <div class="price-input">
                                            <span class="append">S$</span>
                                            <input type="text" class="form-control" placeholder="Enter amount" />
                                        </div>
                                        <div class="actions">
                                            <a class="btn-7" href="#">Make Offer</a>
                                            <span class="line">|</span>
                                            <a class="lnk" href="#">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="message-chat-list vscroll">

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
                        
                    </div>
                    <!-- <div class="message-chat-input">
                        <textarea class="form-control" cols="30" rows="1" placeholder="Type here..."></textarea>
                        <button type="button" class="icon"><i class="far fa-paper-plane"></i></button>
                    </div> -->
                    @php 
                    $buyerId = $chatDetails->buyer_id;
                    $sellerId = $chatDetails->seller_id;
                    $loggedInUser = Auth::user()->id;
                    if($loggedInUser == $buyerId){
                        $receiverId = $sellerId;
                    }else{
                        $receiverId = $buyerId;
                    }
                    @endphp

                    <form method="post" id="chatForm">
                        @csrf
                        <div class="message-chat-input">
                            <input type="hidden" name="carDetail" value="{{$carDetails->id}}">
                            <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                            <input type="hidden" name="receiverId" value="{{$receiverId}}">
                            <textarea class="form-control" cols="30" rows="1" name="chatText" placeholder="Type here..."></textarea>
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
                    location.reload();
                }
            }
        });
    }
</script>
@endsection
