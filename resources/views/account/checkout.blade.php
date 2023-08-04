@extends('layouts.app')
@section('content')

<main class="main-wrap">	
  <div class="tempt-4">
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
    </div>
    <div class="box-6">
      <div class="row sp-col-15">
        <div class="col-xl-7 sp-col">
          <div class="box-6-col">
            <h1 class="title-1">Shopping Cart</h1>
            <div class="mb-30">You have 3 items in your cart</div>
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
            <div class="grid-11 noaction">
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
                  <div class="gcol-3 gprice">
                    <strong>$ {{ $cartt->amount ?? '' }}</strong>
                  </div>
                </div>
              </div>
            </div>
            @php 
          }
          @endphp
        @endforeach
      @endif
            <hr class="bdrtype-1"/>
            <div class="box-3">
              <div class="row">
                <div class="col-lg-7">
                  <h4 class="title-4">Email</h4>
                  <span class="txt-1">{{ Auth::user()->email }}</span> <a class="link-5" href="#">Change email</a>
                </div>
                <div class="col-lg-5">
                  <h4 class="title-4">Contact Number</h4>
                  <span class="txt-1">{{ Auth::user()->mobile }}</span> <a class="link-5" href="#">Change contact number</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-5 sp-col mt-1199-30">
          <div class="box-6-col">
            <h2 class="title-1">Checkout</h2>
            <div class="mb-30">Lorem ipsum dolor sit amet, consectetur piscing</div>
            <div class="box-3">
              <!-- <h4 class="title-8">Card Details</h4>
              <h5 class="title-9">Card Type</h5>
              <div class="row grid-12">
                <div class="col-3">
                  <a class="active" href="#"><img src="images/tempt/visa.jpg" alt="visa" /></a>
                </div>
                <div class="col-3">
                  <a href="#"><img src="images/tempt/paypal.jpg" alt="paypal" /></a>
                </div>
                <div class="col-3">
                  <a href="#"><img src="images/tempt/mastercard.jpg" alt="mastercard" /></a>
                </div>
                <div class="col-3">
                  <a href="#"><img src="images/tempt/american-express.jpg" alt="american express" /></a>
                </div>
              </div> -->
              <!-- <label class="lb-1">Name on Card</label>
              <input class="form-control" type="text" placeholder="enter name" />
              <label class="lb-1">Card Number</label>
              <input class="form-control" type="number" placeholder="0000 0000 0000" />
              <div class="row break-324">
                <div class="col-7 sp-col">
                  <label class="lb-1">Expiration Date</label>
                  <input class="form-control" type="text" placeholder="mm/yyyy" />
                </div>
                <div class="col-5 sp-col">
                  <label class="lb-1">CVV</label>
                  <input class="form-control" type="number" placeholder="XXX" />
                </div>
              </div> -->
              <hr class="bdrtype-1"/>
              <div class="row total-row">
                <span class="col-5">Subtotal</span> <strong class="col-7 lastcol">$ {{ $totalAmount }}</strong>
              </div>
              <!-- <div class="row total-row">
                <span class="col-5">Shipping</span> <strong class="col-7 lastcol">$ 50.00</strong>
              </div> -->
              <div class="row total-row">
                <span class="col-5">Total <span class="d-inline-block">(tax incl.)</span></span> <strong class="col-7 lastcol total">$ {{ $totalAmount }}</strong>
              </div>

              <div class="row output-3">
                <form method="post" action="{{ route('processTransaction') }}">
                  @csrf
                  <input type="hidden" name="totalAmount" value="{{ $totalAmount }}" >
                <div class="col-auto order-last">
                  <button class="btn-1" type="submit">Checkout <i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
              </form>
                <div class="col order-first">
                  <a class="btn-2 rico" href="{{ url('cart') }}"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
                </div>
              </div>

              <!-- <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmTransaction" id="frmTransaction">
                <input type="hidden" name="business" value="{{12345}}">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="item_name" value="fff">
                <input type="hidden" name="item_number" value="ff">
                <input type="hidden" name="amount" value="20">  
                
                <input type="hidden" name="item_name" value="tt">
                <input type="hidden" name="item_number" value="ee">
                <input type="hidden" name="amount" value="40">   


                <input type="hidden" name="currency_code" value="USD">   
                <input type="hidden" name="cancel_return" value="http://abacus.test/payment-cancel">
                <input type="hidden" name="return" value="http://abacus.test/payment-status">

                <div class="row output-3">
                  <div class="col-auto order-last">
                    <button class="btn-1" type="submit">Checkout <i class="fa-solid fa-arrow-right-long"></i></button>
                  </div>
                  <div class="col order-first">
                    <a class="btn-2 rico" href="{{ url('cart') }}"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
                  </div>
                </div>
             </form> -->

             <!-- <a href="{{ route('processTransaction') }}" class="btn btn-success">Pay $1 from Paypal</a> -->





              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>	
</main>

@endsection
