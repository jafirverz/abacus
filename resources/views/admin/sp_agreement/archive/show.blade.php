@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('sp-agreement-archive.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_sp_agreement_archive_crud', 'Show',
            route('sp-agreement-archive.show', $seller_particular->id))])
        </div>
        @include('inc.messages')
        <div class="section-body">
            <div class="accordion type">
                <div class="accordion-header" role="button" data-toggle="collapse" data-target="#seller"
                    aria-expanded="true">
                    <h4>SELLER</h4>
                </div>
                <div class="collapse show" id="seller">
                    <div class="card card-body">
                        <h2 class="section-title mt-0">Seller's Particular</h2>
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" class="form-control" name="seller_company_name" value="{{ $seller_particular->company_name ?? '' }}"  />
                            @if ($errors->has('seller_company_name'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_company_name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="seller_name" value="{{ old('seller_name') ?? $seller_particular->seller_name ?? '' }}" />
                            @if ($errors->has('seller_name'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>NRIC/UEN/Passport No. <em>(Last 4 character 123A)</em></label>
                            <input type="text" class="form-control" name="seller_nric" value="{{ old('seller_nric') ?? $seller_particular->nric ?? '' }}" />
                            @if ($errors->has('seller_nric'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_nric') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>H/P No.</label>
                            <input type="text" class="form-control" name="seller_hp_no" value="{{ old('seller_hp_no') ?? $seller_particular->hp_no ?? '' }}" />
                            @if ($errors->has('seller_hp_no'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_hp_no') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="seller_email" value="{{ old('seller_email') ?? $seller_particular->user->email ?? '' }}" readonly />
                            @if ($errors->has('seller_email'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_email') }}</strong>
                            </span>
                            @endif
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
                            <label>Country of Residence</label>
                            <input type="text" class="form-control" name="seller_country_of_residence" value="{{ old('seller_country_of_residence') ?? $seller_particular->country_of_residence ?? '' }}" />
                            @if ($errors->has('seller_country_of_residence'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_country_of_residence') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="seller_address" value="{{ old('seller_address') ?? $seller_particular->address ?? '' }}" readonly/>
                            @if ($errors->has('seller_address'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_address') }}</strong>
                            </span>
                            @endif
                        </div>
                        <h2 class="section-title">Vehicle Particular</h2>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label>Original Registration No.</label>
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
                            <div class="col-lg-6 form-group">
                                <label>Original Registration Date</label>
                                <input type="text" class="form-control datepicker" name="registration_date" value="{{ old('registration_date') ?? $seller_particular->vehicleparticular->registration_date ?? '' }}" />
                                @if ($errors->has('registration_date'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('registration_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label>Manufacture Year</label>
                                <input type="text" class="form-control" name="year_of_manufacturer" value="{{ old('year_of_manufacturer') ?? $seller_particular->vehicleparticular->year_of_manufacturer ?? '' }}" />
                                @if ($errors->has('year_of_manufacturer'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('year_of_manufacturer') }}</strong>
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
                                <label>Engine No.</label>
                                <input type="text" class="form-control" name="engine_no" value="{{ old('engine_no') ?? $seller_particular->vehicleparticular->engine_no ?? '' }}" />
                                @if ($errors->has('engine_no'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('engine_no') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>Open Market Value</label>
                                <input type="text" class="form-control positive-integer" name="open_market_value" value="{{ old('open_market_value') ?? $seller_particular->vehicleparticular->open_market_value ?? '' }}" />
                                @if ($errors->has('open_market_value'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('open_market_value') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label>Primary Colour</label>
                                <input type="text" class="form-control" name="color" value="{{ old('color') ?? $seller_particular->vehicleparticular->color ?? '' }}" />
                                @if ($errors->has('color'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>Transfer Count</label>
                                <input type="text" class="form-control" name="no_of_transfer" value="{{ old('no_of_transfer') ?? $seller_particular->vehicleparticular->no_of_transfer ?? '' }}" />
                                @if ($errors->has('no_of_transfer'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('no_of_transfer') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group ">
                                <label>COE Expiry Date</label>
                                <input type="text" class="form-control datepicker" name="coe_expiry_date" value="{{ old('coe_expiry_date') ?? $seller_particular->vehicleparticular->coe_expiry_date ?? '' }}" />
                                @if ($errors->has('coe_expiry_date'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('coe_expiry_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>Actual ARF Paid</label>
                                <input type="text" class="form-control positive-integer" name="arf_paid" value="{{ old('arf_paid') ?? $seller_particular->vehicleparticular->arf_paid ?? '' }}" />
                                @if ($errors->has('arf_paid'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('arf_paid') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label>Vehicle Type (Normal/OPC)</label>
                                <input type="text" class="form-control" name="vehicle_type" value="{{ old('vehicle_type') ?? $seller_particular->vehicleparticular->vehicle_type ?? '' }}" />
                                @if ($errors->has('vehicle_type'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('vehicle_type') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>Engine Capacity (CC)</label>
                                <input type="text" class="form-control" name="engine_output" value="{{ old('engine_output') ?? $seller_particular->vehicleparticular->engine_output ?? '' }}" />
                                @if ($errors->has('engine_output'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('engine_output') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <h2 class="section-title">Contract Term &amp; Conditions</h2>
                        <div class="form-group">
                            <label>Contract Term &amp; Conditions</label>
                            <textarea rows="6" cols="30" class="form-control hauto" name="seller_terms_and_condition" placeholder="">{{ old('seller_terms_and_condition') ?? $seller_particular->spcontract->terms_and_condition ?? '' }}</textarea>
                            @if ($errors->has('seller_terms_and_condition'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('seller_terms_and_condition') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Selling Price ($)</label>
                            <input type="text" class="form-control positive-integer" name="selling_price" value="{{ old('selling_price') ?? $seller_particular->spcontract->selling_price ?? '' }}" />
                            @if ($errors->has('selling_price'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('selling_price') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Deposit - n % of Selling Price ($)</label>
                            <input type="text" class="form-control positive-integer" name="deposit" value="{{ old('deposit') ?? $seller_particular->spcontract->deposit ?? '' }}" readonly />
                            @if ($errors->has('deposit'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('deposit') }}</strong>
                            </span>
                            @endif
                        </div>
                        <label>Balance Payment</label>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <input type="text" class="form-control positive-integer" placeholder="Balance Payment" name="balance_payment" value="{{ old('balance_payment') ?? $seller_particular->spcontract->balance_payment ?? '' }}" readonly />
                                @if ($errors->has('balance_payment'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('balance_payment') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
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
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" class="form-control" name="buyer_company_name" value="{{ $buyer_particular->company_name ?? '' }}"  />
                            @if ($errors->has('buyer_company_name'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_company_name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="buyer_name" value="{{ old('buyer_name') ?? $buyer_particular->buyer_name ?? '' }}" />
                            @if ($errors->has('buyer_name'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>NRIC/UEN/Passport No. <em>(Last 4 character 123A)</em></label>
                            <input type="text" class="form-control" name="buyer_nric" value="{{ old('buyer_nric') ?? $buyer_particular->nric ?? '' }}" />
                            @if ($errors->has('buyer_nric'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_nric') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>H/P No.</label>
                            <input type="text" class="form-control" name="buyer_hp_no" value="{{ old('buyer_hp_no') ?? $buyer_particular->hp_no ?? '' }}" />
                            @if ($errors->has('buyer_hp_no'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_hp_no') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="buyer_email" value="{{ old('buyer_email') ?? $buyer_particular->user->email ?? '' }}" />
                            @if ($errors->has('buyer_email'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Country of Residence <em>(If applicable)</em></label>
                            <input type="text" class="form-control" name="buyer_country_of_residence" value="{{ old('buyer_country_of_residence') ?? $buyer_particular->country_of_residence ?? '' }}" />
                            @if ($errors->has('buyer_country_of_residence'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_country_of_residence') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="buyer_address" value="{{ old('buyer_address')?? $buyer_particular->address ?? '' }}" />
                            @if ($errors->has('buyer_address'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_address') }}</strong>
                            </span>
                            @endif
                        </div>
                        <h2 class="section-title">Loan Details</h2>
                        <div class="form-group">
                            <label>Loan Amount</label>
                            <input type="text" class="form-control positive-integer" name="loan_amount" value="{{ old('loan_amount') ?? $buyer_particular->buyerloandetail->loan_amount ?? '' }}" />
                            @if ($errors->has('loan_amount'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('loan_amount') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank" value="{{ old('bank') ?? $buyer_particular->buyerloandetail->bank ?? '' }}" />
                            @if ($errors->has('bank'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Interest Rate</label>
                            <input type="text" class="form-control positive-integer" name="interest" value="{{ old('interest') ?? $buyer_particular->buyerloandetail->interest ?? '' }}" />
                            @if ($errors->has('interest'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('interest') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Balance Payment Due</label>
                            <input type="text" class="form-control positive-integer" name="balance" value="{{ old('balance') ?? $buyer_particular->buyerloandetail->balance ?? '' }}" />
                            @if ($errors->has('balance'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('balance') }}</strong>
                            </span>
                            @endif
                        </div>
                        <h2 class="section-title">Payment Details</h2>
                        <div class="table-responsive">
                            <table class="tb-1">
                                <thead>
                                    <tr>
                                        <th>Payment Details</th>
                                        <th>$</th>
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
                                    <tr>
                                        <td>
                                            <input type="text" name="payment_details[payment_detail][]" class="form-control" value="{{ $payment_details->payment_detail[$i] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="payment_details[payment_amount][]" class="form-control" placeholder="$" value="{{ $payment_details->payment_amount[$i] ?? '' }}">
                                        </td>
                                        <td>
                                            <select name="payment_details[mode_of_payment][]" class="form-control">
                                                <option value="">Select</option>
                                                @if(getPaymentMode())
                                                @foreach (getPaymentMode() as $item)
                                                    <option value="{{ $item->id }}" @if($payment_details->mode_of_payment[$i]==$item->id) selected @endif>{{ $item->title }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="payment_details[payment_date][]" class="form-control datepicker" placeholder="" value="{{ $payment_details->payment_date[$i] ?? '' }}">
                                        </td>
                                    </tr>
                                    @endfor
                                    @endif
                                    @else
                                    <tr>
                                        <td>
                                            <input type="text" name="payment_details[payment_detail][]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="payment_details[payment_amount][]" class="form-control" placeholder="$">
                                        </td>
                                        <td>
                                            <select name="payment_details[mode_of_payment][]" class="form-control">
                                                <option value="">Select</option>
                                                @if(getPaymentMode())
                                                @foreach (getPaymentMode() as $item)
                                                    <option value="{{ $item->id }}" >{{ $item->title }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td><input type="text" name="payment_details[payment_date][]" class="form-control datepicker" placeholder=""></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <h2 class="section-title">Additional Terms &amp; Conditions</h2>
                        <div class="form-group">
                            <label>Additional Terms &amp; Conditions</label>
                            <textarea rows="6" cols="30" class="form-control hauto" name="buyer_terms_and_condition">{{ old('buyer_terms_and_condition') ?? $buyer_particular->buyerpaymenttermcondition->terms_and_condition ?? '' }}</textarea>
                            @if ($errors->has('buyer_terms_and_condition'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('buyer_terms_and_condition') }}</strong>
                            </span>
                            @endif
                        </div>
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
                    </div>
                </div>
            </div>
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
        $("input, select, textarea").attr("disabled", true);
    });
</script>
@endsection
