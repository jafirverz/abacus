@extends('admin.layout.app')

@section('content')
<style>
    .subcol { position: relative; padding-left: 50px !important; }
    .subcol .remove { position: absolute; top: 25px; left: 20px; cursor: pointer; }
	.tb-break .date-col { position: relative; }
	.tb-break .date-col .dropdown-menu th, .tb-break .date-col .dropdown-menu td { /*background: none !important; border: none !important;*/ border-radius: 0; font-size: 13px; padding: 3px; }
	.tb-break .date-col .dropdown-menu th { /*color: #333;*/ }
	@media screen and (max-width: 991px) {
		.tb-break .tb-1 > thead > tr > th, .tb-break .tb-1 > tbody > tr > td { padding: 5px; }
		.tb-break .tb-1  thead > tr > th { line-height: 1.2; }
		.tb-break .input-group-text, .tb-break  select.form-control:not([size]):not([multiple]), .tb-break .form-control:not(.form-control-sm):not(.form-control-lg) { padding: 10px 5px; }
	}
	@media screen and (max-width: 425px) {
		.tb-break .tb-1 > thead > tr > th, .tb-break .tb-1 > tbody > tr > td { font-size: 10px; }
		.tb-break .input-group-text, .tb-break  select.form-control:not([size]):not([multiple]), .tb-break .form-control:not(.form-control-sm):not(.form-control-lg) { font-size: 10px; padding: 5px; }
	}
    .licon { position: relative; }.licon .ltext { align-items: center; bottom: 0; left: 0; line-height: 42px; position: absolute; text-align: center; top: 0; width: 40px; }.licon .form-control { padding-left: 40px !important; }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('sp-agreement.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_sp_agreement_crud', 'Edit',
            route('sp-agreement.edit', $seller_particular->id))])
        </div>
        @include('inc.messages')
        <div class="section-body">
            <form action="{{ route('sp-agreement.update', $seller_particular->id) }}" class="form-ani" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                <div class="accordion type">
                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#seller"
                        aria-expanded="true">
                        <h4>SELLER</h4>
                    </div>
                    <div class="collapse show" id="seller">
                        <div class="card card-body">
                            <h2 class="section-title mt-0">Seller's Particular</h2>
                            {{--
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" class="form-control" name="seller_company_name" value="{{ $seller_particular->company_name ?? '' }}"  />
                                @if ($errors->has('seller_company_name'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_company_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            --}}
                            <div class="form-group">
                                <label>Name/Company Name</label>
                                <input type="text" class="form-control" name="seller_name" value="{{ old('seller_name') ?? $seller_particular->seller_name ?? '' }}" />
                                @if ($errors->has('seller_name'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>NRIC/UEN/Passport No.</label>
                                <input type="text" class="form-control" name="seller_nric" value="{{ old('seller_nric') ?? $seller_particular->nric ?? '' }}"  maxlength="4" minlength="4"/>
                                @if ($errors->has('seller_nric'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_nric') }}</strong>
                                </span>
                                @endif
                            </div>
                            {{-- 
                            <div class="form-group">
                                <label>H/P No.</label>
                                <input type="text" class="form-control" name="seller_hp_no" value="{{ old('seller_hp_no') ?? $seller_particular->hp_no ?? '' }}" />
                                @if ($errors->has('seller_hp_no'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_hp_no') }}</strong>
                                </span>
                                @endif
                            </div>
                            --}}
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="text" class="form-control" name="seller_email" value="{{ old('seller_email') ?? $seller_particular->user->email ?? '' }}" readonly />
                                @if ($errors->has('seller_email'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_email') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Country code</label>
                                        <input type="text" class="form-control" name="seller_country_code" value="{{ old('seller_country_code', $seller_particular->seller_country_code ?? '+65') }}" />
                                        @if ($errors->has('seller_country_code'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('seller_country_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="seller_mobile" value="{{ old('seller_mobile', $seller_particular->seller_mobile ?? '') }}" />
                                        @if ($errors->has('seller_mobile'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('seller_mobile') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>





                            <div class="form-group">
                                <label>Buyer Email Address</label>
                                <input type="text" class="form-control" name="buyer_email" value="{{ old('buyer_email') ?? $seller_particular->buyer_email ?? '' }}" />
                                @if ($errors->has('buyer_email'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Buyer's Mobile No.</label>
                                <input type="text" class="form-control positive-integer" name="buyer_mobile" value="{{ old('buyer_mobile') ?? $seller_particular->buyer_mobile ?? '' }}" />
                                @if ($errors->has('buyer_mobile'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_mobile') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="seller_gender" class="form-control">
                                    <option value="">Please select</option>
                                    <option value="Male" @if($seller_particular->seller_gender == 'Male') selected @endif>Male</option>
                                    <option value="Female" @if($seller_particular->seller_gender == 'Female') selected @endif>Female</option>
                                </select>
                                @if ($errors->has('seller_gender'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_gender') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="seller_address" value="{{ old('seller_address') ?? $seller_particular->address ?? '' }}" />
                                @if ($errors->has('seller_address'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <h2 class="section-title">Vehicle Details</h2>
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>Vehicle Number</label>
                                    <input type="text" class="form-control" name="registration_no" value="{{ old('registration_no') ?? $seller_particular->vehicleparticular->registration_no ?? '' }}" />
                                    @if ($errors->has('registration_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('registration_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Vehicle Make</label>
                                    <input type="text" class="form-control" name="make" value="{{ old('make') ?? $seller_particular->vehicleparticular->make ?? '' }}" />
                                    @if ($errors->has('make'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('make') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>Vehicle Model</label>
                                    <input type="text" class="form-control" name="model" value="{{ old('model') ?? $seller_particular->vehicleparticular->model ?? '' }}" />
                                    @if ($errors->has('model'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('model') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($seller_particular->vehicleparticular->registration_date)){
                                    $registrationDate = date('d-m-Y', strtotime($seller_particular->vehicleparticular->registration_date));
                                }else{
                                    $registrationDate = date('d-m-Y');
                                }
                                @endphp
                                <div class="col-lg-6 form-group">
                                    <label>Original Registration Date</label>
                                    <input type="text" class="form-control datepicker547" name="registration_date" value="{{ old('registration_date') ?? $registrationDate ?? '' }}" />
                                    @if ($errors->has('registration_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('registration_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @php 
                                if(!empty($seller_particular->first_registration_Date)){
                                    $first_registration_Date = date('d-m-Y', strtotime($seller_particular->first_registration_Date));
                                }else{
                                    $first_registration_Date = date('d-m-Y');
                                }
                                @endphp
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>First Registration Date</label>
                                    <input type="text" class="form-control datepicker547" name="first_registration_Date" value="{{ old('first_registration_Date') ?? $first_registration_Date ?? '' }}" />
                                    @if ($errors->has('first_registration_Date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('first_registration_Date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Manufacture Year</label>
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="year_of_manufacturer" value="{{ old('year_of_manufacturer') ?? $seller_particular->vehicleparticular->year_of_manufacturer ?? '' }}" />
                                    @if ($errors->has('year_of_manufacturer'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('year_of_manufacturer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Engine No.</label>
                                    <input type="text" class="form-control" name="engine_no" value="{{ old('engine_no') ?? $seller_particular->vehicleparticular->engine_no ?? '' }}" />
                                    @if ($errors->has('engine_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('engine_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Chassis No.</label>
                                    <input type="text" class="form-control" name="chassis_no" value="{{ old('chassis_no') ?? $seller_particular->vehicleparticular->chassis_no ?? '' }}" />
                                    @if ($errors->has('chassis_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('chassis_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>Transfer Count</label>
                                    <input type="text" class="form-control" name="no_of_transfer" value="{{ old('no_of_transfer') ?? $seller_particular->vehicleparticular->no_of_transfer ?? '' }}" />
                                    @if ($errors->has('no_of_transfer'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('no_of_transfer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Primary Colour</label>
                                    <input type="text" class="form-control" name="color" value="{{ old('color') ?? $seller_particular->vehicleparticular->color ?? '' }}" />
                                    @if ($errors->has('color'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('color') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="row">
                                @php 
                                if(!empty($seller_particular->vehicleparticular->coe_expiry_date)){
                                    $coe_expiry_date = date('d-m-Y', strtotime($seller_particular->vehicleparticular->coe_expiry_date));
                                }else{
                                    $coe_expiry_date = date('d-m-Y');
                                }
                                @endphp
                                <div class="col-lg-6 form-group ">
                                    <label>COE Expiry Date</label>
                                    <input type="text" class="form-control datepicker547" name="coe_expiry_date" value="{{ old('coe_expiry_date') ?? $coe_expiry_date ?? '' }}" />
                                    @if ($errors->has('coe_expiry_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('coe_expiry_date') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @php 
                                if(!empty($seller_particular->vehicleparticular->road_tax_expiry_date)){
                                    $road_tax_expiry_date = date('d-m-Y', strtotime($seller_particular->vehicleparticular->road_tax_expiry_date));
                                }else{
                                    $road_tax_expiry_date = date('d-m-Y');
                                }
                                @endphp
                                <div class="col-lg-6 form-group ">
                                    <label>Road Tax Expiry Date</label>
                                    <input type="text" class="form-control datepicker547" name="road_tax_expiry_date" value="{{ old('road_tax_expiry_date') ??$road_tax_expiry_date ?? '' }}" />
                                    @if ($errors->has('road_tax_expiry_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('road_tax_expiry_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php
                                if(!empty($seller_particular->vehicleparticular->engine_output)){
                                    $enCap = number_format($seller_particular->vehicleparticular->engine_output);
                                }else{
                                    $enCap = '';
                                }
                                @endphp
                                <div class="col-lg-6 form-group">
                                    <label>Engine Capacity (CC)</label>
                                    <input type="text" id="engine_output" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="engine_output" value="{{ old('engine_output') ?? $enCap ?? '' }}" />
                                    @if ($errors->has('engine_output'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('engine_output') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @php 
                                if(!empty($seller_particular->vehicleparticular->open_market_value)){
                                    $open_market_value = number_format($seller_particular->vehicleparticular->open_market_value);
                                }else{
                                    $open_market_value = '';
                                }
                                @endphp
                                <div class="col-lg-6 form-group">
                                    <label>Open Market Value</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" id="open_market_value" class="form-control positive-integer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="open_market_value" value="{{ old('open_market_value') ?? $open_market_value ?? '' }}" />
                                    </div>
                                    @if ($errors->has('open_market_value'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('open_market_value') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="row">
                                @php
                                if(!empty($seller_particular->vehicleparticular->arf_paid)){
                                    $arfPaid = number_format($seller_particular->vehicleparticular->arf_paid);
                                }else{
                                    $arfPaid = '';
                                }
                                @endphp
                                <div class="col-lg-6 form-group">
                                    <label>Minimum PARF Benefit</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" id="arf_paid" class="form-control positive-integer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="arf_paid" value="{{ old('arf_paid') ?? $arfPaid ?? '' }}" />
                                    </div>
                                    @if ($errors->has('arf_paid'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('arf_paid') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Vehicle Type</label>
                                    <input type="text" class="form-control" name="vehicle_type" value="{{ old('vehicle_type') ?? $seller_particular->vehicleparticular->vehicle_type ?? '' }}" />
                                    @if ($errors->has('vehicle_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>Vehicle Scheme</label>
                                    <input type="text" class="form-control" name="vehicle_scheme" value="{{ old('vehicle_scheme') ?? $seller_particular->vehicleparticular->vehicle_scheme ?? '' }}" />
                                    @if ($errors->has('vehicle_scheme'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_scheme') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>IU Label Number</label>
                                    <input type="text" class="form-control" name="iu_label_number" value="{{ old('iu_label_number') ?? $seller_particular->vehicleparticular->iu_label_number ?? '' }}" />
                                    @if ($errors->has('iu_label_number'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('iu_label_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                            </div>

                            <h2 class="section-title">Contract Term &amp; Conditions</h2>
                            <div class="form-group">
                                <div class="check-inline ad-checkline" id="specification_group">
                                    @if(isset($seller_particular) && $seller_particular->spcontract)
                                    @php $specs_arr = json_decode($seller_particular->spcontract->terms_and_condition); @endphp
                                        @foreach ($specs_arr as $key=>$item)
                                        <div class="checkbox">
                                            <input type="checkbox" id="sp{{$key}}" value="{{$item}}" name="seller_terms_and_condition[]"  checked >
                                            <label for="sp{{$key}}">{{$item}}</label>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-lg-12 text-right">
                                    <div class="inrow add-plus empty">
                                        <input type="text" id="add_specification_val" class="form-control">
                                        <button id="add_specification">Add +</button>
                                    </div>
                                </div>
                            </div>

                            {{--
                            <div class="form-group">
                                <label>Contract Term &amp; Conditions</label>
                                <textarea rows="6" cols="30" class="form-control hauto" name="seller_terms_and_conditionp" placeholder="">{{ old('seller_terms_and_condition') ?? $seller_particular->spcontract->terms_and_condition ?? '' }}</textarea>
                                @if ($errors->has('seller_terms_and_condition'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('seller_terms_and_condition') }}</strong>
                                </span>
                                @endif
                            </div>
                            --}}

                            @php 
                                if(!empty($seller_particular->spcontract->selling_price)){
                                    $selling_price = number_format($seller_particular->spcontract->selling_price);
                                }else{
                                    $selling_price = '';
                                }
                                @endphp
                            <div class="form-group">
                                <label>Selling Price ($)</label>
                                <div class="licon">
                                    <div class="ltext">$</div>
                                    <input type="text" id="sellingPrice" class="form-control positive-integer" name="selling_price" value="{{ old('selling_price') ?? $selling_price ?? '' }}" />
                                </div>
                                @if ($errors->has('selling_price'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('selling_price') }}</strong>
                                </span>
                                @endif
                            </div>
                            @php 
                                if(!empty($seller_particular->spcontract->deposit)){
                                    $deposit = number_format($seller_particular->spcontract->deposit);
                                }else{
                                    $deposit = '';
                                }
                                @endphp
                            <div class="form-group">
                                <label>Deposit - n % of Selling Price ($)</label>
                                <div class="licon">
                                    <div class="ltext">$</div>
                                    <input id="depositAmount" type="text" class="form-control positive-integer" name="deposit" value="{{ old('deposit') ?? $deposit ?? '' }}" readonly />
                                </div>
                                @if ($errors->has('deposit'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('deposit') }}</strong>
                                </span>
                                @endif
                            </div>
                            <label>Balance Payment</label>
                            <div class="row">
                                @php 
                                if(!empty($seller_particular->spcontract->balance_payment)){
                                    
                                    $balance_payment = number_format($seller_particular->spcontract->balance_payment);
                                }else{
                                    
                                    $balance_payment = '';
                                }
                                @endphp
                                <div class="col-lg-6 form-group">
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" id="balancePayment" class="form-control positive-integer" placeholder="Balance Payment" name="balance_payment" value="{{ old('balance_payment', $balance_payment ?? '' )}}" readonly />
                                    </div>
                                    @if ($errors->has('balance_payment'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('balance_payment') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            {{-- 
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-8 sp-col">
                                        <label style="font-weight:600">Digital Signature</label>
                                    </div>
                                </div>
                                @if(isset($seller_particular->spcontract->signature))
                                <a href="{{ url($seller_particular->spcontract->signature) }}" target="_blank">
                                    <img src="{{ asset($seller_particular->spcontract->signature) }}" alt="" width="100px">
                                </a>
                                @endif
                            </div>
                            --}}
                        </div>
                    </div>
                </div>
                <div class="accordion type">
                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#buyer"
                        aria-expanded="true">
                        <h4>BUYER</h4>
                    </div>
                    <div class="collapse show" id="buyer">
                        <div class="card card-body">
                            <h2 class="section-title mt-0">Buyer's Particular</h2>
                            {{-- 
                            <div class="form-group">
                                <label>Name/Company Name</label>
                                <input type="text" class="form-control" name="buyer_company_name" value="{{ $buyer_particular->company_name ?? '' }}"  />
                                @if ($errors->has('buyer_company_name'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_company_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            --}}
                            <div class="form-group">
                                <label>Name/Company Name</label>
                                <input type="text" class="form-control" name="buyer_name" value="{{ old('buyer_name') ?? $buyer_particular->buyer_name ?? '' }}" />
                                @if ($errors->has('buyer_name'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>NRIC/UEN/Passport No.</em></label>
                                <input type="text" class="form-control" name="buyer_nric" value="{{ old('buyer_nric') ?? $buyer_particular->nric ?? '' }}"  maxlength="4" minlength="4" />
                                @if ($errors->has('buyer_nric'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_nric') }}</strong>
                                </span>
                                @endif
                            </div>

                            {{--
                            <div class="form-group">
                                <label>H/P No.</label>
                                <input type="text" class="form-control" name="buyer_hp_no" value="{{ old('buyer_hp_no') ?? $buyer_particular->hp_no ?? '' }}" />
                                @if ($errors->has('buyer_hp_no'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_hp_no') }}</strong>
                                </span>
                                @endif
                            </div>
                            --}}

                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="text" class="form-control" name="buyer_email" value="{{ old('buyer_email', $seller_particular->buyer_email ?? '')  }}" />
                                @if ($errors->has('buyer_email'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="buyer_gender" class="form-control">
                                    <option value="">Please select</option>
                                    <option value="Male" @if(isset($buyer_particular) && $buyer_particular->buyer_gender == 'Male') selected @endif>Male</option>
                                    <option value="Female" @if(isset($buyer_particular) && $buyer_particular->buyer_gender == 'Female') selected @endif>Female</option>
                                </select>
                                @if ($errors->has('buyer_country_of_residence'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_country_of_residence') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Country Code</label>
                                        <input type="text" class="form-control" name="country_code" value="{{ old('country_code')?? $buyer_particular->country_code ?? '+65' }}" />
                                        @if ($errors->has('country_code'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('country_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $buyer_particular->phone ?? '')  }}" />
                                        @if ($errors->has('phone'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="buyer_address" value="{{ old('buyer_address', $buyer_particular->address ?? '')  }}" />
                                @if ($errors->has('buyer_address'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <h2 class="section-title">Loan Details</h2>
                            <div class="form-group">
                                <label>Loan Amount</label>
                                @php 
                                if(isset($buyer_particular)){
                                    if(isset($buyer_particular->buyerloandetail)){
                                        $loanAmount = number_format($buyer_particular->buyerloandetail->loan_amount);
                                        $readonlyClass ='';
                                    }else{
                                        $loanAmount = '';
                                        $readonlyClass ='disabled';
                                    }
                                    
                                }else{
                                    $loanAmount = '';
                                    $readonlyClass ='disabled';
                                }
                                @endphp
                                <div class="licon">
                                    <div class="ltext">$</div>
                                    <input type="text" id="loan_amount" class="form-control positive-integer" {{$readonlyClass}} name="loan_amount" value="{{ old('loan_amount') ?? $loanAmount }}" />
                                </div>
                                @if ($errors->has('loan_amount'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('loan_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                            @php 
                                if(isset($buyer_particular)){
                                    if(isset($buyer_particular->buyerloandetail)){
                                        $bankName = $buyer_particular->buyerloandetail->bank;
                                        $interestRate = $buyer_particular->buyerloandetail->interest;
                                        $balancee = number_format($buyer_particular->buyerloandetail->balance);
                                    }else{
                                        $bankName = '';
                                        $interestRate = '';
                                        $balancee = '';
                                    }
                                    
                                }else{
                                    $bankName = '';
                                    $interestRate = '';
                                    $balancee = '';
                                }
                                @endphp
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" name="bank" {{$readonlyClass}} value="{{ old('bank') ?? $bankName ?? '' }}" />
                                @if ($errors->has('bank'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('bank') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Interest Rate%</label>
                                <input type="text" class="form-control positive-integer" {{$readonlyClass}} name="interest" value="{{ old('interest') ?? $interestRate ?? '' }}" />
                                @if ($errors->has('interest'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('interest') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Balance Payment Due</label>
                                <div class="licon">
                                    <div class="ltext">$</div>
                                    <input type="text" class="form-control positive-integer" {{$readonlyClass}} name="balance" value="{{ old('balance') ?? $balancee ?? '' }}" />
                                </div>
                                @if ($errors->has('balance'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('balance') }}</strong>
                                </span>
                                @endif
                            </div>
                            @php
                            if(isset($buyer_particular->buyerpaymenttermcondition)){
                                $clsdis = '';
                            }else{
                                $clsdis = 'disabled';
                            }
                            @endphp

                            <h2 class="section-title">Payment Details</h2>
                            <div class="tb-break">
                                <table class="tb-1">
                                    <thead>
                                        <tr>
                                            <th>Payment Details</th>
                                            <th>$ Amount</th>
                                            <th>Mode of Payment</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="payment-details-content">
                                        @if(isset($buyer_particular->buyerpaymenttermcondition->payment_details))
                                        @php
                                            $payment_details = json_decode($buyer_particular->buyerpaymenttermcondition->payment_details);
                                        @endphp
                                        @if($payment_details)
                                        @for ($i=0;$i<count($payment_details->payment_detail);$i++)

                                            @php
                                            if(isset($payment_details->payment_amount[$i]) && !empty($payment_details->payment_amount[$i])){
                                                $searchForValue = ',';
                                                $stringValue = $payment_details->payment_amount[$i];

                                                if( strpos($stringValue, $searchForValue) !== false ) {
                                                    $paymentAmount = $payment_details->payment_amount[$i];
                                                }else{
                                                    $paymentAmount = number_format($payment_details->payment_amount[$i]);
                                                }
                                                
                                            }else{
                                                $paymentAmount = '';
                                            }

                                            @endphp

                                            @php 
                                            $paymentDetls = old('payment_details');
                                            if($paymentDetls){
                                                $detl = $paymentDetls['payment_detail'][0];
                                                $payment_amount = $paymentDetls['payment_amount'][0];
                                                $mode_of_payment = $paymentDetls['mode_of_payment'][0];
                                                $payment_date = $paymentDetls['payment_date'][0];
                                                if($payment_date == '01-01-1970'){
                                                    $payment_date = date('d-m-Y');
                                                }
                                                if(empty($payment_date)){
                                                    $payment_date = date('d-m-Y');
                                                }
                                                if(!empty($paymentDetls['payment_amount'][0])){
                                                    $payAm = str_replace(',', '', $paymentDetls['payment_amount'][0]);
                                                    $payment_amount = number_format($payAm);
                                                }else{
                                                    $payment_amount = '';
                                                }
                                            }else{
                                                $detl = $payment_details->payment_detail[$i];
                                                $payment_amount = $paymentAmount;
                                                $mode_of_payment = $payment_details->mode_of_payment[$i];
                                                $payment_date = $payment_details->payment_date[$i]; 
                                                if($payment_date == '01-01-1970'){
                                                    $payment_date = date('d-m-Y');
                                                }
                                                if(empty($payment_date)){
                                                    $payment_date = date('d-m-Y');
                                                }
                                            }
                                            @endphp
                                        <tr>
                                            @if($i<>0)
                                            <td class="subcol">
                                                <i class="fas fa-minus remove"></i>
                                                <input type="text" name="payment_details[payment_detail][]" class="form-control" value="{{ $detl }}">
                                            </td>
                                            @else
                                            <td>
                                                <input type="text" name="payment_details[payment_detail][]" class="form-control" value="{{ $detl }}">
                                            </td>
                                            @endif
                                            <td>
                                                
                                                <div class="licon">
                                                    <div class="ltext">$</div>
                                                    <input type="text" name="payment_details[payment_amount][]" class="form-control" id="paymentdetailsamount" placeholder="" value="{{ $payment_amount ?? '' }}">
                                                </div>
                                            </td>
                                            <td>
                                                <select name="payment_details[mode_of_payment][]" class="form-control">
                                                    <option value="">Select</option>
                                                    @if(getPaymentMode())
                                                    @foreach (getPaymentMode() as $item)
                                                        <option value="{{ $item->id }}" @if($mode_of_payment==$item->id) selected @endif>{{ $item->title }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <div class="date-col">
													<input type="text" name="payment_details[payment_date][]" class="form-control datepicker547" placeholder="" value="{{ date('d-m-Y', strtotime($payment_date)) ?? date('d-m-Y') }}">
												</div>
                                            </td>
                                        </tr>
                                        @endfor
                                        @endif
                                        @else
                                        <tr>
                                            @php 
                                            $paymentDetls = old('payment_details');
                                            if($paymentDetls){
                                                $detl = $paymentDetls['payment_detail'][0];
                                                $payment_amount = $paymentDetls['payment_amount'][0];
                                                $mode_of_payment = $paymentDetls['mode_of_payment'][0];
                                                $payment_date = $paymentDetls['payment_date'][0];
                                                if($payment_date == '01-01-1970'){
                                                    $payment_date = date('d-m-Y');
                                                }
                                                if(!empty($paymentDetls['payment_amount'][0])){
                                                    $payment_amount = number_format($paymentDetls['payment_amount'][0]);
                                                }else{
                                                    $payment_amount = '';
                                                }
                                            }else{
                                                $detl = '';
                                                $payment_amount = '';
                                                $mode_of_payment = '';
                                                $payment_date = date('d-m-Y');
                                            }
                                            @endphp
                                            <td>
                                                <input type="text" name="payment_details[payment_detail][]" {{$clsdis}} class="form-control" value="{{$detl}}">
                                            </td>
                                            <td>
                                                
                                                <div class="licon">
                                                    <div class="ltext">$</div>
                                                    <input type="text" id="paymentdetailsamount" {{$clsdis}} name="payment_details[payment_amount][]" class="form-control positive-integer" placeholder="" value="{{$payment_amount}}">
                                                </div>
                                            </td>
                                            <td>
                                                <select name="payment_details[mode_of_payment][]" {{$clsdis}} class="form-control">
                                                    <option value="">Select</option>
                                                    @if(getPaymentMode())
                                                    @foreach (getPaymentMode() as $item)
                                                        <option value="{{ $item->id }}" @if($mode_of_payment == $item->id) selected @endif >{{ $item->title }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
												<div class="date-col">
													<input type="text" {{$clsdis}} name="payment_details[payment_date][]" class="form-control datepicker547" placeholder="" value="{{$payment_date}}">
												</div>
											</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if(checkSellerSigned($seller_particular->id))
                                @if($buyer_particular && $seller_particular->spcontract->buyer_approval_at==null && $seller_particular->spcontract->seller_approval_at==null)
                                <button type="button" class="btn-primary text-center add_payment_details">Add</button>
                                @endif
                            @endif


                            <h2 class="section-title">Additional Terms &amp; Conditions</h2>
                            @if(isset($buyer_particular->buyerpaymenttermcondition))
                            <div class="form-group">
                                @php $attr_arr = json_decode($buyer_particular->buyerpaymenttermcondition->terms_and_condition); @endphp
                                <div class="check-inline ad-checkline" id="additional_accessories_checkbox">
                                    @foreach ($attr_arr as $key=>$item)
                                    <div class="checkbox">
                                        <input type="checkbox" value="{{$item}}" id="ac{{$key}}" name="buyer_terms_and_condition[]"
                                            checked >
                                        <label for="ac{{$key}}">{{$item }}</label>
                                    </div>
                                    @endforeach
                                </div>
                               
                                <div class="col-lg-12 text-right">
                                    <div class="inrow add-plus empty">
                                        <input type="text" id="additional_accessories_checkbox_val" class="form-control">
                                        <button id="add_additional_accessories">Add +</button>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <textarea rows="6" disabled cols="30" class="form-control hauto" name="buyer_terms_and_condition">{{ old('buyer_terms_and_condition') ?? $buyer_particular->buyerpaymenttermcondition->terms_and_condition ?? '' }}</textarea>
                                @if ($errors->has('buyer_terms_and_condition'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('buyer_terms_and_condition') }}</strong>
                                </span>
                                @endif
                            </div>
                            @endif

                            {{--
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-8 sp-col">
                                        <label style="font-weight:600">Digital Signature</label>
                                    </div>
                                </div>
                                @if(isset($buyer_particular->buyerpaymenttermcondition->signature))
                                <a href="{{ url($buyer_particular->buyerpaymenttermcondition->signature) }}" target="_blank">
                                    <img src="{{ asset($buyer_particular->buyerpaymenttermcondition->signature) }}" alt="" width="100px">
                                </a>
                                @endif
                            </div>
                            --}}

                            <h2 class="section-title">DIY Cars Terms and Condition</h2>
                            {{--
                            @if($seller_particular->spcontract->other_terms)
                            <div class="form-group">
                                <textarea rows="20" cols="30" class="form-control hauto" name="diy_terms_condition">{!! old('diy_terms_condition', $seller_particular->spcontract->other_terms) !!}</textarea>
                                @if ($errors->has('diy_terms_condition'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('diy_terms_condition') }}</strong>
                                </span>
                                @endif
                            </div>
                            @else
                            --}}
                            <div class="form-group">
                                <textarea rows="20" cols="30" class="form-control hauto" name="diy_terms_condition">
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

19.	This Agreement shall be governed by the laws of Republic of Singapore.
                                    </textarea>
                                @if ($errors->has('diy_terms_condition'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('diy_terms_condition') }}</strong>
                                </span>
                                @endif
                            </div>
                            {{--
                            @endif
                            --}}

                            @if(checkSellerSigned($seller_particular->id))
                                @if($buyer_particular && $seller_particular->spcontract->buyer_approval_at==null && $seller_particular->spcontract->seller_approval_at==null)
                                <div class="mt-2 text-center">
                                    <button class="btn btn-primary" type="submit">Send Revised S&P to Seller & Buyer <i class="fas fa-arrow-right"></i></button>
                                </div>
                                @endif
                            @else
                            <div class="mt-2 text-center">
                                <button class="btn btn-primary" type="submit">Update <i class="fas fa-arrow-right"></i></button>
                            </div>
                            @endif

                            @if(!empty($buyer_particular) && $buyer_particular->docu_sent == 1)
                            <div class="mt-2 text-center">
                                <a class="btn btn-primary" href="javascript::void();" >PDF Sent </a>
                                <a class="btn btn-primary" href="{{ url('admin/sp-agreement/seller', ['id'=>$seller_particular->id]) }}" >Send PDF to sign again <i class="fas fa-arrow-right"></i></a>
                            </div>
                            @else 
                            <div class="mt-2 text-center">
                                <a class="btn btn-primary" href="{{ url('admin/sp-agreement/seller', ['id'=>$seller_particular->id]) }}" >Send PDF to sign <i class="fas fa-arrow-right"></i></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script>
</script>
<style>
    textarea.hauto {
        height: auto !important;
    }

    .accordion.type .card {
        border-radius: 0;
    }

    .accordion.type .accordion-header {
        border-radius: 3px 3px 0 0;
        position: relative;
    }

    .accordion.type .accordion-header:after {
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 13px;
        content: "\f077";
        margin-top: -10px;
        position: absolute;
        right: 20px;
        top: 50%;
    }

    .accordion.type .accordion-header.collapsed {
        border-radius: 3px;
    }

    .accordion.type .accordion-header.collapsed:after {
        content: "\f078";
    }

</style>
<script>
    $(function() {
        $("body").on("click", ".remove", function() {
            $(this).parents("tr").remove();
        });

        var payment_details = '<tr><td class="subcol"> <i class="fas fa-minus remove"></i> <input type="text" name="payment_details[payment_detail][]" class="form-control"></td><td> <input type="text" name="payment_details[payment_amount][]" class="form-control positive-integer" placeholder="$"></td><td> <select name="payment_details[mode_of_payment][]" class="form-control"><option value="">Select</option> @if(getPaymentMode()) @foreach (getPaymentMode() as $item)<option value="{{ $item->id }}" >{{ $item->title }}</option> @endforeach @endif </select></td><td><div class="date-col"><input type="text" name="payment_details[payment_date][]" class="form-control datepicker" placeholder=""></div></td></tr><script type="text/javascript">$(function(){$(".datepicker").datetimepicker({format:"YYYY-MM-DD",});});$(".positive-integer").numeric({negative: false});<\/script>';
        $("button.add_payment_details").on("click", function() {
            $("tbody.payment-details-content").find("tr:last").after(payment_details);
        });

        $("body").on("keyup", "input[name='selling_price']", function() {
            // var deposit_percent = '{{ $system_settings->deposit_percent }}';
            var selling_price = $(this).val();
            var selling_price = selling_price.replace(/,/g, '');
            // var deposit = parseFloat(selling_price/100*deposit_percent).toFixed(2);
            var deposit = $('#depositAmount').val();
            var deposit = deposit.replace(/,/g, '');
            var balance_payment = (selling_price-deposit);
            // $("input[name='deposit']").val(deposit);
            balance_payment = balance_payment.toLocaleString('en-EN', 3)
            $("input[name='balance_payment']").val(balance_payment);
        });

        $("body").on("keyup", "input[name='loan_amount']", function() {
            var loan_amount = $(this).val();
            var loan_amount = loan_amount.replace(/,/g, '');
            var balance_payment = '{{ $seller_particular->spcontract->balance_payment ?? 0 }}';
            var balance = parseInt(balance_payment-loan_amount);
            balance = balance.toLocaleString('en-EN', 3)
            $("input[name='balance']").val(balance);
        });

        $("form").on("submit", function() {
            $(this).find("button").attr("disabled", true);
        });

        $('.positive-integer').numeric(
            {negative: false}
        );
    });

    $('#add_specification').click(function() {
    var numItems = $('#specification_group div.checkbox').length;
    numItems=numItems+1;
    var text = $('#add_specification_val').val();
    if(text){
        $('#specification_group').append('<div class="checkbox"><input value="' + text + '" name="seller_terms_and_condition[]" type="checkbox" id="sp'+numItems+'"/> <label for="sp'+numItems+'">' + text + '</label></div>');
        $('#add_specification_val').val('')
    }else{
        alert('Please enter specification text first');
        $('#add_specification_val').focus();
    }
    return false;
});

$('#add_additional_accessories').click(function() {
    var numItems = $('#additional_accessories_checkbox div.checkbox').length;
    numItems=numItems+1;
    var text = $('#additional_accessories_checkbox_val').val();
    if(text){
        $('#additional_accessories_checkbox').append('<div class="checkbox"><input value="' + text + '" name="buyer_terms_and_condition[]" type="checkbox" id="ac'+numItems+'"/> <label for="ac'+numItems+'">' + text + '</label></div>');
        $('#additional_accessories_checkbox_val').val('')
    }else{
        alert('Please enter accessories text first');
        $('#additional_accessories_checkbox_val').focus();
    }
    return false;
});

$(function () {
        $("#sellingPrice,#balancePayment,#loan_amount,#engine_output,#open_market_value,#arf_paid,#paymentdetailsamount").on('keyup', function () {
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
</script>
@endsection
