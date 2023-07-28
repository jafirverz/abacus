@extends('layouts.app')
@section('content')

<main class="main-wrap">	
  <div class="tempt-3">
    <div class="container maxmain">
      <ul class="steps">
        <li>
          <span>
            <img src="images/tempt/ico-step-1.jpg" alt="" />
          </span>
          <strong>Step 1</strong>
        </li>
        <li>
          <span>
            <img src="images/tempt/ico-step-2.jpg" alt="" />
          </span>
          <strong>Step 2</strong>
        </li>
      </ul>
      <div class="box-5">
        <div class="row sp-col-20 title-wrap-3">
          <div class="col-md sp-col">
            <h1 class="title-1">Shopping Cart</h1>
            <div>You have {{ count($cartDetails) }} items in your cart</div>
          </div>
          <div class="col-md-auto sp-col">
            <!-- <a class="link-4 rico" href=""><strong>Clear Cart</strong> <i class="fa-solid fa-xmark"></i></a> -->
            <a class="link-4 rico" href="{{ route('delete.cart') }}"><strong>Delete All</strong> <i class="fa-regular fa-trash-can"></i></a>
          </div>
        </div>
        @php
        $totalAmount = 0;
        @endphp
        @if($cartDetails)
          @foreach($cartDetails as $cart)
            @php
            $cartt = json_decode($cart->cart);
            if($cartt->type == 'level'){
              $totalAmount+= $cartt->amount;
            @endphp
              <div class="grid-11">
                <!-- <div class="checkbxtype nolb">
                  <input id="check-1" type="checkbox" name="deletecart[]" value="{{ $cart->id }}" />
                  <label for="check-1"></label>
                </div> -->
                <div class="ginner">
                  <div class="bg">
                    <img class="bgimg" src="{{ asset( $cartt->image) }}" alt="" />
                  </div>
                  <div class="gcontent">
                    <div class="gcol-1">
                      <h4>Premium</h4>
                      <h5>{{ $cartt->name }}</h5>
                      {{ $cartt->months }} months premium membership
                    </div>
                    <div class="gcol-2">
                      {{ $cartt->description }}
                    </div>
                    <div class="gcol-3 gprice">
                      <strong>$ {{ $cartt->amount ?? '' }}</strong>
                    </div>
                  </div>
                </div>
                <a class="btndelete" href="{{ route('cartlist', $cart->id) }}"><i class="fa-solid fa-xmark"></i></a>
              </div>
            @php 
            }
            @endphp
          @endforeach
        @endif


        
        <hr class="bdrtype-1"/>
        <div class="row total-wrap">
          <div class="col-md-6">
            <span>Total:</span> <strong>$ {{ $totalAmount }}</strong>
          </div>
          <div class="col-md-6 lastcol">
            <a class="btn-1" href="{{ url('checkout') }}">Proceed <i class="fa-solid fa-arrow-right-long"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>	
</main>
@endsection
