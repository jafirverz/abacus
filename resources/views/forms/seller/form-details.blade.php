@extends('layouts.app')

@section('content')
<style>
    .signature-pad--body { }
    .signature-pad--footer { margin-top: 5px; }
    .signature-pad--actions .button { background: #ddd; border: none; border-radius: 5px; display; inline-block; margin: 5px 5px 0 0; padding: 3px 15px; }
    .signature-pad--actions .button:hover { background: #333; color: #fff; }
    .signature-pad--body canvas { border: #E1E1E1 solid 1px; width: 100%; height: 200px; }
</style>
<div class="main-wrap">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
        @include('inc.breadcrumb')
        @include('inc.messages')
        <form action="{{ url('forms/form-details/seller/'.$reference.'/'.$id) }}" class="form-ani" method="POST" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" value="{{ $seller_particular->user->address ?? '' }}"  />
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
                        <div class="mt-20 col-6">
                            <div class="row break-375">
                                <div class="col-9 sp-col">
                                    <label class="lb-2">Digital Signature</label>
                                </div>
                            </div>

                            @if(isset($seller_particular->spcontract->signature))
                            <a href="{{ url($seller_particular->spcontract->signature) }}" target="_blank">
                                <img src="{{ asset($seller_particular->spcontract->signature) }}" alt="" width="100px">
                            </a>
                            @else
                            <div id="signature-pad" class="signature-pad">
                                <div class="signature-pad--body">
                                    <canvas></canvas>
                                </div>
                                <div class="signature-pad--footer">
                                    <div class="description">Sign above</div>

                                    <div class="signature-pad--actions">
                                        <div>
                                            <button type="button" class="button clear" data-action="clear">Clear</button>
                                            <button type="button" class="button d-none" data-action="change-color">Change color</button>
                                            <button type="button" class="button" data-action="undo">Undo</button>

                                        </div>
                                        <div>
                                            <button type="button" class="button save d-none" data-action="save-png">Save as PNG</button>
                                            <button type="button" class="button save d-none" data-action="save-jpg">Save as JPG</button>
                                            <button type="button" class="button save d-none" data-action="save-svg">Save as SVG</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="signature" value="">
                            @if ($errors->has('signature'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('signature') }}</strong>
                            </span>
                            @endif
                            <script src="{{ asset('js/signature_pad/signature_pad.umd.js') }}"></script>
                            <script src="{{ asset('js/signature_pad/app.js') }}"></script>
                            @endif
                        </div>
                        @if(!$seller_particular->spcontract->signature)
                        <div class="mb-20 mt-30 text-center">
                            <button class="btn-1 minw-190" type="submit">Submit S&amp;P to Buyer <i
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
                        </div>
                        <div class="inrow">
                            <label>NRIC/UEN/Passport No. <em>(Last 4 character 123A)</em></label>
                            <input type="text" class="form-control" name="nric" value="{{ $buyer_particular->nric ?? '' }}"  maxlength="4" minlength="4" />
                        </div>
                        <div class="inrow">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $buyer_particular->user->address ?? '' }}"  />
                        </div>
                        <div class="inrow">
                            <label>H/P No.</label>
                            <input type="text" class="form-control" name="hp_no" value="{{ $buyer_particular->hp_no ?? '' }}" />
                        </div>
                        <div class="inrow">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="email" value="{{ $buyer_particular->user->email ?? '' }}"  />
                        </div>
                        <div class="inrow">
                            <label>Country of Residence <em>(If applicable)</em></label>
                            <input type="text" class="form-control" name="country_of_residence" value="{{ $buyer_particular->country_of_residence ?? '' }}" />
                        </div>
                        <h2 class="title-2 mt-50 mt-991-30">Loan Details</h2>
                        <div class="inrow mt-0">
                            <label>Loan Amount</label>
                            <input type="text" class="form-control positive-integer" name="loan_amount" value="{{ $buyer_particular->buyerloandetail->loan_amount ?? '' }}" />
                        </div>
                        <div class="inrow">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank" value="{{ $buyer_particular->buyerloandetail->bank ?? '' }}" />
                        </div>
                        <div class="inrow">
                            <label>Interest Rate</label>
                            <input type="text" class="form-control positive-integer" name="interest" value="{{ $buyer_particular->buyerloandetail->interest ?? '' }}" />
                        </div>
                        <div class="inrow">
                            <label>Balance Payment Due</label>
                            <input type="text" class="form-control positive-integer" name="balance" value="{{ $buyer_particular->buyerloandetail->balance ?? '' }}"  />
                        </div>
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
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {
        $(".seller, .buyer").find("input, select, textarea").attr("disabled", true);
        $("input[name='signature']").attr("disabled", false);
        $('.positive-integer').numeric(
            {negative: false}
        );

        var canvas = document.querySelector("canvas");


        var signaturePad = new SignaturePad(canvas, {
            onEnd: function () {
                $("input[name='signature']").val(signaturePad.toDataURL("image/jpeg"));
            },
            backgroundColor: "white",
        });

        $("form").on("submit", function() {
            $(this).find("button").attr("disabled", true);
        });
    });
</script>
@endsection
