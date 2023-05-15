@extends('layouts.app')

@section('content')
<div class="main-wrap" style="padding-bottom: 172px; padding-top: 79.7969px;">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
        @include('inc.breadcrumb')
        @include('inc.messages')
        <div class="note-2">
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
        </div>
        @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif


        <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
        <h3 class="title-6"><span><strong>Seller's Particular</strong></span></h3>
        <div class="row seller">
            <div class="col-xl-6">
                <div class="inrow">
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
            <div class="col-xl-2 col-md-4">
                <div class="inrow">
                    <label>NRIC/FIN</label>
                    <input type="text" class="form-control" name="nric" value="{{ $seller_particular->nric ?? '' }}"
                        maxlength="4" minlength="4">
                </div>
                @if ($errors->has('nric'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('nric') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="inrow">
                    <label>UEN</label>
                    <input type="text" class="form-control" name="uen" value="{{ $seller_particular->uen ?? '' }}"
                        maxlength="4" minlength="4">
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="inrow">
                    <label>Passport</label>
                    <input type="text" class="form-control" name="passport"
                        value="{{ $seller_particular->passport ?? '' }}" maxlength="4" minlength="4">
                </div>
            </div>
        </div>
        <div class="row seller">
            <div class="col-xl-3 col-lg-5 mt-20">
                <div class="dropdown bootstrap-select">
                    <label>Country</label>
                    <select class="selectpicker" name="country_of_residence" tabindex="-98">
                        @if(country())
                        @foreach (country() as $item)
                        <option value="{{ $item->nicename }}" @if(old('country_of_residence')==$item->nicename)
                            selected @elseif($item->nicename=='Singapore') selected @endif>{{ $item->nicename }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                    <!-- <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button"
                            title="Nationality">
                            <div class="filter-option">
                                <div class="filter-option-inner">
                                    <div class="filter-option-inner-inner">Nationality</div>
                                </div>
                            </div>
                        </button> -->
                    <div class="dropdown-menu " role="combobox">
                        <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                            <ul class="dropdown-menu inner show"></ul>
                        </div>
                    </div>
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
                                <strong>{{ $errors->first('seller_country_code') }}</strong>
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
                            <strong>{{ $errors->first('seller_mobile') }}</strong>
                        </span>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
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
        <div class="row seller">
            <div class="col-md-9">
                <div class="inrow empty">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address"
                        value="{{ $seller_particular->address ?? '' }}">
                </div>
                @if ($errors->has('address'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-3 sp-col">
                <div class="inrow empty">
                    <label>Postal Code</label>
                    <input type="text" class="form-control" name="postal_code"
                        value="{{ $seller_particular->postal_code ?? '' }}">
                </div>
            </div>
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
        </div>
        <div class="row seller">
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
                    <label>Open Market Value</label>
                    <input type="text" class="form-control" name="open_market_value"
                        value="{{ $seller_particular->vehicleparticular->open_market_value ?? '' }}">
                </div>
                @if ($errors->has('open_market_value'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('open_market_value') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow date-wrap datepicker-wrap empty">
                    <label>Original Registration Date</label>
                    <input type="text" class="form-control" name="registration_date"
                        value="{{ $seller_particular->vehicleparticular->registration_date ?? '' }}">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                @if ($errors->has('registration_date'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('registration_date') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row seller">
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
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Actual ARF Paid</label>
                    <input type="text" class="form-control" name="arf_paid"
                        value="{{ $seller_particular->vehicleparticular->arf_paid ?? '' }}">
                </div>
                @if ($errors->has('arf_paid'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('arf_paid') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="inrow date-wrap datepicker-wrap empty">
                    <label>COE Expiry Date</label>
                    <input type="text" class="form-control" name="coe_expiry_date"
                        value="{{ $seller_particular->vehicleparticular->coe_expiry_date ?? '' }}">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                @if ($errors->has('coe_expiry_date'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('coe_expiry_date') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row seller">
            <div class="col-lg-4">
                <div class="inrow empty">
                    <label>Engine Capacity (CC)(Ex: 1794 cc)</label>
                    <input type="text" class="form-control" name="engine_output"
                        value="{{ $seller_particular->vehicleparticular->engine_output ?? '' }}">
                </div>
                @if ($errors->has('engine_output'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('engine_output') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-4">
                    <div class="inrow">
                        <label>Vehicle Type (Normal/OPC)</label>
                        <input type="text" class="form-control" name="vehicle_type"
                            value="{{ $seller_particular->vehicleparticular->vehicle_type ?? '' }}" />
                    </div>
                    @if ($errors->has('vehicle_type'))
                    <span class="text-danger d-block">
                        <strong>{{ $errors->first('vehicle_type') }}</strong>
                    </span>
                    @endif
                    <!-- <div class="dropdown bootstrap-select"><select class="selectpicker" tabindex="-98">
                                <option>Vehicle Type</option>
                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                                role="button" title="Vehicle Type">
                                <div class="filter-option">
                                    <div class="filter-option-inner">
                                        <div class="filter-option-inner-inner">Vehicle Type</div>
                                    </div>
                                </div>
                            </button>
                            <div class="dropdown-menu " role="combobox">
                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                    <ul class="dropdown-menu inner show"></ul>
                                </div>
                            </div>
                        </div> -->
            </div>
        </div>
        <div class="grtype mt-20 seller">
            <h3 class="title-6 item"><span><strong>Is this an used Import: </strong></span></h3>
            <div class="check-inline item">
                <div class="radio">
                    <input type="radio" id="yes" name="use" value="yes" @if($seller_particular->usecar == 'yes') checked
                    @endif>
                    <label for="yes">Yes</label>
                </div>
                <div class="radio">
                    <input type="radio" name="use" id="no" value="no" @if($seller_particular->usecar == 'no') checked
                    @endif>
                    <label for="no">No</label>
                </div>
            </div>
        </div>
        <div class="row seller">
            <div class="col-lg-4">
                <div class="mt-20">
                    <div class="inrow date-wrap datepicker-wrap">
                        <label>First Registration Date</label>
                        <input type="text" class="form-control" name="first_registration_Date"
                            value="{{ $seller_particular->first_registration_Date ?? '' }}" />
                    </div>
                    <!-- <div class="dropdown bootstrap-select"><select class="selectpicker" tabindex="-98">
                                <option>First Registration Date</option>
                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                                role="button" title="First Registration Date">
                                <div class="filter-option">
                                    <div class="filter-option-inner">
                                        <div class="filter-option-inner-inner">First Registration Date</div>
                                    </div>
                                </div>
                            </button>
                            <div class="dropdown-menu " role="combobox">
                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                    <ul class="dropdown-menu inner show"></ul>
                                </div>
                            </div>
                        </div> -->
                </div>
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
        <div class="row sp-col-10 seller">
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="loan" type="checkbox" name="terms[]"
                        value="Subject to Loan Approval Within 7 Working Days." @if(in_array('Subject to Loan Approval Within 7 Working Days.', $terms)) checked @endif>
                    <label for="loan">Subject to Loan Approval Within 7 Working Days.</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="retention" type="checkbox" name="terms[]" value="Number Retention (Vehicle Will Be Replaced With a Random Assigned Vehicle
                        No. by LTA)." @if(in_array('Number Retention (Vehicle Will Be Replaced With a Random Assigned Vehicle
                        No. by LTA).', $terms)) checked @endif>
                    <label for="retention">Number Retention (Vehicle Will Be Replaced With a Random Assigned Vehicle
                        No. by LTA).</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="sold" type="checkbox" name="terms[]" value="Vehicle Sold As It Is." @if(in_array('Vehicle Sold As It Is.', $terms)) checked @endif>
                    <label for="sold">Vehicle Sold As It Is.</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="noinspection" name="terms[]" type="checkbox" value="No Inspection Required." @if(in_array('No Inspection Required.', $terms)) checked @endif>
                    <label for="noinspection">No Inspection Required.</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="spare" type="checkbox" name="terms[]"
                        value="No Spare Key. <br>(Buyer to Duplicate at Own Expense)" @if(in_array('No Spare Key. <br>(Buyer to Duplicate at Own Expense)', $terms)) checked @endif>
                    <label for="spare">No Spare Key. <br>(Buyer to Duplicate at Own Expense)</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sp-col mt-20">
                <div class="checkbox">
                    <input id="owners" type="checkbox" name="terms[]" value="No Owners Manual." @if(in_array('No Owners Manual.', $terms)) checked @endif>
                    <label for="owners">No Owners Manual.</label>
                </div>
            </div>
            <div class="col-lg-8 sp-col mt-20">
                <div class="row align-items-center sp-col-10 break-575 typedate">
                    <div class="col-auto sp-col">
                        <div class="checkbox">
                            <input id="sale" name="terms[]" type="checkbox" value="Subject to Completion of Sale by:" @if(in_array('Subject to Completion of Sale by:', $terms)) checked @endif>
                            <label for="sale">Subject to Completion of Sale by:</label>
                        </div>
                    </div>
                    <div class="col sp-col">
                        <div class="date-wrap datepicker-wrap maxw-180 empty">
                            <input type="text" class="form-control" name="termsdate" placeholder="24 Jun 2021" value="{{ $seller_particular->spcontract->termsdate }}">
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
        </div>
        <div class="note-3">
            <ol id="termsdesc">
                @if(!empty($seller_particular->spcontract->other_terms))
                <li>{{ $seller_particular->spcontract->other_terms ?? '' }}</li>
                @endif
                <!-- <li>Subject to Loan Approval Within 7 Working Days.</li>
                    <li>Number Retention (Vehicle Will Be Replaced with a Random Assigned Vehicle No. by LTA).</li>
                    <li>Delivery date: 24 Jun 2021.</li> -->
            </ol>
        </div>
        <div class="row seller">
            <div class="col-lg-3 col-sm-6">
                <h4 class="title-7"><span><strong>Deposit</strong></span></h4>
                <div class="input-group mt-20 grinput empty">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" name="deposit"
                        value="{{ $seller_particular->spcontract->deposit ?? '' }}" placeholder="">
                </div>
                @if ($errors->has('deposit'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('deposit') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-3 col-sm-6">
                <h4 class="title-7"><span><strong>Selling Price</strong></span></h4>
                <div class="input-group mt-20 grinput empty">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" name="selling_price"
                        value="{{ $seller_particular->spcontract->selling_price ?? '' }}">
                </div>
                @if ($errors->has('selling_price'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('selling_price') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-6">
                <h4 class="title-7"><span><strong>Balance Payment (Before Loan Amount)</strong></span></h4>
                <div class="input-group mt-20 grinput empty">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" name="balance_payment"
                        value="{{ $seller_particular->spcontract->balance_payment ?? '' }}" placeholder="" readonly>
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
                        <div class="mt-20">
                            <div class="inrow">
                                <label>Buyer's Country Code</label>
                                <input type="text" name="country_code" class="form-control"
                                    value="{{ $seller_particular->country_code ?? '' }}">
                            </div>
                            @if ($errors->has('country_code'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('country_code') }}</strong>
                            </span>
                            @endif
                            <!-- <div class="dropdown bootstrap-select"><select class="selectpicker" tabindex="-98">
                                        <option>Country Code</option>
                                    </select><button type="button" class="btn dropdown-toggle btn-light"
                                        data-toggle="dropdown" role="button" title="Country Code">
                                        <div class="filter-option">
                                            <div class="filter-option-inner">
                                                <div class="filter-option-inner-inner">Country Code</div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu " role="combobox">
                                        <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                            <ul class="dropdown-menu inner show"></ul>
                                        </div>
                                    </div>
                                </div> -->
                        </div>
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
        <!-- <div class="output-2">
            <button class="btn-1 minw-190" type="submit">Save and Exit <i class="fas fa-arrow-right"></i></button>
            <a href="https://verzview.com/html/autolink-new/forms.html#" class="btn-1 minw-190">View your Agreement
                <i class="fas fa-arrow-right"></i></a>
            <button class="btn-1 minw-190" type="submit">Sign and Submit Agreement to Seller <i
                    class="fas fa-arrow-right"></i></button>
        </div> -->
        <hr class="mt-50 mb-50">

        @if($buyer_particular)
        <div id="buyer">
            <div class="note-2">
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
            </div>
            <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
            <h3 class="title-6"><span><strong>Buyer’s Particulars</strong></span></h3>
            <div class="row">
                <div class="col-xl-6">
                    <div class="inrow empty">
                        <label>Name</label>
                        <input type="text" class="form-control" name="buyer_name"
                            value="{{ $buyer_particular->buyer_name ?? '' }}">
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>NRIC/FIN</label>
                        <input type="text" class="form-control" name="nric" value="{{ $buyer_particular->nric ?? '' }}">
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>UEN</label>
                        <input type="text" class="form-control" name="uen" value="{{ $buyer_particular->uen ?? '' }}">
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>Passport</label>
                        <input type="text" class="form-control" name="passport"
                            value="{{ $buyer_particular->passport ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-5 mt-20">
                    <div class="dropdown bootstrap-select">
                        <select class="selectpicker" name="country_of_residence" tabindex="-98">
                            @if(country())
                            @foreach (country() as $item)
                            <option value="{{ $item->nicename }}" @if(old('country_of_residence')==$item->nicename)
                                selected @elseif($item->nicename=='Singapore') selected @endif>{{ $item->nicename }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        <!-- <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                            role="button" title="Nationality">
                            <div class="filter-option">
                                <div class="filter-option-inner">
                                    <div class="filter-option-inner-inner">Nationality</div>
                                </div>
                            </div>
                        </button> -->
                        <div class="dropdown-menu " role="combobox">
                            <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                <ul class="dropdown-menu inner show"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-7">
                    <div class="row sp-col-10 break-425">
                        <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                            <div class="mt-20">
                                <div class="dropdown bootstrap-select">
                                    <div class="inrow empty">
                                        <label>Country Code</label>
                                        <input type="text" name="country_code" class="form-control"
                                            value="{{ $buyer_particular->country_code ?? '' }}">
                                    </div>
                                    @if ($errors->has('country_code'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country_code') }}</strong>
                                    </span>
                                    @endif
                                    <!-- <select class="selectpicker" tabindex="-98">
                                        <option>Country Code</option>
                                    </select><button type="button" class="btn dropdown-toggle btn-light"
                                        data-toggle="dropdown" role="button" title="Country Code">
                                        <div class="filter-option">
                                            <div class="filter-option-inner">
                                                <div class="filter-option-inner-inner">Country Code</div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu " role="combobox">
                                        <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                            <ul class="dropdown-menu inner show"></ul>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                            <div class="inrow empty">
                                <label>Contact No.</label>
                                <input type="text" class="form-control" name="phone"
                                    value="{{ $buyer_particular->phone ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="inrow empty">
                        <label>Email Address (Ex: janedoe@gmail.com)</label>
                        <input type="text" class="form-control" name="email"
                            value="{{ $buyer_particular->user->email ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="inrow empty">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ $buyer_particular->user->address ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3 sp-col">
                    <div class="inrow empty">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" name="postal_code"
                            value="{{ $buyer_particular->postal_code ?? '' }}">
                    </div>
                </div>
            </div>
            @php 
        $terms = json_decode($buyer_particular->buyerpaymenttermcondition->terms_and_condition);
        if(sizeof($terms) > 0){
            $terms = $terms;
        }else{
            $terms = [];
        }
        @endphp
            <h3 class="title-6"><span><strong>Terms and Conditions</strong></span></h3>
            <div class="row sp-col-10">
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="inspection" type="checkbox" @if(in_array('Subject to STA Inspection. (Minimum Grade B, inspection fee borne by
                        Buyer)', $terms)) checked @endif>
                        <label for="inspection">Subject to STA Inspection. (Minimum Grade B, inspection fee borne by
                            Buyer)</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="subject" type="checkbox" @if(in_array('Subject to loan approval within 7 working days. Otherwise, deposit will be
                        fully refunded.', $terms)) checked @endif>
                        <label for="subject">Subject to loan approval within 7 working days. Otherwise, deposit will be
                            fully refunded.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="accident" type="checkbox" @if(in_array('Accident Free (Chassis).', $terms)) checked @endif>
                        <label for="accident">Accident Free (Chassis).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="workshop" type="checkbox" @if(in_array('Subject to inspection by Buyer’s appointed workshop. (All fees borne by
                        Buyer).', $terms)) checked @endif>
                        <label for="workshop">Subject to inspection by Buyer’s appointed workshop. (All fees borne by
                            Buyer).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="vehicle" type="checkbox" @if(in_array('No illegal modification of vehicle.', $terms)) checked @endif>
                        <label for="vehicle">No illegal modification of vehicle.</label>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="key" type="checkbox">
                        <label for="key">2 Keys</label>
                    </div>
                </div> -->
                <div class="col-lg-12 sp-col mt-20">
                    <div class="row align-items-center sp-col-10">
                        <div class="col-auto sp-col">
                            <div class="checkbox">
                                <input id="other" type="checkbox">
                                <label for="other">Other:</label>
                            </div>
                        </div>
                        <div class="col sp-col empty">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="note-3">
                <ol>
                    {{$buyer_particular->buyerpaymenttermcondition->otherterms ?? ''}}
                </ol>
            </div>
            <h3 class="title-6"><span><strong>Loan Requirements</strong></span></h3>
            <div class="check-inline mt-20">
                <div class="radio">
                    <input type="radio" id="loan2" name="loan" value="yes" @if($buyer_particular->loan == 'yes') checked
                    @endif>
                    <label for="loan2">Loan</label>
                </div>
                <div class="radio">
                    <input type="radio" id="noloan" name="loan" value="no" @if($buyer_particular->loan == 'no') checked
                    @endif>
                    <label for="noloan">No Loan</label>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-5">
                    <div class="check-inline">
                        <div class="radio">
                            <input type="radio" id="tenor" name="tenor" value="maximum_tenor"
                                @if($buyer_particular->tenor == 'maximum_tenor') checked @endif>
                            <label for="tenor">Maximum Tenor</label>
                        </div>
                        <div class="radio">
                            <input type="radio" id="months" name="tenor" name="years_month" @if($buyer_particular->tenor
                            == 'years_month') checked @endif>
                            <label for="months">No. of Years and Months</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row break-425">
                        <div class="col-6 sp-col">
                            <div class="inrow mt-0 empty">
                                <label>Loan Period (Years)</label>
                                <input type="text" class="form-control" name="loan_period"
                                    value="{{ $buyer_particular->loan_period ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 sp-col mt-425-10">
                            <div class="inrow mt-0 empty">
                                <label>Loan Period (Months)</label>
                                <input type="text" class="form-control" name="loan_months"
                                    value="{{ $buyer_particular->loan_months ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Agreed Price</strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$100,000.00" name="agreed_price"
                        value="{{ $buyer_particular->agreed_price ?? '' }}">
                </div>
            </div>
            <h4 class="title-7"><span><strong>Deposit</strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20">
                    <div class="notepp type empty">
                        <input type="text" class="form-control" placeholder="$5,000.00" name="deposit_amount"
                            value="{{ $buyer_particular->deposit_amount ?? '' }}">
                        <div class="notepin">
                            Payment to be made to Autolink Holdings Pte Ltd via PayNow/Internet Bank Transfer after
                            seller signed on this agreement.
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Balance Payment <em>(Before Loan Amount)</em></strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$95,000.00" name="balance_payment"
                        value="{{ $buyer_particular->balance_payment ?? '' }}">
                </div>
            </div>
            <h4 class="title-7"><span><strong>Less: <em>Required Loan Amount</em></strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$70,000.00" name="loan_amount"
                        value="{{ $buyer_particular->buyerloandetail->loan_amount ?? '' }}">
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="dropdown bootstrap-select">
                        <div class="inrow">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank"
                                value="{{ $buyer_particular->buyerloandetail->bank ?? '' }}" />
                        </div>

                        <!-- <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                            role="button" title="Bank and Interest Rate">
                            <div class="filter-option">
                                <div class="filter-option-inner">
                                    <div class="filter-option-inner-inner">Bank and Interest Rate</div>
                                </div>
                            </div>
                        </button> -->
                        <div class="dropdown-menu " role="combobox">
                            <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                <ul class="dropdown-menu inner show"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="dropdown bootstrap-select">

                        <div class="inrow">
                            <label>Interest Rate</label>
                            <input type="text" class="form-control positive-integer" name="interest"
                                value="{{ $buyer_particular->buyerloandetail->interest ?? '' }}" />
                        </div>
                        <!-- <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                            role="button" title="Bank and Interest Rate">
                            <div class="filter-option">
                                <div class="filter-option-inner">
                                    <div class="filter-option-inner-inner">Bank and Interest Rate</div>
                                </div>
                            </div>
                        </button> -->
                        <div class="dropdown-menu " role="combobox">
                            <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                <ul class="dropdown-menu inner show"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Final Balance Payment</strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$25,000.00" name="balance"
                        value="{{ $buyer_particular->buyerloandetail->balance ?? '' }}">
                </div>
            </div>
            <h3 class="title-6"><span><strong>DIY Cars Contract Terms and Policy</strong></span></h3>
            <textarea rows="6" cols="30" class="form-control mt-20"></textarea>
            <div class="captcha">
                <img class="bgimg" src="./Autolink New S&amp;P Form_files/captcha.png" alt="captcha">
            </div>
            <!-- <div class="output-2">
                <button class="btn-1 minw-190" type="submit">Save and Exit <i class="fas fa-arrow-right"></i></button>
                <a href="" class="btn-1 minw-190">View your Agreement
                    <i class="fas fa-arrow-right"></i></a>
                <button class="btn-1 minw-190" type="submit">Sign and Submit Agreement to Seller <i
                        class="fas fa-arrow-right"></i></button>
            </div> -->
        </div>
        <script>
            $(function () {
                $("#buyer").find("input, select, textarea").attr("disabled", true);
            });
        </script>
        @else
        @if(Auth::user()->id!=$seller_particular->user_id)
        <form action="{{ url('forms/form-details/buyer/'.$reference.'/'.$id) }}" class="form-ani" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if(!empty($carId))
            <input type="hidden" name="carId" value="{{ $carId }}">
            @endif
            <div class="note-2">
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
            </div>
            <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
            <h3 class="title-6"><span><strong>Buyer’s Particulars</strong></span></h3>
            <div class="row">
                <div class="col-xl-6">
                    <div class="inrow empty">
                        <label>Name</label>
                        <input type="text" class="form-control" name="buyer_name" readonly
                            value="{{ Auth::user()->name ?? '' }}">
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>NRIC/FIN</label>
                        <input type="text" class="form-control" name="nric" value="{{ $buyer_particular->nric ?? '' }}">
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>UEN</label>
                        <input type="text" class="form-control" name="uen" value="{{ $buyer_particular->uen ?? '' }}">
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>Passport</label>
                        <input type="text" class="form-control" name="passport"
                            value="{{ $buyer_particular->passport ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-5 mt-20">
                    <div class="dropdown bootstrap-select">
                        <select class="selectpicker" name="country_of_residence" tabindex="-98">
                            @if(country())
                            @foreach (country() as $item)
                            <option value="{{ $item->nicename }}" @if(old('country_of_residence')==$item->nicename)
                                selected @elseif($item->nicename=='Singapore') selected @endif>{{ $item->nicename }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        <!-- <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                            role="button" title="Nationality">
                            <div class="filter-option">
                                <div class="filter-option-inner">
                                    <div class="filter-option-inner-inner">Nationality</div>
                                </div>
                            </div>
                        </button> -->
                        <div class="dropdown-menu " role="combobox">
                            <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                <ul class="dropdown-menu inner show"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-7">
                    <div class="row sp-col-10 break-425">
                        <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                            <div class="mt-20">
                                <div class="dropdown bootstrap-select">
                                    <div class="inrow empty">
                                        <label>Country Code</label>
                                        <input type="text" name="country_code" class="form-control"
                                            value="{{ $buyer_particular->country_code ?? '' }}">
                                    </div>
                                    @if ($errors->has('country_code'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country_code') }}</strong>
                                    </span>
                                    @endif
                                    <!-- <select class="selectpicker" tabindex="-98">
                                        <option>Country Code</option>
                                    </select><button type="button" class="btn dropdown-toggle btn-light"
                                        data-toggle="dropdown" role="button" title="Country Code">
                                        <div class="filter-option">
                                            <div class="filter-option-inner">
                                                <div class="filter-option-inner-inner">Country Code</div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu " role="combobox">
                                        <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                            <ul class="dropdown-menu inner show"></ul>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                            <div class="inrow empty">
                                <label>Contact No.</label>
                                <input type="text" class="form-control" name="phone" readonly
                                    value="{{ Auth::user()->mobile ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="inrow empty">
                        <label>Email Address (Ex: janedoe@gmail.com)</label>
                        <input type="text" class="form-control" name="email" readonly
                            value="{{ Auth::user()->email ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="inrow empty">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ Auth::user()->address ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3 sp-col">
                    <div class="inrow empty">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" name="postal_code"
                            value="{{ $buyer_particular->postal_code ?? '' }}">
                    </div>
                </div>
            </div>
            <h3 class="title-6"><span><strong>Terms and Conditions</strong></span></h3>
            <div class="row sp-col-10">
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="inspection" type="checkbox" name="terms[]" value="Subject to STA Inspection. (Minimum Grade B, inspection fee borne by
                        Buyer)">
                        <label for="inspection">Subject to STA Inspection. (Minimum Grade B, inspection fee borne by
                            Buyer)</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="subject" type="checkbox"  name="terms[]" value="Subject to loan approval within 7 working days. Otherwise, deposit will be
                        fully refunded.">
                        <label for="subject">Subject to loan approval within 7 working days. Otherwise, deposit will be
                            fully refunded.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="accident" type="checkbox"  name="terms[]" value="Accident Free (Chassis).">
                        <label for="accident">Accident Free (Chassis).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="workshop" type="checkbox"  name="terms[]" value="Subject to inspection by Buyer’s appointed workshop. (All fees borne by
                        Buyer).">
                        <label for="workshop">Subject to inspection by Buyer’s appointed workshop. (All fees borne by
                            Buyer).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="vehicle" type="checkbox"  name="terms[]" value="No illegal modification of vehicle.">
                        <label for="vehicle">No illegal modification of vehicle.</label>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="key" type="checkbox">
                        <label for="key">2 Keys</label>
                    </div>
                </div> -->
                <div class="col-lg-12 sp-col mt-20">
                    <div class="row align-items-center sp-col-10">
                        <div class="col-auto sp-col">
                            <div class="checkbox">
                                <input id="other" type="checkbox"  value="">
                                <label for="other">Other:</label>
                            </div>
                        </div>
                        <div class="col sp-col empty">
                            <input type="text" class="form-control" name="otherterms">
                        </div>
                    </div>
                </div>
            </div>
            <div class="note-3">
                <ol>
                    <!-- <li>Subject to STA Inspection. (Minimum Grade B, inspection fee borne by Buyer)</li>
                    <li>Subject to loan approval within 7 working days. Otherwise, deposit will be fully refunded.</li>
                    <li>Accident Free (Chassis).</li>
                    <li>No illegal modification of vehicle.</li> -->
                </ol>
            </div>
            <h3 class="title-6"><span><strong>Loan Requirements</strong></span></h3>
            <div class="check-inline mt-20">
                <div class="radio">
                    <input type="radio" id="loan2" name="loan" value="yes" >
                    <label for="loan2">Loan</label>
                </div>
                <div class="radio">
                    <input type="radio" id="noloan" name="loan" value="no" >
                    <label for="noloan">No Loan</label>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-5">
                    <div class="check-inline">
                        <div class="radio">
                            <input type="radio" id="tenor" name="tenor" value="maximum_tenor"
                                >
                            <label for="tenor">Maximum Tenor</label>
                        </div>
                        <div class="radio">
                            <input type="radio" id="months" name="tenor" name="years_month" >
                            <label for="months">No. of Years and Months</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row break-425">
                        <div class="col-6 sp-col">
                            <div class="inrow mt-0 empty">
                                <label>Loan Period (Years)</label>
                                <input type="text" class="form-control" name="loan_period"
                                    value="{{ $buyer_particular->loan_period ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 sp-col mt-425-10">
                            <div class="inrow mt-0 empty">
                                <label>Loan Period (Months)</label>
                                <input type="text" class="form-control" name="loan_months"
                                    value="{{ $buyer_particular->loan_months ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Agreed Price</strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$100,000.00" name="agreed_price"
                        value="{{ $buyer_particular->agreed_price ?? '' }}">
                </div>
            </div>
            <h4 class="title-7"><span><strong>Deposit</strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20">
                    <div class="notepp type empty">
                        <input type="text" class="form-control" placeholder="$5,000.00" name="deposit_amount"
                            value="{{ $buyer_particular->deposit_amount ?? '' }}">
                        <div class="notepin">
                            Payment to be made to Autolink Holdings Pte Ltd via PayNow/Internet Bank Transfer after
                            seller signed on this agreement.
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Balance Payment <em>(Before Loan Amount)</em></strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$95,000.00" name="balance_payment"
                        value="{{ $buyer_particular->balance_payment ?? '' }}">
                </div>
            </div>
            <h4 class="title-7"><span><strong>Less: <em>Required Loan Amount</em></strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$70,000.00" name="loan_amount"
                        value="{{ $buyer_particular->buyerloandetail->loan_amount ?? '' }}">
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="dropdown bootstrap-select">
                        <div class="inrow">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank"
                                value="{{ $buyer_particular->buyerloandetail->bank ?? '' }}" />
                        </div>

                        <!-- <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                            role="button" title="Bank and Interest Rate">
                            <div class="filter-option">
                                <div class="filter-option-inner">
                                    <div class="filter-option-inner-inner">Bank and Interest Rate</div>
                                </div>
                            </div>
                        </button> -->
                        <div class="dropdown-menu " role="combobox">
                            <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                <ul class="dropdown-menu inner show"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="dropdown bootstrap-select">

                        <div class="inrow">
                            <label>Interest Rate</label>
                            <input type="text" class="form-control positive-integer" name="interest"
                                value="{{ $buyer_particular->buyerloandetail->interest ?? '' }}" />
                        </div>
                        <!-- <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown"
                            role="button" title="Bank and Interest Rate">
                            <div class="filter-option">
                                <div class="filter-option-inner">
                                    <div class="filter-option-inner-inner">Bank and Interest Rate</div>
                                </div>
                            </div>
                        </button> -->
                        <div class="dropdown-menu " role="combobox">
                            <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                <ul class="dropdown-menu inner show"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="title-7"><span><strong>Final Balance Payment</strong></span></h4>
            <div class="row">
                <div class="col-lg-4 mt-20 empty">
                    <input type="text" class="form-control" placeholder="$25,000.00" name="balance"
                        value="{{ $buyer_particular->buyerloandetail->balance ?? '' }}">
                </div>
            </div>
            <h3 class="title-6"><span><strong>DIY Cars Contract Terms and Policy</strong></span></h3>
            <textarea rows="6" cols="30" class="form-control mt-20"></textarea>
            <div class="captcha">
                <img class="bgimg" src="./Autolink New S&amp;P Form_files/captcha.png" alt="captcha">
            </div>
            <div class="output-2">
                @if ($buyer_particular)
                @else
                <button class="btn-1 minw-190" type="submit">Save and Exit <i class="fas fa-arrow-right"></i></button>
                <!-- <a href="" class="btn-1 minw-190">View your Agreement
                    <i class="fas fa-arrow-right"></i></a>
                <button class="btn-1 minw-190" type="submit">Sign and Submit Agreement to Seller <i
                        class="fas fa-arrow-right"></i></button> -->
                @endif
            </div>
        </form>
        @endif
        @endif

        <script>
            $(function () {
                $(".seller").find("input, select, textarea").attr("disabled", true);

                $("body").on("keyup", "input[name='loan_amount']", function () {
                    var loan_amount = $(this).val();
                    var balance_payment = '{{ $seller_particular->spcontract->balance_payment }}';
                    var balance = parseFloat(balance_payment - loan_amount).toFixed(2);
                    $("input[name='balance']").val(balance);
                    $("input[name='balance']").parent(".inrow").addClass("not-empty");
                });

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
        </script>



    </div>
</div>

@endsection