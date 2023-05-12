@extends('layouts.app')

@section('content')
<?php
	$content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }

?>

<div class="main-wrap">
				@include('inc.banner')
                <?php /*?>@foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach<?php */?>
				<div class="container main-inner">
					<h1 class="title-1 text-center">{!! $page->title!!}</h1>

                    @include('inc.breadcrumb')
                    {!! $page->content!!}
					<form method="post" class="form-ani" action="{{route('insurance.store')}}">
                    @csrf
                    @include('inc.messages')
						<h2 class="title-2">Section 1: Main Driver's Particulars</h2>
							<label class="lb">Name</label>
							<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_full_name" id="main_driver_full_name" value="{{old('main_driver_full_name',Auth::user()->name ?? '')}}" />
                             @if ($errors->has('main_driver_full_name'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('main_driver_full_name') }}</span>
                             @endif
						<div class="row">
							<div class="col-lg-6">
								<div class="mt-20">
									<label class="lb">NRIC</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif minlength="4" maxlength="4" name="main_driver_nric" id="main_driver_nric" value="{{old('main_driver_nric')}}"  placeholder="Example: 123A"/>

                                </div>
                            @if ($errors->has('main_driver_nric'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_nric') }}</span>
                            @endif
							</div>
							<div class="col-lg-6">
								<div class="mt-20">
									<label class="lb">Date of Birth</label>																		<div class="date-wrap datepicker-wrap">
										<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_date_of_birth" id="main_driver_date_of_birth" value="{{old('main_driver_date_of_birth')}}" />
										<i class="fas fa-calendar-alt"></i>									</div>
								</div>
                            @if ($errors->has('main_driver_date_of_birth'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_date_of_birth') }}</span>
                            @endif
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="mt-20">									<label class="lb">License Passed Date</label>																		<div class="date-wrap datepicker-wrap">
										<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_license_pass_date" id="main_driver_license_pass_date" value="{{old('main_driver_license_pass_date')}}" />
										<i class="fas fa-calendar-alt"></i>									</div>
                                </div>
                                @if ($errors->has('main_driver_license_pass_date'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_license_pass_date') }}</span>
                                @endif
							</div>
							<div class="col-lg-6 mt-20">									<label class="lb">Gender</label>
								@if(Auth::check())
								<select class="selectpicker" name="main_driver_gender" id="main_driver_gender">
									<option value="">Gender</option>
									<option @if(old('main_driver_gender')=="Male" ) selected="selected" @elseif(Auth::user()->gender==1)
										selected="selected" @endif value="Male">Male</option>
									<option @if(old('main_driver_gender')=="Female" ) selected="selected" @elseif(Auth::user()->gender==2)
										selected="selected" @endif value="Female">Female</option>
								</select>
								@else
								<input type="text" class="form-control @if(!Auth::check())login-popup @endif"
									value="Gender" @if(!Auth::check()) readonly="readonly" @endif />
								@endif

                                @if ($errors->has('main_driver_gender'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_gender') }}</span>
                                @endif
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="mt-20">
									<label class="lb">Marital Status</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_marital_status" id="main_driver_marital_status" value="{{old('main_driver_marital_status')}}" />
								</div>
                                @if ($errors->has('main_driver_marital_status'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_marital_status') }}</span>
                                @endif
							</div>
							<div class="col-lg-6">
								<div class="mt-20">
									<label class="lb">Occupation</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_occupation" id="main_driver_occupation" value="{{old('main_driver_occupation')}}" />
								</div>
                                @if ($errors->has('main_driver_occupation'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_occupation') }}</span>
                                @endif
							</div>
						</div>
						<div class="row">													<div class="col-lg-6">								<div class="row">
									<div class="col-lg-5">
										<div class="mt-20">
											<label class="lb">Country Code</label>
											<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_country_code" id="main_driver_country_code" value="{{old('main_driver_country_code',Auth::user()->country_code ?? '')}}"  />
										</div>
										@if ($errors->has('main_driver_country_code'))
										<span class="text-danger">&nbsp;{{ $errors->first('main_driver_country_code') }}</span>
										@endif
									</div>
									<div class="col-lg-7">
										<div class="mt-20">
											<label class="lb">Contact Number</label>
											<input type="text" class="form-control positive-integer @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_contact_number" id="main_driver_contact_number" value="{{old('main_driver_contact_number',Auth::user()->mobile ?? '')}}" />
										</div>
										@if ($errors->has('main_driver_contact_number'))
										<span class="text-danger">&nbsp;{{ $errors->first('main_driver_contact_number') }}</span>
										@endif
									</div>								</div>							</div>
							<div class="col-lg-6">
								<div class="mt-20">
									<label class="lb">Email Address</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="main_driver_email" id="main_driver_email" value="{{old('main_driver_email',Auth::user()->email ?? '')}}" />
								</div>
                                @if ($errors->has('main_driver_email'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_email') }}</span>
                                @endif
							</div>
						</div>
						<h2 class="title-2 mt-50 mt-991-30">Section 2</h2>
						<div class="check-inline">
							<div class="lb title-3">Named Driver</div>
							<div class="group">
								<div class="radio">
									<input type="radio" value="1" id="driveyes" class="@if(!Auth::check()) login-popup-radio @endif" name="named_driver" @if(old("named_driver")==1) checked="checked" @endif  />
									<label for="driveyes">Yes</label>
								</div>
								<div class="radio">
									<input value="2" type="radio" id="driveno" class="@if(!Auth::check()) login-popup-radio @endif" name="named_driver"  @if(is_null(old('named_driver'))) checked="checked" @elseif(old("named_driver")==2) checked="checked" @else @endif />
									<label for="driveno">No</label>
								</div>
							</div>
						</div>
                        <div id="section2" class="@if(is_null(old('named_driver'))) hide @elseif(old("named_driver")==2) hide @else  @endif">
						<div class="row">
							<div class="col-lg-6">
								<div class="inrow mt-10">
									<label>Name</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="driver_full_name" id="driver_full_name" value="{{old('driver_full_name')}}" />
								</div>
                                @if ($errors->has('driver_full_name'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_full_name') }}</span>
                                @endif
							</div>
							<div class="col-lg-6">
								<div class="inrow mt-10 mt-991-20">
									<label>NRIC</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="driver_nric" minlength="4" maxlength="4" id="driver_nric" value="{{old('driver_nric')}}" />
								</div>
                                @if ($errors->has('driver_nric'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_nric') }}</span>
                                @endif
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="inrow date-wrap datepicker-wrap">
									<label>Date of Birth</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="driver_date_of_birth" id="driver_date_of_birth" value="{{old('driver_date_of_birth')}}" />
									<i class="fas fa-calendar-alt"></i>
								</div>
                                @if ($errors->has('driver_date_of_birth'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_date_of_birth') }}</span>
                                @endif
							</div>
							<div class="col-lg-6">
								<div class="inrow date-wrap datepicker-wrap">
									<label>License Passed Date</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="driver_license_pass_date" id="driver_license_pass_date" value="{{old('driver_license_pass_date')}}" />
								    <i class="fas fa-calendar-alt"></i>
                                </div>
                                @if ($errors->has('driver_license_pass_date'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_license_pass_date') }}</span>
                                @endif
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 mt-20">
								<select class="selectpicker" name="driver_gender" id="driver_gender" value="{{old('driver_gender')}}">
									<option value="">Gender</option>
									<option @if(old('main_driver_gender')=="Male") selected="selected" @endif value="Male">Male</option>
									<option @if(old('main_driver_gender')=="Female") selected="selected" @endif value="Female">Female</option>
								</select>
                                @if ($errors->has('driver_gender'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_gender') }}</span>
                                @endif
							</div>
							<div class="col-lg-6">
								<div class="inrow">
									<label>Marital Status</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="driver_marital_status" id="driver_marital_status" value="{{old('driver_marital_status')}}" />
								</div>
                                @if ($errors->has('driver_marital_status'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_marital_status') }}</span>
                                @endif
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="inrow">
									<label>Occupation</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="driver_occupation" id="driver_occupation" value="{{old('driver_occupation')}}" />
								</div>
                                @if ($errors->has('driver_occupation'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_occupation') }}</span>
                                @endif
							</div>
							<div class="col-lg-6">
								<div class="inrow">
									<label>Relationship to Main Driver</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif name="relationship_main_driver" id="relationship_main_driver" value="{{old('relationship_main_driver')}}" />
								</div>
                                @if ($errors->has('relationship_main_driver'))
                                <span class="text-danger">&nbsp;{{ $errors->first('relationship_main_driver') }}</span>
                                @endif
							</div>
						</div>
                        </div>
						<h2 class="title-2 mt-50 mt-991-30">Vehicle Details for Insurance Quotation</h2>
						<!--<div class="mt-20">
							<label class="lb">Vehicle details</label>
							<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: Details" name="vehicle_details" id="vehicle_details" value="{{old('vehicle_details')}}" />
						        @if ($errors->has('vehicle_details'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vehicle_details') }}</span>
                                @endif
                        </div>-->
                        <div class="mt-20">
							<label class="lb">Car Plate Number</label>
							<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: SBG1234A" name="vehicles_car_plate_no" id="vehicles_car_plate_no" value="{{old('vehicles_car_plate_no')}}" />
						        @if ($errors->has('car_plate_no'))
                                <span class="text-danger">&nbsp;{{ $errors->first('car_plate_no') }}</span>
                                @endif
                        </div>
						<div class="mt-20">
							<label class="lb">Make/Model</label>
							<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: Toyota Altis 1.6A" name="make_model" id="make_model" value="{{old('make_model')}}" />
						    @if ($errors->has('make_model'))
                                <span class="text-danger">&nbsp;{{ $errors->first('make_model') }}</span>
                                @endif
                        </div>
						<div class="mt-20">
							<label class="lb">Engine Capacity</label>
							<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: 1000cc" name="engine_capacity" id="engine_capacity" value="{{old('engine_capacity')}}" />
						    @if ($errors->has('engine_capacity'))
                                <span class="text-danger">&nbsp;{{ $errors->first('engine_capacity') }}</span>
                                @endif
                        </div>
						<div class="mt-20">
							<label class="lb">Date of Registration</label>
							<div class="date-wrap datepicker-wrap">
								<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Date of Registration" name="date_of_registration" id="date_of_registration" value="{{old('date_of_registration')}}" />
								<i class="fas fa-calendar-alt"></i>
							</div>
                            @if ($errors->has('date_of_registration'))
                                <span class="text-danger">&nbsp;{{ $errors->first('date_of_registration') }}</span>
                                @endif
						</div>
						<div class="mt-20">
							<label class="lb">Year of Manufacture</label>
							<input type="text" class="form-control  positive-integer @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: 2000"  minlength="4" maxlength="4" name="year_of_manufacture" id="year_of_manufacture" value="{{old('year_of_manufacture')}}"/>
						@if ($errors->has('year_of_manufacture'))
                                <span class="text-danger">&nbsp;{{ $errors->first('year_of_manufacture') }}</span>
                                @endif
                        </div>
						<div class="check-inline mt-20">
							<div class="lb">Is this an OPC Car</div>
							<div class="group">
								<div class="radio">
									<input type="radio" id="opc-yes" class="@if(!Auth::check()) login-popup-radio @endif" name="is_opc_car" value="1"  @if(old('is_opc_car')==2) checked @endif />
									<label for="opc-yes">Yes</label>
								</div>
								<div class="radio">
									<input type="radio" id="opc-no" class="@if(!Auth::check()) login-popup-radio @endif" name="is_opc_car" value="2"   @if(!old('is_opc_car')) checked @elseif(old('is_opc_car')==2) checked @endif/>
									<label for="opc-no">No</label>
								</div>
							</div>
						</div>
						<div class="title-3 mt-20 line-1">If you don't have the information </div>
						<div class="mt-20">
							<label class="lb">Car Plate Number</label>
							<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: SBG1234A" name="car_plate_no" id="car_plate_no" value="{{old('car_plate_no')}}" />
						@if ($errors->has('car_plate_no'))
                                <span class="text-danger">&nbsp;{{ $errors->first('car_plate_no') }}</span>
                                @endif
                        </div>
						<div class="mt-20">
							<label class="lb">NRIC/UEN/Business/Passport Number</label>
							<input minlength="4" maxlength="4" type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: 123Z" name="nric_uen_business_passport" id="nric_uen_business_passport" value="{{old('nric_uen_business_passport')}}" />
						@if ($errors->has('nric_uen_business_passport'))
                                <span class="text-danger">&nbsp;{{ $errors->first('nric_uen_business_passport') }}</span>
                        @endif
                        </div>
						<div class="line-1 mt-30">
							<div class="row">
								<div class="col-lg-6">
									<label class="title-3">NCD (%)</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: 10, -50 or 0" name="ncd" id="ncd" value="{{old('ncd')}}" />
								@if ($errors->has('ncd'))
                                <span class="text-danger">&nbsp;{{ $errors->first('ncd') }}</span>
                                @endif
                                </div>
								<div class="col-lg-6 mt-991-20">
									<label class="title-3">From previous vehicle number</label>
									<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check()) readonly="readonly" @endif placeholder="Example: SBG5678A" name="previous_vehicle_number" id="previous_vehicle_number" value="{{old('previous_vehicle_number')}}" />
								@if ($errors->has('previous_vehicle_number'))
                                <span class="text-danger">&nbsp;{{ $errors->first('previous_vehicle_number') }}</span>
                                @endif
                                </div>
							</div>
						</div>
						<div class="checkbox mt-30">
							<input type="checkbox" id="information" class="@if(!Auth::check()) login-popup-radio @endif" name="terms_condition" value="1" />
							<label class="pt-3" for="information"> @isset($content['section_1'])
                         {!! $content['section_1'] !!}
                         @endisset </label>
						        @if ($errors->has('terms_condition'))
                                <span class="text-danger">&nbsp;{{ $errors->first('terms_condition') }}</span>
                                @endif
                        </div>
						<div class="captcha">
									<!-- Google reCAPTCHA widget -->
									<div class="google-recaptcha">
										<div class="g-recaptcha" data-callback="setResponse" data-size="invisible"
											data-sitekey="{{config('system_settings')->recaptcha_site_key}}"></div>
											<input type="hidden" id="captcha-response" name="captcha_response" />

									</div>
									<!-- Google reCAPTCHA widget -->
								</div>
						<div class="mt-30 text-center">
							@if(Auth::check())
							<button class="btn-1 minw-190" type="submit">Submit <i class="fas fa-arrow-right"></i></button>
							@else
							<a href="{{ url('login') }}" class="btn-1 minw-190">Login <i class="fas fa-arrow-right"></i></a>
							@endif
						</div>
					</form>
				</div>
			</div>
			<div class="modal fade" id="messagepp" tabindex="-1" aria-labelledby="messagepp" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<p>Oops, we noticed you are not logged in.</p>
							<p>Please login to fill out the Insurance Application Form.</p>
							<div class="mt-20">
								<a href="{{ url('login') }}" class="btn-1" style="margin-right:10px; padding-right: 30px;">Login</a>
								<a href="{{ url('register') }}" class="btn-1"
									style="margin-left:10px; padding-right: 30px;">Signup</a>
							</div>
						</div>
					</div>
				</div>
			</div>
<style type="text/css">
.hide{display:none}
.login-popup{
	background: #e9ecef !important;
}
</style>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback" async defer></script>
<script>
$(function() {
	$.ajaxSetup({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});
	var auth_check = '{{ Auth::check() }}';
	if(auth_check==false)
	{
	$("#messagepp").modal("show");
	}

	$(".login-popup").on("click", function() {
	$("#messagepp").modal("show");
	});
	$(".login-popup-radio").on("click", function() {
	if($(this).attr('name') == 'named_driver'){
	$('input[name='+ $(this).attr('name') +']').get(1).checked = true;
	}else if($(this).attr('name') == 'terms_condition'){
	$('input[name='+ $(this).attr('name') +']').get(0).checked = false;
	}else{
	$('input[name='+ $(this).attr('name') +']').get(0).checked = true;
	}
	$("#messagepp").modal("show");
	});
	});

    $('.positive-integer').numeric(
            {negative: false}
        );
	var onloadCallback = function() {
		grecaptcha.execute();
	};

	function setResponse(response) {
		document.getElementById('captcha-response').value = response;
	}

	<?php if($errors->count()>0) { ?>
	   $('html, body').animate({
              scrollTop: $("#p1").offset().top
        }, 800);
	<?php } ?>
</script>
<script type="text/javascript">
$('input[type=radio][name=named_driver]').change(function() {
    if (this.value == 1) {
        $("#section2").removeClass("hide");
    }
    else if (this.value == 2) {
        $("#section2").addClass("hide");
    }
});
</script>
@endsection
