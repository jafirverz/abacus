@extends('layouts.app')

@section('content')
<div class="main-wrap">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
        @include('inc.breadcrumb')
        @include('inc.messages')
        <form action="{{ url('forms/form-details') }}" class="form-ani" method="POST" enctype="multipart/form-data">
            @csrf
            @if(!empty($carId))
            <input type="hidden" name="carId" value="{{ $carId }}">
            @endif
            <div class="collapse-wrap mt-0">
                <a class="title" data-toggle="collapse" href="#seller">SELLER</a>
                <div class="collapse show" id="seller">
                    <div class="card card-body">
                        <h2 class="title-2">Seller's Particular</h2>
                        <div class="inrow mt-0">
                            <label>Company Name</label>
                            <input type="text" class="form-control" name="company_name" value="{{ old('company_name',  Auth::user()->company_name) ?? '' }}"  />
                        </div>
						@if ($errors->has('company_name'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('company_name') }}</strong>
						</span>
						@endif
                        <div class="inrow">
                            <label>Name</label>
                            <input type="text" class="form-control" name="seller_name" value="{{ old('seller_name', Auth::user()->name) ?? '' }}"  />
                        </div>
						@if ($errors->has('seller_name'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('seller_name') }}</strong>
						</span>
						@endif
                        <div class="inrow">
                            <label>NRIC/UEN/Passport No. <em>(Last 4 character 123A)</em></label>
                            <input type="text" class="form-control" name="nric" value="{{ old('nric') ?? '' }}" maxlength="4" minlength="4" />
                        </div>
						@if ($errors->has('nric'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('nric') }}</strong>
						</span>
						@endif
                        <div class="inrow">
                            <label>H/P No.</label>
                            <input type="text" class="form-control positive-integer" name="hp_no" value="{{ old('hp_no', Auth::user()->mobilewithcountrycode) ?? '' }}"  />
                        </div>
						@if ($errors->has('hp_no'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('hp_no') }}</strong>
						</span>
						@endif
                        <div class="inrow">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="email" value="{{ old('email', Auth::user()->email) ?? '' }}" readonly />
                        </div>
						@if ($errors->has('email'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
                        <div class="inrow">
                            <label>Buyer Email Address</label>
                            <input type="text" class="form-control" name="buyer_email" value="{{ old('buyer_email') ?? '' }}"  />
                        </div>
						@if ($errors->has('buyer_email'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('buyer_email') }}</strong>
						</span>
						@endif
                        <div class="row break-767">
                            <div class="col-auto sp-col">
                                <div class="inrow" style="min-width:200px;">
                                    <label>Buyer's Country Code</label>
                                    <input type="text" name="country_code" class="form-control" value="{{ old('country_code') }}">
                                </div>
								@if ($errors->has('country_code'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('country_code') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col sp-col">
                                <div class="inrow">
									<label>Buyer's Mobile No.</label>
									<input type="text" class="form-control positive-integer" name="buyer_mobile" value="{{ old('buyer_mobile') ?? '' }}"  />
								</div>
								@if ($errors->has('buyer_mobile'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('buyer_mobile') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="inrow">
                            <label>Country of Residence</label>
                            <select name="country_of_residence" class="form-control">
                                @if(country())
                                @foreach (country() as $item)
                                    <option value="{{ $item->nicename }}" @if(old('country_of_residence')==$item->nicename) selected  @elseif($item->nicename=='Singapore') selected @endif>{{ $item->nicename }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
						@if ($errors->has('country_of_residence'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('country_of_residence') }}</strong>
						</span>
						@endif
                        <div class="inrow">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', Auth::user()->address) ?? '' }}"  />
                        </div>
						@if ($errors->has('address'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('address') }}</strong>
						</span>
						@endif
                        <h2 class="title-2 mt-50 mt-991-30">Vehicle Particular</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow mt-0">
                                    <label>Original Registration No.</label>
                                    <input type="text" class="form-control" name="registration_no" value="{{ old('registration_no') ?? '' }}" />
                                </div>
								@if ($errors->has('registration_no'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('registration_no') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow mt-0 mt-991-20">
                                    <label>Vehicle Make</label>
                                    <input type="text" class="form-control" name="make" value="{{ old('make') ?? '' }}" />
                                </div>
								@if ($errors->has('make'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('make') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Vehicle Model</label>
                                    <input type="text" class="form-control" name="model" value="{{ old('model') ?? '' }}" />
                                </div>
								@if ($errors->has('model'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('model') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow date-wrap datepicker-wrap">
                                    <label>Original Registration Date</label>
                                    <input type="text" class="form-control" name="registration_date" value="{{ old('registration_date') ?? '' }}" />
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
								@if ($errors->has('registration_date'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('registration_date') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Manufacture Year</label>
                                    <input type="text" class="form-control positive-integer" name="year_of_manufacturer" value="{{ old('year_of_manufacturer') ?? '' }}" maxlength="4" />
                                </div>
								@if ($errors->has('year_of_manufacturer'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('year_of_manufacturer') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Chassis No.</label>
                                    <input type="text" class="form-control" name="chassis_no" value="{{ old('chassis_no') ?? '' }}"  />
                                </div>
								@if ($errors->has('chassis_no'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('chassis_no') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Engine No.</label>
                                    <input type="text" class="form-control" name="engine_no" value="{{ old('engine_no') ?? '' }}" />
                                </div>
								@if ($errors->has('engine_no'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('engine_no') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Open Market Value</label>
                                    <input type="text" class="form-control positive-integer" name="open_market_value" value="{{ old('open_market_value') ?? '' }}" />
                                </div>
								@if ($errors->has('open_market_value'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('open_market_value') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Primary Colour</label>
                                    <input type="text" class="form-control" name="color" value="{{ old('color') ?? '' }}" />
                                </div>
								@if ($errors->has('color'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('color') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Transfer Count</label>
                                    <input type="text" class="form-control" name="no_of_transfer" value="{{ old('no_of_transfer') ?? '' }}" />
                                </div>
								@if ($errors->has('no_of_transfer'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('no_of_transfer') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow date-wrap datepicker-wrap">
                                    <label>COE Expiry Date</label>
                                    <input type="text" class="form-control" name="coe_expiry_date" value="{{ old('coe_expiry_date') ?? '' }}" />
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
								@if ($errors->has('coe_expiry_date'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('coe_expiry_date') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Actual ARF Paid</label>
                                    <input type="text" class="form-control positive-integer" name="arf_paid" value="{{ old('arf_paid') ?? '' }}" />
                                </div>
								@if ($errors->has('arf_paid'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('arf_paid') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Vehicle Type (Normal/OPC)</label>
                                    <input type="text" class="form-control" name="vehicle_type" value="{{ old('vehicle_type') ?? '' }}" />
                                </div>
								@if ($errors->has('vehicle_type'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('vehicle_type') }}</strong>
								</span>
								@endif
                            </div>
                            <div class="col-lg-6">
                                <div class="inrow">
                                    <label>Engine Capacity (CC)</label>
                                    <input type="text" class="form-control" name="engine_output" value="{{ old('engine_output') ?? '' }}" />
                                </div>
								@if ($errors->has('engine_output'))
								<span class="text-danger d-block">
									<strong>{{ $errors->first('engine_output') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <h2 class="title-2 mt-50 mt-991-30">Contract Term &amp; Conditions</h2>
                        <label class="lb-2">Overview</label>
                        <textarea rows="6" cols="30" class="form-control" placeholder="Sample:
1. Subject to STA Inspection
2. 2 Keys
3. Vehicle is accident-free
4. Subject to financing loan approval." name="terms_and_condition">{{ old('terms_and_condition') ?? '' }}</textarea>
                        @if ($errors->has('terms_and_condition'))
                        <span class="text-danger d-block">
                            <strong>{{ $errors->first('terms_and_condition') }}</strong>
                        </span>
                        @endif
                        <div class="mt-20">
                            <label class="lb-2">Selling Price ($)</label>
                            <input type="text" class="form-control positive-integer" name="selling_price" value="{{ old('selling_price') ?? '' }}" />
                            @if ($errors->has('selling_price'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('selling_price') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="mt-20">
                            <label class="lb-2">Deposit ($)</label>
                            <input type="text" class="form-control positive-integer" name="deposit" value="{{ old('deposit') ?? '' }}" placeholder=""  />
                            @if ($errors->has('deposit'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('deposit') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="mt-20">
                            <label class="lb-2">Balance Payment ($ - Before Loan Amount)</label>
                            <input type="text" class="form-control positive-integer" name="balance_payment" value="{{ old('balance_payment') ?? '' }}" placeholder="" readonly />
                            @if ($errors->has('balance_payment'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('balance_payment') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="mb-20 mt-30 text-center">
                            <button class="btn-1 minw-190" type="submit">Submit S&amp;P to Buyer <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("body").on("keyup", "input[name='selling_price']", function() {
            var selling_price = $(this).val();
            var deposit = $("input[name='deposit']").val();
            calcBalancePayment(selling_price, deposit);
        });

        $("body").on("keyup", "input[name='deposit']", function() {
            var selling_price = $("input[name='selling_price']").val();
            var deposit = $(this).val();
            calcBalancePayment(selling_price, deposit);
        });

        function calcBalancePayment(selling_price, deposit) {
            var deposit_percent = '{{ $system_settings->deposit_percent }}';
            var balance_payment = parseFloat(selling_price-deposit).toFixed(2);
            $("input[name='balance_payment']").val(balance_payment);
        }

        $('.positive-integer').numeric(
            {negative: false}
        );

        $("form").on("submit", function() {
            $(this).find("button").attr("disabled", true);
        });

        $("select[name='country_of_residence']").on("change", function() {
            var country_of_residence = $(this).val();
            $.ajax({
                method: 'POST',
                url: '{{ route("get-country-code") }}',
                data: {
                    'country_of_residence': country_of_residence,
                },
                cache: false,
                async: true,
                success: function(data)
                {
                    $("input[name='country_code']").val(data.success);
                    $("input[name='country_code']").parent("div.inrow").remove("empty").addClass("not-empty");
                },
                error: function(data)
                {
                    var mydata = JSON.parse(data.responseText);
                    if(mydata)
                    {
                        alert(mydata.error);
                    }
                },
                complete: function()
                {
                    //
                }
            });
        });

        $("select[name='country_of_residence']").trigger("change");
    });
</script>
@endsection
