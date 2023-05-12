@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
  <div class="bn-inner bg-get-image">
    <img class="bgimg" src="{{ asset('images/tempt/bn-loan.jpg') }}" alt="Loan Applications">
  </div>
  @include('inc.messages')
  <form action="{{ route('my-profile.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container main-inner">
      <div class="row">
        <div class="col-lg-3 mb-991-30">
          @include('inc.account-profile-image')
          @include('inc.account-sidebar')

        </div>
        <div class="col-lg-9">
          <div class="title-5 type">

            <h1>My Quote</h1>
          </div>
          <div class="table-responsive">
            <div class="section-body">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">
                        Owner's Particulars
                        <hr />
                      </h5>
                      <div class="form-group">
                        <strong>Full Name/Company Name</strong>: {{ $quote_request->full_name }}
                      </div>
                      <div class="form-group">
                        <strong>NRIC/FIN/UEN</strong>: {{ $quote_request->nric }}
                      </div>
                      <div class="form-group">
                        <strong>Contact Number</strong>: {{ $quote_request->country."
                        ".$quote_request->contact_number }}
                      </div>
                      <div class="form-group">
                        <strong>Email</strong>: {{ $quote_request->email }}
                      </div>
                      <div class="form-group">
                        @php $gender_arr = ['1' => 'Male', '2' => 'Female']; @endphp
                        <strong>Gender</strong>: {{ $gender_arr[$quote_request->gender] }}
                      </div>
                    </div>
                  </div>

                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">
                        Vehicle Details
                        <hr />
                      </h5>
                      <div class="form-group">
                        <strong>Vehicle Number</strong>: {{ $quote_request->vehicle_number }}
                      </div>
                      <div class="form-group">
                        <strong>Vehicle Make</strong>: {{ $quote_request->vehicle_make }}
                      </div>
                      <div class="form-group">
                        <strong>Vehicle Model</strong>: {{ $quote_request->vehicle_model }}
                      </div>
                      <div class="form-group">
                        <strong>Primary Color</strong>: {{ $quote_request->primary_color }}
                      </div>
                      <div class="form-group">
                        <strong>Year of Manufacuture</strong>: {{ $quote_request->year_of_manufacture }}
                      </div>
                      @php
                      if(!empty($quote_request->open_market_value)){
                        $omv = '$'.number_format($quote_request->open_market_value);
                      }else{
                        $omv = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Open Market Value</strong>: {{ $omv }}
                      </div>
                      @php 
                      if(!empty($quote_request->orig_reg_date)){
                        $ord = date('d-m-Y', strtotime($quote_request->orig_reg_date));
                      }else{
                        $ord = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Original Registration Date</strong>: {{ $ord }}
                      </div>
                      @php 
                      if(!empty($quote_request->first_reg_date)){
                        $frd = date('d-m-Y', strtotime($quote_request->first_reg_date));
                      }else{
                        $frd = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>First Registration Date</strong>: {{ $frd }}
                      </div>
                      <div class="form-group">
                        <strong>No. of Transfer</strong>: {{ $quote_request->no_of_transfer }}
                      </div>
                      @php
                      if(!empty($quote_request->minimumparfbenefit)){
                        $mfb = '$'.number_format($quote_request->minimumparfbenefit);
                      }else{
                        $mfb = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Minimum PARF Benefit</strong>: {{ $mfb }}
                      </div>
                      @php 
                      if(!empty($quote_request->coe_expiry_date)){
                        $coeed = date('d-m-Y', strtotime($quote_request->coe_expiry_date));
                      }else{
                        $coeed = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>COE Expiry Date</strong>: {{ $coeed }}
                      </div>
                      <div class="form-group">
                        <strong>COE Category</strong>: {{ $quote_request->coe_category }}
                      </div>
                      @php
                      if(!empty($quote_request->quota_premium)){
                        $qp = '$'.number_format($quote_request->quota_premium);
                      }else{
                        $qp = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Quota Premium</strong>: {{ $qp }}
                      </div>
                      <div class="form-group">
                        <strong>Vehicle Type</strong>: {{ $quote_request->vehicle_type }}
                      </div>
                      <div class="form-group">
                        <strong>Propellant</strong>: {{ $quote_request->propellant }}
                      </div>
                      @php
                      if(!empty($quote_request->engine_capacity)){
                        $ec = number_format($quote_request->engine_capacity) . ' cc';
                      }else{
                        $ec = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Engine Capacity</strong>: {{ $ec }} 
                      </div>
                      <div class="form-group">
                        <strong>Engine Number</strong>: {{ $quote_request->engine_no }}
                      </div>
                      <div class="form-group">
                        <strong>Chassis Number</strong>: {{ $quote_request->chassis_no }}
                      </div>
                      @php
                      if(!empty($quote_request->max_unladen_weight)){
                        $muw = number_format($quote_request->max_unladen_weight) . ' kg';
                      }else{
                        $muw = '0';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Max Unladen Weight</strong>: {{ $muw }}
                      </div>
                      <div class="form-group">
                        <strong>Vehicle Scheme</strong>: {{ $quote_request->vehicle_scheme }}
                      </div>
                      @php 
                      if(!empty($quote_request->roadtaxexpirydate)){
                        $rted = date('d-m-Y', strtotime($quote_request->roadtaxexpirydate));
                      }else{
                        $rted = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Road Tax Expiry Date</strong>: {{ $rted }}
                      </div>
                      

                      @php
                      if(!empty($quote_request->mileage)){
                        $mileagee = number_format($quote_request->mileage) . ' Km';
                      }else{
                        $mileagee = '';
                      }
                      @endphp

                      <div class="form-group">
                        <strong>Mileage</strong>: {{ $mileagee }}
                      </div>
                    </div>
                  </div>

                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">
                        Additional Details
                        <hr />
                      </h5>
                      <div class="form-group">
                        <strong>Seller's Remarks</strong>: {{ $quote_request->seller_remarks }}
                      </div>
                      @php 
                      if(!empty($quote_request->handing_over_date)){
                        $hod = date('d-m-Y', strtotime($quote_request->handing_over_date));
                      }else{
                        $hod = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Handing Over Date</strong>: {{ $hod }}
                      </div>
                      
                      <div class="form-group">
                        <strong>Photos:</strong>
                        @php $uploaded_files = json_decode($quote_request->upload_file); @endphp
                        @if(isset($uploaded_files))
                        <ul>
                          @foreach($uploaded_files as $key=>$item)
                          <li><a href="{{ url($item) }}">{{ $item }}</a></li>
                          @endforeach
                        </ul>
                        @endif
                      </div>
                      @php 
                      if(!empty($quote_request->quote_price)){
                        $quotePrice = number_format($quote_request->quote_price);
                      }else{
                        $quotePrice = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Quote Price</strong>: ${{ $quotePrice }}
                      </div>
                      @php 
                      if(!empty($quote_request->quote_expiry_date)){
                        $qed = date('d-m-Y', strtotime($quote_request->quote_expiry_date));
                      }else{
                        $qed = '';
                      }
                      @endphp
                      <div class="form-group">
                        <strong>Quote Expiry Date</strong>: {{ $qed }}
                      </div>
                      <div class="form-group">
                        @php $statusArr = ['0'=>'', '1'=>'Pending', '2'=>'Quoted']; @endphp
                        <strong>Status</strong>: {{ $statusArr[$quote_request->status] }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection