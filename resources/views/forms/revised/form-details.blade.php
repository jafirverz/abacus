@extends('layouts.app')

@section('content')
<div class="main-wrap">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
        @include('inc.breadcrumb')
        @include('inc.messages')
        <form action="{{ url('forms/form-details/revised/'.$reference.'/'.$id) }}" class="form-ani" method="POST">
            @csrf
            <div class="collapse-wrap mt-0 seller">
                <a class="title" data-toggle="collapse" href="#seller">SELLER</a>
                <div class="collapse show" id="seller">
                    <div class="card card-body">
                        <h2 class="title-2">Seller's Particular</h2>
                        <div class="inrow mt-0">
                            <label>Name/Company Name</label>
                            <input type="text" class="form-control" value="{{ $seller_particular->user->company_name ?? '' }}"  />
                        </div>
                        <div class="inrow">
                            <label>NRIC/UEN/Passport No. <em>(Last 4 character 123A)</em></label>
                            <input type="text" class="form-control" value="{{ $seller_particular->nric ?? '' }}" />
                        </div>
                        <div class="inrow">
                            <label>Address</label>
                            <input type="text" class="form-control" value="{{ $seller_particular->address ?? '' }}"  />
                        </div>
                        <div class="inrow">
                            <label>H/P No.</label>
                            <input type="text" class="form-control" value="{{ $seller_particular->hp_no ?? '' }}" />
                        </div>
                        <div class="inrow">
                            <label>Email Address</label>
                            <input type="text" class="form-control" value="{{ $seller_particular->user->email ?? '' }}"  />
                        </div>
                        <div class="inrow">
                            <label>Buyer Email Address</label>
                            <input type="text" class="form-control" value="{{ $seller_particular->buyer_email ?? '' }}"  />
                        </div>
                        <div class="inrow">
                            <label>Buyer's Mobile No.</label>
                            <input type="text" class="form-control positive-integer" value="{{ $seller_particular->buyer_mobile ?? '' }}"  />
                        </div>
                        <div class="inrow">
                            <label>Country of Residence</label>
                            <input type="text" class="form-control" value="{{ $seller_particular->country_of_residence ?? '' }}" />
                        </div>
                        <h2 class="title-2 mt-50 mt-991-30">Vehicle Particular</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow mt-0">
                                    <label>Original Registration No.</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->registration_no ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow mt-0 mt-991-20">
                                    <label>Vehicle Make</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->make ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Vehicle Model</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->model ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow date-wrap datepicker-wrap">
                                    <label>Original Registration Date</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->registration_date ?? '' }}" />
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Manufacture Year</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->year_of_manufacturer ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Chassis No.</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->chassis_no ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Engine No.</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->engine_no ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Open Market Value</label>
                                    <input type="text" class="form-control positive-integer" value="{{ $seller_particular->vehicleparticular->open_market_value ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Primary Colour</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->color ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Transfer Count</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->no_of_transfer ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow date-wrap datepicker-wrap">
                                    <label>COE Expiry Date</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->coe_expiry_date ?? '' }}" />
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Actual ARF Paid</label>
                                    <input type="text" class="form-control positive-integer" value="{{ $seller_particular->vehicleparticular->arf_paid ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Vehicle Type (Normal/OPC)</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->vehicle_type ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Engine Capacity (CC)</label>
                                    <input type="text" class="form-control" value="{{ $seller_particular->vehicleparticular->engine_output ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <h2 class="title-2 mt-50 mt-991-30">Contract Term &amp; Conditions</h2>
                        <label class="lb-2">Overview</label>
                        <textarea rows="6" cols="30" class="form-control" placeholder="" >{{ $seller_particular->spcontract->terms_and_condition ?? '' }}</textarea>
                        <div class="mt-20">
                            <label class="lb-2">Selling Price ($)</label>
                            <input type="text" class="form-control positive-integer" value="{{ $seller_particular->spcontract->selling_price ?? '' }}" />
                        </div>
                        <div class="mt-20">
                            <label class="lb-2">Deposit ($)</label>
                            <input type="text" class="form-control positive-integer" name="deposit" value="{{ $seller_particular->spcontract->deposit ?? '' }}" placeholder=""  />
                        </div>
                        <div class="mt-20">
                            <label class="lb-2">Balance Payment</label>
                            <input type="text" class="form-control positive-integer" name="balance_payment" value="{{ $seller_particular->spcontract->balance_payment ?? '' }}" placeholder=""  />
                        </div>
                        <div class="form-group">
                            <div class="row break-375">
                                <div class="col-9 sp-col">
                                    <label class="lb-2">Digital Signature</label>
                                </div>
                            </div>
                            @if(isset($seller_particular->spcontract->signature))
                            <a href="{{ url($seller_particular->spcontract->signature) }}" target="_blank">
                                <img src="{{ asset($seller_particular->spcontract->signature) }}" alt="" width="100px">
                            </a>
                            @endif
                        </div>
                        @if(Auth::user()->id==$seller_particular->user->id && $seller_particular->spcontract->seller_approval_at==null)
                        <div class="mb-20 mt-30 text-center">
                            <button class="btn-1 minw-190" type="submit">Accept <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="collapse-wrap mt-30 buyer">
                <a class="title" data-toggle="collapse" href="#buyer">BUYER</a>
                <div class="collapse show" id="buyer">
                    <div class="card card-body">
                        <h2 class="title-2">Buyer's Particular</h2>
                        <div class="inrow mt-0">
                            <label>Name/Company Name</label>
                            <input type="text" class="form-control" name="company_name" value="{{ $buyer_particular->user->company_name ?? '' }}" />
                            @if ($errors->has('company_name'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('company_name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>NRIC/UEN/Passport No. <em>(Last 4 character 123A)</em></label>
                            <input type="text" class="form-control" name="nric" value="{{ $buyer_particular->nric ?? '' }}"  maxlength="4" minlength="4" />
                            @if ($errors->has('nric'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('nric') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $buyer_particular->user->address ?? '' }}" readonly />
                            @if ($errors->has('address'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>H/P No.</label>
                            <input type="text" class="form-control" name="hp_no" value="{{ $buyer_particular->hp_no ?? '' }}" />
                            @if ($errors->has('hp_no'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('hp_no') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="email" value="{{ $buyer_particular->user->email ?? '' }}" readonly />
                            @if ($errors->has('email'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>Country of Residence <em>(If applicable)</em></label>
                            <input type="text" class="form-control" name="country_of_residence" value="{{ $buyer_particular->country_of_residence ?? '' }}" />
                            @if ($errors->has('country_of_residence'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('country_of_residence') }}</strong>
                            </span>
                            @endif
                        </div>
                        <h2 class="title-2 mt-50 mt-991-30">Loan Details</h2>
                        <div class="inrow mt-0">
                            <label>Loan Amount</label>
                            <input type="text" class="form-control positive-integer" name="loan_amount" value="{{ $buyer_particular->buyerloandetail->loan_amount ?? '' }}" />
                            @if ($errors->has('loan_amount'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('loan_amount') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank" value="{{ $buyer_particular->buyerloandetail->bank ?? '' }}" />
                            @if ($errors->has('bank'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>Interest Rate</label>
                            <input type="text" class="form-control positive-integer" name="interest" value="{{ $buyer_particular->buyerloandetail->interest ?? '' }}" />
                            @if ($errors->has('interest'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('interest') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <label>Balance Payment Due</label>
                            <input type="text" class="form-control positive-integer" name="balance" value="{{ $buyer_particular->buyerloandetail->balance ?? '' }}" readonly />
                            @if ($errors->has('balance'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('balance') }}</strong>
                            </span>
                            @endif
                        </div>
                        @if(isset($buyer_particular->user->id))
                        @if(Auth::user()->id==$buyer_particular->user->id)
                        <h2 class="title-2 mt-50 mt-991-30">Payment Details</h2>
                        <div class="table-responsive">
                            <table class="tb-1">
                                <thead>
                                    <tr>
                                        <th>Payment Details</th>
                                        <th>$ Amount</th>
                                        <th>Mode of Payment</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($buyer_particular->buyerpaymenttermcondition->payment_details))
                                    @php
                                        $payment_details = json_decode($buyer_particular->buyerpaymenttermcondition->payment_details);
                                    @endphp
                                    @if($payment_details)
                                    @for ($i=0;$i<count($payment_details->payment_detail);$i++)
                                    <tr>
                                        <td>
                                            {{ $payment_details->payment_detail[$i] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $payment_details->payment_amount[$i] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $payment_details->mode_of_payment[$i] ? getPaymentMode($payment_details->mode_of_payment[$i])->title : '' }}
                                        </td>
                                        <td>
                                            {{ $payment_details->payment_date[$i] ?? '' }}
                                        </td>
                                    </tr>
                                    @endfor
                                    @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endif
                        <h2 class="title-2 mt-50 mt-991-30">Additional Terms &amp; Conditions</h2>
                        <div class="inrow intextarea mt-0">
                            <label>Additional Terms &amp; Conditions</label>
                            <textarea rows="6" cols="30" class="form-control" name="terms_and_condition">{{ $buyer_particular->buyerpaymenttermcondition->terms_and_condition ?? '' }}</textarea>
                        </div>
                        <div class="mt-20">
                            <div class="row break-375">
                                <div class="col-9 sp-col">
                                    <label class="lb-2">Digital Signature</label>
                                </div>
                            </div>
                            @if(isset($buyer_particular->buyerpaymenttermcondition->signature))
                            <a href="{{ url($buyer_particular->buyerpaymenttermcondition->signature) }}" target="_blank">
                                <img src="{{ asset($buyer_particular->buyerpaymenttermcondition->signature) }}" alt="" width="100px">
                            </a>
                            @endif
                        </div>
                        @if(Auth::user()->id==$buyer_particular->user->id && $seller_particular->spcontract->buyer_approval_at==null)
                        <div class="mb-20 mt-30 text-center">
                            <button class="btn-1 minw-190" type="submit">Accept <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {
        $(".seller, .buyer").find("input, select, textarea").attr("disabled", true);

        $("body").on("keyup", "input[name='loan_amount']", function() {
            var loan_amount = $(this).val();
            var balance_payment = '{{ $seller_particular->spcontract->balance_payment }}';
            var balance = parseFloat(balance_payment-loan_amount).toFixed(2);
            $("input[name='balance']").val(balance);
        });

        $('.positive-integer').numeric(
            {negative: false}
        );

        $("form").on("submit", function() {
            $(this).find("button").attr("disabled", true);
        });
    });
</script>
@endsection
