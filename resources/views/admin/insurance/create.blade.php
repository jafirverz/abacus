@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('insurance.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_insurance_crud', 'Create', route('insurance.create'))])
        </div>
        <?php /*?>@if($errors->has())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
        @endif<?php */?>
        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.insurance.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <h2 class="section-title">Section 1: Main Driver's Particulars</h2>
                                <div class="form-group">
                                <label>Name</label>
							    <input type="text" class="form-control" name="main_driver_full_name" id="main_driver_full_name" value="{{old('main_driver_full_name')}}" />
                                 @if ($errors->has('main_driver_full_name'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('main_driver_full_name') }}</span>
                                 @endif

                                </div>
                                <div class="form-group">
                                <label>NRIC</label>
							    <input type="text" class="form-control" minlength="4" maxlength="4" name="main_driver_nric" id="main_driver_nric" value="{{old('main_driver_nric')}}" />
								@if ($errors->has('main_driver_nric'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_nric') }}</span>
                                @endif
                                </div>
                                <div class="form-group">
									<label>Date of Birth</label>
									<input type="text" class="form-control datepicker" name="main_driver_date_of_birth" id="main_driver_date_of_birth" value="{{old('main_driver_date_of_birth')}}" />
								</div>
                                @if ($errors->has('main_driver_date_of_birth'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_date_of_birth') }}</span>
                                @endif

                                <div class="form-group">
									<label>License Passed Date</label>
									<input type="text" class="form-control datepicker" name="main_driver_license_pass_date" id="main_driver_license_pass_date" value="{{old('main_driver_license_pass_date')}}" />
                                </div>
                                @if ($errors->has('main_driver_license_pass_date'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_license_pass_date') }}</span>
                                @endif

                                <div class="form-group">
                                <label>Gender</label>
								<select class="form-control" name="main_driver_gender" id="main_driver_gender">
									<option @if(old('main_driver_gender')=="Male") selected="selected" @endif value="Male">Male</option>
									<option @if(old('main_driver_gender')=="Female") selected="selected" @endif value="Female">Female</option>
								</select>
                                @if ($errors->has('main_driver_gender'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_gender') }}</span>
                                @endif
							   </div>

                               <div class="form-group">
									<label>Marital Status</label>
									<input type="text" class="form-control" name="main_driver_marital_status" id="main_driver_marital_status" value="{{old('main_driver_marital_status')}}" />
                                @if ($errors->has('main_driver_marital_status'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_marital_status') }}</span>
                                @endif
							</div>
							<div class="form-group">
									<label>Occupation</label>
									<input type="text" class="form-control" name="main_driver_occupation" id="main_driver_occupation" value="{{old('main_driver_occupation')}}" />
                                @if ($errors->has('main_driver_occupation'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_occupation') }}</span>
                                @endif
							</div>
                            <div class="row">
                            <div class="col-2">
                             <div class="form-group">
									<label>Country Code</label>
									<input type="text" class="form-control" name="main_driver_country_code" id="main_driver_country_code" value="{{old('main_driver_country_code')}}" placeholder="+65" />
                                @if ($errors->has('main_driver_country_code'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_country_code') }}</span>
                                @endif
							</div>
                            </div>
                            <div class="col-10">
                             <div class="form-group">
									<label>Contact Number</label>
									<input type="text" class="form-control positive-integer" name="main_driver_contact_number" id="main_driver_contact_number" value="{{old('main_driver_contact_number')}}" />
                                @if ($errors->has('main_driver_contact_number'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_contact_number') }}</span>
                                @endif
							</div>
                            </div>
                            </div>
							<div class="form-group">
									<label>Email Address</label>
									<input type="text" class="form-control" name="main_driver_email" id="main_driver_email" value="{{old('main_driver_email')}}" />
                                @if ($errors->has('main_driver_email'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_email') }}</span>
                                @endif
							</div>
                            <h2 class="section-title">Section 2</h2>
                            <div class="check-inline">
							<div class="form-group">
                            <label>Named Driver</label><br />
								<div class="form-check form-check-inline">
									<input type="radio" value="1" id="driveyes" name="named_driver" @if(old("named_driver")==1) checked="checked" @endif  />
									<label class="form-check-label" for="driveyes">&nbsp;Yes</label>
								</div>
								<div class="form-check form-check-inline">
									<input value="2" type="radio" id="driveno" name="named_driver"  @if(is_null(old('named_driver'))) checked="checked" @elseif(old("named_driver")==2) checked="checked" @else @endif />
									<label class="form-check-label" for="driveno">&nbsp;No</label>
								</div>
							</div>
							</div>
                            <div id="section2" class="@if(is_null(old('named_driver'))) hide @elseif(old("named_driver")==2) hide @else  @endif">
                                <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="driver_full_name" id="driver_full_name" value="{{old('driver_full_name')}}" />
                                    @if ($errors->has('driver_full_name'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_full_name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>NRIC</label>
                                        <input minlength="4" maxlength="4" type="text" class="form-control" name="driver_nric" id="driver_nric" value="{{old('driver_nric')}}" />
                                    @if ($errors->has('driver_nric'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_nric') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="text" class="form-control datepicker" name="driver_date_of_birth" id="driver_date_of_birth" value="{{old('driver_date_of_birth')}}" />
                                    @if ($errors->has('driver_date_of_birth'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_date_of_birth') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>License Passed Date</label>
                                        <input type="text" class="form-control datepicker" name="driver_license_pass_date" id="driver_license_pass_date" value="{{old('driver_license_pass_date')}}" />

                                    @if ($errors->has('driver_license_pass_date'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_license_pass_date') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label value="">Gender</label>
                                    <select class="form-control" name="driver_gender" id="driver_gender" value="{{old('driver_gender')}}">
                                        <option @if(old('main_driver_gender')=="Male") selected="selected" @endif value="Male">Male</option>
                                        <option @if(old('main_driver_gender')=="Female") selected="selected" @endif value="Female">Female</option>
                                    </select>
                                    @if ($errors->has('driver_gender'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_gender') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>Marital Status</label>
                                        <input type="text" class="form-control" name="driver_marital_status" id="driver_marital_status" value="{{old('driver_marital_status')}}" />
                                    @if ($errors->has('driver_marital_status'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_marital_status') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>Occupation</label>
                                        <input type="text" class="form-control" name="driver_occupation" id="driver_occupation" value="{{old('driver_occupation')}}" />
                                    @if ($errors->has('driver_occupation'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_occupation') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>Relationship to Main Driver</label>
                                        <input type="text" class="form-control" name="relationship_main_driver" id="relationship_main_driver" value="{{old('relationship_main_driver')}}" />
                                    @if ($errors->has('relationship_main_driver'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('relationship_main_driver') }}</span>
                                    @endif
                                </div>
                                </div>
                               <h2 class="section-title">Vehicle Details for Insurance Quotation</h2>

                        <div class="form-group">
							<label class="lb">Car Plate Number</label>
							<input type="text" class="form-control" placeholder="Example: SBG1234A" name="vehicles_car_plate_no" id="vehicles_car_plate_no" value="{{old('vehicles_car_plate_no')}}" />
						        @if ($errors->has('car_plate_no'))
                                <span class="text-danger">&nbsp;{{ $errors->first('car_plate_no') }}</span>
                                @endif
                        </div>
						<div class="form-group">
							<label class="lb">Make/Model</label>
							<input type="text" class="form-control" placeholder="Example: Toyota Altis 1.6A" name="make_model" id="make_model" value="{{old('make_model')}}" />
						    @if ($errors->has('make_model'))
                                <span class="text-danger">&nbsp;{{ $errors->first('make_model') }}</span>
                                @endif
                        </div>
						<div class="form-group">
							<label class="lb">Engine Capacity</label>
							<input type="text" class="form-control" placeholder="Example: 1000cc" name="engine_capacity" id="engine_capacity" value="{{old('engine_capacity')}}" />
						    @if ($errors->has('engine_capacity'))
                                <span class="text-danger">&nbsp;{{ $errors->first('engine_capacity') }}</span>
                                @endif
                        </div>
						<div class="form-group">
							<label class="lb">Date of Registration</label>
							<input type="text" class="form-control datepicker"  name="date_of_registration" id="date_of_registration" value="{{old('date_of_registration')}}" />

                            @if ($errors->has('date_of_registration'))
                                <span class="text-danger">&nbsp;{{ $errors->first('date_of_registration') }}</span>
                                @endif
						</div>
						<div class="form-group">
							<label class="lb">Year of Manufacture</label>
							<input minlength="4" maxlength="4" type="text" class="form-control positive-integer" placeholder="Example: 2000"  name="year_of_manufacture" id="year_of_manufacture" value="{{old('year_of_manufacture')}}"/>
						@if ($errors->has('year_of_manufacture'))
                                <span class="text-danger">&nbsp;{{ $errors->first('year_of_manufacture') }}</span>
                                @endif
                        </div>
						<div class="form-group">
							<label class="lb">Is this an OPC Car</label><br />
								<div class="form-check form-check-inline">
									<input type="radio" id="opc-yes" name="is_opc_car" value="1"  @if(old('is_opc_car')==1) checked @endif />
									<label class="form-check-label" for="opc-yes">&nbsp;Yes</label>
                                    </div>
								<div class="form-check form-check-inline">
									<input type="radio" id="opc-no" name="is_opc_car" value="2"  @if(!old('is_opc_car')) checked @elseif(old('is_opc_car')==2) checked @endif/>
									<label class="form-check-label" for="opc-no">&nbsp;No</label>
								</div>
						</div>
						<div class="section-title">If you don't have the information </div>
						<div class="form-group">
							<label class="lb">Car Plate Number</label>
							<input type="text" class="form-control" placeholder="Example: SBG1234A" name="car_plate_no" id="car_plate_no" value="{{old('car_plate_no')}}" />
						@if ($errors->has('car_plate_no'))
                                <span class="text-danger">&nbsp;{{ $errors->first('car_plate_no') }}</span>
                                @endif
                        </div>
						<div class="form-group">
							<label class="lb">NRIC/UEN/Business/Passport Number</label>
							<input minlength="4" maxlength="4" type="text" class="form-control" placeholder="Example: 123Z" name="nric_uen_business_passport" id="nric_uen_business_passport" value="{{old('nric_uen_business_passport')}}" />
						@if ($errors->has('nric_uen_business_passport'))
                                <span class="text-danger">&nbsp;{{ $errors->first('nric_uen_business_passport') }}</span>
                        @endif
                        </div>

                        <div class="form-group">
                            <label class="title-3">NCD (%)</label>
                            <input type="text" class="form-control" placeholder="Example: 10, -50 or 0" name="ncd" id="ncd" value="{{old('ncd')}}" />
                        @if ($errors->has('ncd'))
                        <span class="text-danger">&nbsp;{{ $errors->first('ncd') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="title-3">From previous vehicle number</label>
                            <input type="text" class="form-control" placeholder="Example: SBG5678A" name="previous_vehicle_number" id="previous_vehicle_number" value="{{old('previous_vehicle_number')}}" />
                        @if ($errors->has('previous_vehicle_number'))
                        <span class="text-danger">&nbsp;{{ $errors->first('previous_vehicle_number') }}</span>
                        @endif
                        </div>
						<div class="form-group">
                                    <label class="title-3" for="user_id">Select User</label>
                                    <select name="user_id" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if($users->count())
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if(old('user_id')==$user->id) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('user_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
						<?php
                        $content = [];
						if($page->json_content){
							$content = json_decode($page->json_content, true);
						}
                        ?>
                        <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="terms_condition" name="terms_condition" value="1" class="custom-control-input">
                      <label class="custom-control-label" for="terms_condition">
                          @isset($content['section_1'])
                         {!! $content['section_1'] !!}
                         @endisset
                      </label>
                    </div>
                  </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('insurance.index') }}" class="btn btn-primary"><i class="fas fa-window-close"></i> Cancel</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<style type="text/css">
.hide{display:none}
</style>
<script type="text/javascript">
$('input[type=radio][name=named_driver]').change(function() {
    if (this.value == 1) {
        $("#section2").removeClass("hide");
    }
    else if (this.value == 2) {
        $("#section2").addClass("hide");
    }
});

$('.positive-integer').numeric(
            {negative: false}
);
</script>
@endsection
