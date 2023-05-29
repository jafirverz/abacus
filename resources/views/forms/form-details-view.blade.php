@extends('layouts.app')

@section('content')
<div class="main-wrap" style="padding-bottom: 172px; padding-top: 79.7969px;">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
        @include('inc.breadcrumb')
        @include('inc.messages')
        <!-- <div class="note-2">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-7 col-md-8">
                    <h4>Faster form filling with Singpass.</h4>
                    <p>Singpass enables you to retrieve your personal data from participating Government agencies.
                        With your consent, we can auto-fill this, making your application convenient.</p>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-4 last">
                    <a href="" class="btn-6"><strong>Retrieve
                            Myinfo</strong> <span>with <img src="" alt="singpass"></span></a>
                </div>
            </div>
        </div> -->

        @php 
        session()->put('buyerspurl',Request::path());
        @endphp
        
        <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
        <h3 class="title-6"><span><strong>Seller's Particular</strong></span></h3>
		<div class="form-ani">
        <div class="row seller">
            <div class="col-xl-6">
                <div class="inrow empty">
                    <label>Name</label>
                    <input type="text" class="form-control" name="seller_name"
                        value="{{ $seller_particular->seller_name ?? '' }}" />
                </div>
                @if ($errors->has('seller_name'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('seller_name') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="inrow empty">
                    <label>NRIC/FIN</label>
                    <input type="text" class="form-control" name="seller_nric"
                        value="{{ $seller_particular->nric ?? '' }}" maxlength="4" minlength="4">
                </div>
                @if ($errors->has('seller_nric'))
                <span class="text-danger d-block">
                    {{ $errors->first('seller_nric') }}
                </span>
                @endif
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="inrow empty">
                    <label>Passport</label>
                    <input type="text" class="form-control" name="passport"
                        value="{{ $seller_particular->passport ?? '' }}" maxlength="4" minlength="4">
                </div>
                @if ($errors->has('passport'))
                <span class="text-danger d-block">
                    {{ $errors->first('passport') }}
                </span>
                @endif
            </div>
        </div>
        <div class="row seller">

            <div class="col-xl-3">
                <div class="mt-20">
                    <div class="inrow empty">
                        <label>Gender</label>
                        <input type="text" class="form-control" name="seller_gender" readonly
                            value="{{ $seller_particular->seller_gender ?? '' }}">
                    </div>
                    @if ($errors->has('seller_gender'))
                    <span class="text-danger d-block">
                        {{ $errors->first('seller_gender') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-xl-5 col-lg-7">
                <div class="row sp-col-10 break-425">
                    <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                        <div class="mt-20">
                            <div class="inrow empty">
                                <label>Country Code</label>
                                <input type="text" name="seller_country_code" class="form-control"
                                    value="{{ $seller_particular->seller_country_code ?? '' }}">
                            </div>
                            @if ($errors->has('seller_country_code'))
                            <span class="text-danger d-block">
                                {{ $errors->first('seller_country_code') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                        <div class="mt-20">
                            <div class="inrow empty">
                                <label>Contact No.</label>
                                <input type="text" class="form-control" name="seller_mobile" readonly
                                    value="{{ $seller_particular->seller_mobile ?? '' }}">
                            </div>
                            @if ($errors->has('seller_mobile'))
                            <span class="text-danger d-block">
                                {{ $errors->first('seller_mobile') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="mt-20">
                    <div class="inrow empty">
                        <label>Email Address (Ex: janedoe@gmail.com)</label>
                        <input type="text" class="form-control" name="seller_email" readonly
                            value="{{ $seller_particular->seller_email ?? '' }}">
                    </div>
                    @if ($errors->has('seller_email'))
                    <span class="text-danger d-block">
                        <strong>{{ $errors->first('seller_email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row seller">
            
            <div class="col-md-9">
                <div class="inrow empty">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address"
                        value="{{ $seller_particular->address ?? '' }}">
                </div>
                {{--
                @if ($errors->has('address'))
                <span class="text-danger d-block">
                    {{ $errors->first('address') }}
                </span>
                @endif
                --}}
            </div>
            {{-- <div class="col-md-3 sp-col">
                <div class="inrow empty">
                    <label>Postal Code</label>
                    <input type="text" class="form-control" name="postal_code"
                        value="{{ $seller_particular->postal_code ?? '' }}">
                </div>
            </div> --}}
        </div>
        <h3 class="title-6"><span><strong>Vehicle Details</strong></span></h3>
        <div class="row seller">
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Vehicle No. (Ex: SBY1234A)</label>
                    <input type="text" class="form-control" name="registration_no"
                        value="{{ $seller_particular->vehicleparticular->registration_no ?? '' }}">
                </div>
                @if ($errors->has('registration_no'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('registration_no') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Vehicle Make (Ex: Toyota)</label>
                    <input type="text" class="form-control" name="make"
                        value="{{ $seller_particular->vehicleparticular->make ?? '' }}">
                </div>
                @if ($errors->has('make'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('make') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Vehicle Model (Ex: Corolla)</label>
                    <input type="text" class="form-control" name="model"
                        value="{{ $seller_particular->vehicleparticular->model ?? '' }}">
                </div>
                @if ($errors->has('model'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('model') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row seller">
            <div class="col-lg-4">
                <div class="inrow date-wrap datepicker-wrap empty">
                    <label>Original Registration Date</label>
                    <input type="text" class="form-control" name="registration_date"
                        value="{{ date('d-m-Y', strtotime($seller_particular->vehicleparticular->registration_date)) ?? '' }}">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                @if ($errors->has('registration_date'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('registration_date') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>First Registration Date</label>
                    <input type="text" class="form-control" name="first_registration_Date"
                        value="{{ date('d-m-Y', strtotime($seller_particular->first_registration_Date)) ?? '' }}" />

                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Manufacturing Year (Ex: 2017)</label>
                    <input type="text" class="form-control" name="year_of_manufacturer"
                        value="{{ $seller_particular->vehicleparticular->year_of_manufacturer ?? '' }}" maxlength="4">
                </div>
                @if ($errors->has('year_of_manufacturer'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('year_of_manufacturer') }}</strong>
                </span>
                @endif
            </div>
            
        </div>

        
        
        


        <div class="row seller">
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Engine No.</label>
                    <input type="text" class="form-control" name="engine_no"
                        value="{{ $seller_particular->vehicleparticular->engine_no ?? '' }}">
                </div>
                @if ($errors->has('engine_no'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('engine_no') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Chassis No.</label>
                    <input type="text" class="form-control" name="chassis_no"
                        value="{{ $seller_particular->vehicleparticular->chassis_no ?? '' }}">
                </div>
                @if ($errors->has('chassis_no'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('chassis_no') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Transfer Count</label>
                    <input type="text" class="form-control" name="no_of_transfer"
                        value="{{ $seller_particular->vehicleparticular->no_of_transfer ?? '' }}">
                </div>
                @if ($errors->has('no_of_transfer'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('no_of_transfer') }}</strong>
                </span>
                @endif
            </div>
            
            
        </div>
        <div class="row seller">
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Primary Color</label>
                    <input type="text" class="form-control" name="color"
                        value="{{ $seller_particular->vehicleparticular->color ?? '' }}">
                </div>
                @if ($errors->has('color'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('color') }}</strong>
                </span>
                @endif
            </div>
            
            <div class="col-lg-4">
                <div class="inrow date-wrap datepicker-wrap empty">
                    <label>COE Expiry Date</label>
                    <input type="text" class="form-control" name="coe_expiry_date"
                        value="{{ date('d-m-Y', strtotime($seller_particular->vehicleparticular->coe_expiry_date)) ?? '' }}">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                @if ($errors->has('coe_expiry_date'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('coe_expiry_date') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow date-wrap datepicker-wrap empty">
                    <label>Road Tax Expiry Date</label>
                    <input type="text" class="form-control" name="road_tax_expiry_date"
                        value="{{ date('d-m-Y', strtotime($seller_particular->vehicleparticular->road_tax_expiry_date)) ?? '' }}">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                @if ($errors->has('road_tax_expiry_date'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('road_tax_expiry_date') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row seller">
            <div class="col-lg-4">
                <div class="inrow inptxt empty">
                    <label>Engine Capacity (Ex: 1794 cc)</label>
                    <input type="text" class="form-control" name="engine_output"
                        value="{{ $seller_particular->vehicleparticular->engine_output ?? '' }}">
					<span class="txt">CC</span>
                </div>
                @if ($errors->has('engine_output'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('engine_output') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow inptxt lefttxt empty">
                    <label>Open Market Value</label>
					<span class="txt">$</span>
                    <input type="text" class="form-control" name="open_market_value"
                        value="{{ number_format($seller_particular->vehicleparticular->open_market_value) ?? '' }}">
                </div>
                @if ($errors->has('open_market_value'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('open_market_value') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow inptxt lefttxt empty">
                    <label>Minimum PARF Benefit</label>
					<span class="txt">$</span>
                    <input type="text" class="form-control" name="arf_paid"
                        value="{{ number_format($seller_particular->vehicleparticular->arf_paid) ?? '' }}">
                </div>
                @if ($errors->has('arf_paid'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('arf_paid') }}</strong>
                </span>
                @endif
            </div>
            
            
        </div>

        <div class="row seller">
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Vehicle Type</label>
                    <input type="text" class="form-control" name="vehicle_type"
                        value="{{ $seller_particular->vehicleparticular->vehicle_type ?? '' }}" />
                </div>
                @if ($errors->has('vehicle_type'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('vehicle_type') }}</strong>
                </span>
                @endif

            </div>
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Vehicle Scheme</label>
                    <input type="text" class="form-control"
                        value="{{ $seller_particular->vehicleparticular->vehicle_scheme ?? '' }}" name="vehicle_scheme">
                </div>
                @if ($errors->has('vehicle_scheme'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('vehicle_scheme') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>IU Label Number</label>
                    <input type="text" class="form-control"
                        value="{{ $seller_particular->vehicleparticular->iu_label_number ?? '' }}"
                        name="iu_label_number">
                </div>
                @if ($errors->has('iu_label_number'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('iu_label_number') }}</strong>
                </span>
                @endif
            </div>

        </div>


        <h3 class="title-6"><span><strong>Terms and Conditions</strong></span></h3>
        @php
        $terms = json_decode($seller_particular->spcontract->terms_and_condition);
        if(sizeof($terms) > 0){
        $terms = $terms;
        }else{
        $terms = [];
        }
        @endphp
        {{--<div class="row sp-col-10 seller">
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="loan" type="checkbox" name="terms[]"
                        value="Subject to Loan Approval Within 7 Working Days." @if(in_array('Subject to Loan Approval
                        Within 7 Working Days.', $terms)) checked @endif>
                    <label for="loan">Subject to Loan Approval Within 7 Working Days.</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="retention" type="checkbox" name="terms[]" value="Number Retention (Vehicle Will Be Replaced With a Random Assigned Vehicle
                        No. by LTA)." @if(in_array('Number Retention (Vehicle Will Be Replaced With a Random Assigned
                        Vehicle No. by LTA).', $terms)) checked @endif>
                    <label for="retention">Number Retention (Vehicle Will Be Replaced With a Random Assigned Vehicle
                        No. by LTA).</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="sold" type="checkbox" name="terms[]" value="Vehicle Sold As It Is." @if(in_array('Vehicle
                        Sold As It Is.', $terms)) checked @endif>
                    <label for="sold">Vehicle Sold As It Is.</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="noinspection" name="terms[]" type="checkbox" value="No Inspection Required."
                        @if(in_array('No Inspection Required.', $terms)) checked @endif>
                    <label for="noinspection">No Inspection Required.</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="spare" type="checkbox" name="terms[]"
                        value="No Spare Key. <br>(Buyer to Duplicate at Own Expense)" @if(in_array('No Spare Key.
                        <br>(Buyer to Duplicate at Own Expense)', $terms)) checked @endif>
                    <label for="spare">No Spare Key. <br>(Buyer to Duplicate at Own Expense)</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="owners" type="checkbox" name="terms[]" value="No Owners Manual." @if(in_array('No Owners
                        Manual.', $terms)) checked @endif>
                    <label for="owners">No Owners Manual.</label>
                </div>
            </div>
            <div class="col-lg-8 sp-col mt-20">
                <div class="row align-items-center sp-col-10 break-575 typedate">
                    <div class="col-auto sp-col">
                        <div class="checkbox">
                            <input id="sale" name="terms[]" type="checkbox" value="Subject to Completion of Sale by:"
                                @if(in_array('Subject to Completion of Sale by:', $terms)) checked @endif>
                            <label for="sale">Subject to Completion of Sale by:</label>
                        </div>
                    </div>
                    <div class="col sp-col">
                        <div class="date-wrap datepicker-wrap maxw-180 empty">
                            <input type="text" class="form-control" name="termsdate" placeholder="24 Jun 2021"
                                value="{{ $seller_particular->spcontract->termsdate }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 sp-col mt-20">
                <div class="row align-items-center sp-col-10">
                    <div class="col-auto sp-col">
                        <div class="checkbox">
                            <input id="other" type="checkbox">
                            <label for="other">Other:</label>
                        </div>
                    </div>
                    <!-- <div class="col sp-col empty">
                        <input type="text" class="form-control" value="" id="otherdesc" value="">
                    </div> -->
                </div>
            </div>
        </div> --}}
        <div class="note-3">
            <ol id="termsdesc">
                @foreach($terms as $term)
                <li>{{ $term }}</li>
                @endforeach
                <!-- <li>Subject to Loan Approval Within 7 Working Days.</li>
                    <li>Number Retention (Vehicle Will Be Replaced with a Random Assigned Vehicle No. by LTA).</li>
                    <li>Delivery date: 24 Jun 2021.</li> -->
            </ol>
        </div>
        <div class="row seller">
            <div class="col-lg-3 col-sm-6">
                <h4 class="title-7"><span><strong>Selling Price</strong></span></h4>
                <div class="input-group mt-20 grinput empty">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" name="selling_price"
                        value="{{ number_format($seller_particular->spcontract->selling_price) ?? '' }}">
                </div>
                @if ($errors->has('selling_price'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('selling_price') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-3 col-sm-6">
                <h4 class="title-7"><span><strong>Deposit</strong></span></h4>
                <div class="input-group mt-20 grinput empty">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" name="deposit"
                        value="{{ number_format($seller_particular->spcontract->deposit) ?? '' }}" placeholder="">
                </div>
                @if ($errors->has('deposit'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('deposit') }}</strong>
                </span>
                @endif
            </div>
            
            <div class="col-lg-6">
                <h4 class="title-7"><span><strong>Balance Payment (Before Loan Amount)</strong></span></h4>
                <div class="input-group mt-20 grinput empty">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" name="balance_payment"
                        value="{{ number_format($seller_particular->spcontract->balance_payment) ?? '' }}" placeholder="" readonly>
                </div>
                @if ($errors->has('balance_payment'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('balance_payment') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <h4 class="title-7"><span><strong>Buyer’s Contact Information</strong></span></h4>
        <div class="row seller">
            <div class="col-xl-7 col-lg-5">
                <div class="inrow empty">
                    <label>Email Address (Ex: janedoe@gmail.com)</label>
                    <input type="text" class="form-control" name="buyer_email"
                        value="{{ $seller_particular->buyer_email ?? '' }}">
                </div>
                @if ($errors->has('buyer_email'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('buyer_email') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-xl-5 col-lg-7">
                <div class="row sp-col-10 break-425">
                    <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                        <div class="inrow empty">
                            <label>Buyer's Country Code</label>
                            <input type="text" name="country_code" class="form-control"
                                value="{{ $seller_particular->country_code ?? '' }}">
                        </div>
                        {{--
                        @if ($errors->has('country_code'))
                        <span class="text-danger d-block">
                            <strong>{{ $errors->first('country_code') }}</strong>
                        </span>
                        @endif
                        --}}
                    </div>

                    <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                        <div class="inrow empty">
                            <label>Contact No.</label>
                            <input type="text" class="form-control" name="buyer_mobile"
                                value="{{ $seller_particular->buyer_mobile ?? '' }}">
                        </div>
                        @if ($errors->has('buyer_mobile'))
                        <span class="text-danger d-block">
                            <strong>{{ $errors->first('buyer_mobile') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
		</div>
        <!-- <div class="output-2">
            <button class="btn-1 minw-190" type="submit">Save and Exit <i class="fas fa-arrow-right"></i></button>
            <a href="https://verzview.com/html/autolink-new/forms.html#" class="btn-1 minw-190">View your Agreement
                <i class="fas fa-arrow-right"></i></a>
            <button class="btn-1 minw-190" type="submit">Sign and Submit Agreement to Seller <i
                    class="fas fa-arrow-right"></i></button>
        </div> -->
        <hr class="mt-50 mb-50">

        @if($buyer_particular)
        <form action="{{ url('forms/form-details/buyer/'.$reference.'/'.$id) }}" class="form-ani" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idd" value="{{ $buyer_particular->id }}">
            <div id="buyer">
                <!-- <div class="note-2">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-lg-7 col-md-8">
                            <h4>Faster form filling with Singpass.</h4>
                            <p>Singpass enables you to retrieve your personal data from participating Government agencies.
                                With your consent, we can auto-fill this, making your application convenient.</p>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 last">
                            <a href="https://verzview.com/html/autolink-new/forms.html#" class="btn-6"><strong>Retrieve
                                    Myinfo</strong> <span>with <img
                                        src="./Autolink New S&amp;P Form_files/singpass-logo.png" alt="singpass"></span></a>
                        </div>
                    </div>
                </div> -->
                <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
                <h3 class="title-6"><span><strong>Buyer’s Particulars</strong></span></h3>
                <div class="form-ani">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="inrow empty">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="buyer_name"
                                    value="{{ old('buyer_name', $buyer_particular->buyer_name) ?? '' }}">
                            </div>
                            @if ($errors->has('buyer_name'))
                            <span class="text-danger d-block">
                                {{ $errors->first('buyer_name') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <div class="inrow empty">
                                <label>NRIC/FIN</label>
                                <input type="text" class="form-control" name="nric" value="{{ old('nric', $buyer_particular->nric) ?? '' }}">
                            </div>
                            @if ($errors->has('nric'))
                            <span class="text-danger d-block">
                                {{ $errors->first('nric') }}
                            </span>
                            @endif
                        </div>

                        <div class="col-xl-3 col-md-4">
                            <div class="inrow empty">
                                <label>Passport</label>
                                <input type="text" class="form-control" name="passport"
                                    value="{{ old('passport', $buyer_particular->passport) ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-3">
                            <div class="inrow empty">
                                <label>Gender</label>
                                @if($buyer_particular->issaved == 0)
                                <input type="text" class="form-control" name="buyer_gender"
                                    value="{{ old('buyer_gender', $buyer_particular->buyer_gender) ?? '' }}">
                                @else
                                <select class="selectpicker" name="buyer_gender" id="gender" data-title="Gender">
                                    <option value="Male" @if($buyer_particular->buyer_gender=='Male') selected @endif>Male</option>
                                    <option value="Female" @if($buyer_particular->buyer_gender=='Female') selected @endif>Female</option>
                                </select>
                                @endif
                            </div>
                            @if ($errors->has('buyer_gender'))
                            <span class="text-danger d-block">
                                {{ $errors->first('buyer_gender') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-xl-5 col-lg-7">
                            <div class="row sp-col-10 break-425">
                                <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                                    <div class="dropdown bootstrap-select">
                                        <div class="inrow empty">
                                            <label>Country Code</label>
                                            <input type="text" name="country_code" class="form-control" value="+65">
                                        </div>
                                        @if ($errors->has('country_code'))
                                        <span class="text-danger d-block">
                                            {{ $errors->first('country_code') }}
                                        </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                                    <div class="inrow empty">
                                        <label>Contact No.</label>
                                        <input type="text" class="form-control" name="phone"
                                        value="{{ old('phone', $buyer_particular->phone) ?? '' }}">
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger d-block">
                                            {{ $errors->first('phone') }}
                                        </span>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="inrow empty">
                                <label>Email Address (Ex: janedoe@gmail.com)</label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ old('email', Auth::user()->email) ?? '' }}">
                            </div>
                            @if ($errors->has('email'))
                                        <span class="text-danger d-block">
                                            {{ $errors->first('email') }}
                                        </span>
                                        @endif
                        </div>
                    </div>



                







                    <div class="row">
                        {{--
                        <div class="col-lg-4">
                            <div class="inrow empty">
                                <label>Nationality</label>
                                <input type="text" class="form-control" name="nationality"
                                    value="{{ $buyer_particular->buyer_nationality ?? '' }}">
                            </div>
                        </div>
                        --}}
                        <div class="col-md-8">
                            <div class="inrow empty">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address"
                                    value="{{ old('address', $buyer_particular->user->address) ?? '' }}">
                            </div>
                        </div>
                        {{--
                        <div class="col-md-3 sp-col">
                            <div class="inrow empty">
                                <label>Postal Code</label>
                                <input type="text" class="form-control" name="postal_code"
                                    value="{{ old('postal_code', $buyer_particular->postal_code) ?? '' }}">
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
                @php
                if(old('terms')){
                    $terms = old('terms') ?? '';
                }
                else{
                    $terms = json_decode($buyer_particular->buyerpaymenttermcondition->terms_and_condition);
                    if(sizeof($terms) > 0){
                        $terms1 = $terms;
                    }else{
                        $terms1 = [];
                    }
                }
                @endphp
                <h3 class="title-6"><span><strong>Terms and Conditions</strong></span></h3>
                <div class="row sp-col-10">
                    <div class="col-lg-4 col-md-6 sp-col mt-20">
                        <div class="checkbox">
                            <input id="inspection" @if(in_array('Subject to STA Inspection. (Minimum Grade B, inspection fee borne by Buyer)', $terms1)) checked @endif type="checkbox" onchange="checkcheckbox('term');" name="terms[]" value="Subject to STA Inspection. (Minimum Grade B, inspection fee borne by Buyer)">
                            <label for="inspection">Subject to STA Inspection. (Minimum Grade B, inspection fee borne by
                                Buyer)</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 sp-col mt-20">
                        <div class="checkbox">
                            <input id="subject" type="checkbox" @if(in_array('Subject to loan approval within 7 working days. Otherwise, deposit will be fully refunded.', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]" value="Subject to loan approval within 7 working days. Otherwise, deposit will be fully refunded.">
                            <label for="subject">Subject to loan approval within 7 working days. Otherwise, deposit will be
                                fully refunded.</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 sp-col mt-20">
                        <div class="checkbox">
                            <input id="accident" type="checkbox" @if(in_array('Accident-free (Chassis).', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]"
                                value="Accident-free (Chassis).">
                            <label for="accident">Accident-free (Chassis).</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 sp-col mt-20">
                        <div class="checkbox">
                            <input id="workshop" type="checkbox" @if(in_array('Subject to inspection by Buyer’s appointed workshop. (All fees borne by Buyer).', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]" value="Subject to inspection by Buyer’s appointed workshop. (All fees borne by Buyer).">
                            <label for="workshop">Subject to inspection by Buyer’s appointed workshop. (All fees borne by
                                Buyer).</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 sp-col mt-20">
                        <div class="checkbox">
                            <input id="vehicle" type="checkbox" @if(in_array('No illegal modification of vehicle.', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]"
                                value="No illegal modification of vehicle.">
                            <label for="vehicle">No illegal modification of vehicle.</label>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4 col-md-6 sp-col mt-20">
                        <div class="checkbox">
                            <input id="key" type="checkbox">
                            <label for="key">2 Keys</label>
                        </div>
                    </div> -->
                    <div id="termsadded">
    
                    </div>
                    <div id="othertermsextra" style="display: block;" class="col-lg-8 sp-col mt-20">
                        @php 
                        $oldteArray = array('Subject to STA Inspection. (Minimum Grade B, inspection fee borne by Buyer)', 'Subject to loan approval within 7 working days. Otherwise, deposit will be fully refunded.', 'Accident-free (Chassis).', 'Subject to inspection by Buyer’s appointed workshop. (All fees borne by Buyer).', 'No illegal modification of vehicle.');
                        $addedTerms= old('termsadded') ?? '';
                        $oldtermscheck = old('terms') ?? '';
                        @endphp
                        @if($addedTerms)
                            @foreach($addedTerms as $trw)
                            <div class="checkbox">
                                <input type="checkbox" name="terms[]" value="{{$trw}}" @if(in_array($trw, $oldtermscheck)) checked="checked" @endif onchange="checkcheckbox();">
                                <label for="extra">{{$trw}}</label>
                            </div>
                            @endforeach
                        @else 
                        @if($terms)
                        @foreach($terms as $oldt)
                            @if(!in_array($oldt, $oldteArray))
                            <div class="checkbox">
                                <input type="checkbox" name="terms[]" value="{{$oldt}}" @if(!in_array($oldt, $oldteArray)) checked="checked" @endif onchange="checkcheckbox();">
                                <label for="extra">{{$oldt}}</label>
                            </div>
                            @endif
                        @endforeach
                        @endif
                        @endif
                    </div>
    
                    <div class="col-lg-12 sp-col mt-20">
                        <div class="row align-items-center sp-col-10">
                            <div class="col-auto sp-col">
                                <!-- <div class="checkbox">
                                    <input id="other" type="checkbox" value="">
                                    <label for="other">Other:</label>
                                </div> -->
                            </div>
                            <div class="col sp-col empty">
                                <div class="row align-items-center">
                                    <div class="col-lg-2">
                                        <div class="inrow-label">
                                            Additional T&amp;C:
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="inrow add-plus">
                                            <input type="text" class="form-control" name="otherterms" id="otherdesc">
                                            <button type="button" onclick="addotherterms();">Add +</button>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>
                    <div id="termserror"></div>
                </div>

                

                <div class="note-3">
                    <ol id="termsdescbuyer">
    
                    </ol>
                </div>
                <h3 class="title-6"><span><strong>Loan Requirements</strong></span></h3>
                
                <div class="check-inline mt-20">
                    <div class="radio">
                        <input type="radio" id="loan2" name="loan" value="1" @if($buyer_particular->loan == '1' || old('loan') == 1) checked
                        @endif>
                        <label for="loan2">Loan</label>
                    </div>
                    <div class="radio">
                        <input type="radio" id="noloan" name="loan" value="2" @if($buyer_particular->loan == '2' || old('loan') == 2) checked
                        @endif>
                        <label for="noloan">No Loan</label>
                    </div>
                </div>
                @php 
            if($buyer_particular->loan == 2 || old('loan') == 2){
                $noneClass = 'd-none';
            }else{
                $noneClass = '';
            }
            @endphp
                <div class="row align-items-center {{ $noneClass }}" id="noloanselected">
                    <div class="col-xl-4 col-lg-5">
                        <div class="check-inline">
                            <div class="radio">
                                <input type="radio" id="tenor" name="tenor" value="1"
                                    @if($buyer_particular->tenor == '1' || old('tenor') == 1) checked @endif>
                                <label for="tenor">Maximum Tenor</label>
                            </div>
                            <div class="radio">
                                <input type="radio" id="months" name="tenor" value="2" @if($buyer_particular->tenor
                                == '2' || old('tenor') == 2) checked @endif>
                                <label for="months">No. of Years and Months</label>
                            </div>
                        </div>
                    </div>
                    @php
                    if($buyer_particular->tenor== '2' || old('tenor') == 2){
                        $disPC = '';
                    }else{
                        $disPC = 'd-none';
                    } 
                    @endphp
                    <div class="col-lg-6 {{ $disPC }}" id="loanPeriodsMonths">
                        <div class="row break-425">
                            <div class="col-6 sp-col">
                                <div class="inrow mt-0 empty">
                                    <label>Loan Period (Years)</label>
                                    <input type="text" class="form-control" name="loan_period"
                                        value="{{ old('loan_period', $buyer_particular->loan_period) ?? '' }}">
                                </div>
                            </div>
                            <div class="col-6 sp-col mt-425-10">
                                <div class="inrow mt-0 empty">
                                    <label>Loan Period (Months)</label>
                                    <input type="text" class="form-control" name="loan_months"
                                        value="{{ old('loan_months', $buyer_particular->loan_months) ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                





                <h4 class="title-7"><span><strong>Agreed Price</strong></span></h4>
                <div class="row">
                    <div class="col-lg-4 mt-20 empty">
                        <div class="input-group grinput">
                            <span class="input-group-text">$</span>	
                            <input type="text" class="form-control" placeholder="$100,000" name="agreed_price" readonly
                            value="{{ number_format($buyer_particular->agreed_price) ?? '' }}" id="agreedPrice">
                        </div>
                    </div>
                </div>
                <h4 class="title-7"><span><strong>Deposit</strong></span></h4>
                <div class="row">
                    @php 
                    if(!empty($buyer_particular->deposit_amount)){
                        $depositAmount1 = number_format($buyer_particular->deposit_amount);
                    }else{
                        $depositAmount1 = '';
                    }
                    @endphp
                    <div class="col-lg-4 mt-20">
                        <div class="notepp type empty">
                            <div class="input-group grinput">
                                <span class="input-group-text">$</span>							
                                <input type="text" class="form-control" placeholder="" id="depositAmount" name="deposit_amount"
                                value="{{ $depositAmount1 ?? '' }}" readonly>
                            </div>
                            <div class="notepin">
                                Deposit to be made to Autolink Holdings Pte Ltd (Escrow account) for the purchase of the vehicle in this agreement.
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="title-7"><span><strong>Balance Payment <em>(Before Loan Amount)</em></strong></span></h4>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mt-20 grinput empty">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" placeholder="95,000" name="balance_payment"
                            value="{{ number_format($buyer_particular->balance_payment) ?? '' }}" id="balancePayment" readonly>
                        </div>
                    </div>
                </div>


                <h4 class="title-7"><span><strong>Less: <em>Required Loan Amount</em></strong></span></h4>
                <div class="row">
                    @php
                    if(isset($buyer_particular->buyerloandetail)){
                        if(!empty($buyer_particular->buyerloandetail->loan_amount)){
                            $loanAmount = number_format($buyer_particular->buyerloandetail->loan_amount);
                        }else{
                            $loanAmount = '';
                        }
                    }else{
                        $loanAmount = '';
                    }
                    
                    @endphp
                    <div class="col-lg-4 mt-20 empty">
                        <div class="inrow inptxt lefttxt empty"> <label>Loan Amount</label> <span class="txt">$</span>
                            <input type="text" class="form-control" placeholder="" name="loan_amount" id="loan_amount_buyer" value="{{ $loanAmount ?? '' }}"
                                onkeyup="finalBalance();">
                        </div>
                    </div>
                    <div class="col-lg-4 mt-20">
                        <div class="dropdown bootstrap-select">
                            <div class="inrow">
                                <label>Bank Name</label>
                                @if($buyer_particular->issaved == 0)
                                <input type="text" class="form-control" name="bank_id"
                                    value="{{ old('bank_id', $buyer_particular->buyerloandetail->bank ?? '') ?? '' }}">
                                @else
                                <select class="selectpicker" name="bank_id" id="bank_id_buyer">
                                    <option value="">Nil</option>
                                    @if(getBankDetail())
                                    @foreach (getBankDetail() as $value)
                                    <option value="{{ $value->title }}/{{ $value->interest }}" data-loan="{{ $value->interest }}" @if(old('bank_id') || isset($buyer_particular->buyerloandetail->bank))
                                        @if(old('bank_id')==$value->id || $buyer_particular->buyerloandetail->bank == $value->title) selected
                                        @endif
                                        @endif>{{ $value->title }} - {{ $value->interest.'%' }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @endif
                            </div>

                        </div>
                    </div>
                    @if($buyer_particular->issaved == 0)
                    <div class="col-lg-4 mt-20">
                        <div class="dropdown bootstrap-select">

                            <div class="inrow">
                                <label>Interest Rate%</label>
                                <input type="text" class="form-control positive-integer" name="interest"
                                    value="{{ $buyer_particular->buyerloandetail->interest ?? '' }}" />
                            </div>
                            
                        </div>
                    </div>
                    @endif
                </div>

                <h4 class="title-7"><span><strong>Final Balance Payment</strong></span></h4>
                <div class="row">
                    @php
                    if(!empty($buyer_particular->buyerloandetail->balance)){
                        $balancePay = number_format($buyer_particular->buyerloandetail->balance);
                    }elseif(!empty($buyer_particular->balance_payment)){
                        $balancePay = number_format($buyer_particular->balance_payment);
                    }else{
                        $balancePay = 0;
                    }
                    @endphp
                    <div class="col-lg-4 mt-20 empty">
                        <div class="input-group grinput">
                            <span class="input-group-text">$</span>	
                            <input type="text" class="form-control" placeholder="" id="finalPayment" readonly name="balance"
                            value="{{ $balancePay ?? '' }}">
                        </div>
                    </div>
                </div>
                <h3 class="title-6"><span><strong>DIY Cars Contract Terms and Policy</strong></span></h3>
                <textarea rows="20" cols="30" class="form-control mt-20">
1. All documentation and payment transactions will be carried out by AUTOLINK HOLDINGS PTE LTD (Case Trust Accredited). It is noted that DIY Cars Pte Ltd is a wholly-owned subsidiary of Autolink Holdings Pte Ltd.

2. Any fees and levies imposed by the Land Transport Authority of Singapore (LTA) directly associated with the transfer of the vehicle stated in this agreement are to be borne by the BUYER.

3. Autolink Holdings Pte Ltd will be acting as an Escrow for all financial payments and receipts i.e., Deposit for the vehicle, balance payment to the seller and any other payments related to the Sales and Purchase for the said vehicle in this Agreement. 

4. All payments are to be paid to Autolink Holdings Pte Ltd only, otherwise, Buyer and Seller will be responsible for any financial losses due to their own actions.

5. Final payment will be made to Seller once all documentations i.e., Buyer’s loan application, Motor Vehicle insurance coverage etc. are complete and effective.

6. Autolink Holdings Pte Ltd will carry out the transfer of the vehicle as LTA’s Electronic Service Agent via the Onemotoring.com.sg platform.

7. Any finance settlement on behalf of Seller is chargeable with a service fee of 0.5% (before GST) of the outstanding amount to the Bank/Finance Institution. E.g., Finance settlement amount is $30000. Service fee = $30000 x 5% x 1.07 = $150 plus $10.50 = $160.50 (inclusive of GST)

8. In the event Seller is to make full settlement of vehicle himself/herself, handover of the vehicle can only be carried out upon clearance of Form B1. Autolink Holdings Pte Ltd will ensure that Form B1 is cleared before making the balance payment to the Seller.

9. Buyer will purchase a motor insurance policy which is valid for the purpose of the transfer of vehicle as of the date of ownership transfer. The period of insurance should be at least 1 year or until the next road tax renewal date for vehicles less than 1 year to C.O.E Expiration.

10.	In the event of a breach of this Agreement by the Seller, the Buyer will be compensated with an amount equal to twice the value of the Deposit.

11.	In the event of a breach of this Agreement by the Buyer, the Seller will keep the Deposit.

12.	In the event of an unsuccessful loan application by Buyer within the agreed period in this Agreement, this Agreement will be void and Seller is to refund the deposit to Buyer.

13.	In case of unresolved disputes relating to this Agreement, Buyer and Seller will bring forth to Small Claims Tribunal for further negotiation of claims.

14.	The Seller is to hand over the keys and any other documents i.e., Owner’s Manual, Warranty Booklet etc. belonging to the Vehicle in this Agreement.

15.	Autolink Holdings Pte Ltd is only acting as an Escrow agent for the Sales and Purchase of the vehicle in this Agreement and will not be liable for any claims under The Consumer Protection (Fair Trading) Act (CPFTA).

16.	The Seller is to preserve the condition of the vehicle in accordance with the Agreed Terms and Conditions between Buyer and Seller stipulated in this Agreement.

17.	The Buyer and Seller acknowledge that each has read and understood the terms of this Agreement and executes this Agreement with a full understanding of the Terms and Conditions in this Agreement.

18.	This Agreement constitutes supersedes all prior communications, contracts or agreements between the parties with respect to the subject matter addressed in this Agreement, whether in writing or oral.

19.	This Agreement shall be governed by the laws of Republic of Singapore.</textarea>

<div class="checkbox mt-20">
    <input id="agree" type="checkbox" required>  
    <label for="agree">I acknowledge and agree to the collection, use and disclosure of my personal data, which has been provided for the purpose of creating a Sales and Purchase Agreement, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.</label>
</div>
                <div class="captcha">
                    <img class="bgimg" src="./Autolink New S&amp;P Form_files/captcha.png" alt="captcha">
                </div>
                @if($buyer_particular->issaved == 1)
                <div class="output-2">
                <button class="btn-1 minw-190" type="submit" name="saveexit" value="saveeUpdate">Save and Exit <i class="fas fa-arrow-right"></i></button>
                <button class="btn-1 minw-190" type="submit" name="saveexit" value="submittr">Submit Agreement to Seller <i
                        class="fas fa-arrow-right"></i></button>
                </div>
                @endif
            </div>
        </form>
        @if($buyer_particular->issaved == 0)
        <script>
            $(function () {
                $("#buyer").find("input, select, textarea").attr("disabled", true);
            });
        </script>
        @endif

        @else
        @if(Auth::user()->id!=$seller_particular->user_id)

        @php
        if(!empty(session()->get('myinfobuyersp'))){
            $data = serialize(session()->get('myinfobuyersp'));
            $test = unserialize($data);
            if(sizeof($test)>0){
                $uinfin1 = $test['uinfin'] ?? '';
                $name1 = $test['name'] ?? '';
                $nationality1 = $test['nationality'] ?? '';
                $email1 = $test['email'] ?? '';
                $mobileno1 = $test['mobileno'] ?? '';
                $address = $test['address'] ?? '';
                $sex1 = $test['sex'] ?? '';
            }
        }else{
            if(Auth::user()){
                $name1 = Auth::user()->name ?? '';
                $mobileno1 = Auth::user()->mobile;
                $email1 = Auth::user()->email;
                $countryCode = Auth::user()->country_code;
                $address = Auth::user()->address;
                if(Auth::user()->gender==1){
                    $sex1 = 'MALE';
                }elseif(Auth::user()->gender==2){
                    $sex1 = 'FEMALE';
                }
            }else{
                $name1 = '';
                $sex1 = '';
                $mobileno1 = '';
                $email1 = '';
                $countryCode = '';
                $address = '';
                $sex1 = '';
            }
            $dob1 = '';
            $marital1 = '';
            $nric = '';
            
        }

        @endphp
        <form action="{{ url('forms/form-details/buyer/'.$reference.'/'.$id) }}" class="form-ani" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if(!empty($carId))
            <input type="hidden" name="carId" value="{{ $carId }}">
            @endif
            <div class="note-2">
                <div class="row align-items-center">
                    <div class="col-xl-8 col-lg-7 col-md-8">
                        <h4>Faster form filling with Singpass (Individual).</h4>
                        <p>Singpass enables you to retrieve your personal data from participating Government agencies.
                            With your consent, we can auto-fill this, making your application convenient.</p>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-4 last">
                        <a href="javascript::void(0);" onclick="callAuthoriseApi();" class="btn-6"><strong>Retrieve
                                Myinfo</strong><br> <span>with <img
                                    src="{{asset('images/tempt/singpass-logo.png')}}" alt="singpass"></span></a>
                    </div>
                </div>
            </div>
            <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
            <h3 class="title-6"><span><strong>Buyer’s Particulars</strong></span></h3>
            <div class="form-ani">
				<div class="row">
					<div class="col-xl-6">
						<div class="inrow empty">
							<label>Name</label>
							<input type="text" class="form-control" name="buyer_name" @if(!empty($name1) && !empty(session()->get('myinfobuyersp'))) readonly="readonly" @endif
								value="{{ old('buyer_name',$name1 ?? '') }}">
						</div>
                        @if(empty($name1) && empty(old('buyer_name')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('buyer_name'))
                        <span class="text-danger">This field is required</span>
                        @endif
						@if ($errors->has('buyer_name'))
						<span class="text-danger d-block">
							{{ $errors->first('buyer_name') }}
						</span>
						@endif
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="inrow empty">
							<label>NRIC/FIN</label>
							<input type="text" class="form-control" name="nric" value="{{ old('nric', $uinfin1 ?? '') }}" @if(!empty($uinfin1)) readonly="readonly" @endif>
						</div>
                        @if(empty($uinfin1) && empty(old('nric')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('nric'))
                        <span class="text-danger">This field is required</span>
                        @endif
						@if ($errors->has('nric'))
						<span class="text-danger d-block">
							{{ $errors->first('nric') }}
						</span>
						@endif
					</div>

					<div class="col-xl-3 col-md-6">
						<div class="inrow empty">
							<label>Passport</label>
							<input type="text" class="form-control" name="passport"
								value="{{ old('passport', $buyer_particular->passport ?? '') }}">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xl-3 col-lg-5 mt-20">
						<div class="dropdown bootstrap-select">
						    @if(empty(session()->get('myinfobuyersp')))
                            <select class="selectpicker" name="buyer_gender" id="gender">
                                <option value="">Gender</option>
                                <option value="Male" @if(Auth::user()->gender==1) selected @endif>Male</option>
                                <option value="Female" @if(Auth::user()->gender==2) selected @endif>Female</option>
                            </select>
    					    
    						@else
    							@if(empty($sex1))
                                <select class="selectpicker" name="buyer_gender" id="gender">
                                    <option value="">Gender</option>
                                    <option value="Male" @if(old('buyer_gender')=='Male') selected @endif>Male</option>
                                    <option value="Female"@if(old('buyer_gender')=='Female') selected @endif>Female</option>
                                </select>
                                @else 
                                <input type="text" @if(!empty($sex1)) readonly="readonly" @endif class="form-control" name="buyer_gender" value="{{ $sex1 ?? '' }}" />
                                @endif

                            @endif

						</div>
                        @if(empty($sex1) && empty(old('buyer_gender')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('buyer_gender'))
                        <span class="text-danger">This field is required</span>
                        @endif
						@if ($errors->has('buyer_gender'))
						<span class="text-danger d-block">
							{{ $errors->first('buyer_gender') }}
						</span>
						@endif
					</div>
					<div class="col-xl-5 col-lg-7">
						<div class="row sp-col-10 break-425">
							<div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
								<div class="dropdown bootstrap-select">
									<div class="inrow empty">
										<label>Country Code</label>
										<input type="text" name="country_code" class="form-control" value="+65">
									</div>
									@if ($errors->has('country_code'))
									<span class="text-danger d-block">
										{{ $errors->first('country_code') }}
									</span>
									@endif

								</div>
							</div>
							<div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
								<div class="inrow empty">
									<label>Contact No.</label>
									<input type="text" class="form-control" name="phone"
										value="{{ old('phone', $mobileno1 ?? '') }}">
								</div>
                                @if(empty($mobileno1) && empty(old('phone')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('phone'))
                                <span class="text-danger">This field is required</span>
                                @endif

                                @if ($errors->has('phone'))
                                <span class="text-danger d-block">
                                    {{ $errors->first('phone') }}
                                </span>
                                @endif
							</div>
						</div>
					</div>
					<div class="col-xl-4">
						<div class="inrow empty">
							<label>Email Address (Ex: janedoe@gmail.com)</label>
							<input type="text" class="form-control" name="email"
								value="{{ old('email', $email1 ?? '') }}">
                               
						</div>
                        @if(empty($email1) && empty(old('email')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('email'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('email'))
                        <span class="text-danger d-block">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
					</div>
				</div>
				<div class="row">
                    {{--
				    <div class="col-lg-4">
                        <div class="mt-20">
                            <select class="selectpicker" name="nationality">
                                <option value="Singapore">Singapore</option>
                            </select>
                        </div>
                    </div>
                    --}}
					<div class="col-md-8">
						<div class="inrow empty">
							<label>Address</label>
							<input type="text" class="form-control" name="address" @if(!empty($address) && !empty(session()->get('myinfobuyersp'))) readonly="readonly" @endif
								value="{{ old('address', $address ?? '') }}">
						</div>
                        @if(empty($address) && empty(old('address')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('address'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('address'))
                        <span class="text-danger d-block">
                            {{ $errors->first('address') }}
                        </span>
                        @endif
					</div>
					{{-- 
                        <div class="col-md-3 sp-col">
                            <div class="inrow empty">
                                <label>Postal Code</label>
                                <input type="text" class="form-control" name="postal_code"
                                    value="{{ $buyer_particular->postal_code ?? '' }}">
                            </div>
                        </div>
                    --}}
				</div>
			</div>
            <h3 class="title-6"><span><strong>Terms and Conditions</strong></span></h3>
            @if(empty(old('terms')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('terms'))
            <span class="text-danger">This field is required</span>
            @endif
            @if ($errors->has('terms'))
            <span class="text-danger d-block">
               {{ $errors->first('terms') }}
            </span>
            @endif
            @php 
                $terms1 = old('terms') ?? [];
            @endphp
            <div class="row sp-col-10">
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="inspection" @if(in_array('Subject to STA Inspection. (Minimum Grade B, inspection fee borne by Buyer)', $terms1)) checked @endif type="checkbox" onchange="checkcheckbox('term');" name="terms[]" value="Subject to STA Inspection. (Minimum Grade B, inspection fee borne by Buyer)">
                        <label for="inspection">Subject to STA Inspection. (Minimum Grade B, inspection fee borne by
                            Buyer)</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="subject" type="checkbox" @if(in_array('Subject to loan approval within 7 working days. Otherwise, deposit will be fully refunded.', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]" value="Subject to loan approval within 7 working days. Otherwise, deposit will be fully refunded.">
                        <label for="subject">Subject to loan approval within 7 working days. Otherwise, deposit will be
                            fully refunded.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="accident" type="checkbox" @if(in_array('Accident-free (Chassis).', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]"
                            value="Accident-free (Chassis).">
                        <label for="accident">Accident-free (Chassis).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="workshop" type="checkbox" @if(in_array('Subject to inspection by Buyer’s appointed workshop. (All fees borne by Buyer).', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]" value="Subject to inspection by Buyer’s appointed workshop. (All fees borne by Buyer).">
                        <label for="workshop">Subject to inspection by Buyer’s appointed workshop. (All fees borne by
                            Buyer).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="vehicle" type="checkbox" @if(in_array('No illegal modification of vehicle.', $terms1)) checked @endif onchange="checkcheckbox('term');" name="terms[]"
                            value="No illegal modification of vehicle.">
                        <label for="vehicle">No illegal modification of vehicle.</label>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="key" type="checkbox">
                        <label for="key">2 Keys</label>
                    </div>
                </div> -->
                <div id="termsadded">

                </div>
                <div id="othertermsextra" style="display: block;" class="col-lg-8 sp-col mt-20">
                    @php 
                    $oldteArray = array('Subject to STA Inspection. (Minimum Grade B, inspection fee borne by Buyer)', 'Subject to loan approval within 7 working days. Otherwise, deposit will be fully refunded.', 'Accident-free (Chassis).', 'Subject to inspection by Buyer’s appointed workshop. (All fees borne by Buyer).', 'No illegal modification of vehicle.');
                    $addedTerms= old('termsadded') ?? '';
                    $oldtermscheck = old('terms') ?? '';
                    @endphp
                    @if($addedTerms)
                    @foreach($addedTerms as $trw)
                    <div class="checkbox">
                        <input type="checkbox" name="terms[]" value="{{$trw}}" @if(in_array($trw, $oldtermscheck)) checked="checked" @endif onchange="checkcheckbox();">
                        <label for="extra">{{$trw}}</label>
                    </div>
                    @endforeach
                    @else 
                    @if($oldtermscheck)
                    @foreach($oldtermscheck as $oldt)
                    <div class="checkbox">
                        <input type="checkbox" name="terms[]" value="{{$oldt}}" @if(!in_array($oldt, $oldteArray)) checked="checked" @endif onchange="checkcheckbox();">
                        <label for="extra">{{$oldt}}</label>
                    </div>
                    @endforeach
                    @endif
                    @endif
                </div>

                <div class="col-lg-12 sp-col mt-20">
                    <div class="row align-items-center sp-col-10">
                        <div class="col-auto sp-col">
                            <!-- <div class="checkbox">
                                <input id="other" type="checkbox" value="">
                                <label for="other">Other:</label>
                            </div> -->
                        </div>
                        <div class="col sp-col empty">
							<div class="row align-items-center">
								<div class="col-lg-2">
									<div class="inrow-label">
										Additional T&amp;C:
									</div>
								</div>
								<div class="col-lg-10">
									<div class="inrow add-plus">
										<input type="text" class="form-control" name="otherterms" id="otherdesc">
										<button type="button" onclick="addotherterms();">Add +</button>
									</div>
								</div>
							</div>                            
                        </div>
                    </div>
                </div>
                <div id="termserror"></div>
            </div>
            

            <div class="note-3">
                <ol id="termsdescbuyer">

                </ol>
            </div>
            <h3 class="title-6"><span><strong>Loan Requirements</strong></span></h3>
            @php
            $selectedLoan = old('loan') ?? '';
            @endphp
            <div class="check-inline mt-20">
                <div class="radio">
                    <input type="radio" id="loan2" name="loan" value="1" @if($selectedLoan == 1) checked @else checked @endif>
                    <label for="loan2">Loan</label>
                </div>
                <div class="radio">
                    <input type="radio" id="noloan" name="loan" value="2" @if($selectedLoan == 2) checked @endif>
                    <label for="noloan">No Loan</label>
                </div>
            </div>
            @php 
            if($selectedLoan == 2){
                $noneClass = 'd-none';
            }else{
                $noneClass = '';
            }
            $selectedTenor = old('tenor') ?? '';
            @endphp
            <div class="row align-items-center {{ $noneClass }}" id="noloanselected" >
                <div class="col-xl-4 col-lg-5">
                    <div class="check-inline">
                        <div class="radio">
                            <input type="radio" id="tenor" name="tenor" value="1" @if($selectedTenor == 1) checked @else checked @endif>
                            <label for="tenor">Maximum Tenor</label>
                        </div>
                        <div class="radio">
                            <input type="radio" id="months" name="tenor" value="2" @if($selectedTenor == 2) checked @endif>
                            <label for="months">No. of Years and Months</label>
                        </div>
                    </div>
                </div>
                @php 
                if($selectedTenor == 2){
                    $noneClass1 = '';
                }else{
                    $noneClass1 = 'd-none';
                }
                @endphp
                <div class="col-lg-6 {{ $noneClass1 }}" id="loanPeriodsMonths">
                    <div class="row break-425">
                        <div class="col-6 sp-col">
                            <div class="inrow mt-0 empty">
                                <label>Loan Period (Years)</label>
                                <input type="text" class="form-control" name="loan_period"
                                    value="{{ old('loan_period',$buyer_particular->loan_period ?? '') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    
                            </div>
                            @if(empty(old('loan_period')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('loan_period'))
                            <span class="text-danger">This field is required</span>
                            @endif

                            @if ($errors->has('loan_period'))
                            <span class="text-danger d-block">
                               {{ $errors->first('loan_period') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-6 sp-col mt-425-10">
                            <div class="inrow mt-0 empty">
                                <label>Loan Period (Months)</label>
                                <input type="text" class="form-control" name="loan_months" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value="{{ old('loan_months', 0) }}">
                                   
                            </div>
                            @if ($errors->has('loan_months'))
                            <span class="text-danger d-block">
                               {{ $errors->first('loan_months') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>






            <h4 class="title-7"><span><strong>Agreed Price*</strong></span></h4>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                <div class="input-group mt-20 grinput empty">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="agreedPrice" onkeyup=""
                        placeholder="$100,000" name="agreed_price" readonly
                        value="{{ number_format($seller_particular->spcontract->selling_price) ?? '' }}">
                        
                </div>
                @if ($errors->has('agreed_price'))
                <span class="text-danger d-block">
                   {{ $errors->first('agreed_price') }}
                </span>
                @endif
            </div>
            </div>
            <h4 class="title-7"><span><strong>Less: Deposit*</strong></span></h4>
            
            <div class="row">
                <div class="col-lg-4 mt-20">
                    <div class="notepp empty">
                        <div class="input-group grinput empty">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="depositAmount" onkeyup=""
                            placeholder="$5,000" name="deposit_amount" readonly
                            value="{{ number_format($seller_particular->spcontract->deposit) ?? '' }}">
                        </div>
                        <div class="notepin">
                            Deposit to be made to Autolink Holdings Pte Ltd (Escrow account) for the purchase of the vehicle in this agreement.
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Balance Payment <em>(Before Loan Amount)</em></strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="balancePayment" onkeyup="finalBalance();"
                        placeholder="$95,000" name="balance_payment" readonly
                        value="{{ number_format($seller_particular->spcontract->balance_payment) ?? '' }}">
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Less: <em>Required Loan Amount</em></strong></span></h4>
            <div class="mt-20">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mt-20 grinput empty">
                            <span class="input-group-text">$</span>
                            @php
                    if(isset($buyer_particular->buyerloandetail)){
                        if(!empty($buyer_particular->buyerloandetail->loan_amount)){
                            $loanAmount = number_format($buyer_particular->buyerloandetail->loan_amount);
                        }else{
                            $loanAmount = '';
                        }
                    }else{
                        $loanAmount = '';
                    }
                    
                    @endphp
                        <input type="text" class="form-control" id="loan_amount_buyer" onkeyup="finalBalance();"
                            placeholder="" name="loan_amount" @if($selectedLoan == 2) readonly @endif
                            value="{{ old('loan_amount',$loanAmount ?? '') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            @if(empty(old('loan_amount')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('loan_amount'))
                                <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('loan_amount'))
                            <span class="text-danger d-block">
                                {{ $errors->first('loan_amount') }}
                            </span>
                            @endif
                    </div>
                    
                    <div class="col-lg-4 mt-20">
                        <select class="selectpicker" name="bank_id" id="bank_id_buyer">
                            <option value="">Nil</option>
                            @if(getBankDetail())
                            @foreach (getBankDetail() as $value)
                            <option value="{{ $value->title }}/{{ $value->interest }}" data-loan="{{ $value->interest }}" @if(old('bank_id'))
                                @if(old('bank_id')==$value->id) selected
                                @endif
                                @endif>{{ $value->title }} - {{ $value->interest.'%' }}</option>
                            @endforeach
                            @endif
                        </select>

                        @if(empty(old('bank_id')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('bank_id'))
                            <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('bank_id'))
                        <span class="text-danger d-block">
                           {{ $errors->first('bank_id') }}
                        </span>
                        @endif
                    </div>

                </div>
            </div>
            <h4 class="title-7"><span><strong>Final Balance Payment</strong></span></h4>
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                         <input type="text" class="form-control" id="finalPayment" readonly  name="balance"
                        value="{{ old('balance', $buyer_particular->buyerloandetail->balance ?? '')  }}">
                    </div>
                    @if(empty(old('balance')) && !empty(session()->get('myinfobuyersp')) && !$errors->has('balance'))
                        <span class="text-danger">This field is required</span>
                    @endif
                    @if ($errors->has('balance'))
                    <span class="text-danger d-block">
                        {{ $errors->first('balance') }}
                    </span>
                    @endif
                </div>
            </div>
            <h3 class="title-6"><span><strong>DIY Cars Contract Terms and Policy</strong></span></h3>
            <textarea rows="20" cols="30" class="form-control mt-20" disabled>
1. All documentation and payment transactions will be carried out by AUTOLINK HOLDINGS PTE LTD (Case Trust Accredited). It is noted that DIY Cars Pte Ltd is a wholly-owned subsidiary of Autolink Holdings Pte Ltd.

2. Any fees and levies imposed by the Land Transport Authority of Singapore (LTA) directly associated with the transfer of the vehicle stated in this agreement are to be borne by the BUYER.

3. Autolink Holdings Pte Ltd will be acting as an Escrow for all financial payments and receipts i.e., Deposit for the vehicle, balance payment to the seller and any other payments related to the Sales and Purchase for the said vehicle in this Agreement. 

4. All payments are to be paid to Autolink Holdings Pte Ltd only, otherwise, Buyer and Seller will be responsible for any financial losses due to their own actions.

5. Final payment will be made to Seller once all documentations i.e., Buyer’s loan application, Motor Vehicle insurance coverage etc. are complete and effective.

6. Autolink Holdings Pte Ltd will carry out the transfer of the vehicle as LTA’s Electronic Service Agent via the Onemotoring.com.sg platform.

7. Any finance settlement on behalf of Seller is chargeable with a service fee of 0.5% (before GST) of the outstanding amount to the Bank/Finance Institution. E.g., Finance settlement amount is $30000. Service fee = $30000 x 5% x 1.07 = $150 plus $10.50 = $160.50 (inclusive of GST)

8. In the event Seller is to make full settlement of vehicle himself/herself, handover of the vehicle can only be carried out upon clearance of Form B1. Autolink Holdings Pte Ltd will ensure that Form B1 is cleared before making the balance payment to the Seller.

9. Buyer will purchase a motor insurance policy which is valid for the purpose of the transfer of vehicle as of the date of ownership transfer. The period of insurance should be at least 1 year or until the next road tax renewal date for vehicles less than 1 year to C.O.E Expiration.

10.	In the event of a breach of this Agreement by the Seller, the Buyer will be compensated with an amount equal to twice the value of the Deposit.

11.	In the event of a breach of this Agreement by the Buyer, the Seller will keep the Deposit.

12.	In the event of an unsuccessful loan application by Buyer within the agreed period in this Agreement, this Agreement will be void and Seller is to refund the deposit to Buyer.

13.	In case of unresolved disputes relating to this Agreement, Buyer and Seller will bring forth to Small Claims Tribunal for further negotiation of claims.

14.	The Seller is to hand over the keys and any other documents i.e., Owner’s Manual, Warranty Booklet etc. belonging to the Vehicle in this Agreement.

15.	Autolink Holdings Pte Ltd is only acting as an Escrow agent for the Sales and Purchase of the vehicle in this Agreement and will not be liable for any claims under The Consumer Protection (Fair Trading) Act (CPFTA).

16.	The Seller is to preserve the condition of the vehicle in accordance with the Agreed Terms and Conditions between Buyer and Seller stipulated in this Agreement.

17.	The Buyer and Seller acknowledge that each has read and understood the terms of this Agreement and executes this Agreement with a full understanding of the Terms and Conditions in this Agreement.

18.	This Agreement constitutes supersedes all prior communications, contracts or agreements between the parties with respect to the subject matter addressed in this Agreement, whether in writing or oral.

19.	This Agreement shall be governed by the laws of Republic of Singapore.</textarea>
            <div class="captcha">
                <img class="bgimg" src="./Autolink New S&amp;P Form_files/captcha.png" alt="captcha">
            </div>
			<div class="checkbox mt-20">
				<input id="agree" type="checkbox" required>  
				<label for="agree">I acknowledge and agree to the collection, use and disclosure of my personal data, which has been provided for the purpose of creating a Sales and Purchase Agreement, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.</label>
			</div>

            <div class="output-2">
                @if ($buyer_particular)
                @else
                <button class="btn-1 minw-190" type="submit" name="saveexit" value="savee">Save and Exit <i class="fas fa-arrow-right"></i></button>
                <!-- <a href="" class="btn-1 minw-190">View your Agreement
                    <i class="fas fa-arrow-right"></i></a> -->
                <button class="btn-1 minw-190" type="submit" name="saveexit" value="submitt">Submit Agreement to Seller <i
                        class="fas fa-arrow-right"></i></button>
                @endif
            </div>
        </form>
        @endif
        @endif
        
       



    </div>
</div>
<script>
    $('form').submit(function() {
        window.onbeforeunload = null;
    });
    window.onbeforeunload = function(event) {
        return confirm("Confirm refresh");
    };
</script>

<script>
    $(function () {
        $(".seller").find("input, select, textarea").attr("disabled", true);

        // $("body").on("keyup", "input[name='loan_amount']", function () {
        //     var loan_amount = $(this).val();
        //     var balance_payment = '{{ $seller_particular->spcontract->balance_payment }}';
        //     var balance = parseFloat(balance_payment - loan_amount).toFixed(2);
        //     $("input[name='balance']").val(balance);
        //     $("input[name='balance']").parent(".inrow").addClass("not-empty");
        // });

        var checked = [];
        var arr = $.map($('input:checkbox:checked'), function (e, i) {
            checked.push('<li>' + e.value + '</li>');
        });
        $('#termsdescbuyer').html(checked);

        $('.positive-integer').numeric(
            { negative: false }
        );

        var canvas = document.querySelector("canvas");


        var signaturePad = new SignaturePad(canvas, {
            onEnd: function () {
                $("input[name='signature']").val(signaturePad.toDataURL("image/jpeg"));
            },
            backgroundColor: "white",
        });

        $("form").on("submit", function () {
            $(this).find("button").attr("disabled", true);
        });







    });

    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
            event.preventDefault();
            return false;
            }
        });
    });

    $("input[name='loan']").on("change", function () {
        var loan = $("input[name='loan']:checked").val();
        let balancePayment = $('#balancePayment').val();
        // $("#loanperiod").addClass("d-none");
        // $("input[name='year'], input[name='month']").attr("readonly", true);
        if (loan == 2) {
            $("#noloanselected").addClass("d-none");
            $("#loan_amount_buyer").val('No Loan Required');
            $("#loan_amount_buyer").prop('readonly', true);
            $("#bank_id_buyer option[value='']").attr('selected','selected');
            $("#bank_id_buyer").val('');
            $("#bank_id_buyer").attr("disabled", true);
            
            $("#finalPayment").closest("div").addClass('not-empty');
            $('#finalPayment').val(balancePayment);
            $('#finalPayment').attr("readonly", true);
        }
        if (loan == 1) {
            $("#noloanselected").removeClass("d-none");
            $("#loan_amount_buyer").val('');
            $("#loan_amount_buyer").prop('readonly', false);
            $("#bank_id_buyer").attr("disabled", false);
            $('#finalPayment').attr("readonly", true);
            $('#finalPayment').val('');
        }

    });

    $("input[name='tenor']").on("change", function () {
        var tenor = $("input[name='tenor']:checked").val();
        // $("#loanperiod").addClass("d-none");
        // $("input[name='year'], input[name='month']").attr("readonly", true);
        if (tenor == 2) {
            $("#loanPeriodsMonths").removeClass("d-none");
        }
        if (tenor == 1) {
            $("#loanPeriodsMonths").addClass("d-none");
        }

    });

    function calculateDownPayment() {
        let agreedPrice = $('#agreedPrice').val();
        let depositAmount = $('#depositAmount').val();
        let downPayment = 0;
        if (agreedPrice != '' && depositAmount != '') {
            downPayment = agreedPrice - depositAmount;
            $("#balancePayment").closest("div").addClass('not-empty');
            $('#balancePayment').val(downPayment);
            $('#balancePayment').attr("readonly", true);
        }
    }

    function finalBalance() {
        let agreedPrice = $('#agreedPrice').val();
        agreedPrice = agreedPrice.replace(/,/g, '');
        let depositAmount = $('#depositAmount').val();
        depositAmount = depositAmount.replace(/,/g, '');
        // let balancePayment = $('#balancePayment').val();
        let loan_amount_buyer = $('#loan_amount_buyer').val();
        loan_amount_buyer = loan_amount_buyer.replace(/,/g, '');
        let allowedLoanAmount = agreedPrice * 0.7;
        let finalPayment = 0;
        agreedPrice = parseInt(agreedPrice);
        depositAmount = parseInt(depositAmount);
        loan_amount_buyer = parseInt(loan_amount_buyer);
        if(loan_amount_buyer > allowedLoanAmount ){
            allowedLoanAmount = parseInt(allowedLoanAmount);
            finalPayment = agreedPrice - depositAmount - allowedLoanAmount;
            finalPayment = finalPayment.toLocaleString('en-EN', 3)
            $('#loan_amount_buyer').val(allowedLoanAmount);
            alert('Loan amount should not exceed 70% of Agreed price');
        }else{
            finalPayment = agreedPrice - depositAmount - loan_amount_buyer;
            finalPayment = finalPayment.toLocaleString('en-EN', 3)
        }
        if (agreedPrice != '' && loan_amount_buyer != '') {
            // loan_amount_buyer = loan_amount_buyer.replace(/,/g, '');
            // agreedPrice = parseInt(agreedPrice);
            // depositAmount = parseInt(depositAmount);
            // loan_amount_buyer = parseInt(loan_amount_buyer);
            // finalPayment = agreedPrice - depositAmount - loan_amount_buyer;
            // finalPayment = finalPayment.toLocaleString('en-EN', 3)
            console.log(finalPayment);
            $("#finalPayment").closest("div").addClass('not-empty');
            $('#finalPayment').val(finalPayment);
            $('#finalPayment').attr("readonly", true);
        }
    }

    $(function () {
        $("#loan_amount_buyer").on('keyup', function () {
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

    function addotherterms() {
        let otherterms = $('#otherdesc').val();
        //     if (otherterms != '') {
        //         $('<input type="checkbox" name="terms[]" checked value="' + otherterms + '">').appendTo('#othertermsextra');
        //         $('#otherdesc').val('');
        //         checkcheckbox(otherterms);
        //     }
        if(otherterms != ''){
            $('<div class="checkbox"><input type="checkbox" name="terms[]" checked value="'+otherterms+'" onchange="checkcheckbox();"><label for="extra">'+otherterms+'</label></div><br>').appendTo('#othertermsextra');
            $('<input type="hidden" name="termsadded[]" value="'+otherterms+'">').appendTo('#termsadded');
            $('#otherdesc').val('');
            checkcheckbox();
        }
            

    }

    function checkcheckbox(abc) {
        var checked = [];
        var arr = $.map($('input:checkbox:checked'), function (e, i) {
            // checked.push('<li>' + e.value + '</li>');
            if(e.id == ''){
                // checked.push('<li id="inputFormRow">'+e.value+'<button id="removeRow" type="button" class="btn btn-danger">Remove</button></li>');
                checked.push('<li id="inputFormRow">'+e.value+'</li>');
            }else{
                if(e.value == 'on'){

                }else{
                    checked.push('<li id="inputFormRow">'+e.value+'</li>');
                }
            }
        });
        $('#termsdescbuyer').html(checked);
    }

    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
        let removeval = $(this).closest('#inputFormRow').text().replace("Remove", "");
        var arr = $.map($('input:checkbox:checked'), function(e, i) {
            $('input:checkbox[value='+removeval+']').prop('checked',false);
            var vall = e.value;
            if(vall == removeval){
                $('input:checkbox[value='+removeval+']').prop('checked',false);
            }
        });
        $('input:checkbox[value='+removeval+']').prop('checked',false);
        checkcheckbox(otherterms);
    });


    function callAuthoriseApi() {
        let authApiUrl = 'https://api.myinfo.gov.sg/com/v3/authorise';
        let clientId = 'PROD-200501881C-AUTOLINK-BUYERSALESPURCH';
        let redirectUrl = 'https://www.diycars.com/buyer-sales-purchase/callback';
        let attributes = 'uinfin,name,sex,mobileno,email,regadd';
        let purpose = 'state the purpose of requesting the data. This will be shown to the Entity when requesting for their consent';
        let state = 'D43IoH6a64FuAujEgd5Hq29pfcydnAIFvouQ9rVt1642739624';
        var authoriseUrl = authApiUrl +
            "?client_id=" + clientId +
            "&attributes=" + attributes +
            "&purpose=" + purpose +
            "&state=" + state +
            "&redirect_uri=" + redirectUrl;

        window.location = authoriseUrl;
    }
</script>
@endsection