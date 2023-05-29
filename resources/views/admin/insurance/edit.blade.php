@extends('admin.layout.app')

@section('content')
<style>
    .signature-pad--body { width:255px; }
    .signature-pad--footer { margin-top: 5px; }
    .signature-pad--actions .button { background: #ddd; border: none; border-radius: 5px; display; inline-block; margin: 5px 5px 0 0; padding: 3px 15px; }
    .signature-pad--actions .button:hover { background: #333; color: #fff; }
    .signature-pad--body canvas { border: #E1E1E1 solid 1px; width: 100%; height: 200px; }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('insurance.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_insurance_crud', 'Edit', route('insurance.edit', $insurance->id))])
        </div>
        
        <div class="section-body">
            @include('admin.inc.messages')

            <?php /*?>@foreach ($errors->all() as $error)
        		<div>{{ $error }}</div>
    		@endforeach<?php */?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('insurance.update', $insurance->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h2 class="section-title">Section 1: Main Driver's Particulars</h2>
                                <div class="form-group">
                                <label>Name</label>
							    <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_full_name" id="main_driver_full_name" value="{{old('main_driver_full_name',$insurance->main_driver_full_name)}}" required="required" />
                                 @if ($errors->has('main_driver_full_name'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('main_driver_full_name') }}</span>
                                 @endif

                                </div>
                                <div class="form-group">
                                <label>NRIC</label>
							    <input  @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_nric" id="main_driver_nric" value="{{old('main_driver_nric',$insurance->main_driver_nric)}}" required="required" />
								@if ($errors->has('main_driver_nric'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_nric') }}</span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label>Passport</label>
                                    <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_passport" id="main_driver_passport" value="{{old('main_driver_passport',$insurance->main_driver_passport)}}" />
                                    @if ($errors->has('main_driver_passport'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('main_driver_passport') }}</span>
                                    @endif
                                    </div>
                                <div class="form-group">
									<label>Date of Birth</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control datepicker547" name="main_driver_date_of_birth" id="main_driver_date_of_birth" value="{{old('main_driver_date_of_birth',date('d-m-Y', strtotime($insurance->main_driver_date_of_birth)))}}" required="required" />
								</div>
                                @if ($errors->has('main_driver_date_of_birth'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_date_of_birth') }}</span>
                                @endif

                                <div class="form-group">
									<label>Nationality</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_nationality" id="main_driver_nationality" value="{{old('main_driver_nationality',$insurance->main_driver_nationality)}}" />
                                </div>
                                @if ($errors->has('main_driver_nationality'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_nationality') }}</span>
                                @endif


                                <div class="form-group">
									<label>Address</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_address" id="main_driver_address" value="{{old('main_driver_address',$insurance->main_driver_address)}}" />
                                </div>
                                @if ($errors->has('main_driver_address'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_address') }}</span>
                                @endif

                                <div class="form-group">
                                <label>Gender</label>
								<select @if($insurance->quotation_id!=null) disabled="disabled" @endif class="form-control" name="main_driver_gender" id="main_driver_gender" required="required">
									<option @if(old('main_driver_gender',$insurance->main_driver_gender)=="Male") selected="selected" @endif value="Male">Male</option>
									<option @if(old('main_driver_gender',$insurance->main_driver_gender)=="Female") selected="selected" @endif value="Female">Female</option>
								</select>
                                @if($insurance->quotation_id!=null)
                                    <input type="hidden" name="main_driver_gender" value="{{$insurance->main_driver_gender}}" />
                                @endif
                                @if ($errors->has('main_driver_gender'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_gender') }}</span>
                                @endif
							   </div>

                               <div class="form-group">
									<label>Marital Status</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_marital_status" id="main_driver_marital_status" value="{{old('main_driver_marital_status',$insurance->main_driver_marital_status)}}" required="required" />
                                @if ($errors->has('main_driver_marital_status'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_marital_status') }}</span>
                                @endif
							</div>
							<div class="form-group">
									<label>Occupation</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_occupation" id="main_driver_occupation" value="{{old('main_driver_occupation',$insurance->main_driver_occupation)}}" required="required" />
                                @if ($errors->has('main_driver_occupation'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_occupation') }}</span>
                                @endif
							</div>
                            <div class="form-group">
                                <label>Name of Employer</label>
                                <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_employer" id="main_driver_employer" value="{{old('main_driver_employer',$insurance->main_driver_employer)}}" />
                            @if ($errors->has('main_driver_employer'))
                            <span class="text-danger">&nbsp;{{ $errors->first('main_driver_employer') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Qualified Driving License Class</label>
                            <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_licence_class" id="main_driver_licence_class" value="{{old('main_driver_licence_class',$insurance->main_driver_licence_class)}}" />
                        @if ($errors->has('main_driver_licence_class'))
                        <span class="text-danger">&nbsp;{{ $errors->first('main_driver_licence_class') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Qualified Driving License Validity</label>
                        <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_licence_validity" id="main_driver_licence_validity" value="{{old('main_driver_licence_validity',$insurance->main_driver_licence_validity)}}" />
                    @if ($errors->has('main_driver_licence_validity'))
                    <span class="text-danger">&nbsp;{{ $errors->first('main_driver_licence_validity') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Certificate of Merit status</label>
                    <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_merit_status" id="main_driver_merit_status" value="{{old('main_driver_merit_status',$insurance->main_driver_merit_status)}}" />
                @if ($errors->has('main_driver_merit_status'))
                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_merit_status') }}</span>
                @endif
            </div>
                            <div class="row">
                            <div class="col-2">
                             <div class="form-group">
									<label>Country Code</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_country_code" id="main_driver_country_code" value="{{old('main_driver_country_code',$insurance->main_driver_country_code)}}" placeholder="+65" required="required" />
                                @if ($errors->has('main_driver_country_code'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_country_code') }}</span>
                                @endif
							</div>
                            </div>
                            <div class="col-10">
                             <div class="form-group">
									<label>Contact Number</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control positive-integer" name="main_driver_contact_number" id="main_driver_contact_number" value="{{old('main_driver_contact_number',$insurance->main_driver_contact_number)}}" required="required" />
                                @if ($errors->has('main_driver_contact_number'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_contact_number') }}</span>
                                @endif
							</div>
                            </div>
                            </div>
							<div class="form-group">
									<label>Email Address</label>
									<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="main_driver_email" id="main_driver_email" value="{{old('main_driver_email',$insurance->main_driver_email)}}" required="required" />
                                @if ($errors->has('main_driver_email'))
                                <span class="text-danger">&nbsp;{{ $errors->first('main_driver_email') }}</span>
                                @endif
							</div>
                            <h2 class="section-title">Section 2</h2>
                            <div class="check-inline">
							<div class="form-group">
                            <label>Named Driver</label><br />
								<div class="form-check form-check-inline">
									<input @if($insurance->quotation_id!=null) disabled="disabled" @endif type="radio" value="1" id="driveyes" name="named_driver" @if(old("named_driver",$insurance->named_driver)==1) checked="checked" @endif  />
									<label class="form-check-label" for="driveyes">&nbsp;Yes</label>
								</div>
								<div class="form-check form-check-inline">
									<input @if($insurance->quotation_id!=null) disabled="disabled" @endif value="2" type="radio" id="driveno" name="named_driver"  @if(is_null(old('named_driver',$insurance->named_driver))) checked="checked" @elseif(old("named_driver",$insurance->named_driver)==2) checked="checked" @else @endif />
									<label class="form-check-label" for="driveno">&nbsp;No</label>
								</div>
                                 @if($insurance->quotation_id!=null)
                                    <input type="hidden" name="named_driver" value="{{$insurance->named_driver}}" />
                                 @endif

							</div>
							</div>
                            
                            <div id="section2" class="@if(is_null(old('named_driver',$insurance->named_driver))) hide @elseif(old("named_driver",$insurance->named_driver)==2) hide @else  @endif">
                                <div class="form-group">
                                        <label>Name</label>
                                        <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_full_name" id="driver_full_name" value="{{old('driver_full_name',$insurance->driver_full_name)}}" />
                                    @if ($errors->has('driver_full_name'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_full_name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>NRIC</label>
                                        <input minlength="4" maxlength="4" @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_nric" id="driver_nric" value="{{old('driver_nric',$insurance->driver_nric)}}" />
                                    @if ($errors->has('driver_nric'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_nric') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Passport</label>
                                    <input minlength="4" maxlength="4" @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_passport" id="driver_passport" value="{{old('driver_passport',$insurance->driver_passport)}}" />
                                @if ($errors->has('driver_passport'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_passport') }}</span>
                                @endif
                            </div>
                                <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control datepicker547" name="driver_date_of_birth" id="driver_date_of_birth" value="{{old('driver_date_of_birth',date('d-m-Y', strtotime($insurance->driver_date_of_birth)))}}"  />
                                    @if ($errors->has('driver_date_of_birth'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_date_of_birth') }}</span>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label value="">Gender</label>
                                    <select @if($insurance->quotation_id!=null) disabled="disabled" @endif class="form-control" name="driver_gender" id="driver_gender">
                                        <option @if(old('driver_gender',$insurance->driver_gender)=="Male") selected="selected" @endif value="Male">Male</option>
                                        <option @if(old('driver_gender',$insurance->driver_gender)=="Female") selected="selected" @endif value="Female">Female</option>
                                    </select>
                                    @if($insurance->quotation_id!=null)
                                    <input type="hidden" name="driver_gender" value="{{$insurance->driver_gender}}" />
                                    @endif
                                    @if ($errors->has('driver_gender'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_gender') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Nationality</label>
                                    <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_nationality" id="driver_nationality" value="{{old('driver_nationality',$insurance->driver_nationality)}}" />

                                @if ($errors->has('driver_nationality'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_nationality') }}</span>
                                @endif
                            </div>
                                <div class="form-group">
                                        <label>Marital Status</label>
                                        <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_marital_status" id="driver_marital_status" value="{{old('driver_marital_status',$insurance->driver_marital_status)}}"  />
                                    @if ($errors->has('driver_marital_status'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_marital_status') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>Occupation</label>
                                        <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_occupation" id="driver_occupation" value="{{old('driver_occupation',$insurance->driver_occupation)}}"  />
                                    @if ($errors->has('driver_occupation'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('driver_occupation') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                        <label>Relationship to Main Driver</label>
                                        <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="relationship_main_driver" id="relationship_main_driver" value="{{old('relationship_main_driver',$insurance->relationship_main_driver)}}"  />
                                    @if ($errors->has('relationship_main_driver'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('relationship_main_driver') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Qualified Driving License Class</label>
                                    <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_license_class" id="driver_license_class" value="{{old('driver_license_class',$insurance->driver_license_class)}}" />
                                @if ($errors->has('driver_license_class'))
                                <span class="text-danger">&nbsp;{{ $errors->first('driver_license_class') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Qualified Driving License Validity</label>
                                <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_license_validity" id="driver_license_validity" value="{{old('driver_license_validity',$insurance->driver_license_validity)}}" />
                            @if ($errors->has('driver_license_validity'))
                            <span class="text-danger">&nbsp;{{ $errors->first('driver_license_validity') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Certificate of Merit status</label>
                            <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" name="driver_merit_status" id="driver_merit_status" value="{{old('driver_merit_status',$insurance->driver_merit_status)}}" />
                        @if ($errors->has('driver_merit_status'))
                        <span class="text-danger">&nbsp;{{ $errors->first('driver_merit_status') }}</span>
                        @endif
                    </div>
                                </div>
                               <h2 class="section-title">Vehicle Details for Insurance Quotation</h2>

                        <div class="form-group">
							<label class="lb">Vehicle Number</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="Example: SBG1234A" name="vehicles_car_plate_no" id="vehicles_car_plate_no" value="{{old('vehicles_car_plate_no',$insurance->vehicles_car_plate_no)}}" />
						        @if ($errors->has('vehicles_car_plate_no'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vehicles_car_plate_no') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
							<label class="lb">Vehicle Scheme</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="" name="vehicle_schme" id="vehicle_schme" value="{{old('vehicle_schme',$insurance->vehicle_schme)}}" />
						        @if ($errors->has('vehicle_schme'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vehicle_schme') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
							<label class="lb">Vehicle Type</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="" name="vehicle_type" id="vehicle_type" value="{{old('vehicle_type',$insurance->vehicle_type)}}" />
						        @if ($errors->has('vehicle_type'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vehicle_type') }}</span>
                                @endif
                        </div>
						<div class="form-group">
							<label class="lb">Make/Model</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="Example: Toyota Altis 1.6A" name="make_model" id="make_model" value="{{old('make_model',$insurance->make_model)}}" />
						    @if ($errors->has('make_model'))
                                <span class="text-danger">&nbsp;{{ $errors->first('make_model') }}</span>
                                @endif
                        </div>
                        @php
                        if(!empty($insurance->engine_capacity)){
                            $engineCapacity = number_format($insurance->engine_capacity);
                        }else{
                            $engineCapacity = '';
                        }
                        @endphp
						<div class="form-group">
							<label class="lb">Engine Capacity</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="Example: 1598" name="engine_capacity" id="engine_capacity" value="{{old('engine_capacity',$engineCapacity)}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  />
						    @if ($errors->has('engine_capacity'))
                                <span class="text-danger">&nbsp;{{ $errors->first('engine_capacity') }}</span>
                                @endif
                        </div>
						<div class="form-group">
							<label class="lb">Date of Registration</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control datepicker547" placeholder="Example: 1598" name="date_of_registration" id="date_of_registration" value="{{old('date_of_registration', date('d-m-Y', strtotime($insurance->date_of_registration)))}}"  />

                            @if ($errors->has('date_of_registration'))
                                <span class="text-danger">&nbsp;{{ $errors->first('date_of_registration') }}</span>
                                @endif
						</div>
						<div class="form-group">
							<label class="lb">Year of Manufacture</label>
							<input minlength="4" maxlength="4" @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control positive-integer" placeholder="Example: 1598"  name="year_of_manufacture" id="year_of_manufacture" value="{{old('year_of_manufacture',$insurance->year_of_manufacture)}}"  />
						@if ($errors->has('year_of_manufacture'))
                                <span class="text-danger">&nbsp;{{ $errors->first('year_of_manufacture') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
							<label class="lb">Primary Color</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="" name="vehicle_primary_color" id="vehicle_primary_color" value="{{old('vehicle_primary_color',$insurance->vehicle_primary_color)}}" />
						        @if ($errors->has('vehicle_primary_color'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vehicle_primary_color') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
							<label class="lb">Engine Number</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="" name="vehicle_engine_number" id="vehicle_engine_number" value="{{old('vehicle_engine_number',$insurance->vehicle_engine_number)}}"  />
						        @if ($errors->has('vehicle_engine_number'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vehicle_engine_number') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
							<label class="lb">Chassis Number</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="" name="vechile_chasis_number" id="vechile_chasis_number" value="{{old('vechile_chasis_number',$insurance->vechile_chasis_number)}}" />
						        @if ($errors->has('vechile_chasis_number'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vechile_chasis_number') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
							<label class="lb">Propellant</label>
							<input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="" name="vechile_propellant" id="vechile_propellant" value="{{old('vechile_propellant',$insurance->vechile_propellant)}}" />
						        @if ($errors->has('vechile_propellant'))
                                <span class="text-danger">&nbsp;{{ $errors->first('vechile_propellant') }}</span>
                                @endif
                        </div>
                        {{-- 
						<div class="form-group">
							<label class="lb">Is this an OPC Car</label><br />
								<div class="form-check form-check-inline">
									<input @if($insurance->quotation_id!=null) disabled="disabled" @endif type="radio" id="opc-yes" name="is_opc_car" value="1" @if($insurance->is_opc_car==1)checked @endif />
									<label class="form-check-label" for="opc-yes">&nbsp;Yes</label>
                                    </div>
								<div class="form-check form-check-inline">
									<input @if($insurance->quotation_id!=null) disabled="disabled" @endif type="radio" id="opc-no" name="is_opc_car" @if($insurance->is_opc_car==2)checked @endif value="2" />
									<label class="form-check-label" for="opc-no">&nbsp;No</label>
								</div>
                                @if($insurance->quotation_id!=null)
                                    <input type="hidden" name="is_opc_car" value="{{$insurance->is_opc_car}}" />
                                 @endif

						</div>
                        --}}
						<div class="section-title">No Claim Discount</div>
                       
						<div class="form-group">
							<label class="lb">Type of Quote</label>
							<input type="text" class="form-control" placeholder="" name="type_of_quote" id="type_of_quote" value="{{old('type_of_quote',$insurance->type_of_quote)}}" />
						@if ($errors->has('type_of_quote'))
                                <span class="text-danger">&nbsp;{{ $errors->first('type_of_quote') }}</span>
                                @endif
                        </div>
                        {{-- 
						<div class="form-group">
							<label class="lb">NRIC/UEN/Business/Passport Number</label>
							<input minlength="4" maxlength="4" @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="Example: 123Z" name="nric_uen_business_passport" id="nric_uen_business_passport" value="{{old('nric_uen_business_passport',$insurance->nric_uen_business_passport)}}" required="required"  />
						@if ($errors->has('nric_uen_business_passport'))
                                <span class="text-danger">&nbsp;{{ $errors->first('nric_uen_business_passport') }}</span>
                        @endif
                        </div>
                        --}}
                        <div class="form-group">
                            <label class="title-3">NCD (%)</label>
                            <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="" name="ncd" id="ncd" value="{{old('ncd',$insurance->ncd)}}" />
                        @if ($errors->has('ncd'))
                        <span class="text-danger">&nbsp;{{ $errors->first('ncd') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="title-3">From previous vehicle number</label>
                            <input @if($insurance->quotation_id!=null) readonly="readonly" @endif type="text" class="form-control" placeholder="Example: SBG5678A" name="previous_vehicle_number" id="previous_vehicle_number" value="{{old('previous_vehicle_number',$insurance->previous_vehicle_number)}}" />
                        @if ($errors->has('previous_vehicle_number'))
                        <span class="text-danger">&nbsp;{{ $errors->first('previous_vehicle_number') }}</span>
                        @endif
                        </div>

                        @if(!empty($insurance->document1) || !empty($insurance->document2))
                        <div class="form-group">
                            <label class="title-3">Uploaded Document</label>
									@if(!empty($insurance->document1))
									<p><a href="{{asset('images/'.$insurance->document1)}}" target="_blank">LTA</a></p>
									@endif
									@if(!empty($insurance->document2))
									<p><a href="{{asset('images/'.$insurance->document2)}}" target="_blank">Vehicle Registration Document</a></p>
									@endif
									@endif

					<?php
                        $content = [];
						if($page->json_content){
							$content = json_decode($page->json_content, true);
						}
                        ?>
                   <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input @if($insurance->quotation_id!=null) disabled="disabled" @endif type="checkbox" @if(old('terms_condition',$insurance->terms_condition)==1) checked="checked" @endif type="checkbox" id="terms_condition" name="terms_condition" value="1" class="custom-control-input" required="required" >
                      <label class="custom-control-label" for="terms_condition">
                         @isset($content['section_1'])
                         {!! $content['section_1'] !!}
                         @endisset
                      </label>
                      @if($insurance->quotation_id!=null)
                                    <input type="hidden" name="terms_condition" value="{{$insurance->terms_condition}}" />
                      @endif
                    </div>
                  </div>
                  @if(isset($insurance->quotation_id))
                  <!--If quotation accepted-->
                  <div class="table-responsive">
							<table class="table table-md">
								<thead>
									<tr>
										<th rowspan="2">Select One</th>
										<th rowspan="2">Quotation</th>
										<th rowspan="2">Insurer</th>
										<th rowspan="2">Premium</th>
										<th rowspan="2">@if(isset($insurance->discount)) {{$insurance->discount}} @else {{systemSetting()->insurance_discount}}@endif% <br>Discount</th>
										<th rowspan="2">Premium after <br>Discount</th>
										<th colspan="2" style="text-align:center">Excess</th>
                                        <th rowspan="2">Remark</th>
									</tr>
									<tr>
										<th>Own <br>Damage</th>
										<th>3rd <br>Party</th>
									</tr>
								</thead>
								<tbody>
									 @if($quotations)
                                     @php $i=0; @endphp
                                       @foreach($quotations as $quotation)
                                       @php $i++; @endphp
									<tr>
										<td>
											<div class="radio">
												<input @if($insurance->quotation_id!=null) disabled="disabled" @endif @if(isset($insurance->quotation_id) && $insurance->quotation_id==$quotation->id)checked="checked" @endif type="radio" value="<?=$quotation->id?>" name="quotation_id" id="check-{{$i}}">
												<label for="check-{{$i}}"></label>
											</div>
										</td>
										<td>{{$quotation->quotation_number??'-'}}</td>
										<td>{{$quotation->insurer_name??'-'}}</td>
										<td>{{$quotation->premium??'-'}}</td>
										<td>
										<?php
										if(isset($insurance->discount))
										{
										    $discouT = (int)$insurance->discount;
										    $qPre= str_replace('$', '', $quotation->premium);
										echo $discount=$insurance->discount*$qPre/100 ;
										}
										else
										{
										    $discouT = (int)systemSetting()->insurance_discount;
										    $qPre= str_replace('$', '', $quotation->premium);
										echo $discount=$discouT*$qPre/100 ;
										}
										?>
                                        </td>
										<td><?=$qPre-$discount?></td>
										<td>{{$quotation->excess_own_damage??'-'}}</td>
										<td>{{$quotation->excess_party??'-'}}</td>
                                        <td>{{$quotation->remark??'-'}}</td>
									</tr>
                                    @endforeach
                                   @endif
								</tbody>
							</table>
						</div>
                        @if($insurance->quotation_id!=null)
                                    <input type="hidden" name="quotation_id" value="{{$insurance->quotation_id}}" />
                        @endif
                        <?php
						$quote=getQuotation($insurance->quotation_id);
						?>
                        <div class="form-group">
                        <h2 class="section-title">Additional Information</h2>
                            <label class="title-3">Address</label>
                            <input type="text" class="form-control" placeholder="" name="address" id="address" value="{{old('address',$quote->address)}}" />
                        @if ($errors->has('address'))
                        <span class="text-danger">&nbsp;{{ $errors->first('address') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="title-3">Engine Number</label>
                            <input type="text" class="form-control" placeholder="" name="engine_number" id="engine_number" value="{{old('engine_number',$quote->engine_number)}}" />
                        @if ($errors->has('engine_number'))
                        <span class="text-danger">&nbsp;{{ $errors->first('engine_number') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="title-3">Chassis Number </label>
                            <input type="text" class="form-control" placeholder="" name="chassis_number" id="chassis_number" value="{{old('chassis_number',$quote->chassis_number)}}" />
                        @if ($errors->has('chassis_number'))
                        <span class="text-danger">&nbsp;{{ $errors->first('chassis_number') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="title-3">Finance Company </label>
                            <input type="text" class="form-control" placeholder="" name="finance_company" id="finance_company" value="{{old('finance_company',$quote->finance_company)}}" />
                        @if ($errors->has('finance_company'))
                        <span class="text-danger">&nbsp;{{ $errors->first('finance_company') }}</span>
                        @endif
                        </div>

                        @php 
                        if(!empty($quote->start_date_of_proposal)){
                            $startDateOfPropoal = date('d-m-Y', strtotime($quote->start_date_of_proposal));
                        }else{
                            $startDateOfPropoal = date('d-m-Y');
                        }
                        @endphp
                        <div class="form-group">
                            <label class="title-3">Start Date of proposal </label>
                            <input type="text" class="form-control datepicker547" placeholder="" name="start_date_of_proposal" id="start_date_of_proposal" value="{{old('start_date_of_proposal',$startDateOfPropoal)}}" />
                        @if ($errors->has('start_date_of_proposal'))
                        <span class="text-danger">&nbsp;{{ $errors->first('start_date_of_proposal') }}</span>
                        @endif
                        </div>
                        @php 
                        if(!empty($quote->end_date)){
                            $endDateOfPropoal = date('d-m-Y', strtotime($quote->end_date));
                        }else{
                            $endDateOfPropoal = date('d-m-Y');
                        }
                        @endphp
                        <div class="form-group">
                            <label class="title-3">End Date </label>
                            <input type="text" class="form-control datepicker547" placeholder="" name="end_date" id="end_date" value="{{old('end_date',$endDateOfPropoal)}}" />
                        @if ($errors->has('end_date'))
                        <span class="text-danger">&nbsp;{{ $errors->first('end_date') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="title-3">Seating Capacity </label>
                            <input type="text" class="form-control" placeholder="" name="seating_capacity" id="seating_capacity" value="{{old('seating_capacity',$quote->seating_capacity)}}" />
                        @if ($errors->has('seating_capacity'))
                        <span class="text-danger">&nbsp;{{ $errors->first('seating_capacity') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="title-3">Previous Insurer</label>
                            <input type="text" class="form-control" placeholder="" name="previous_insurer" id="previous_insurer" value="{{old('previous_insurer',$quote->previous_insurer)}}" />
                        @if ($errors->has('previous_insurer'))
                        <span class="text-danger">&nbsp;{{ $errors->first('previous_insurer') }}</span>
                        @endif
                        </div>
                        <div class="form-group">
                                    @if(isset($quote->insurance_proposal_form))
                                           <label class="title-3">Company’s Insurance Proposal form </label><br />
                                           <a href="{{ asset($quote->insurance_proposal_form) }}" target="_blank">{{ asset($quote->insurance_proposal_form) }}</a>
                                    @else
                                    <div class="custom-file">
                                        <label class="form-control-file" for="customFile1">Company’s Insurance Proposal form </label>
                                        <input type="file" name="insurance_proposal_form" class="form-control-file" id="customFile1">

                                        <small class="text-muted">
                                            Only pdf, png, jpg, and gif
                                            files upto 2.5mb are accepted.
                                        </small>
                                        @if ($errors->has('insurance_proposal_form'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('insurance_proposal_form') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                        </div>
                        {{-- 
                        <div class="form-group">

                                @if(isset($quote->partner_sign))

                                    <label class="title-3" >Insurance Partner's Signature </label><br />
                                    <img height="200" src="{{ asset($quote->partner_sign) }}" alt="">
                                @else
                                <div class="custom-file">
                                        <label class="form-control-file" for="customFile1">Partner Sign </label>
                                        <div id="signature-pad" class="signature-pad">
                                <div class="signature-pad--body">
                                    <canvas></canvas>
                                </div>
                                <div class="signature-pad--footer">
                                    <div class="description">Insurance Partner's Signature<br />Please sign in the above box</div>

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
                                            <input type="hidden" name="partner_sign" value="">

                                        @if ($errors->has('partner_sign'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('partner_sign') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                <script src="{{ asset('js/signature_pad/signature_pad.umd.js') }}"></script>
                                   <script src="{{ asset('js/signature_pad/app.js') }}"></script>
                                @endif
                       </div>
                       --}}
                  @else
                  @if($quotations)
                   @foreach($quotations as $quotation)
                   <!--If quotation not accepted-->
                     <div class="row mb-2 quotation">
                     <hr style="width: 100%; color: black; height: 1px; background-color:grey;">
                     <div class="col-11"><div class="form-group"> <label for="">Quotation number </label> <input required="required" type="text" name="quotation_number[]" value="<?=$quotation->quotation_number?>" class="form-control"></div></div>
                     <div class="col-1 mt-4"> <a href="javascript:void(0);" class="btn btn-danger mr-1 mt-1 delete" title="<?=$quotation->id?>"><i title="<?=$quotation->id?>" class="fas fa-trash"></i></a></div>
                     <div class="col-12"><div class="form-group"><label>Insurer name </label><input type="text" class="form-control" required="required" name="insurer_name[]" id="insurer_name" value="<?=$quotation->insurer_name?>" /></div></div>
                     <div class="col-12"><div class="form-group"><label>Premium </label><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" name="premium[]" id="premium" value="<?=$quotation->premium?>" /></div></div>
                     <div class="col-12"><div class="form-group"><label>Excess: Own damage </label><input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" name="excess_own_damage[]" id="excess_own_damage" value="<?=$quotation->excess_own_damage?>" /></div></div>
                     <div class="col-12"><div class="form-group"><label>Excess: 3rd Party  </label><input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="excess_party[]" id="excess_party" value="<?=$quotation->excess_party?>" /></div></div>
                     <div class="col-12"><div class="form-group"><label>Remark  </label><input type="text" class="form-control" name="remark[]" id="remark" value="<?=$quotation->remark?>" /></div></div>
                     <input type="hidden" value="<?=$quotation->id?>" name="q_id[]" />
                     </div>
                   @endforeach
                  @endif
                
                  @php
                  if(old('quotation_number')){
                      $countt = count(old('quotation_number'));
                      $quotation_numberr = old('quotation_number');
                      $insurer_namee = old('insurer_name');
                      $premiumm = old('premium');
                      $excess_own_damagee = old('excess_own_damage');
                      $excess_partyy = old('excess_party');
                      $remarkO = old('remark');
                  }else{
                    $countt = 0;
                  }
                  @endphp
                  @if(!empty($countt))
                   @foreach(old('quotation_number') as $key=>$quotation)
                   <!--If quotation not accepted-->
                     <div class="row mb-2 quotation">
                     <hr style="width: 100%; color: black; height: 1px; background-color:grey;">
                     <div class="col-11"><div class="form-group"> <label for="">Quotation number </label> <input required="required" type="text" name="quotation_number[]" value="{{$quotation_numberr[$key] ?? ''}}" class="form-control"></div></div>

                     <div class="col-1 mt-4"> <a href="javascript:void(0);" class="btn btn-danger mr-1 mt-1 delete" title=""><i title="" class="fas fa-trash"></i></a></div>
                     <div class="col-12"><div class="form-group"><label>Insurer name </label><input type="text" class="form-control" required="required" name="insurer_name[]" id="insurer_name" value="{{$insurer_namee[$key] ?? ''}}" /></div></div>

                     <div class="col-12"><div class="form-group"><label>Premium </label><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" name="premium[]" id="premium" value="{{$premiumm[$key] ?? ''}}" /></div></div>

                     <div class="col-12"><div class="form-group"><label>Excess: Own damage </label><input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" name="excess_own_damage[]" id="excess_own_damage" value="{{$excess_own_damagee[$key] ?? ''}}" /></div></div>

                     <div class="col-12"><div class="form-group"><label>Excess: 3rd Party  </label><input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="excess_party[]" id="excess_party" value="{{$excess_partyy[$key] ?? ''}}" /></div></div>

                     <div class="col-12"><div class="form-group"><label>Remark  </label><input type="text" class="form-control" name="remark[]" id="remark" value="{{$remarkO[$key] ?? ''}}" /></div></div>

                     </div>
                   @endforeach
                  @endif
                    <div class="d-block">
                      <button type="button" class="btn btn-warning add_more">Add More</button>
                    </div>

                 @endif
                             @if(isset($insurance->insurance_pdf))
                              <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getInsuranceStatus())
                                            @foreach (getInsuranceStatus() as $key => $value)
                                                <option value="{{ $key }}" @if(old('status',$insurance->status)) @if(old('status',$insurance->status)==$key) selected  @endif @endif>{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                             @endif

                            </div>
                            <div class="card-footer text-right">
                            @if($insurance->insurance_pdf!=null)
                            <input type="hidden" name="final_pdf_submission" value="Y" />
                            @endif
                                <a href="{{ route('insurance.index') }}" class="btn btn-primary"><i class="fas fa-window-close"></i> Cancel</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                                <a href="{{ url('admin/insurance/seller', ['id'=>$insurance->id]) }}" class="btn btn-primary"><i class="fas fa-save"></i> Send PDF</a>
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
@if($insurance->insurance_pdf!=null)
<script>
    $(document).ready(function() {
        $("input, textarea").attr("readonly", true);
		$("input[type='radio'],select[name='main_driver_gender'],input[type='checkbox']").attr("disabled", true);
    });
</script>
@endif
<script type="text/javascript">
$('input[type=radio][name=named_driver]').change(function() {
    if (this.value == 1) {
        $("#section2").removeClass("hide");
    }
    else if (this.value == 2) {
        $("#section2").addClass("hide");
    }
});

$(function () {
        $("#engine_capacity").on('keyup', function () {
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


$(function() {
        $("input[name='partner_sign']").attr("disabled", false);
        $('.positive-integer').numeric(
            {negative: false}
        );

        // var canvas = document.querySelector("canvas");


        // var signaturePad = new SignaturePad(canvas, {
        //     onEnd: function () {
        //         $("input[name='partner_sign']").val(signaturePad.toDataURL("image/jpeg"));
        //     },
        //     backgroundColor: "white",
        // });
    });


$(document).ready(function () {
    $('.number_only').on('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
  });
$("body").on("click", ".add_more", function() {
	var numItems = $('.quotation').length;
	//alert(numItems);
	if(numItems>=5)
	{
	 alert("You couldn't add quotation more than 5 times.");
	 return false;
	}
	else
	{
	var content = '<div class="row mb-2 quotation"><hr style="width: 100%; color: black; height: 1px; background-color:black;"><div class="col-11"><div class="form-group"> <label for="">Quotation number </label> <input required="required" type="text" name="quotation_number[]" class="form-control"></div></div><div class="col-1 mt-4"> <a href="javascript:void(0);" class="btn btn-danger mr-1 mt-1 delete"><i class="fas fa-trash"></i></a></div><div class="col-12"><div class="form-group"><label>Insurer name </label><input type="text" class="form-control" required="required" name="insurer_name[]" id="insurer_name" value="" /></div></div><div class="col-12"><div class="form-group"><label>Premium </label><input type="text" pattern="[0-9]+([\.,][0-9]+)?" class="form-control number_only" name="premium[]" id="premium" value="" /></div></div><div class="col-12"><div class="form-group"><label>Excess: Own damage </label><input type="text" pattern="[0-9]+([\.,][0-9]+)?"  class="form-control positive-integer" name="excess_own_damage[]" id="excess_own_damage" value="" /></div></div><div class="col-12"><div class="form-group"><label>Excess: 3rd Party  </label><input type="text" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" name="excess_party[]" id="excess_party" value="" /></div></div><div class="col-12"><div class="form-group"><label>Remark  </label><input type="text" class="form-control" name="remark[]" id="remark" value="" /></div></div></div>';
	$(this).before(content);
	}

   });

        $("body").on("click", ".delete", function() {
			if($(this).attr("title"))
			{
			   var id=	$(this).attr("title");
			   if(confirm('Do you want to delete quotation?')==true)
			   {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$.ajax({
						method: 'post',
						url: '{{ url("admin/insurance/delete-quotation") }}',
						data: {
							id: id,
						},
						cache: false,
						async: true,
					});
				    $(this).parents("div.quotation").remove();
			   }

			}
			else
			{
            $(this).parents("div.quotation").remove();
			}
        });
});

$('.positive-integer').numeric(
            {negative: false}
        );
        
        
</script>
<style>
hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}
</style>
@endsection