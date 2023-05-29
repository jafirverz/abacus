@extends('layouts.app')

@section('content')
<div class="main-wrap" style="padding-bottom: 172px; padding-top: 79.7969px;">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
        @include('inc.breadcrumb')
        @include('inc.messages')
        
        @php 
        $chekSaved = \App\SellerParticular::where('user_id', Auth::user()->id)->where('issaved', 1)->orderBy('id', 'desc')->first();
        @endphp 

        <div class="note-2">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-7 col-md-8">
                    <h4>Faster form filling with Singpass <strong>(Individual)</strong>.</h4>
                    <p>Singpass enables you to retrieve your personal data from participating Government agencies.
                        With your consent, we can auto-fill this, making your application convenient.</p>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-4 last">
                    @if($chekSaved)
                    <a href="javascript::void(0);" class="btn-6"><strong>Retrieve
                            Myinfo</strong><br> <span>with <img src="{{ asset('images/tempt/singpass-logo.png') }}" alt="singpass"></span></a>
                    @else 
                    <a href="javascript::void(0);" onclick="callAuthoriseApi();" class="btn-6"><strong>Retrieve
                        Myinfo</strong><br> <span>with <img src="{{ asset('images/tempt/singpass-logo.png') }}" alt="singpass"></span></a>
                    @endif
                </div>
            </div>
        </div>
        
 <!--       <div class="note-2">-->
	<!--		<div class="row align-items-center">-->
	<!--				<div class="col-xl-8 col-lg-7 col-md-8">-->
	<!--						<h4>Faster form filling with Singpass <strong>(Business)</strong>.</h4>-->
	<!--						<p>Singpass enables you to retrieve your personal data from participating Government agencies.-->
	<!--								With your consent, we can auto-fill this, making your application convenient.</p>-->
	<!--				</div>-->
	<!--				<div class="col-xl-4 col-lg-5 col-md-4 last">-->
	<!--						<a href="javascript::void(0);" onclick="callAuthoriseApiBusiness();" class="btn-6"><strong>Retrieve-->
	<!--										Myinfo Business</strong> <br><span>with <img src="{{ asset('images/tempt/singpass-logo.png') }}"-->
	<!--												alt="singpass" /></span></a>-->
	<!--				</div>-->
	<!--		</div>-->
	<!--</div>-->
	{{--
	 <div class="note-2">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-7 col-md-8">
                    <p>Myinfo Business is currently unvailable.<br /> For business applications, kindly contact us at <a
                            href="tel:8939 3383"><strong>8939 3383</strong></a> or <a
                            href="mailto:info@diycars.com"><strong>info@diycars.com</strong></a></p>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-4 last"> <a href="#myinfo" class="btn-6"
                        data-toggle="modal"><strong>Retrieve Myinfo Business</strong> <br><span>with <img
                                src="{{ asset('images/tempt/singpass-logo.png') }}" alt="singpass" /></span></a> </div>
            </div>
        </div>
        <div id="myinfo" class="modal pp-agreement ppbg" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"> <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times-circle"></i></button>
                    <p>Myinfo Business is currently unvailable.<br /> For business applications, kindly contact us at <a
                            href="tel:8939 3383"><strong>8939 3383</strong></a> or <a
                            href="mailto:info@diycars.com"><strong>info@diycars.com</strong></a></p>
                </div>
            </div>
        </div>
        --}}

        @php 
		if(!empty(session()->get('myinfospagreement'))){
		    $data = serialize(session()->get('myinfospagreement'));
		    $test = unserialize($data);
    		if(sizeof($test)>0){
    		    $uinfin1 = $test['uinfin'] ?? '';
    		    $name1 = $test['name'] ?? '';
    		    $email1 = $test['email'] ?? '';
                $sex1 = $test['sex'] ?? '';
    		    $mobileno1 = $test['mobileno'] ?? '';
    		    $address = $test['address'] ?? '';
    		    $vehicle_number = $test['vehiclesNo'] ?? '';
				$vehicle_type = $test['type'] ?? '';
				$vehicle_make = $test['make'] ?? '';
				$vehicle_model = $test['model'] ?? '';
				$year_of_mfg = $test['yearofmanufacture'] ?? '';
				$orig_reg_date = $test['originalregistrationdate'] ?? '';
				$make_model = $test['make_model'] ?? '';
				$engine_cc = $test['enginecapacity'] ?? '';
				$chassisno = $test['chassisno'] ?? '';
				if(!empty($test['primarycolour'])){
				    $primary_color = ucwords(strtolower($test['primarycolour'])) ?? '';
				}else{
				    $primary_color = '';
				}
				
				$scheme = $test['scheme'] ?? '';
				$engineno = $test['engineno'] ?? '';
                $iulabelno = $test['iulabelno'] ?? '';
                $nooftransfers = $test['nooftransfers'] ?? '';
                if(!empty($test['minimumparfbenefit'])){
				    $minimumparfbenefit = ucwords(strtolower($test['minimumparfbenefit'])) ?? '';
				}else{
				    $minimumparfbenefit = '';
				}
                //$minimumparfbenefit = number_format($test['minimumparfbenefit']) ?? '';
                $coe_expiry_date = $test['coeexpirydate'] ?? '';
                $roadtaxexpirydate = $test['roadtaxexpirydate'] ?? '';
                if(!empty($test['openmarketvalue'])){
				    $open_market_value = ucwords(strtolower($test['openmarketvalue'])) ?? '';
				}else{
				    $open_market_value = '';
				}
                //$open_market_value = number_format($test['openmarketvalue']) ?? '';
                $first_reg_date = $test['firstregistrationdate'] ?? '';
                $countryCode = $test['countryCode'];
    		}
		}else{
		    if(Auth::user()){
		        $name1 = Auth::user()->name ?? '';
		        $mobileno1 = Auth::user()->mobile;
		        $email1 = Auth::user()->email;
		        $countryCode = Auth::user()->country_code;
		        if(Auth::user()->gender==1){
    		        $sex1 = 'MALE';
    		    }elseif(Auth::user()->gender==2){
    		        $sex1 = 'FEMALE';
    		    }
                $address = Auth::user()->address;
                $postalCode = Auth::user()->postal_code;
		    }else{
		        $name1 = '';
		        $sex1 = '';
		        $mobileno1 = '';
		        $email1 = '';
		        $countryCode = '';
		        
		       
		    }
				$dob1 = '';
				$marital1 = '';
				$nric = '';
                $postalCode = '';
                $address = '';
                $uinfin1 = '';
                $vehicle_number = '';
				$vehicle_type = '';
				$vehicle_make = '';
				$vehicle_model = '';
				$year_of_mfg = '';
				$orig_reg_date = '';
				$make_model = '';
				$engine_cc = '';
				$chassisno = '';
				$primary_color = '';
				$scheme = '';
				$engineno = '';
                $iulabelno = '';
                $nooftransfers = '';
                $minimumparfbenefit = '';
                $coe_expiry_date = '';
                $roadtaxexpirydate = '';
                $open_market_value = '';
                $first_reg_date = '';
		}
		if(!empty(session()->get('myinfospbusiness'))){
		    $data = serialize(session()->get('myinfospbusiness'));
		    $test = unserialize($data);
    		if(sizeof($test)>0){
    		    $uinfin1 = $test['uinfin'] ?? '';
    		    $name1 = $test['name'] ?? '';
    		    $email1 = $test['email'] ?? '';
    		    $mobileno1 = $test['mobileno'] ?? '';
    		    $address = $test['address'] ?? '';
                
    		}
		}
		@endphp

        @if($chekSaved)


        <form action="{{ url('forms/form-details') }}" class="form-ani" method="POST" enctype="multipart/form-data" >
            @csrf

            <div id="filledform">
            @if(!empty($carId))
            <input type="hidden" name="carId" value="{{ $carId }}">
            @endif
            <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
            <h3 class="title-6"><span><strong>Seller's Particular</strong></span></h3>
            <div class="row">
                <div class="col-xl-6">
                    <div class="inrow empty">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="seller_name" id="fullname"
                            value="{{ old('seller_name', $chekSaved->seller_name) ?? '' }}" />
                    </div>
                    @if ($errors->has('seller_name'))
                    <span class="text-danger d-block">
                     {{ $errors->first('seller_name') }}
                    </span>
                    @endif
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="inrow empty">
                        <label>NRIC/FIN</label>
                        <input type="text" class="form-control" name="nric" id="nricmain" value="{{ old('nric', $chekSaved->nric) ?? '' }}"
                            >
                    </div>
                    @if ($errors->has('nric'))
                    <span class="text-danger d-block">
                        {{ $errors->first('nric') }}
                    </span>
                    @endif
                </div>
                <!-- <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>UEN</label>
                        <input type="text" class="form-control" name="uen" value="{{ old('uen') ?? '' }}" maxlength="4"
                            minlength="4">
                    </div>
                    @if ($errors->has('uen'))
                    <span class="text-danger d-block">
                        <strong>{{ $errors->first('uen') }}</strong>
                    </span>
                    @endif
                </div> -->
                <div class="col-xl-3 col-md-6">
                    <div class="inrow empty">
                        <label>Passport Number (Optional)</label>
                        <input type="text" class="form-control" name="passport" id="passport" value="{{ old('passport', $chekSaved->passport) ?? '' }}"
                            maxlength="4" minlength="4">
                    </div>
                    @if ($errors->has('passport'))
                    <span class="text-danger d-block">
                        {{ $errors->first('passport') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3">
					<div class="mt-20">
						@if(!empty(session()->get('myinfospagreement')))	
					    <input type="text" class="form-control" name="gender" readonly="readonly" value="{{ $sex1 ?? '' }}" />	
					    @else	
    						@if(Auth::check())	
    						<select class="selectpicker" name="gender" id="gender" data-title="Gender">	
    							<option @if(old('gender')=="Male" ) selected="selected" @elseif($chekSaved->seller_gender == 'Male')	
    								selected="selected" @endif value="Male">Male</option>	
    							<option @if(old('gender')=="Female" ) selected="selected" @elseif($chekSaved->seller_gender == 'Female')	
    								selected="selected" @endif value="Female">Female</option>	
    						</select>	
    						@else	
    						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" value=""	
    							@if(!Auth::check()) readonly="readonly" @endif />	
    						@endif	
    					@endif

						@if ($errors->has('gender'))
						<span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
						@endif
					</div>
				</div>
                <div class="col-xl-5 col-lg-7">
                    <div class="row sp-col-10 break-425">
                        <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                            @if(empty(session()->get('myinfospagreement')))
                                <div class="mt-20">
                                        <select class="selectpicker" name="seller_country_code" data-title="Country Code" >
                                            <option value="+65" @if(old('seller_country_code')=="+65" ) selected="selected" @elseif($chekSaved->seller_country_code == "+65") selected @endif>+65</option>
                                            <option value="+66" @if($chekSaved->seller_country_code == "+66" ) selected="selected" @endif>+66</option>
                                            <option value="+673" @if($chekSaved->seller_country_code == "+673" ) selected="selected" @endif>+673</option>
                                            
                                        </select>
                                    @if ($errors->has('seller_country_code'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('seller_country_code') }}
                                    </span>
                                    @endif
                                </div>
                            @else
                                <div class="inrow empty">
                                    <label>Country Code</label>
                                    <input type="text" class="form-control" name="seller_country_code" id="seller_country_code" value="{{ $countryCode ?? '' }}" maxlength="4" minlength="4">
                                </div>
                                @if ($errors->has('seller_country_code'))
                                <span class="text-danger d-block">
                                    {{ $errors->first('seller_country_code') }}
                                </span>
                                @endif
                            @endif
                            
                        </div>
                        <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                            <div class="inrow empty">
                                <label>Contact No.</label>
                                <input type="text" class="form-control" name="seller_mobile"
                                    value="{{ old('seller_mobile', $chekSaved->seller_mobile ?? '') }}">
                            </div>
                            @if ($errors->has('seller_mobile'))
                            <span class="text-danger d-block">
                                {{ $errors->first('seller_mobile') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="inrow empty">
                        <label>Email Address (Ex: janedoe@gmail.com)</label>
                        <input type="text" class="form-control" name="seller_email"
                            value="{{ old('seller_email', $chekSaved->seller_email ?? '') }}">
                    </div>
                    @if ($errors->has('seller_email'))
                    <span class="text-danger d-block">
                       {{ $errors->first('seller_email') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="inrow empty">
                        <label>Address (Block Number), (Street Name), (Floor)-(Unit Number), Singapore (Postal Code)</label>
                        <input type="text" class="form-control" name="address" id="address"
                            value="{{ old('address', $chekSaved->address) ?? '' }}">
                    </div>
                    @if ($errors->has('address'))
                    <span class="text-danger d-block">
                       {{ $errors->first('address') }}
                    </span>
                    @endif
                </div>
                {{-- <div class="col-md-3 sp-col">
                    <div class="inrow empty">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" name="postal_code"
                            value="{{ old('postal_code', $chekSaved->seller_name) ?? '' }}">
                    </div>
                    @if ($errors->has('postal_code'))
                    <span class="text-danger d-block">
                       {{ $errors->first('postal_code') }}
                    </span>
                    @endif
                </div> --}}
            </div>
            @php
            if(!empty($carId) && empty(session()->get('myinfospagreement'))){
                $vehicleDetail = \App\VehicleDetail::where('vehicle_id', $carId)->first();
                if($vehicleDetail){
                    $vehicle_number = $vehicleDetail->vehicle_number;
                    $vehicle_make = $vehicleDetail->vehicle_make;
                    $vehicle_model = $vehicleDetail->vehicle_model;
                    $primary_color = $vehicleDetail->primary_color;
                    $year_of_mfg = $vehicleDetail->year_of_mfg;
                    $first_reg_date = $vehicleDetail->first_reg_date;
                    $vehicle_type = $vehicleDetail->vehicle_type;
                    $engine_cc = $vehicleDetail->engine_cc;
                    $coe_expiry_date = $vehicleDetail->coe_expiry_date;
                    $open_market_value = $vehicleDetail->open_market_value;
                    $orig_reg_date = $vehicleDetail->orig_reg_date;
                    $scheme = $vehicleDetail->vehicle_scheme;
                    $chassisno ='';
                    $engineno = '';
                    $iulabelno = '';
                    $nooftransfers = '';
                    $minimumparfbenefit = '';
                    $roadtaxexpirydate = '';
                }
            }
            
            @endphp
            <h3 class="title-6"><span><strong>Vehicle Details</strong></span></h3>
            <div id="vehicleDetails">
                <div class="row">
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                            <div class="inrow empty">
                                <label>Vehicle No. (Ex: SBY1234A)</label>
                                <input type="text" class="form-control" name="registration_no"
                                    value="{{ old('registration_no', $chekSaved->vehicleparticular->registration_no ?? '') ?? '' }}">
                            </div>
                            @if ($errors->has('registration_no'))
                            <span class="text-danger d-block">
                               {{ $errors->first('registration_no') }}
                            </span>
                            @endif
                        @else
                            <div class="inrow empty">
                                <label>Vehicle No. (Ex: SBY1234A)</label>
                                <input type="text" class="form-control" readonly name="registration_no"
                                    value="{{ $vehicle_number ?? ''}}">
                            </div>
                            @if ($errors->has('registration_no'))
                            <span class="text-danger d-block">
                               {{ $errors->first('registration_no') }}
                            </span>
                            @endif
                        @endif

                    </div>

                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                            <div class="inrow empty">
                                <label>Vehicle Make (Ex: Toyota)</label>
                                <input type="text" class="form-control" name="make" value="{{ old('make', $chekSaved->vehicleparticular->make ?? '') ?? '' }}">
                            </div>
                            @if ($errors->has('make'))
                            <span class="text-danger d-block">
                               {{ $errors->first('make') }}
                            </span>
                            @endif
                        @else 
                            <div class="inrow empty">
                                <label>Vehicle Make (Ex: Toyota)</label>
                                <input type="text" class="form-control" readonly name="make" value="{{ $vehicle_make ?? '' }}">
                            </div>
                            @if ($errors->has('make'))
                            <span class="text-danger d-block">
                               {{ $errors->first('make') }}
                            </span>
                            @endif
                        @endif
                        
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow empty">
                            <label>Vehicle Model (Ex: Corolla)</label>
                            <input type="text" class="form-control" name="model" value="{{ old('model', $chekSaved->vehicleparticular->model ?? '') ?? '' }}">
                        </div>
                        @if ($errors->has('model'))
                        <span class="text-danger d-block">
                           {{ $errors->first('model') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>Original Registration Date</label>
                            <input type="text" class="form-control" name="registration_date"
                                value="{{ old('registration_date', date('d-m-Y', strtotime($chekSaved->vehicleparticular->registration_date)) ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @if ($errors->has('registration_date'))
                        <span class="text-danger d-block">
                           {{ $errors->first('registration_date') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="mt-20">
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>First Registration Date</label>
                                <input type="text" class="form-control" name="first_registration_Date"
                                value="{{ old('first_registration_Date', date('d-m-Y', strtotime($chekSaved->first_registration_Date)) ?? '') ?? '' }}">
                                <i class="fas fa-calendar-alt"></i>
                            
                            </div>
                            @if ($errors->has('first_registration_Date'))
                            <span class="text-danger d-block">
                               {{ $errors->first('first_registration_Date') }}
                            </span>
                            @endif  
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow empty">
                            <label>Manufacturing Year (Ex: 2017)</label>
                            <input type="text" class="form-control" name="year_of_manufacturer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value="{{ old('year_of_manufacturer', $chekSaved->vehicleparticular->year_of_manufacturer ?? '') ?? '' }}" minlength="4" maxlength="4">
                        </div>
                        @if ($errors->has('year_of_manufacturer'))
                        <span class="text-danger d-block">
                           {{ $errors->first('year_of_manufacturer') }}
                        </span>
                        @endif
                    </div>

                    
                    
                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="inrow empty">
                            <label>Engine No.</label>
                            <input type="text" class="form-control" name="engine_no" value="{{ old('engine_no', $chekSaved->vehicleparticular->engine_no ?? '') ?? '' }}">
                        </div>
                        @if ($errors->has('engine_no'))
                        <span class="text-danger d-block">
                           {{ $errors->first('engine_no') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow empty">
                            <label>Chassis No.</label>
                            <input type="text" class="form-control" name="chassis_no" value="{{ old('chassis_no', $chekSaved->vehicleparticular->chassis_no ?? '') ?? '' }}">
                        </div>
                        @if ($errors->has('chassis_no'))
                        <span class="text-danger d-block">
                           {{ $errors->first('chassis_no') }}
                        </span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="inrow empty">
                            <label>Transfer Count</label>
                            <input type="text" class="form-control" name="no_of_transfer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="2" maxlength="2"
                                value="{{ old('no_of_transfer', $chekSaved->vehicleparticular->no_of_transfer ?? '') ?? '' }}">
                        </div>
                        @if ($errors->has('no_of_transfer'))
                        <span class="text-danger d-block">
                           {{ $errors->first('no_of_transfer') }}
                        </span>
                        @endif
                    </div>
                    
                    
                </div>
                <div class="row">
                    @if(empty(session()->get('myinfospagreement')))
                        <div class="col-lg-4 mt-20">
                                <select class="selectpicker" name="color" data-title="Primary Color" >
                                <option value="White" @if($chekSaved->vehicleparticular->color =="White") selected="selected" @endif>White</option>
                                <option value="Black" @if($chekSaved->vehicleparticular->color=="Black") selected="selected" @endif>Black</option>
                                <option value="Grey" @if($chekSaved->vehicleparticular->color=="Grey") selected="selected" @endif>Grey</option>
                                <option value="Silver" @if($chekSaved->vehicleparticular->color=="Silver") selected="selected" @endif>Silver</option>
                                <option value="Red" @if($chekSaved->vehicleparticular->color=="Red") selected="selected" @endif>Red</option>
                                <option value="Blue" @if($chekSaved->vehicleparticular->color=="Blue") selected="selected" @endif>Blue</option>
                                <option value="Brown" @if($chekSaved->vehicleparticular->color=="Brown") selected="selected" @endif>Brown</option>
                                <option value="Green" @if($chekSaved->vehicleparticular->color=="Green") selected="selected" @endif>Green</option>
                                <option value="Beige" @if($chekSaved->vehicleparticular->color=="Beige") selected="selected" @endif>Beige</option>
                                <option value="Orange" @if($chekSaved->vehicleparticular->color=="Orange") selected="selected" @endif>Orange</option>
                                <option value="Gold" @if($chekSaved->vehicleparticular->color=="Gold") selected="selected" @endif>Gold</option>
                                <option value="Yellow" @if($chekSaved->vehicleparticular->color=="Yellow") selected="selected" @endif>Yellow</option>
                                <option value="Purple" @if($chekSaved->vehicleparticular->color=="Purple") selected="selected" @endif>Purple</option>
                                <option value="Pink" @if($chekSaved->vehicleparticular->color=="Pink") selected="selected" @endif>Pink</option>
                                <option value="Others" @if($chekSaved->vehicleparticular->color=="Others") selected="selected" @endif>Others</option>
                            </select>
                            
                            @if ($errors->has('color'))
                            <span class="text-danger d-block">
                               {{ $errors->first('color') }}
                            </span>
                            @endif
                        </div>
                    @else
                        <div class="col-lg-4">
                            <div class="inrow empty">
                                <label>Primary Color</label>
                                <input type="text" class="form-control" name="color"
                                    value="{{ $primary_color ?? '' }}">
                            </div>
                            @if ($errors->has('color'))
                            <span class="text-danger d-block">
                               {{ $errors->first('color') }}
                            </span>
                            @endif
                        </div>
                    @endif




                    <div class="col-lg-4">
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>COE Expiry Date</label>
                            <input type="text" class="form-control" name="coe_expiry_date"
                                value="{{ old('coe_expiry_date', date('d-m-Y', strtotime($chekSaved->vehicleparticular->coe_expiry_date)) ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @if ($errors->has('coe_expiry_date'))
                        <span class="text-danger d-block">
                            {{ $errors->first('coe_expiry_date') }}
                        </span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>Road Tax Expiry Date</label>
                            <input type="text" class="form-control" name="road_tax_expiry_date"
                                value="{{ old('road_tax_expiry_date', date('d-m-Y', strtotime($chekSaved->vehicleparticular->road_tax_expiry_date)) ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @if ($errors->has('road_tax_expiry_date'))
                        <span class="text-danger d-block">
                           {{ $errors->first('road_tax_expiry_date') }}
                        </span>
                        @endif
                    </div>
                    
                    
                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        @php 
                        if(!empty($chekSaved->vehicleparticular->engine_output)){
                            $engineCapacity = number_format($chekSaved->vehicleparticular->engine_output);
                        }else{
                            $engineCapacity = '';
                        }
                        @endphp
                        <div class="inrow inptxt empty">
                            <label>Engine Capacity (Ex: 1794 cc)</label>
                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ old('engine_output', $engineCapacity ?? '') ?? '' }}" name="engine_output">
                            <span class="txt">CC</span>
                        </div>
                        @if ($errors->has('engine_output'))
                        <span class="text-danger d-block">
                           {{ $errors->first('engine_output') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow inptxt lefttxt empty">
                            <label>Open Market Value</label>
                            <span class="txt">$</span>
                            <input type="text" class="form-control" onkeyup="addCommas(this.value, 'open_market_value');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="open_market_value" name="open_market_value"
                                value="{{ old('open_market_value', number_format($chekSaved->vehicleparticular->open_market_value) ?? '') ?? '' }}">
                            
                        </div>
                        @if ($errors->has('open_market_value'))
                        <span class="text-danger d-block">
                           {{ $errors->first('open_market_value') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow inptxt lefttxt empty">
                            <label>Minimum PARF Benefit</label>
                            <span class="txt">$</span>
                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="arf_paid" id="minimumparfbenefit" value="{{ old('arf_paid', number_format($chekSaved->vehicleparticular->arf_paid) ?? '') ?? '' }}">
                            
                        </div>
                        @if ($errors->has('arf_paid'))
                        <span class="text-danger d-block">
                           {{ $errors->first('arf_paid') }}
                        </span>
                        @endif
                    </div>

                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="mt-20">
                                <select class="selectpicker" name="vehicle_type" data-title="Vehicle Type">
                                    <option value="Mid-Sized Sedan" @if($chekSaved->vehicleparticular->vehicle_type=="Mid-Sized Sedan" ) selected="selected" @endif>Mid-Sized Sedan</option>
                                    <option value="Luxury Sedan"  @if($chekSaved->vehicleparticular->vehicle_type=="Luxury Sedan" ) selected="selected" @endif>Luxury Sedan</option>
                                    <option value="Hatchback"  @if($chekSaved->vehicleparticular->vehicle_type=="Hatchback" ) selected="selected" @endif>Hatchback</option>
                                    <option value="SUV"  @if($chekSaved->vehicleparticular->vehicle_type=="SUV" ) selected="selected" @endif>SUV</option>
                                    <option value="Passenger Car"  @if($chekSaved->vehicleparticular->vehicle_type=="Passenger Car" ) selected="selected" @endif>Passenger Car</option>
                                    <option value="MPV"  @if($chekSaved->vehicleparticular->vehicle_type=="MPV" ) selected="selected" @endif>MPV</option>
                                    <option value="Station Wagon"  @if($chekSaved->vehicleparticular->vehicle_type=="Station Wagon" ) selected="selected" @endif>Station Wagon</option>
                                    <option value="Sports Car"  @if($chekSaved->vehicleparticular->vehicle_type=="Sports Car" ) selected="selected" @endif>Sports Car</option>
                                    <option value="Commercial Vehicle"  @if($chekSaved->vehicleparticular->vehicle_type=="Commercial Vehicle" ) selected="selected" @endif>Commercial Vehicle</option>
                                    <option value="Van"  @if($chekSaved->vehicleparticular->vehicle_type=="Van" ) selected="selected" @endif>Van</option>
                                    <option value="Truck"  @if($chekSaved->vehicleparticular->vehicle_type=="Truck" ) selected="selected" @endif>Truck</option>
                                    <option value="Bus/Mini Bus"  @if($chekSaved->vehicleparticular->vehicle_type=="Bus/Mini Bus" ) selected="selected" @endif>Bus/Mini Bus</option>
                                    <option value="Others"  @if($chekSaved->vehicleparticular->vehicle_type=="Others" ) selected="selected" @endif>Others</option>
                                </select>
                            @if ($errors->has('vehicle_type'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_type') }}
                            </span>
                            @endif
                            
                        </div>
                        @else
                        <div class="inrow inptxt lefttxt empty">
                            <label>Vehicle Type</label>
                            <input type="text" class="form-control" readonly name="vehicle_type" value="{{ $vehicle_type ?? '' }}">
                            
                        </div>
                        @if ($errors->has('vehicle_type'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_type') }}
                            </span>
                            @endif
                        @endif
                    </div>
                    
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="mt-20">
                            <select class="selectpicker" name="vehicle_scheme" data-title="Vehicle Scheme (- represents normal)">
                                <option value="Normal" @if($chekSaved->vehicleparticular->vehicle_scheme=="Normal" ) selected="selected" @endif>Normal</option>
                                <option value="OPC (Off Peak Car)" @if($chekSaved->vehicleparticular->vehicle_scheme=="OPC (Off Peak Car)" ) selected="selected" @endif>OPC (Off Peak Car)</option>
                                <option value="Classic" @if($chekSaved->vehicleparticular->vehicle_scheme=="Classic" ) selected="selected" @endif>Classic</option>
							    <option value="Vintage" @if($chekSaved->vehicleparticular->vehicle_scheme=="Vintage" ) selected="selected" @endif>Vintage</option>
                            </select>
                            @if ($errors->has('vehicle_scheme'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_scheme') }}
                            </span>
                            @endif
                        </div>
                        @else 
                        <div class="inrow inptxt lefttxt empty">
                            <label>Vehicle Scheme (- represents normal)</label>
                            <input type="text" class="form-control" readonly name="vehicle_scheme" value="{{ $scheme ?? '' }}">
                            
                        </div>
                        @if ($errors->has('vehicle_scheme'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_scheme') }}
                            </span>
                            @endif
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow empty">
                            <label>IU Label Number</label>
                            <input type="text" class="form-control" value="{{ old('iu_label_number', $chekSaved->vehicleparticular->iu_label_number ?? '') ?? '' }}" name="iu_label_number">
                        </div>
                        @if ($errors->has('iu_label_number'))
                        <span class="text-danger d-block">
                           {{ $errors->first('iu_label_number') }}
                        </span>
                        @endif
                    </div>

                </div>
            </div>

            <!-- <div class="grtype mt-20">
                <h3 class="title-6 item"><span><strong>Is this an used Import: </strong></span></h3>
                <div class="check-inline item">
                    <div class="radio">
                        <input type="radio" id="yes" name="use" value="yes">
                        <label for="yes">Yes</label>
                    </div>
                    <div class="radio">
                        <input type="radio" name="use" id="no" value="no">
                        <label for="no">No</label>
                    </div>
                </div>
            </div> -->
            <!-- <div class="row">
                <div class="col-lg-4">
                    <div class="mt-20">
                        <div class="inrow date-wrap datepicker-wrap">
                            <label>First Registration Date</label>
                            <input type="text" class="form-control" name="first_registration_Date"
                            value="{{ old('first_registration_Date') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                           
                        </div>
                        
                    </div>
                </div>
            </div> -->
            <h3 class="title-6"><span><strong>Terms and Conditions</strong></span></h3>
            @if ($errors->has('terms'))
            <span class="text-danger d-block">
               {{ $errors->first('terms') }}
            </span>
            @endif

            @php
            $termsArray = array('Subject to loan approval within 7 working days', 'Number retention (Vehicle will be replaced with a random assigned vehicle no. by LTA).', 'Vehicle sold as it is.', 'No inspection required.', 'No spare key. (Buyer to duplicate at own expense)', 'No owners manual.');
            $textMatch = 'Subject to completion of sale by';
            $textMatch1 = 'Indicative mileage';
            $terms = json_decode($chekSaved->spcontract->terms_and_condition);
            if(sizeof($terms) > 0){
                $terms = $terms;
            }else{
                $terms = old('terms') ?? [];
            }
            @endphp
            
            <div class="row sp-col-10">
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        
                        <input id="loan" type="checkbox"  name="terms[]" onchange="checkcheckbox('term');"
                            value="Subject to loan approval within 7 working days" @if(in_array('Subject to loan approval within 7 working days', $terms)) checked @endif>
                        <label for="loan">Subject to loan approval within 7 working days.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="retention" type="checkbox" name="terms[]" onchange="checkcheckbox('term');" value="Number retention (Vehicle will be replaced with a random assigned vehicle no. by LTA)." @if(in_array('Number retention (Vehicle will be replaced with a random assigned vehicle no. by LTA).', $terms)) checked @endif>
                        <label for="retention">Number retention (Vehicle will be replaced with a random assigned vehicle no. by LTA).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="sold" type="checkbox" name="terms[]" onchange="checkcheckbox('term');" value="Vehicle sold as it is." @if(in_array('Vehicle sold as it is.', $terms)) checked @endif>
                        <label for="sold">Vehicle sold as it is.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="noinspection" name="terms[]" onchange="checkcheckbox('term');" type="checkbox" value="No inspection required." @if(in_array('No inspection required.', $terms)) checked @endif>
                        <label for="noinspection">No inspection required.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="spare" type="checkbox" name="terms[]" onchange="checkcheckbox('term');"
                            value="No spare key. (Buyer to duplicate at own expense)" @if(in_array('No spare key. (Buyer to duplicate at own expense)', $terms)) checked @endif>
                        <label for="spare">No spare key. <br>(Buyer to duplicate at own expense)</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="owners" type="checkbox" name="terms[]" onchange="checkcheckbox('term');" value="No owners manual." @if(in_array('No owners manual.', $terms)) checked @endif>
                        <label for="owners">No owner's manual.</label>
                    </div>
                </div>
                <div class="col-lg-8 sp-col mt-20">
                    <div class="row sp-col-10 break-575 typedate">
                        <div class="col-auto sp-col pt-10">
                            @php 
                            $valuee = '';
                            foreach($terms as $index => $string) {
                                if (strpos($string, 'Subject to Completion of Sale by') !== FALSE){
                                    $valuee = $string;
                                    $valex = explode(':',$valuee);
                                    $dateval = $valex[1];
                                }
                                    
                            }
                            @endphp
                            <div class="checkbox">
                                <input id="sale" name="terms[]" @if(!empty($valuee)) checked @endif type="checkbox" onchange="removecheckbox('termsdate');" value="">
                                <label for="sale">Subject to completion of sale by:</label>
                            </div>
                        </div>
                        <div class="col sp-col">
							<div class="date-wrap datepicker-wrap maxw-180 empty">
								<input type="text" id="termsdate" class="form-control" data-date-format="DD-MMM-YYYY" onmouseup="removecheck();"  value="{{ $dateval ?? '' }}" name="termsdate" />
								<i class="fas fa-calendar-alt"></i>                                
							</div>
							<div class="checknote" id="termsdateerror"></div>    
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 sp-col mt-20">
                    <div class="row sp-col-10 break-575 typedate">
                        <div class="col-auto sp-col pt-10">
                            @php 
                            $valueeM = '';
                            foreach($terms as $index => $string) {
                                if (strpos($string, 'Indicative Mileage') !== FALSE){
                                    $valueeM = $string;
                                    $valex = explode(':',$valueeM);
                                    $valex[1] = str_replace('Km', '', $valex[1]);
                                    $datevalM = $valex[1];
                                }
                                    
                            }
                            @endphp
                            <div class="checkbox">
                                <input id="indicative_mileagecheck" name="terms[]" @if(!empty($valueeM)) checked @endif onchange="checkcontent('indicative_mileage');" type="checkbox" value="">
                                <label for="indicative_mileagecheck">Indicative mileage:</label>
                            </div>
                        </div>
                        <div class="col sp-col">
							<div class="checkmg">
								<div class="input-group maxw-180 grinput rtext">
									<input type="text" class="form-control" id="indicative_mileage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="indicative_mileage" value="{{ $datevalM ?? ''}}"><span class="input-group-text">KM</span>
								</div>
								<div id="indicative_mileageerror"></div>
							</div>
                        </div>

                        
                    </div>
                </div>
                @foreach($terms as $term)
                @if(!in_array($term, $termsArray))
                    @if(stripos($term, "Subject to completion of sale by") !== false || stripos($term, "Indicative mileage") !== false)
                    @else
                    <div class="row sp-col-10">
                        <div class="col-lg-4 col-md-6 sp-col mt-20">
                            <div class="checkbox">
                                <input id="spare" type="checkbox" name="terms[]" onchange="checkcheckbox('term');"
                                    value="{{$term}}" @if(in_array($term, $terms)) checked @endif>
                                <label for="spare">{{$term}}</label>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
                @endforeach
                <div id="termsadded"></div>
                <div id="othertermsextra" style="display: block;" class="col-lg-8 sp-col mt-20">
                    @php 
                    $addedTerms= old('termsadded') ?? '';
                    $checkedTerms= old('terms') ?? '';
                    @endphp
                    @if($addedTerms)
                    @foreach($addedTerms as $trw)
                    <div class="checkbox">
                        <input type="checkbox" name="terms[]" @if(in_array($trw,$checkedTerms)) checked @endif value="{{$trw}}" onchange="checkcheckbox();">
                        <label for="extra">{{$trw}}</label>
                    </div>
                    @endforeach
                    @endif
                </div>

                <div class="col-lg-12 sp-col mt-20">
                    <div class="row align-items-center sp-col-10">
                        <div class="col-auto sp-col">
                            <!-- <div class="checkbox">
                                <input id="other" type="checkbox" name="otherTerms" value="otherTerms">
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
										<input type="text" class="form-control" value="" id="otherdesc" name="otherconditions">
										<button type="button" onclick="addotherterms();">Add +</button>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="note-3">
                <ol id="termsdesc">
                   
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <h4 class="title-7"><span><strong>Selling Price</strong></span></h4>
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="selling_price" id="selling_price"
                            value="{{ old('selling_price', number_format($chekSaved->spcontract->selling_price)) ?? '' }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    @if ($errors->has('selling_price'))
                    <span class="text-danger d-block">
                       {{ $errors->first('selling_price') }}
                    </span>
                    @endif
                </div>
                <div class="col-lg-3 col-sm-6">
                    <h4 class="title-7"><span><strong>Deposit</strong></span></h4>
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="deposit" value="{{ old('deposit', number_format($chekSaved->spcontract->deposit)) ?? '' }}"
                            placeholder="" id="deposit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    @if ($errors->has('deposit'))
                    <span class="text-danger d-block">
                       {{ $errors->first('deposit') }}
                    </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <h4 class="title-7"><span><strong>Balance Payment (Before Loan Amount)</strong></span></h4>
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="balance_payment"
                            value="{{ old('balance_payment', number_format($chekSaved->spcontract->balance_payment)) ?? '' }}" placeholder="" readonly>
                    </div>
                    @if ($errors->has('balance_payment'))
                    <span class="text-danger d-block">
                       {{ $errors->first('balance_payment') }}
                    </span>
                    @endif
                </div>
            </div>
            <h4 class="title-7"><span><strong>Buyer’s Contact Information</strong></span></h4>
            <div class="row">
                <div class="col-xl-7 col-lg-5">
                    <div class="inrow empty">
                        <label>Email Address (Ex: janedoe@gmail.com)</label>
                        <input type="text" class="form-control" name="buyer_email"
                            value="{{ old('buyer_email', $chekSaved->buyer_email) ?? '' }}">
                    </div>
                    @if ($errors->has('buyer_email'))
                    <span class="text-danger d-block">
                       {{ $errors->first('buyer_email') }}
                    </span>
                    @endif
                </div>
                <div class="col-xl-5 col-lg-7">
                    <div class="row sp-col-10 break-425">
                        <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                            <div class="mt-20">
                                    <select class="selectpicker" name="country_code" data-title="Buyer's Country Code" >
                                        <option value="+65" @if($chekSaved->country_code=="+65" ) selected="selected" @elseif(empty(old('country_code'))) selected @endif>+65</option>
                                        <option value="+66" @if($chekSaved->country_code=="+66" ) selected="selected" @endif>+66</option>
                                        <option value="+673" @if($chekSaved->country_code=="+673" ) selected="selected" @endif>+673</option>
                                        
                                    </select>
                                @if ($errors->has('country_code'))
                                <span class="text-danger d-block">
                                    {{ $errors->first('country_code') }}
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
                                    value="{{ old('buyer_mobile', str_replace('+65', '', $chekSaved->buyer_mobile)) ?? '' }}">
                            </div>
                            @if ($errors->has('buyer_mobile'))
                            <span class="text-danger d-block">
                               {{ $errors->first('buyer_mobile') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkbox mt-20">
				<input id="agree" type="checkbox" required checked>  
				<label for="agree">I acknowledge and agree to the collection, use and disclosure of my personal data which has been provided for the purpose of creating a Sales and Purchase Agreement, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.</label>
			</div>

        </div>

            <input type="hidden" name="sendEmailandW" value="1">
            <input type="hidden" name="seller_particular" value="{{ $chekSaved->id }}">
            <div class="output-2">
                <button class="btn-1 minw-190" type="submit" value="saveUpdate" name="savebutton">Save and Exit <i class="fas fa-arrow-right"></i></button>
                <!-- <a href="https://verzview.com/html/autolink-new/forms.html#" class="btn-1 minw-190">View your Agreement
                    <i class="fas fa-arrow-right"></i></a> -->
                <button class="btn-1 minw-190" type="submit" value="submitSaved" name="savebutton">Submit Agreement to Buyer <i
                        class="fas fa-arrow-right"></i></button>
            </div>
            <hr class="mt-50 mb-50">

        </form>

        @else 

        <form action="{{ url('forms/form-details') }}" class="form-ani" method="POST" enctype="multipart/form-data">
            @csrf
            @if(!empty($carId))
            <input type="hidden" name="carId" value="{{ $carId }}">
            @endif
            <h2 class="title-2 mt-30">Sales and Purchase Agreement</h2>
            <h3 class="title-6"><span><strong>Seller's Particular</strong></span></h3>
            <div class="row">
                <div class="col-xl-6">
                    <div class="inrow empty">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="seller_name" id="fullname" @if(!empty($name1)  && !empty(session()->get('myinfospagreement'))) readonly="readonly" @endif
                            value="{{ old('seller_name', $name1) ?? '' }}" />
                    </div>
                    @if(empty($name1) && empty(old('seller_name')) && !empty(session()->get('myinfospagreement')) && !$errors->has('seller_name'))
					<span class="text-danger">This field is required</span>
				    @endif
                    @if ($errors->has('seller_name'))
                    <span class="text-danger d-block">
                       {{ $errors->first('seller_name') }}
                    </span>
                    @endif
                </div>
                @php
                if(!empty($carId) && empty(session()->get('myinfospagreement'))){
                    $vehicleDetail = \App\VehicleDetail::where('vehicle_id', $carId)->first();
                    if($vehicleDetail){
                        $uinfin1 = $vehicleDetail->nric;
                    }
                }
                @endphp
                <div class="col-xl-3 col-md-6">
                    <div class="inrow empty">
                        <label>NRIC/FIN</label>
                        <input type="text" class="form-control" name="nric" @if(!empty($uinfin1)) readonly="readonly" @endif id="nricmain" value="{{ old('nric', $uinfin1) ?? '' }}"
                            >
                    </div>
                    @if(empty($uinfin1) && empty(old('nric')) && !empty(session()->get('myinfospagreement')) && !$errors->has('nric'))
					<span class="text-danger">This field is required</span>
				    @endif
                    @if ($errors->has('nric'))
                    <span class="text-danger d-block">
                       {{ $errors->first('nric') }}
                    </span>
                    @endif
                </div>
                <!-- <div class="col-xl-2 col-md-4">
                    <div class="inrow empty">
                        <label>UEN</label>
                        <input type="text" class="form-control" name="uen" value="{{ old('uen') ?? '' }}" maxlength="4"
                            minlength="4">
                    </div>
                    @if ($errors->has('uen'))
                    <span class="text-danger d-block">
                        <strong>{{ $errors->first('uen') }}</strong>
                    </span>
                    @endif
                </div> -->
                <div class="col-xl-3 col-md-6">
                    <div class="inrow empty">
                        <label>Passport Number (Optional)</label>
                        <input type="text" class="form-control" name="passport" id="passport" value="{{ old('passport') ?? '' }}"
                            maxlength="4" minlength="4">
                    </div>
                    @if ($errors->has('passport'))
                    <span class="text-danger d-block">
                       {{ $errors->first('passport') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3">
					<div class="mt-20">
						@if(!empty(session()->get('myinfospagreement')) && !empty($sex1))	
                        
					    <input type="text" class="form-control" name="gender" @if(!empty($sex1)) readonly="readonly" @endif value="{{ $sex1 ?? '' }}" />	
						@else	
						    @if(Auth::check())	
    						<select class="selectpicker" name="gender" id="gender" data-title="Gender">	
    							<option value="" selected="selected">Gender</option>	
    							<option @if(old('gender')=="Male" ) selected="selected" @elseif($sex1 == 1)	
    								selected="selected" @endif value="Male">Male</option>	
    							<option @if(old('gender')=="Female" ) selected="selected" @elseif($sex1 == 2)	
    								selected="selected" @endif value="Female">Female</option>	
    						</select>	
    						@else	
    						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" value=""	
    							@if(!Auth::check()) readonly="readonly" @endif />	
    						@endif	
    					@endif

                        @if(empty($sex1) && empty(old('gender')) && !empty(session()->get('myinfospagreement')) && !$errors->has('gender'))
                            <span class="text-danger">This field is required</span>
                        @endif
						@if ($errors->has('gender'))
						<span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
						@endif
					</div>
				</div>
                <div class="col-xl-5 col-lg-7">
                    <div class="row sp-col-10 break-425">
                        <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                            @if(empty(session()->get('myinfospagreement')) || empty($countryCode))
                                <div class="mt-20">
                                        <select class="selectpicker" name="seller_country_code" data-title="Country Code" >
                                            <option value="+65" @if(old('seller_country_code')=="+65" ) selected="selected" @elseif(empty(old('seller_country_code'))) selected @endif>+65</option>
                                            <option value="+66" @if(old('seller_country_code')=="+66" ) selected="selected" @endif>+66</option>
                                            <option value="+673" @if(old('seller_country_code')=="+673" ) selected="selected" @endif>+673</option>
                                            
                                        </select>
                                    @if ($errors->has('seller_country_code'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('seller_country_code') }}
                                    </span>
                                    @endif
                                </div>
                            @else
                                <div class="inrow empty">
                                    <label>Country Code</label>
                                    <input type="text" class="form-control" @if(!empty($countryCode)) readonly="readonly" @endif name="seller_country_code" id="seller_country_code" value="{{ $countryCode ?? '' }}" maxlength="4" minlength="4">
                                </div>
                                @if ($errors->has('seller_country_code'))
                                <span class="text-danger d-block">
                                   {{ $errors->first('seller_country_code') }}
                                </span>
                                @endif
                            @endif
                            
                        </div>
                        <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                            <div class="inrow empty">
                                <label>Contact No.</label>
                                <input type="text" class="form-control" name="seller_mobile"
                                    value="{{ old('seller_mobile', $mobileno1 ?? '') }}">
                            </div>
                            @if(empty($mobileno1) && empty(old('seller_mobile')) && !empty(session()->get('myinfospagreement')) && !$errors->has('seller_mobile'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('seller_mobile'))
                            <span class="text-danger d-block">
                                {{ $errors->first('seller_mobile') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="inrow empty">
                        <label>Email Address (Ex: janedoe@gmail.com)</label>
                        <input type="text" class="form-control" name="seller_email"
                            value="{{ $email1 ?? '' }}">
                    </div>
                    @if(empty($email1) && empty(old('seller_email')) && !empty(session()->get('myinfospagreement')) && !$errors->has('seller_email'))
                    <span class="text-danger">This field is required</span>
                    @endif
                    @if ($errors->has('seller_email'))
                    <span class="text-danger d-block">
                       {{ $errors->first('seller_email') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="inrow empty">
                        <label>Address (Block Number), (Street Name), (Floor)-(Unit Number), Singapore (Postal Code)</label>
                        <input type="text" class="form-control" @if(!empty($address)) readonly="readonly" @endif name="address" id="address"
                            value="{{ old('address', $address) ?? '' }}">
                    </div>
                    @if(empty($address) && empty(old('address')) && !empty(session()->get('myinfospagreement')) && !$errors->has('address'))
                    <span class="text-danger">This field is required</span>
                    @endif
                    @if ($errors->has('address'))
                    <span class="text-danger d-block">
                       {{ $errors->first('address') }}
                    </span>
                    @endif
                </div>
                {{-- <div class="col-md-3 sp-col">
                    <div class="inrow empty">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" name="postal_code"
                            value="{{ old('postal_code') ?? '' }}">
                    </div>
                    @if ($errors->has('postal_code'))
                    <span class="text-danger d-block">
                       {{ $errors->first('postal_code') }}
                    </span>
                    @endif
                </div> --}}
            </div>
            @php
            if(!empty($carId) && empty(session()->get('myinfospagreement'))){
                $vehicleDetail = \App\VehicleDetail::where('vehicle_id', $carId)->first();
                if($vehicleDetail){
                    $vehicle_number = $vehicleDetail->vehicle_number;
                    $vehicle_make = $vehicleDetail->vehicle_make;
                    $vehicle_model = $vehicleDetail->vehicle_model;
                    $primary_color = $vehicleDetail->primary_color;
                    $year_of_mfg = $vehicleDetail->year_of_mfg;
                    if(!empty($vehicleDetail->first_reg_date)){
                        $first_reg_date = date('d-m-Y', strtotime($vehicleDetail->first_reg_date));
                    }else{
                        $first_reg_date = '';
                    }
                    
                    $vehicle_type = $vehicleDetail->vehicle_type;
                    if(!empty($vehicleDetail->engine_cc)){
                        $engine_cc = number_format($vehicleDetail->engine_cc);
                    }else{
                        $engine_cc = '';
                    }
                    
                    if(!empty($vehicleDetail->coe_expiry_date)){
                        $coe_expiry_date = date('d-m-Y', strtotime($vehicleDetail->coe_expiry_date));
                    }else{
                        $coe_expiry_date = '';
                    }
                    if(!empty($vehicleDetail->open_market_value)){
                        $open_market_value = number_format($vehicleDetail->open_market_value);
                    }else{
                        $open_market_value = '';
                    }
                    if(!empty($vehicleDetail->orig_reg_date)){
                        $orig_reg_date = date('d-m-Y', strtotime($vehicleDetail->orig_reg_date));
                    }else{
                        $orig_reg_date = '';
                    }
                    $scheme = $vehicleDetail->vehicle_scheme;
                    $chassisno = '';
                    $engineno = '';
                    $iulabelno = '';
                    $nooftransfers = $vehicleDetail->no_of_transfers ?? '';
                    if(!empty($vehicleDetail->min_parf_benefit)){
                        $minimumparfbenefit = number_format($vehicleDetail->min_parf_benefit);
                    }else{
                        $minimumparfbenefit = '';
                    }
                    if(!empty($vehicleDetail->road_tax_expiry_date)){
                        $roadtaxexpirydate = date('d-m-Y', strtotime($vehicleDetail->road_tax_expiry_date));
                    }else{
                        $roadtaxexpirydate = '';
                    }
                }
            }
            
            @endphp
            <h3 class="title-6"><span><strong>Vehicle Details</strong></span></h3>
            <div id="vehicleDetails">
                <div class="row">
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                            <div class="inrow empty">
                                <label>Vehicle No. (Ex: SBY1234A)</label>
                                <input type="text" class="form-control" name="registration_no"
                                    value="{{ old('registration_no', $vehicle_number ?? '') ?? '' }}">
                            </div>
                            @if ($errors->has('registration_no'))
                            <span class="text-danger d-block">
                               {{ $errors->first('registration_no') }}
                            </span>
                            @endif
                        @else
                            <div class="inrow empty">
                                <label>Vehicle No. (Ex: SBY1234A)</label>
                                <input type="text" class="form-control" @if(!empty($vehicle_number)) readonly="readonly" @endif name="registration_no"
                                    value="{{ $vehicle_number ?? ''}}">
                            </div>
                            @if(empty($vehicle_number) && empty(old('registration_no')) && !empty(session()->get('myinfospagreement')) && !$errors->has('registration_no'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('registration_no'))
                            <span class="text-danger d-block">
                               {{ $errors->first('registration_no') }}
                            </span>
                            @endif
                        @endif

                    </div>

                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                            <div class="inrow empty">
                                <label>Vehicle Make (Ex: Toyota)</label>
                                <input type="text" class="form-control" name="make" value="{{ old('make', $vehicle_make ?? '') ?? '' }}">
                            </div>
                            @if ($errors->has('make'))
                            <span class="text-danger d-block">
                               {{ $errors->first('make') }}
                            </span>
                            @endif
                        @else 
                            <div class="inrow empty">
                                <label>Vehicle Make (Ex: Toyota)</label>
                                <input type="text" class="form-control" @if(!empty($vehicle_make)) readonly="readonly" @endif name="make" value="{{ $vehicle_make ?? '' }}">
                            </div>
                            @if(empty($vehicle_make) && empty(old('make')) && !empty(session()->get('myinfospagreement')) && !$errors->has('make'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('make'))
                            <span class="text-danger d-block">
                               {{ $errors->first('make') }}
                            </span>
                            @endif
                        @endif
                        
                    </div>
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow empty">
                            <label>Vehicle Model (Ex: Corolla)</label>
                            <input type="text" class="form-control" name="model" value="{{ old('model', $vehicle_model ?? '') ?? '' }}">
                        </div>
                        @else
                        <div class="inrow empty">
                            <label>Vehicle Model (Ex: Corolla)</label>
                            <input type="text" class="form-control" @if(!empty($vehicle_model)) readonly="readonly" @endif name="model" value="{{ old('model', $vehicle_model ?? '') ?? '' }}">
                        </div>
                        @endif

                        @if(empty($vehicle_model) && empty(old('model')) && !empty(session()->get('myinfospagreement')) && !$errors->has('model'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('model'))
                        <span class="text-danger d-block">
                           {{ $errors->first('model') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>Original Registration Date</label>
                            <input type="text" class="form-control" name="registration_date"
                                value="{{ old('registration_date', $orig_reg_date ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @else
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>Original Registration Date</label>
                            <input type="text" class="form-control" name="registration_date" @if(!empty($orig_reg_date)) readonly="readonly" @endif
                                value="{{ old('registration_date', $orig_reg_date ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @endif
                        @if(empty($orig_reg_date) && empty(old('registration_date')) && !empty(session()->get('myinfospagreement')) && !$errors->has('registration_date'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('registration_date'))
                        <span class="text-danger d-block">
                           {{ $errors->first('registration_date') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="mt-20">
                            @if(empty(session()->get('myinfospagreement')))
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>First Registration Date</label>
                                <input type="text" class="form-control" name="first_registration_Date"
                                value="{{ old('first_registration_Date', $first_reg_date ?? '') ?? '' }}">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @else
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>First Registration Date</label>
                                <input type="text" class="form-control" @if(!empty($first_reg_date)) readonly="readonly" @endif name="first_registration_Date"
                                value="{{ old('first_registration_Date', $first_reg_date ?? '') ?? '' }}">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @endif
                            @if(empty($first_reg_date) && empty(old('first_registration_Date')) && !empty(session()->get('myinfospagreement')) && !$errors->has('first_registration_Date'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('first_registration_Date'))
                            <span class="text-danger d-block">
                                {{ $errors->first('first_registration_Date') }}
                            </span>
                            @endif  
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow empty">
                            <label>Manufacturing Year (Ex: 2017)</label>
                            <input type="text" class="form-control" name="year_of_manufacturer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value="{{ old('year_of_manufacturer', $year_of_mfg ?? '') ?? '' }}" minlength="4" maxlength="4">
                        </div>
                        @else
                        <div class="inrow empty">
                            <label>Manufacturing Year (Ex: 2017)</label>
                            <input type="text" class="form-control" @if(!empty($year_of_mfg)) readonly="readonly" @endif name="year_of_manufacturer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value="{{ old('year_of_manufacturer', $year_of_mfg ?? '') ?? '' }}" minlength="4" maxlength="4">
                        </div>
                        @endif

                        @if(empty($year_of_mfg) && empty(old('year_of_manufacturer')) && !empty(session()->get('myinfospagreement')) && !$errors->has('year_of_manufacturer'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('year_of_manufacturer'))
                        <span class="text-danger d-block">
                            {{ $errors->first('year_of_manufacturer') }}
                        </span>
                        @endif
                    </div>

                    
                    
                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow empty">
                            <label>Engine No.</label>
                            <input type="text" class="form-control" name="engine_no" value="{{ old('engine_no', $engineno ?? '') ?? '' }}">
                        </div>
                        @else 
                        <div class="inrow empty">
                            <label>Engine No.</label>
                            <input type="text" class="form-control" @if(!empty($engineno)) readonly="readonly" @endif name="engine_no" value="{{ old('engine_no', $engineno ?? '') ?? '' }}">
                        </div>
                        @endif

                        @if(empty($engineno) && empty(old('engine_no')) && !empty(session()->get('myinfospagreement')) && !$errors->has('engine_no'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('engine_no'))
                        <span class="text-danger d-block">
                           {{ $errors->first('engine_no') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow empty">
                            <label>Chassis No.</label>
                            <input type="text" class="form-control" name="chassis_no" value="{{ old('chassis_no', $chassisno ?? '') ?? '' }}">
                        </div>
                        @else 
                        <div class="inrow empty">
                            <label>Chassis No.</label>
                            <input type="text" class="form-control" @if(!empty($chassisno)) readonly="readonly" @endif name="chassis_no" value="{{ old('chassis_no', $chassisno ?? '') ?? '' }}">
                        </div>
                        @endif

                        @if(empty($chassisno) && empty(old('chassis_no')) && !empty(session()->get('myinfospagreement')) && !$errors->has('chassis_no'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('chassis_no'))
                        <span class="text-danger d-block">
                           {{ $errors->first('chassis_no') }}
                        </span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow empty">
                            <label>Transfer Count</label>
                            <input type="text" class="form-control" name="no_of_transfer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="2" maxlength="2"
                                value="{{ old('no_of_transfer', $nooftransfers ?? '') ?? '' }}">
                        </div>
                        @else 
                        <div class="inrow empty">
                            <label>Transfer Count</label>
                            <input type="text" class="form-control" @if(!empty($nooftransfers)) readonly="readonly" @endif name="no_of_transfer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="2" maxlength="2"
                                value="{{ old('no_of_transfer', $nooftransfers ?? '') ?? '' }}">
                        </div>
                        @endif

                        @if(empty($nooftransfers) && empty(old('no_of_transfer')) && !empty(session()->get('myinfospagreement')) && !$errors->has('no_of_transfer'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('no_of_transfer'))
                        <span class="text-danger d-block">
                           {{ $errors->first('no_of_transfer') }}
                        </span>
                        @endif
                    </div>
                    
                    
                </div>
                <div class="row">
                    @if(empty(session()->get('myinfospagreement')))
                        <div class="col-lg-4 mt-20">
                                <select class="selectpicker" name="color" data-title="Primary Color" >
                                <option value="White" @if(old('color')=="White") selected="selected" @endif>White</option>
                                <option value="Black" @if(old('color')=="Black") selected="selected" @endif>Black</option>
                                <option value="Grey" @if(old('color')=="Grey") selected="selected" @endif>Grey</option>
                                <option value="Silver" @if(old('color')=="Silver") selected="selected" @endif>Silver</option>
                                <option value="Red" @if(old('color')=="Red") selected="selected" @endif>Red</option>
                                <option value="Blue" @if(old('color')=="Blue") selected="selected" @endif>Blue</option>
                                <option value="Brown" @if(old('color')=="Brown") selected="selected" @endif>Brown</option>
                                <option value="Green" @if(old('color')=="Green") selected="selected" @endif>Green</option>
                                <option value="Beige" @if(old('color')=="Beige") selected="selected" @endif>Beige</option>
                                <option value="Orange" @if(old('color')=="Orange") selected="selected" @endif>Orange</option>
                                <option value="Gold" @if(old('color')=="Gold") selected="selected" @endif>Gold</option>
                                <option value="Yellow" @if(old('color')=="Yellow") selected="selected" @endif>Yellow</option>
                                <option value="Purple" @if(old('color')=="Purple") selected="selected" @endif>Purple</option>
                                <option value="Pink" @if(old('color')=="Pink") selected="selected" @endif>Pink</option>
                                <option value="Others" @if(old('color')=="Others") selected="selected" @endif>Others</option>
                            </select>

                            @if ($errors->has('color'))
                            <span class="text-danger d-block">
                               {{ $errors->first('color') }}
                            </span>
                            @endif
                        </div>
                    @elseif(!empty(session()->get('myinfospagreement')) && empty($primary_color))
                        <div class="col-lg-4 mt-20">
                            <select class="selectpicker" name="color" data-title="Primary Color" >
                            <option value="White" @if(old('color')=="White") selected="selected" @endif>White</option>
                            <option value="Black" @if(old('color')=="Black") selected="selected" @endif>Black</option>
                            <option value="Grey" @if(old('color')=="Grey") selected="selected" @endif>Grey</option>
                            <option value="Silver" @if(old('color')=="Silver") selected="selected" @endif>Silver</option>
                            <option value="Red" @if(old('color')=="Red") selected="selected" @endif>Red</option>
                            <option value="Blue" @if(old('color')=="Blue") selected="selected" @endif>Blue</option>
                            <option value="Brown" @if(old('color')=="Brown") selected="selected" @endif>Brown</option>
                            <option value="Green" @if(old('color')=="Green") selected="selected" @endif>Green</option>
                            <option value="Beige" @if(old('color')=="Beige") selected="selected" @endif>Beige</option>
                            <option value="Orange" @if(old('color')=="Orange") selected="selected" @endif>Orange</option>
                            <option value="Gold" @if(old('color')=="Gold") selected="selected" @endif>Gold</option>
                            <option value="Yellow" @if(old('color')=="Yellow") selected="selected" @endif>Yellow</option>
                            <option value="Purple" @if(old('color')=="Purple") selected="selected" @endif>Purple</option>
                            <option value="Pink" @if(old('color')=="Pink") selected="selected" @endif>Pink</option>
                            <option value="Others" @if(old('color')=="Others") selected="selected" @endif>Others</option>
                        </select>
                        @if(empty($primary_color) && empty(old('color')) && !empty(session()->get('myinfospagreement')) && !$errors->has('color'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('color'))
                        <span class="text-danger d-block">
                           {{ $errors->first('color') }}
                        </span>
                        @endif
                    </div>
                    @else
                        <div class="col-lg-4">
                            <div class="inrow empty">
                                <label>Primary Color</label>
                                <input type="text" class="form-control" name="color" @if(!empty($primary_color)) readonly="readonly" @endif
                                    value="{{ ucwords($primary_color) ?? '' }}">
                            </div>
                            @if ($errors->has('color'))
                            <span class="text-danger d-block">
                               {{ $errors->first('color') }}
                            </span>
                            @endif
                        </div>
                    @endif




                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>COE Expiry Date</label>
                            <input type="text" class="form-control" name="coe_expiry_date"
                                value="{{ old('coe_expiry_date', $coe_expiry_date ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @else 
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>COE Expiry Date</label>
                            <input type="text" class="form-control" @if(!empty($coe_expiry_date)) readonly="readonly" @endif name="coe_expiry_date"
                                value="{{ old('coe_expiry_date', $coe_expiry_date ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @endif

                        @if(empty($coe_expiry_date) && empty(old('coe_expiry_date')) && !empty(session()->get('myinfospagreement')) && !$errors->has('coe_expiry_date'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('coe_expiry_date'))
                        <span class="text-danger d-block">
                            {{ $errors->first('coe_expiry_date') }}
                        </span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>Road Tax Expiry Date</label>
                            <input type="text" class="form-control" name="road_tax_expiry_date"
                                value="{{ old('road_tax_expiry_date', $roadtaxexpirydate ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @else 
                        <div class="inrow date-wrap datepicker-wrap empty">
                            <label>Road Tax Expiry Date</label>
                            <input type="text" class="form-control" @if(!empty($roadtaxexpirydate)) readonly="readonly" @endif name="road_tax_expiry_date"
                                value="{{ old('road_tax_expiry_date', $roadtaxexpirydate ?? '') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @endif

                        @if(empty($roadtaxexpirydate) && empty(old('road_tax_expiry_date')) && !empty(session()->get('myinfospagreement')) && !$errors->has('road_tax_expiry_date'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('road_tax_expiry_date'))
                        <span class="text-danger d-block">
                           {{ $errors->first('road_tax_expiry_date') }}
                        </span>
                        @endif
                    </div>
                    
                    
                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        @php
                        if(!empty($engine_cc)){
                            $engine_cc = str_replace(',','',$engine_cc);
                            $engine_cc = number_format($engine_cc);
                        }else{
                            $engine_cc = '';
                        }
                        @endphp

                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow inptxt empty">
                            <label>Engine Capacity (Ex: 1794 cc)</label>
                            <input id="engineeCapacity" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ old('engine_output', $engine_cc  ?? '') ?? '' }}" name="engine_output">
                            <span class="txt">CC</span>
                        </div>
                        @else 
                        <div class="inrow inptxt empty">
                            <label>Engine Capacity (Ex: 1794 cc)</label>
                            <input id="engineeCapacity" type="text" @if(!empty($engine_cc)) readonly="readonly" @endif class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ old('engine_output', $engine_cc ?? '') ?? '' }}" name="engine_output">
                            <span class="txt">CC</span>
                        </div>
                        @endif

                        @if(empty($engine_cc) && empty(old('engine_output')) && !empty(session()->get('myinfospagreement')) && !$errors->has('engine_output'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('engine_output'))
                        <span class="text-danger d-block">
                           {{ $errors->first('engine_output') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow inptxt lefttxt empty">
                            <label>Open Market Value</label>
                            <span class="txt">$</span>
                            <input type="text" class="form-control" onkeyup="addCommas(this.value, 'open_market_value');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="open_market_value" name="open_market_value"
                                value="{{ old('open_market_value', $open_market_value ?? '') ?? '' }}">
                        </div>
                        @else 
                        <div class="inrow inptxt lefttxt empty">
                            <label>Open Market Value</label>
                            <span class="txt">$</span>
                            <input type="text" class="form-control" @if(!empty($open_market_value)) readonly="readonly" @endif onkeyup="addCommas(this.value, 'open_market_value');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="open_market_value" name="open_market_value"
                                value="{{ old('open_market_value', $open_market_value ?? '') ?? '' }}">
                        </div>
                        @endif

                        @if(empty($open_market_value) && empty(old('open_market_value')) && !empty(session()->get('myinfospagreement')) && !$errors->has('open_market_value'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('open_market_value'))
                        <span class="text-danger d-block">
                           {{ $errors->first('open_market_value') }}
                        </span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow inptxt lefttxt empty">
                            <label>Minimum PARF Benefit</label>
                            <span class="txt">$</span>
                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="arf_paid" id="minimumparfbenefit" value="{{ old('arf_paid', $minimumparfbenefit ?? '') ?? '' }}">
                        </div>
                        @else 
                        <div class="inrow inptxt lefttxt empty">
                            <label>Minimum PARF Benefit</label>
                            <span class="txt">$</span>
                            <input type="text" class="form-control" @if(!empty($minimumparfbenefit)) readonly="readonly" @endif oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="arf_paid" id="minimumparfbenefit" value="{{ old('arf_paid', $minimumparfbenefit ?? '') ?? '' }}">
                        </div>
                        @endif

                        @if(empty($minimumparfbenefit) && empty(old('arf_paid')) && !empty(session()->get('myinfospagreement')) && !$errors->has('arf_paid'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('arf_paid'))
                        <span class="text-danger d-block">
                           {{ $errors->first('arf_paid') }}
                        </span>
                        @endif
                    </div>

                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="mt-20">
                                <select class="selectpicker" name="vehicle_type" data-title="Vehicle Type">
                                    <option value="Mid-Sized Sedan" @if(old('vehicle_type')=="Mid-Sized Sedan" ) selected="selected" @endif>Mid-Sized Sedan</option>
                                    <option value="Luxury Sedan"  @if(old('vehicle_type')=="Luxury Sedan" ) selected="selected" @endif>Luxury Sedan</option>
                                    <option value="Hatchback"  @if(old('vehicle_type')=="Hatchback" ) selected="selected" @endif>Hatchback</option>
                                    <option value="SUV"  @if(old('vehicle_type')=="SUV" ) selected="selected" @endif>SUV</option>
                                    <option value="Passenger Car"  @if(old('vehicle_type')=="Passenger Car" ) selected="selected" @endif>Passenger Car</option>
                                    <option value="MPV"  @if(old('vehicle_type')=="MPV" ) selected="selected" @endif>MPV</option>
                                    <option value="Station Wagon"  @if(old('vehicle_type')=="Station Wagon" ) selected="selected" @endif>Station Wagon</option>
                                    <option value="Sports Car"  @if(old('vehicle_type')=="Sports Car" ) selected="selected" @endif>Sports Car</option>
                                    <option value="Commercial Vehicle"  @if(old('vehicle_type')=="Commercial Vehicle" ) selected="selected" @endif>Commercial Vehicle</option>
                                    <option value="Van"  @if(old('vehicle_type')=="Van" ) selected="selected" @endif>Van</option>
                                    <option value="Truck"  @if(old('vehicle_type')=="Truck" ) selected="selected" @endif>Truck</option>
                                    <option value="Bus/Mini Bus"  @if(old('vehicle_type')=="Bus/Mini Bus" ) selected="selected" @endif>Bus/Mini Bus</option>
                                    <option value="Others"  @if(old('vehicle_type')=="Others" ) selected="selected" @endif>Others</option>
                                </select>
                            @if ($errors->has('vehicle_type'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_type') }}
                            </span>
                            @endif
                            
                        </div>
                        @elseif(!empty(session()->get('myinfospagreement')) && empty($vehicle_type))
                            <div class="mt-20">
                                <select class="selectpicker" name="vehicle_type" data-title="Vehicle Type">
                                    <option value="Mid-Sized Sedan" @if(old('vehicle_type')=="Mid-Sized Sedan" ) selected="selected" @endif>Mid-Sized Sedan</option>
                                    <option value="Luxury Sedan"  @if(old('vehicle_type')=="Luxury Sedan" ) selected="selected" @endif>Luxury Sedan</option>
                                    <option value="Hatchback"  @if(old('vehicle_type')=="Hatchback" ) selected="selected" @endif>Hatchback</option>
                                    <option value="SUV"  @if(old('vehicle_type')=="SUV" ) selected="selected" @endif>SUV</option>
                                    <option value="Passenger Car"  @if(old('vehicle_type')=="Passenger Car" ) selected="selected" @endif>Passenger Car</option>
                                    <option value="MPV"  @if(old('vehicle_type')=="MPV" ) selected="selected" @endif>MPV</option>
                                    <option value="Station Wagon"  @if(old('vehicle_type')=="Station Wagon" ) selected="selected" @endif>Station Wagon</option>
                                    <option value="Sports Car"  @if(old('vehicle_type')=="Sports Car" ) selected="selected" @endif>Sports Car</option>
                                    <option value="Commercial Vehicle"  @if(old('vehicle_type')=="Commercial Vehicle" ) selected="selected" @endif>Commercial Vehicle</option>
                                    <option value="Van"  @if(old('vehicle_type')=="Van" ) selected="selected" @endif>Van</option>
                                    <option value="Truck"  @if(old('vehicle_type')=="Truck" ) selected="selected" @endif>Truck</option>
                                    <option value="Bus/Mini Bus"  @if(old('vehicle_type')=="Bus/Mini Bus" ) selected="selected" @endif>Bus/Mini Bus</option>
                                    <option value="Others"  @if(old('vehicle_type')=="Others" ) selected="selected" @endif>Others</option>
                                </select>

                                @if(empty($vehicle_type) && empty(old('vehicle_type')) && !empty(session()->get('myinfospagreement')) && !$errors->has('vehicle_type'))
                                <span class="text-danger">This field is required</span>
                                @endif

                                @if ($errors->has('vehicle_type'))
                                <span class="text-danger d-block">
                                   {{ $errors->first('vehicle_type') }}
                                </span>
                                @endif
                                
                            </div>
                        @else
                        <div class="inrow inptxt lefttxt empty">
                            <label>Vehicle Type</label>
                            <input type="text" class="form-control" @if(!empty($vehicle_type)) readonly="readonly" @endif name="vehicle_type" value="{{ $vehicle_type ?? '' }}">
                            
                        </div>
                        @if ($errors->has('vehicle_type'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_type') }}
                            </span>
                            @endif
                        @endif
                    </div>
                    
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="mt-20">
                            <select class="selectpicker" name="vehicle_scheme" data-title="Vehicle Scheme (- represents normal)">
                                <option value="Normal" @if(old('vehicle_scheme')=="Normal" ) selected="selected" @endif>Normal</option>
                                <option value="OPC (Off Peak Car)" @if(old('vehicle_scheme')=="OPC (Off Peak Car)" ) selected="selected" @endif>OPC (Off Peak Car)</option>
                                <option value="Classic" @if(old('vehicle_scheme')=="Classic" ) selected="selected" @endif>Classic</option>
							    <option value="Vintage" @if(old('vehicle_scheme')=="Vintage" ) selected="selected" @endif>Vintage</option>
                            </select>
                            @if ($errors->has('vehicle_scheme'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_scheme') }}
                            </span>
                            @endif
                        </div>

                        @elseif(!empty(session()->get('myinfospagreement')) && empty($scheme))
                            <div class="mt-20">
                                <select class="selectpicker" name="vehicle_scheme" data-title="Vehicle Scheme (- represents normal)">
                                    <option value="Normal" @if(old('vehicle_scheme')=="Normal" ) selected="selected" @endif>Normal</option>
                                    <option value="OPC (Off Peak Car)" @if(old('vehicle_scheme')=="OPC (Off Peak Car)" ) selected="selected" @endif>OPC (Off Peak Car)</option>
                                    <option value="Classic" @if(old('vehicle_scheme')=="Classic" ) selected="selected" @endif>Classic</option>
                                    <option value="Vintage" @if(old('vehicle_scheme')=="Vintage" ) selected="selected" @endif>Vintage</option>
                                </select>
                                @if(empty($scheme) && empty(old('vehicle_scheme')) && !empty(session()->get('myinfospagreement')) && !$errors->has('vehicle_scheme'))
                                <span class="text-danger">This field is required</span>
                                @endif
                                @if ($errors->has('vehicle_scheme'))
                                <span class="text-danger d-block">
                                   {{ $errors->first('vehicle_scheme') }}
                                </span>
                                @endif
                            </div>
                        @else 
                        <div class="inrow inptxt lefttxt empty">
                            <label>Vehicle Scheme (- represents normal)</label>
                            <input type="text" class="form-control" @if(!empty($scheme)) readonly="readonly" @endif name="vehicle_scheme" value="{{ $scheme ?? '' }}">
                            
                        </div>
                        @if ($errors->has('vehicle_scheme'))
                            <span class="text-danger d-block">
                               {{ $errors->first('vehicle_scheme') }}
                            </span>
                            @endif
                        @endif
                    </div>
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfospagreement')))
                        <div class="inrow empty">
                            <label>IU Label Number</label>
                            <input type="text" class="form-control" value="{{ old('iu_label_number', $iulabelno ?? '') ?? '' }}" name="iu_label_number">
                        </div>
                        @else 
                        <div class="inrow empty">
                            <label>IU Label Number</label>
                            <input type="text" class="form-control" @if(!empty($iulabelno)) readonly="readonly" @endif value="{{ old('iu_label_number', $iulabelno ?? '') ?? '' }}" name="iu_label_number">
                        </div>
                        @endif

                        @if(empty($iulabelno) && empty(old('iu_label_number')) && !empty(session()->get('myinfospagreement')) && !$errors->has('iu_label_number'))
                        <span class="text-danger">This field is required</span>
                        @endif

                        @if ($errors->has('iu_label_number'))
                        <span class="text-danger d-block">
                           {{ $errors->first('iu_label_number') }}
                        </span>
                        @endif
                    </div>

                </div>
            </div>

            <!-- <div class="grtype mt-20">
                <h3 class="title-6 item"><span><strong>Is this an used Import: </strong></span></h3>
                <div class="check-inline item">
                    <div class="radio">
                        <input type="radio" id="yes" name="use" value="yes">
                        <label for="yes">Yes</label>
                    </div>
                    <div class="radio">
                        <input type="radio" name="use" id="no" value="no">
                        <label for="no">No</label>
                    </div>
                </div>
            </div> -->
            <!-- <div class="row">
                <div class="col-lg-4">
                    <div class="mt-20">
                        <div class="inrow date-wrap datepicker-wrap">
                            <label>First Registration Date</label>
                            <input type="text" class="form-control" name="first_registration_Date"
                            value="{{ old('first_registration_Date') ?? '' }}">
                            <i class="fas fa-calendar-alt"></i>
                           
                        </div>
                        
                    </div>
                </div>
            </div> -->
            <h3 class="title-6"><span><strong>Terms and Conditions</strong></span></h3>
            @if(empty(old('terms')) && !empty(session()->get('myinfospagreement')) && !$errors->has('terms'))
                <span class="text-danger">This field is required</span>
            @endif
            @if ($errors->has('terms'))
            <span class="text-danger d-block">
                {{ $errors->first('terms') }}
            </span>
            @endif
            
            <div class="row sp-col-10">
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        @php 
                        $terms = old('terms') ?? [];
                        @endphp
                        <input id="loan" type="checkbox"  name="terms[]" onchange="checkcheckbox('term');"
                            value="Subject to loan approval within 7 working days" @if(in_array('Subject to loan approval within 7 working days', $terms)) checked @endif>
                        <label for="loan">Subject to loan approval within 7 working days.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="retention" type="checkbox" name="terms[]" onchange="checkcheckbox('term');" value="Number retention (Vehicle will be replaced with a random assigned vehicle no. by LTA)." @if(in_array('Number retention (Vehicle will be replaced with a random assigned vehicle no. by LTA).', $terms)) checked @endif>
                        <label for="retention">Number retention (Vehicle will be replaced with a random assigned vehicle no. by LTA).</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="sold" type="checkbox" name="terms[]" onchange="checkcheckbox('term');" value="Vehicle sold as it is." @if(in_array('Vehicle sold as it is.', $terms)) checked @endif>
                        <label for="sold">Vehicle sold as it is.</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="noinspection" name="terms[]" onchange="checkcheckbox('term');" type="checkbox" value="No inspection required." @if(in_array('No inspection required.', $terms)) checked @endif>
                        <label for="noinspection">No inspection required.</label>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="spare" type="checkbox" name="terms[]" onchange="checkcheckbox('term');"
                            value="No spare key. (Buyer to duplicate at own expense)" @if(in_array('No spare key. (Buyer to duplicate at own expense)', $terms)) checked @endif>
                        <label for="spare">No spare key. <br>(Buyer to duplicate at own expense)</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sp-col mt-20">
                    <div class="checkbox">
                        <input id="owners" type="checkbox" name="terms[]" onchange="checkcheckbox('term');" value="No owners manual." @if(in_array('No owners manual.', $terms)) checked @endif>
                        <label for="owners">No owner's manual.</label>
                    </div>
                </div>
                <div class="col-lg-8 sp-col mt-20">
                    <div class="row sp-col-10 break-575 typedate">
                        <div class="col-auto sp-col pt-10">
                            @php 
                            $valuee = '';
                            foreach($terms as $index => $string) {
                                if (strpos($string, 'Subject to Completion of Sale by') !== FALSE){
                                    $valuee = $string;
                                    $valex = explode(':',$valuee);
                                    $dateval = $valex[1];
                                }
                                    
                            }
                            @endphp
                            <div class="checkbox">
                                <input id="sale" name="terms[]" @if(!empty($valuee)) checked @endif type="checkbox" onchange="removecheckbox('termsdate');" value="">
                                <label for="sale">Subject to completion of sale by:</label>
                            </div>
                        </div>
                        <div class="col sp-col">
							<div class="date-wrap datepicker-wrap maxw-180 empty">
								<input type="text" id="termsdate" class="form-control" data-date-format="DD-MMM-YYYY" onmouseup="removecheck();"  value="{{ $dateval ?? '' }}" name="termsdate" />
								<i class="fas fa-calendar-alt"></i>                                
							</div>
							<div class="checknote" id="termsdateerror"></div>    
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 sp-col mt-20">
                    <div class="row sp-col-10 break-575 typedate">
                        <div class="col-auto sp-col pt-10">
                            @php 
                            $valueeM = '';
                            foreach($terms as $index => $string) {
                                if (strpos($string, 'Indicative Mileage') !== FALSE){
                                    $valueeM = $string;
                                    $valex = explode(':',$valueeM);
                                    $valex[1] = str_replace('Km', '', $valex[1]);
                                    $datevalM = $valex[1];
                                }
                                    
                            }
                            @endphp
                            <div class="checkbox">
                                <input id="indicative_mileagecheck" name="terms[]" @if(!empty($valueeM)) checked @endif onchange="checkcontent('indicative_mileage');" type="checkbox" value="">
                                <label for="indicative_mileagecheck">Indicative mileage:</label>
                            </div>
                        </div>
                        <div class="col sp-col">
							<div class="checkmg">
								<div class="input-group maxw-180 grinput rtext">
									<input type="text" class="form-control" id="indicative_mileage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="indicative_mileage" value="{{ $datevalM ?? ''}}"><span class="input-group-text">KM</span>
								</div>
								<div id="indicative_mileageerror"></div>
							</div>
                        </div>
                    </div>
                </div>
                <div id="termsadded"></div>
                <div id="othertermsextra" style="display: block;" class="col-lg-8 sp-col mt-20">
                    @php 
                    $addedTerms= old('termsadded') ?? '';
                    $checkedTerms= old('terms') ?? '';
                    @endphp
                    @if($addedTerms)
                    @foreach($addedTerms as $trw)
                    <div class="checkbox">
                        <input type="checkbox" name="terms[]" @if(in_array($trw,$checkedTerms)) checked @endif value="{{$trw}}" onchange="checkcheckbox();">
                        <label for="extra">{{$trw}}</label>
                    </div>
                    @endforeach
                    @endif
                </div>

                <div class="col-lg-12 sp-col mt-20">
                    <div class="row align-items-center sp-col-10">
                        <div class="col-auto sp-col">
                            <!-- <div class="checkbox">
                                <input id="other" type="checkbox" name="otherTerms" value="otherTerms">
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
										<input type="text" class="form-control" value="" id="otherdesc" name="otherconditions">
										<button type="button" onclick="addotherterms();">Add +</button>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="note-3">
                <ol id="termsdesc">
                    
                </ol>
            </div>
            @php 
            $sellingPricee = '';
            if(!empty($carId)){
                $chatDetail = \App\Chat::where('vehicle_main_id', $carId)->where('seller_id', Auth::user()->id)->first();
                if($chatDetail){
                    if($chatDetail->accept_reject_offer == 1 && $chatDetail->revise_offer_buyer == 1 && $chatDetail->revise_offer_status == 1){
                        $sellingPricee = number_format($chatDetail->offer_amount);
                    }elseif($chatDetail->accept_reject_offer == 1 && $chatDetail->revise_offer_buyer == 0){
                        $sellingPricee = number_format($chatDetail->offer_amount);
                    }
                    
                }
            }
            @endphp
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <h4 class="title-7"><span><strong>Selling Price</strong></span></h4>
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="selling_price" id="selling_price"
                            value="{{ old('selling_price', $sellingPricee) ?? '' }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    @if(empty(old('selling_price')) && !empty(session()->get('myinfospagreement')) && !$errors->has('selling_price'))
                    <span class="text-danger">This field is required</span>
                    @endif
                    @if ($errors->has('selling_price'))
                    <span class="text-danger d-block">
                       {{ $errors->first('selling_price') }}
                    </span>
                    @endif
                </div>
                <div class="col-lg-3 col-sm-6">
                    <h4 class="title-7"><span><strong>Deposit</strong></span></h4>
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="deposit" value="{{ old('deposit') ?? '' }}"
                            placeholder="" id="deposit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    @if(empty(old('deposit')) && !empty(session()->get('myinfospagreement')) && !$errors->has('deposit'))
                    <span class="text-danger">This field is required</span>
                    @endif
                    @if ($errors->has('deposit'))
                    <span class="text-danger d-block">
                       {{ $errors->first('deposit') }}
                    </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <h4 class="title-7"><span><strong>Balance Payment (Before Loan Amount)</strong></span></h4>
                    <div class="input-group mt-20 grinput empty">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="balance_payment"
                            value="{{ old('balance_payment') ?? '' }}" placeholder="" readonly>
                    </div>
                    @if(empty(old('balance_payment')) && !empty(session()->get('myinfospagreement')) && !$errors->has('balance_payment'))
                    <span class="text-danger">This field is required</span>
                    @endif
                    @if ($errors->has('balance_payment'))
                    <span class="text-danger d-block">
                       {{ $errors->first('balance_payment') }}
                    </span>
                    @endif
                </div>
            </div>
            <h4 class="title-7"><span><strong>Buyer’s Contact Information</strong></span></h4>
            <div class="row">
                <div class="col-xl-7 col-lg-5">
                    <div class="inrow empty">
                        <label>Email Address (Ex: janedoe@gmail.com)</label>
                        <input type="text" class="form-control" name="buyer_email"
                            value="{{ old('buyer_email') ?? '' }}">
                    </div>
                    @if(empty(old('buyer_email')) && !empty(session()->get('myinfospagreement')) && !$errors->has('buyer_email'))
                    <span class="text-danger">This field is required</span>
                    @endif
                    @if ($errors->has('buyer_email'))
                    <span class="text-danger d-block">
                       {{ $errors->first('buyer_email') }}
                    </span>
                    @endif
                </div>
                <div class="col-xl-5 col-lg-7">
                    <div class="row sp-col-10 break-425">
                        <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                            <div class="mt-20">
                                    <select class="selectpicker" name="country_code" data-title="Buyer's Country Code" >
                                        <option value="+65" @if(old('country_code')=="+65" ) selected="selected" @elseif(empty(old('country_code'))) selected @endif>+65</option>
                                        <option value="+66" @if(old('country_code')=="+66" ) selected="selected" @endif>+66</option>
                                        <option value="+673" @if(old('country_code')=="+673" ) selected="selected" @endif>+673</option>
                                        
                                    </select>
                                @if ($errors->has('country_code'))
                                <span class="text-danger d-block">
                                    {{ $errors->first('country_code') }}
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
                                    value="{{ old('buyer_mobile') ?? '' }}">
                            </div>
                            @if(empty(old('buyer_mobile')) && !empty(session()->get('myinfospagreement')) && !$errors->has('buyer_mobile'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('buyer_mobile'))
                            <span class="text-danger d-block">
                                {{ $errors->first('buyer_mobile') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkbox mt-20">
				<input id="agree" type="checkbox" required>  
				<label for="agree">I acknowledge and agree to the collection, use and disclosure of my personal data which has been provided for the purpose of creating a Sales and Purchase Agreement, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.</label>
			</div>
            <div class="output-2">
                <button class="btn-1 minw-190" type="submit" value="save" name="savebutton">Save and Exit <i class="fas fa-arrow-right"></i></button>
                <!-- <a href="https://verzview.com/html/autolink-new/forms.html#" class="btn-1 minw-190">View your Agreement
                    <i class="fas fa-arrow-right"></i></a> -->
                <button class="btn-1 minw-190" type="submit" value="submit" name="savebutton">Submit Agreement to Buyer <i
                        class="fas fa-arrow-right"></i></button>
            </div>
            <hr class="mt-50 mb-50">

        </form>

        @endif





    </div>
</div>
@if(!empty(session()->get('myinfospagreement')))
<script>
    // $('input').prop('readonly',true);
    // $('#fullname').prop('readonly',true);
    // $('#nricmain').prop('readonly',true);
    // $('#passport').prop('readonly',true);
    // $('#seller_country_code').prop('readonly',true);
    // $('#address').prop('readonly',true);
    // $('#vehicleDetails :input').prop('readonly',true);
</script>
@endif
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
        // $("#filledform").find("input, select, textarea").attr("disabled", true);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var checked = [];
        removecheckbox();
        checkcontent();   
        var arr = $.map($('input:checkbox:checked'), function(e, i) {
            if(e.value == 'on'){

            }else{
                checked.push('<li>'+e.value+'</li>');
            }
        });
        $('#termsdesc').html(checked);

        $("body").on("keyup", "input[name='selling_price']", function () {
            var selling_price = $(this).val();
            selling_price = selling_price.replace(/,/g, '');
            var deposit = $("input[name='deposit']").val();
            deposit = deposit.replace(/,/g, '');
            calcBalancePayment(selling_price, deposit);
        });

        $("body").on("keyup", "input[name='deposit']", function () {
            var selling_price = $("input[name='selling_price']").val();
            // selling_price = selling_price.replace(',', '');
            selling_price = selling_price.replace(/,/g, '');
            var deposit = $(this).val();
            // deposit = deposit.replace(',', '');
            deposit = deposit.replace(/,/g, '');
            calcBalancePayment(selling_price, deposit);
        });

        function calcBalancePayment(selling_price, deposit) {
            var deposit_percent = '{{ $system_settings->deposit_percent }}';
            // var balance_payment = parseFloat(selling_price - deposit).toFixed(2);
            var balance_payment = selling_price - deposit;
            balance_payment = balance_payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $("input[name='balance_payment']").val(balance_payment);
        }

        $('.positive-integer').numeric(
            { negative: false }
        );

        $("form").on("submit", function () {
            $(this).find("button").attr("disabled", true);
        });

        $("select[name='country_of_residence']").on("change", function () {
            var country_of_residence = $(this).val();
            $.ajax({
                method: 'POST',
                url: '{{ route("get-country-code") }}',
                data: {
                    'country_of_residence': country_of_residence,
                },
                cache: false,
                async: true,
                success: function (data) {
                    $("input[name='country_code']").val(data.success);
                    $("input[name='country_code']").parent("div.inrow").remove("empty").addClass("not-empty");
                },
                error: function (data) {
                    var mydata = JSON.parse(data.responseText);
                    if (mydata) {
                        alert(mydata.error);
                    }
                },
                complete: function () {
                    //
                }
            });
        });

        $("select[name='country_of_residence']").trigger("change");
    });

    $(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
            });

    function otherterms() {
        let val = $('#otherdesc').val();
        $('#termsdesc').val(val);
    }

    function removecheckbox(){
        let termsdateval = $('#termsdate').val();
        if(termsdateval == ''){
            $('#termsdateerror').html('');
            $('<p>Please enter date</p>').appendTo('#termsdateerror');
            $('#sale').prop('checked', false);
            return false;
        }else{
            $('#sale').val('Subject to Completion of Sale by:' + termsdateval);
            checkcheckbox();
        }
        
    }

    function removecheck(){
        $('#sale').prop('checked', false);
        // $('#sale').val('Subject to Completion of Sale by:' + termsdateval);
        checkcheckbox();
        // $('#sale').prop('checked', false);
        
    }

    function checkcontent(){
        let indicative_mileage = $('#indicative_mileage').val();
        if(indicative_mileage != ''){
            $('#indicative_mileagecheck').val('Indicative Mileage:' + indicative_mileage +' Km');
            checkcheckbox();
        }else{
            $('#indicative_mileageerror').html('');
            $('<p>Please enter Mileage</p>').appendTo('#indicative_mileageerror');
            $('#indicative_mileagecheck').prop('checked', false);
            return false;
        }
    }

    function addotherterms(){
        let otherterms = $('#otherdesc').val();
        if(otherterms != ''){
            $('<div class="checkbox"><input type="checkbox" name="terms[]" checked value="'+otherterms+'" onchange="checkcheckbox();"><label for="extra">'+otherterms+'</label></div><br>').appendTo('#othertermsextra');
            $('<input type="hidden" name="termsadded[]" value="'+otherterms+'">').appendTo('#termsadded');
            $('#otherdesc').val('');
            checkcheckbox();
        }
        
    }

    

    function checkcheckbox(){
        var checked = [];
        var arr = $.map($('input:checkbox:checked'), function(e, i) {
            var vall = e.value;
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
        $('#termsdesc').html(checked);
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

    
    function addCommas(nStr, idd) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        let val = x1 + x2;
        $('#'+idd).val(val);
    }

    $(function () {
        $("#open_market_value,#minimumparfbenefit,#selling_price,#deposit,#indicative_mileage,#engineeCapacity").on('keyup', function () {
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
<script>
	function callAuthoriseApi() {
		let authApiUrl = 'https://api.myinfo.gov.sg/com/v3/authorise';
		let clientId = 'PROD-200501881C-AUTOLINK-SELLERSALESPURCH';
		let redirectUrl = 'https://www.diycars.com/seller-sales-purchase/callback';
		let attributes = 'uinfin,name,sex,email,mobileno,regadd,vehicles.vehicleno,vehicles.type,vehicles.make,vehicles.model,vehicles.yearofmanufacture,vehicles.originalregistrationdate,vehicles.enginecapacity,vehicles.type,vehicles.chassisno,vehicles.primarycolour,vehicles.scheme,vehicles.enginecapacity,vehicles.engineno,vehicles.iulabelno,vehicles.nooftransfers,vehicles.minimumparfbenefit,vehicles.coeexpirydate,vehicles.roadtaxexpirydate,vehicles.openmarketvalue,vehicles.firstregistrationdate';
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
    
    function callAuthoriseApiBusiness() {
        let authApiUrl = 'https://api.myinfo.gov.sg/biz/v2/authorise';
        let clientId = 'PROD-200501881C-AUTOLINK-MIB-SELLERSALESPURCH';
        let redirectUrl = 'https://www.diycars.com/mib-seller-sales-purchase/callback';
        let attributes = 'uinfin,name,sex,email,mobileno';
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