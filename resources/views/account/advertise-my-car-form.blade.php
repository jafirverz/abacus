@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
    @include('inc.banner')
    @php
    if(!empty(session()->get('myinfoadvertisecar'))){
        $data = serialize(session()->get('myinfoadvertisecar'));
        $test = unserialize($data);
        if(sizeof($test)>0){
            $uinfin1 = $test['uinfin'] ?? '';
            $name1 = $test['name'] ?? '';
            $email1 = $test['email'] ?? '';
            $mobileno1 = $test['mobileno'] ?? '';
            $sex = ucwords(strtolower($test['sex'])) ?? '';
            $vehiclesNo = $test['vehiclesNo'] ?? '';
            $type = $test['type'] ?? '';
            $make = $test['make'] ?? '';
            $model = $test['model'] ?? '';
            $yearofmanufacture = $test['yearofmanufacture'] ?? '';
            $maximumunladenweight = $test['maximumunladenweight'] ?? '';
            if(!empty($test['originalregistrationdate']))
            {
                $originalregistrationdate = date('d-m-Y', strtotime($test['originalregistrationdate'])) ?? '';
            }else{
                $originalregistrationdate = '';
            }
            $make_model = $test['make_model'] ?? '';
            $enginecapacity = $test['enginecapacity'] ?? '';
            $primarycolour = $test['primarycolour'] ?? '';
            $scheme = $test['scheme'] ?? '';
            $propellant = $test['propellant'] ?? '';
            $engineno = $test['engineno'] ?? '';
            if(!empty($test['firstregistrationdate']))
            {
                $firstregistrationdate = date('d-m-Y', strtotime($test['firstregistrationdate'])) ?? '';
            }else{
                $firstregistrationdate = '';
            }
            
            $coecategory = $test['coecategory'] ?? '';
            $nooftransfers = $test['nooftransfers'] ?? '';
            if(!empty($test['minimumparfbenefit'])){
                $minimumparfbenefit = number_format($test['minimumparfbenefit']) ?? '';
            }else{
                $minimumparfbenefit = '';
            }
            if(!empty($test['openmarketvalue'])){
                $openmarketvalue = number_format($test['openmarketvalue']) ?? '';
            }else{
                $openmarketvalue = '';
            }
            //$openmarketvalue = number_format($test['openmarketvalue']) ?? '';
            if(!empty($test['quotapremium'])){
                $quotapremium = number_format($test['quotapremium']) ?? '';
            }else{
                $quotapremium = '';
            }
            //$quotapremium = number_format($test['quotapremium']) ?? '';
            if(!empty($test['coeexpirydate'])){
                $coeexpirydate = date('d-m-Y', strtotime($test['coeexpirydate'])) ?? '';
            }else{
                $coeexpirydate = '';
            }
            if(!empty($test['roadtaxexpirydate'])){
                $roadtaxexpirydate = date('d-m-Y', strtotime($test['roadtaxexpirydate'])) ?? '';
            }else{
                $roadtaxexpirydate = '';
            }
            //$coeexpirydate = date('d-m-Y', strtotime($test['coeexpirydate'])) ?? '';
            //$roadtaxexpirydate = date('d-m-Y', strtotime($test['roadtaxexpirydate'])) ?? '';
            $powerrate = $test['powerrate'] ?? '';
            $co2emission = $test['co2emission'] ?? '';
        }
    }else{
        if(Auth::user()){
            $name1 = Auth::user()->name ?? '';
            $mobileno1 = Auth::user()->mobile;
            $email1 = Auth::user()->email;
            $countryCode = Auth::user()->country_code;
            if(Auth::user()->gender==1){
                $sex = 'MALE';
            }elseif(Auth::user()->gender==2){
                $sex = 'FEMALE';
            }
            $address = Auth::user()->address;
            $postalCode = Auth::user()->postal_code;
            $uinfin1 = '';
        }else{
            $name1 = '';
            $sex = '';
            $mobileno1 = '';
            $email1 = '';
            $countryCode = '';
            $uinfin1 = '';
        }

        $vehiclesNo = '';
        $type = '';
        $make = '';
        $model = '';
        $yearofmanufacture = '';
        $originalregistrationdate = '';
        $make_model = '';
        $enginecapacity = '';
        $primarycolour = '';
        $scheme = '';
        $propellant = '';
        $engineno = '';
        $firstregistrationdate = '';
        $coecategory = '';
        $nooftransfers = '';
        $minimumparfbenefit = '';
        $openmarketvalue = '';
        $quotapremium = '';
        $coeexpirydate = '';
        $roadtaxexpirydate = '';
        $powerrate = '';
        $co2emission = '';
        $sex = '';
        $maximumunladenweight = '';
    }
    if(!empty(session()->get('myinfoadvertisebusiness'))){
        $data = serialize(session()->get('myinfoadvertisebusiness'));
        $test = unserialize($data);
        if(sizeof($test)>0){
            $uinfin1 = $test['uinfin'] ?? '';
            $name1 = $test['name'] ?? '';
            $email1 = $test['email'] ?? '';
            $mobileno1 = $test['mobileno'] ?? '';

        }
    }
    @endphp
    <div class="container main-inner">
        <h1 class="title-1 text-center">Advertise My Car</h1>
        <ul class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Advertise My Car</li>
        </ul>

        <div style="margin-bottom: 20px">
            {!! $page->content !!}
        </div>

        <div class="note-2">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-7 col-md-8">
                    <h4>Faster form filling with Singpass (Individual).</h4>
                    <p>Singpass enables you to retrieve your personal data from participating Government agencies.
                        With your consent, we can auto-fill this, making your application convenient.</p>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-4 last">
                    <a href="javascript::void(0);" onclick="callAuthoriseApi();" class="btn-6"><strong>Retrieve
                            Myinfo</strong> <br><span>with <img src="images/tempt/singpass-logo.png"
                                alt="singpass" /></span></a>
                </div>
            </div>
        </div>
        
        <!-- <div class="note-2">
			<div class="row align-items-center">
					<div class="col-xl-8 col-lg-7 col-md-8">
							<h4>Faster form filling with Singpass (Business).</h4>
							<p>Singpass enables you to retrieve your personal data from participating Government agencies.
									With your consent, we can auto-fill this, making your application convenient.</p>
					</div>
					<div class="col-xl-4 col-lg-5 col-md-4 last">
							<a href="javascript::void(0);" class="btn-6"><strong>Retrieve
											Myinfo Business</strong> <br><span>with <img src="images/tempt/singpass-logo.png"
													alt="singpass" /></span></a>
					</div>
			</div>
	    </div> -->
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
          @if(!empty(session()->get('myinfoadvertisecar')))
          @php 
          $required = '';
          @endphp
          @else 
          @php 
          $required = 'required';
          @endphp
          @endif
        <div class="add-my-car">
            @include('inc.messages')
            <form action="{{ url('advertise-my-car-form') }}" method="post" enctype="multipart/form-data"
                class="form-ani">
                @csrf
                <h3 class="title-6 item"><span><strong>Owner's Particulars </strong></span></h3>
                <div class="row">

                    <div class="col-xl-4">

                        <div class="inrow">

                            @if(!empty(session()->get('myinfoadvertisecar')))
                            <label>Full Name</label>
                            @else
                            <label>Full Name/ Company Name</label>
                            @endif

                            <input name="full_name" id="fullname" style="text-transform:uppercase" type="text" @if(!empty($name1) && !empty(session()->get('myinfoadvertisecar'))) readonly="readonly" @endif
                                class="form-control" value="{{ old('full_name', $name1 ?? '') }}" >
                        </div>
                        @if(empty($name1) && empty(old('full_name')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('full_name'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('full_name'))
                        <span class="text-danger">&nbsp;{{ $errors->first('full_name') }}</span>
                        @endif

                    </div>

                    <div class="col-xl-4 col-md-4">

                        <div class="inrow">
                            @if(!empty(session()->get('myinfoadvertisecar')))
                            <label>NRIC/FIN</label>
                            @else
                            <label>NRIC/FIN/UEN</label>
                            @endif

                            <input  name="nric" style="text-transform:uppercase" id="nric" @if(!empty($uinfin1)) readonly="readonly" @endif
                                value="{{ old('nric', $uinfin1) }}" type="text" class="form-control" >
                        </div>
                        @if(empty($uinfin1) && empty(old('nric')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('nric'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('nric'))
                        <span class="text-danger">&nbsp;{{ $errors->first('nric') }}</span>
                        @endif

                        {{--<p class="input-guid">*Full ID Required for Loan Application</p>--}}

                    </div>
                    @php 
                    $gender = old('gender') ?? '';
                    @endphp
                    <div class="col-xl-4 col-md-4">
                        @if(empty(session()->get('myinfoadvertisecar')))
                        <div class="mt-20">

                            <select class="selectpicker" name="gender" id="gender" datga-title="Gender" >

                                <option value="Male" @if($gender == 'Male' || $sex == 'Male') selected @endif>Male</option>
                                <option value="Female" @if($gender == 'Female' || $sex == 'Female') selected @endif>Female</option>
                            </select>
                            @if ($errors->has('gender'))
                            <span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                        @elseif(!empty(session()->get('myinfoadvertisecar')) && empty($sex))
                        <div class="mt-20">

                            <select class="selectpicker" name="gender" id="gender" datga-title="Gender" >

                                <option value="Male" @if(old('gender') == 'Male') selected @endif>Male</option>
                                <option value="Female" @if(old('gender') == 'Female') selected @endif>Female</option>
                            </select>
                            @if(empty($sex) && empty(old('gender')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('gender'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('gender'))
                            <span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                        @else 
                        <div class="inrow">

                            <label>Gender</label>

                            <input  name="gender" id="gender" @if(!empty($sex)) readonly="readonly" @endif
                                value="{{ $sex ?? '' }}" type="text" class="form-control">
                        </div>
                        @endif

                    </div>

                    <div class="col-md-5">

                        <div class="row sp-col-10 break-425">

                            <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">

                                <div class="inrow">

                                    <label>Country Code</label>

                                    <input name="country" @if(!empty(session()->get('myinfoadvertisecar'))) readonly @endif id="countrycode" value="+65" type="text" class="form-control" >
                                </div>
                                @if ($errors->has('country'))
                                <span class="text-danger">&nbsp;{{ $errors->first('country') }}</span>
                                @endif

                            </div>

                            <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">

                                <div class="inrow">

                                    <label>Contact No.</label>

                                    <input name="contact_number"
                                        value="{{ old('contact_number', $mobileno1 ?? '') }}" type="text"
                                        class="form-control"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" >
                                </div>
                                @if(empty($mobileno1) && empty(old('contact_number')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('contact_number'))
                                <span class="text-danger">This field is required</span>
                                @endif
                                @if ($errors->has('contact_number'))
                                <span class="text-danger">&nbsp;{{ $errors->first('contact_number') }}</span>
                                @endif

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-4">

                        <div class="inrow">

                            <label>Email Address (Ex: janedoe@gmail.com)</label>

                            <input name="email" value="{{ old('email', $email1 ?? '') }}" type="email"
                                class="form-control" >
                        </div>
                        @if(empty($email1) && empty(old('email')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('email'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('email'))
                        <span class="text-danger">&nbsp;{{ $errors->first('email') }}</span>
                        @endif

                    </div>
                    
                    @if(!empty(session()->get('myinfoadvertisecar')))
                    <div class="col-xl-3 col-md-3">

                        <div class="inrow">

                            <label>Vehicle Number</label>

                            <input name="vehicle_number" style="text-transform:uppercase" id="vehiclenumber" @if(!empty($vehiclesNo)) readonly="readonly" @endif
                                value="{{ old('vehicle_number', $vehiclesNo) }}" type="text" class="form-control" >
                        </div>
                        @if(empty($vehiclesNo) && empty(old('vehicle_number')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('vehicle_number'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('vehicle_number'))
                        <span class="text-danger">&nbsp;{{ $errors->first('vehicle_number') }}</span>
                        @endif

                    </div>
                    @endif
                </div>

                @if(empty(session()->get('myinfoadvertisecar')))
                <h3 class="title-6 mt-30"><span><strong>Vehicle Details </strong></span></h3>
                <div id="vehicleDetails">
                    <div class="row">

                        <div class="col-xl-3 col-md-3">

                            <div class="inrow">
    
                                <label>Vehicle Number</label>
    
                                <input name="vehicle_number" style="text-transform:uppercase" id="vehiclenumber"
                                    value="{{ old('vehicle_number', $vehiclesNo) }}" type="text" class="form-control" >
                            </div>
                            @if ($errors->has('vehicle_number'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_number') }}</span>
                            @endif
    
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="inrow info-wrap empty">
                                <label>Mileage (Estimated)</label>
                                <input value="{{ old('mileage') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="mileage" type="text" id="mileage"
                                    class="form-control" >
                                <span class="input-info"> km </span>
                            </div>
                            @if ($errors->has('mileage'))
                            <span class="text-danger">&nbsp;{{ $errors->first('mileage') }}</span>
                            @endif
                        </div>

                        

                    </div>

                    

                </div>
                @endif

                @if(!empty(session()->get('myinfoadvertisecar')))
                <h3 class="title-6 mt-30"><span><strong>Vehicle Details </strong></span></h3>
                <div id="vehicleDetails">
                    <div class="row">

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>Vehicle Make</label>

                                <input type="text" class="form-control" name="vehicle_make" @if(!empty($make)) readonly="readonly" @endif style="text-transform:uppercase"
                                value="{{ old('vehicle_make', $make) }}" />

                            </div>
                            @if(empty($make) && empty(old('vehicle_make')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('vehicle_make'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('vehicle_make'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_make') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>Vehicle Model</label>

                                <input type="text" class="form-control" name="vehicle_model" @if(!empty($model)) readonly="readonly" @endif style="text-transform:uppercase"
                                value="{{ old('vehicle_model', $model) }}" />

                            </div>
                            @if(empty($model) && empty(old('vehicle_model')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('vehicle_model'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('vehicle_model'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_model') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">
                            @if(!empty($primarycolour))
                            <div class="inrow">
                                <label>Primary Colour</label>
                                 <input type="text" class="form-control" name="primary_color" @if(!empty($primarycolour)) readonly="readonly" @endif style="text-transform:uppercase"
                                value="{{ old('primary_color', $primarycolour) }}" />
                            </div>
                            @else
                            <div class="inrow">
                                <select class="selectpicker" name="primary_color" data-title="Primary Color" >
                                    <option value="White" @if(old('primary_color')=="White" ) selected="selected" @endif>White</option>
                                    <option value="Black" @if(old('primary_color')=="Black" ) selected="selected" @endif>Black</option>
                                    <option value="Grey" @if(old('primary_color')=="Grey" ) selected="selected" @endif>Grey</option>
                                    <option value="Silver" @if(old('primary_color')=="Silver" ) selected="selected" @endif>Silver</option>
                                    <option value="Red" @if(old('primary_color')=="Red" ) selected="selected" @endif>Red</option>
                                    <option value="Blue" @if(old('primary_color')=="Blue" ) selected="selected" @endif>Blue</option>
                                    <option value="Brown" @if(old('primary_color')=="Brown" ) selected="selected" @endif>Brown</option>
                                    <option value="Green" @if(old('primary_color')=="Green" ) selected="selected" @endif>Green</option>
                                    <option value="Beige" @if(old('primary_color')=="Beige" ) selected="selected" @endif>Beige</option>
                                    <option value="Orange" @if(old('primary_color')=="Orange" ) selected="selected" @endif>Orange</option>
                                    <option value="Gold" @if(old('primary_color')=="Gold" ) selected="selected" @endif>Gold</option>
                                    <option value="Yellow" @if(old('primary_color')=="Yellow" ) selected="selected" @endif>Yellow</option>
                                    <option value="Purple" @if(old('primary_color')=="Purple" ) selected="selected" @endif>Purple</option>
                                    <option value="Pink" @if(old('primary_color')=="Pink" ) selected="selected" @endif>Pink</option>
                                    <option value="Others" @if(old('primary_color')=="Others" ) selected="selected" @endif>Others</option>
                                </select>
                            </div>
                            @endif
                            @if(empty($primarycolour) && empty(old('primary_color')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('primary_color'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('primary_color'))
                            <span class="text-danger">&nbsp;{{ $errors->first('primary_color') }}</span>
                            @endif

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>Year of Manufacture</label>

                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="year_of_manufacture" style="text-transform:uppercase" @if(!empty($yearofmanufacture)) readonly="readonly" @endif
                                value="{{ old('year_of_manufacture', $yearofmanufacture) }}" minlength="4" maxlength="4" />
                                

                            </div>
                            @if(empty($yearofmanufacture) && empty(old('year_of_manufacture')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('year_of_manufacture'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('year_of_manufacture'))
                            <span class="text-danger">&nbsp;{{ $errors->first('year_of_manufacture') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            
                            <div class="inrow inptxt lefttxt">
                                <label>Open Market Value</label>
								<span class="txt">$</span>  

                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="open_market_value" style="text-transform:uppercase" @if(!empty($openmarketvalue)) readonly="readonly" @endif
                                value="{{ old('open_market_value', $openmarketvalue) }}" id="open_market_value" />

                            </div>
                            @if(empty($openmarketvalue) && empty(old('open_market_value')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('open_market_value'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('open_market_value'))
                            <span class="text-danger">&nbsp;{{ $errors->first('open_market_value') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow date-wrap datepicker-wrap">

                                <label>Original Registration Date</label>

                                <input type="text" class="form-control" name="orig_reg_date" style="text-transform:uppercase" @if(!empty($originalregistrationdate)) readonly="readonly" @endif
                                value="{{ old('orig_reg_date', $originalregistrationdate) }}" />
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @if(empty($originalregistrationdate) && empty(old('orig_reg_date')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('orig_reg_date'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('orig_reg_date'))
                            <span class="text-danger">&nbsp;{{ $errors->first('orig_reg_date') }}</span>
                            @endif

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow date-wrap datepicker-wrap">

                                <label>First Registration Date (For Used Import)</label>

                                <input type="text" class="form-control" name="first_reg_date" style="text-transform:uppercase" @if(!empty($firstregistrationdate)) readonly="readonly" @endif
                                value="{{ old('first_reg_date', $firstregistrationdate) }}" />
                                <i class="fas fa-calendar-alt"></i>

                            </div>
                            @if(empty($firstregistrationdate) && empty(old('first_reg_date')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('first_reg_date'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('first_reg_date'))
                            <span class="text-danger">&nbsp;{{ $errors->first('first_reg_date') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>No. of Transfers</label>

                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="2" maxlength="2" name="no_of_transfer" style="text-transform:uppercase" @if(!empty($nooftransfers)) readonly="readonly" @endif
                                value="{{ old('no_of_transfer', $nooftransfers) }}" />

                            </div>
                            @if(empty($nooftransfers) && empty(old('no_of_transfer')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('no_of_transfer'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('no_of_transfer'))
                            <span class="text-danger">&nbsp;{{ $errors->first('no_of_transfer') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow inptxt lefttxt">
                                <label>Minimum PARF Benefit</label>
								<span class="txt">$</span>  

                                <input type="text" class="form-control" name="minimumparfbenefit" style="text-transform:uppercase" id="minimumparfbenefit" @if(!empty($minimumparfbenefit)) readonly="readonly" @endif
                                value="{{ old('minimumparfbenefit', $minimumparfbenefit) }}" />

                            </div>
                            @if(empty($minimumparfbenefit) && empty(old('minimumparfbenefit')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('minimumparfbenefit'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('minimumparfbenefit'))
                            <span class="text-danger">&nbsp;{{ $errors->first('minimumparfbenefit') }}</span>
                            @endif

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow date-wrap datepicker-wrap">

                                <label>COE Expiry Date</label>

                                <input type="text" class="form-control" name="coe_expiry_date" style="text-transform:uppercase" @if(!empty($coeexpirydate)) readonly="readonly" @endif
                                value="{{ old('coe_expiry_date', $coeexpirydate) }}" />
                                <i class="fas fa-calendar-alt"></i>

                            </div>
                            @if(empty($coeexpirydate) && empty(old('coe_expiry_date')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('coe_expiry_date'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('coe_expiry_date'))
                            <span class="text-danger">&nbsp;{{ $errors->first('coe_expiry_date') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>COE Category</label>

                                <input type="text" class="form-control" name="coe_category" style="text-transform:uppercase" @if(!empty($coecategory)) readonly="readonly" @endif
                                value="{{ old('coe_category', $coecategory) }}" />

                            </div>
                            @if(empty($coecategory) && empty(old('coe_category')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('coe_category'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('coe_category'))
                            <span class="text-danger">&nbsp;{{ $errors->first('coe_category') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                           <div class="inrow inptxt lefttxt">
                                <label>Quota Premium</label>
								<span class="txt">$</span> 

                                <input type="text" class="form-control" name="quota_premium" style="text-transform:uppercase" @if(!empty($quotapremium)) readonly="readonly" @endif
                                value="{{ old('quota_premium', $quotapremium) }}" id="quota_premium" />

                            </div>
                            @if(empty($quotapremium) && empty(old('quota_premium')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('quota_premium'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('quota_premium'))
                            <span class="text-danger">&nbsp;{{ $errors->first('quota_premium') }}</span>
                            @endif

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-xl-4 col-md-4">
                            @if(!empty($type))
                            <div class="inrow">
                                <label>Vehicle Type</label>
                                <input type="text" class="form-control" name="vehicle_type" @if(!empty($type)) readonly="readonly" @endif style="text-transform:uppercase"
                                value="{{ old('vehicle_type', $type) }}" />
                            </div>
                            @else
                            <div class="inrow">
                                <label>Vehicle Type</label>
                                <select class="selectpicker" name="vehicle_type" data-title="Vehicle Type">
                                    <option value="Mid-Sized Sedan" @if(old('vehicle_type')=="Mid-Sized Sedan" ) selected="selected" @endif>Mid-Sized Sedan</option>
                                    <option value="Luxury Sedan" @if(old('vehicle_type')=="Luxury Sedan" ) selected="selected" @endif>Luxury Sedan</option>
                                    <option value="Hatchback" @if(old('vehicle_type')=="Hatchback" ) selected="selected" @endif>Hatchback</option>
                                    <option value="SUV" @if(old('vehicle_type')=="SUV" ) selected="selected" @endif>SUV</option>
                                    <option value="Passenger Car" @if(old('vehicle_type')=="Passenger Car" ) selected="selected" @endif>Passenger Car</option>
                                    <option value="MPV" @if(old('vehicle_type')=="MPV" ) selected="selected" @endif>MPV</option>
                                    <option value="Station Wagon" @if(old('vehicle_type')=="Station Wagon" ) selected="selected" @endif>Station Wagon</option>
                                    <option value="Sports Car" @if(old('vehicle_type')=="Sports Car" ) selected="selected" @endif>Sports Car</option>
                                    <option value="Commercial Vehicle" @if(old('vehicle_type')=="Commercial Vehicle" ) selected="selected" @endif>Commercial Vehicle</option>
                                    <option value="Van" @if(old('vehicle_type')=="Van" ) selected="selected" @endif>Van</option>
                                    <option value="Truck" @if(old('vehicle_type')=="Truck" ) selected="selected" @endif>Truck</option>
                                    <option value="Bus/Mini Bus" @if(old('vehicle_type')=="Bus/Mini Bus" ) selected="selected" @endif>Bus/Mini Bus</option>
                                    <option value="Others" @if(old('vehicle_type')=="Others" ) selected="selected" @endif>Others</option>
                                </select>
                            </div>
                            @endif
                            @if(empty($type) && empty(old('vehicle_type')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('vehicle_type'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('vehicle_type'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_type') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">
                            @if(!empty($propellant))
                            <div class="inrow">

                                <label>Propellant</label>

                                <input type="text" class="form-control" name="propellant" style="text-transform:uppercase" @if(!empty($propellant)) readonly="readonly" @endif
                                value="{{ old('propellant', $propellant) }}" />

                            </div>
                            @else
                            <div class="inrow">
                                <select class="selectpicker" name="propellant" data-title="Propellant">
                                    <option value="Compressed Natural Gas" @if(old('propellant')=="Compressed Natural Gas" ) selected="selected" @endif>Compressed Natural Gas</option>
                                    <option value="Diesel" @if(old('propellant')=="Diesel" ) selected="selected" @endif>Diesel</option>
                                    <option value="Diesel-CNG" @if(old('propellant')=="Diesel-CNG" ) selected="selected" @endif>Diesel-CNG</option>
                                    <option value="Diesel-Electric" @if(old('propellant')=="Diesel-Electric" ) selected="selected" @endif>Diesel-Electric</option>
                                    <option value="Diesel-Electric (Plug-In)" @if(old('propellant')=="Diesel-Electric (Plug-In)" ) selected="selected" @endif>Diesel-Electric (Plug-In)</option>
                                    <option value="Electric" @if(old('propellant')=="Electric" ) selected="selected" @endif>Electric</option>
                                    <option value="Gas" @if(old('propellant')=="Gas" ) selected="selected" @endif>Gas</option>
                                    <option value="Liquefied Petroleum Gas (LPG)" @if(old('propellant')=="Liquefied Petroleum Gas (LPG)" ) selected="selected" @endif>Liquefied Petroleum Gas (LPG)</option>
                                    <option value="Petrol" @if(old('propellant')=="Petrol" ) selected="selected" @endif>Petrol</option>
                                    <option value="Petrol-CNG" @if(old('propellant')=="Petrol-CNG" ) selected="selected" @endif>Petrol-CNG</option>
                                    <option value="Petrol-Electric" @if(old('propellant')=="Petrol-Electric" ) selected="selected" @endif>Petrol-Electric</option>
                                    <option value="Petrol-Electric (Plug-In)" @if(old('propellant')=="Petrol-Electric (Plug-In)" ) selected="selected" @endif>Petrol-Electric (Plug-In)</option>
                                    <option value="Petrol-LPG" @if(old('propellant')=="Petrol-LPG" ) selected="selected" @endif>Petrol-LPG</option>
                                </select>
                            </div>
                            @endif
                            @if(empty($propellant) && empty(old('propellant')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('propellant'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('propellant'))
                            <span class="text-danger">&nbsp;{{ $errors->first('propellant') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>Power Rate</label>

                                <input type="text" class="form-control" name="power_rate" style="text-transform:uppercase" @if(!empty($powerrate)) readonly="readonly" @endif
                                value="{{ old('power_rate', $powerrate) }}" />

                            </div>
                            @if(empty($powerrate) && empty(old('power_rate')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('power_rate'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('power_rate'))
                            <span class="text-danger">&nbsp;{{ $errors->first('power_rate') }}</span>
                            @endif

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>Vehicle CO2 Emission Rate</label>

                                <input type="text" class="form-control" name="vehicle_emission_rate" style="text-transform:uppercase" @if(!empty($co2emission)) readonly="readonly" @endif
                                value="{{ old('vehicle_emission_rate', $co2emission) }}" />

                            </div>
                            @if(empty($co2emission) && empty(old('vehicle_emission_rate')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('vehicle_emission_rate'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('vehicle_emission_rate'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_emission_rate') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>Max Unladen Weight</label>

                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="max_weight" style="text-transform:uppercase"
                                value="{{ old('max_weight', $maximumunladenweight ?? '') }}" @if(!empty($maximumunladenweight)) readonly="readonly" @endif id="max_weight" />

                            </div>
                            @if(empty($maximumunladenweight) && empty(old('max_weight')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('max_weight'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('max_weight'))
                            <span class="text-danger">&nbsp;{{ $errors->first('max_weight') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">
                            @if(!empty($scheme))
                            <div class="inrow">

                                <label>Vehicle Scheme (- represents normal)</label>

                                <input type="text" class="form-control" name="vehicle_scheme" @if(!empty($scheme)) readonly="readonly" @endif style="text-transform:uppercase"
                                value="{{ old('vehicle_scheme', $scheme) }}" />

                            </div>
                            @else
                            <div class="inrow">
                                <select class="selectpicker" name="vehicle_scheme" data-title="Vehicle Scheme (- represents normal)">
                                    <option value="Normal" @if(old('vehicle_scheme')=="Normal" ) selected="selected" @endif>Normal</option>
                                    <option value="OPC (Off Peak Car)" @if(old('vehicle_scheme')=="OPC (Off Peak Car)" ) selected="selected" @endif>OPC (Off Peak Car)</option>
                                    <option value="Classic" @if(old('vehicle_scheme')=="Classic" ) selected="selected" @endif>Classic</option>
                                    <option value="Vintage" @if(old('vehicle_scheme')=="Vintage" ) selected="selected" @endif>Vintage</option>
                                </select>
                            </div>
                            @endif

                            @if(empty($scheme) && empty(old('vehicle_scheme')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('vehicle_scheme'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('vehicle_scheme'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_scheme') }}</span>
                            @endif

                        </div>

                    </div>



                    <div class="row">

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow">

                                <label>Engine Capacity</label>

                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="engine_capacity" style="text-transform:uppercase" @if(!empty($enginecapacity)) readonly="readonly" @endif
                                value="{{ old('engine_capacity', $enginecapacity) }}" />

                            </div>
                            @if(empty($enginecapacity) && empty(old('engine_capacity')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('engine_capacity'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('engine_capacity'))
                            <span class="text-danger">&nbsp;{{ $errors->first('engine_capacity') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">

                            <div class="inrow date-wrap datepicker-wrap">

                                <label>Road Tax Expiry Date</label>

                                <input type="text" class="form-control" name="roadtaxexpirydate"  style="text-transform:uppercase" @if(!empty($roadtaxexpirydate)) readonly="readonly" @endif
                                value="{{ old('roadtaxexpirydate', $roadtaxexpirydate) }}" />
                                <i class="fas fa-calendar-alt"></i>

                            </div>
                            @if(empty($roadtaxexpirydate) && empty(old('roadtaxexpirydate')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('roadtaxexpirydate'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('roadtaxexpirydate'))
                            <span class="text-danger">&nbsp;{{ $errors->first('roadtaxexpirydate') }}</span>
                            @endif

                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="inrow not-empty">
                                <label>Mileage (Estimated)</label>
                                <input value="{{ old('mileage') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="mileage" type="text" id="mileage"
                                    class="form-control">
                                <span class="input-info"> km </span>
                            </div>
                            @if(empty(old('mileage')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('mileage'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('mileage'))
                            <span class="text-danger">&nbsp;{{ $errors->first('mileage') }}</span>
                            @endif
                        </div>

                    </div>

                </div>
                @endif

                <h3 class="title-6 mt-30"><span><strong>Asking Price </strong></span></h3>
                <div class="row">
                    <div class="col-lg-4 mt-20">
                        <div class="notepp empty">
                            <div class="input-group grinput empty">
                                <span class="input-group-text">$</span>
                                <input value="{{ old('price') }}" id="askingprice"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="price"
                                    type="text" class="form-control" >
                            </div>
                            @if(empty(old('price')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('price'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('price'))
                            <span class="text-danger">&nbsp;{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- 
                    <div class="col-xl-6 col-md-6">
                        <div class="inrow info-wrap empty">
                            <label>Mileage (Estimated)</label>
                            <input value="{{ old('mileage') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="mileage" type="text"
                                class="form-control">
                            <span class="input-info"> km </span>
                        </div>
                        @if ($errors->has('mileage'))
                        <span class="text-danger">&nbsp;{{ $errors->first('mileage') }}</span>
                        @endif
                    </div>
                    --}}
                </div>

                <h3 class="title-6 mb-30 mt-30"><span><strong>Features </strong></span></h3>
                @php
                $specificationList = old('specification') ?? [];
                @endphp

                {{--
                @if(empty(old('specification')) && !empty(session()->get('myinfoadvertisecar')) && !$errors->has('specification'))
                <span class="text-danger">This field is required</span>
                @endif
                --}}
                @if ($errors->has('specification'))
                    <span class="text-danger">&nbsp;{{ $errors->first('specification') }}</span>
                @endif

                <div class="check-inline ad-checkline" id="specification_group">
                    @if(get_specifications())
                    @foreach (get_specifications() as $key=>$item)
                    <div class="checkbox">
                        <input type="checkbox" id="sp{{$key}}" @if(in_array($item->specification,$specificationList)) checked @endif value="{{$item->specification}}" name="specification[]">
                        <label for="sp{{$key}}" style="text-transform:uppercase">{{$item->specification}}</label>
                    </div>
                    @endforeach
                    @endif
                </div>
                
               

                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <div class="inrow-label">
                            <label>Additional Features:</label>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="inrow add-plus empty">
                            <input type="text" id="add_specification_val" style="text-transform:uppercase"
                                class="form-control">
                            <button id="add_specification" type="button">Add +</button>
                        </div>
                    </div>
                </div>
                <div id="specification_list" style="text-transform: uppercase;">
                    @foreach($specificationList as $key=>$itemS)
                    <li>{{ $itemS }}</li>
                    @endforeach
                </div>

                <h3 class="title-6 mb-30 mt-30"><span><strong>Accessories </strong></span></h3>
                @php
                $accessoryList = old('additional_accessories') ?? [];
                @endphp
                @if ($errors->has('additional_accessories'))
                    <span class="text-danger">&nbsp;{{ $errors->first('additional_accessories') }}</span>
                @endif
                <div class="check-inline ad-checkline" id="additional_accessories_checkbox">
                    @if(get_attributes())
                    @foreach (get_attributes() as $key=>$item)
                    <div class="checkbox">
                        <input type="checkbox" value="{{$item->attribute_title }}" @if(in_array($item->attribute_title,$accessoryList)) checked @endif id="ac{{$key}}"
                            name="additional_accessories[]">
                        <label for="ac{{$key}}" style="text-transform:uppercase">{{$item->attribute_title }}</label>
                    </div>
                    @endforeach
                    @endif
                </div>
                @if ($errors->has('additional_accessories.*'))
                <span class="text-danger d-block">
                    <strong>{{ $errors->first('additional_accessories.*') }}</strong>
                </span>
                @endif
                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <div class="inrow-label">
                            <label>Additional accessories:</label>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="inrow add-plus empty">
                            <input type="text" style="text-transform:uppercase" id="additional_accessories_checkbox_val"
                                class="form-control">
                            <button id="add_additional_accessories">Add +</button>
                        </div>
                    </div>
                </div>

                <div id="accessories_list" style="text-transform: uppercase;">
                    @foreach($accessoryList as $key=>$itemA)
                    <li>{{ $itemA }}</li>
                    @endforeach
                </div>

                <h3 class="title-6 mb-30 mt-30"><span><strong>Seller's Comment </strong></span></h3>
                <div class="mt-20 empty">
                    <textarea value="{{ old('seller_comment') }}" name="seller_comment" rows="6" cols="30"
                        class="form-control"></textarea>
                </div>
                @if ($errors->has('seller_comment'))
                <span class="text-danger">&nbsp;{{ $errors->first('seller_comment') }}</span>
                @endif

                <h3 class="title-6 mb-10 mt-30"><span><strong>Select to Upload Photos / Videos</strong></span></h3>
                <div class="row">
                    <div class="col-lg-4 col-sm-6 mt-20">	
                        <label>Front Photo</label>								
                        <div class="attach-box">
                            <div class="file-wrap">
                                <input  class="custom-file-input text-file" onchange="remove(1);" type="file" id="upload_photo_1" name="upload_file[]" >
                                <span class="txt" id="upload_photo_name_1">No file chosen</span>
                                <label for="upload_photo_1" class="upload">Upload File </label>
                            </div>
                            <a href="javascript::void();" id="button1" onclick="deleteImage('1');" style="display: none;" >Remove</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-20">	
                        <label>Front Interior</label>								
                        <div class="attach-box">
                            <div class="file-wrap">
                                <input  class="custom-file-input text-file"  type="file" onchange="remove(2);" id="upload_photo_2" name="upload_file[]" >
                                <span class="txt" id="upload_photo_name_2">No file chosen</span>
                                <label for="upload_photo_2" class="upload">Upload File </label>
                            </div>
                            <a href="javascript::void();" id="button2" onclick="deleteImage('2');" style="display: none;" >Remove</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-20">	
                        <label>Left side Photo</label>								
                        <div class="attach-box">
                            <div class="file-wrap">
                                <input  class="custom-file-input text-file" type="file" onchange="remove(3);" id="upload_photo_3" name="upload_file[]" >
                                <span class="txt" id="upload_photo_name_3">No file chosen</span>
                                <label for="upload_photo_3" class="upload">Upload File </label>
                            </div>
                            <a href="javascript::void();" id="button3" onclick="deleteImage('3');" style="display: none;" >Remove</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-20">	
                        <label>Right hand Side Photo</label>								
                        <div class="attach-box">
                            <div class="file-wrap">
                                <input  class="custom-file-input text-file" type="file" onchange="remove(6);" id="upload_photo_6" name="upload_file[]" >
                                <span class="txt" id="upload_photo_name_6">No file chosen</span>
                                <label for="upload_photo_6" class="upload">Upload File </label>
                            </div>
                            <a href="javascript::void();" id="button6" style="display: none;" onclick="deleteImage('6');">Remove</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-20">	
                        <label>Rear Interior</label>								
                        <div class="attach-box">
                            <div class="file-wrap">
                                <input  class="custom-file-input text-file" type="file" onchange="remove(5);" id="upload_photo_5" name="upload_file[]" >
                                <span class="txt" id="upload_photo_name_5">No file chosen</span>
                                <label for="upload_photo_5" class="upload">Upload File </label>
                            </div>
                            <a href="javascript::void();" id="button5" style="display: none;" onclick="deleteImage('5');">Remove</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-20">	
                        <label>Rear</label>								
                        <div class="attach-box">
                            <div class="file-wrap">
                                <input  class="custom-file-input text-file" type="file" onchange="remove(4);" id="upload_photo_4" name="upload_file[]" >
                                <span class="txt" id="upload_photo_name_4">No file chosen</span>
                                <label for="upload_photo_4" class="upload">Upload File </label>
                            </div>
                            <a href="javascript::void();" id="button4" style="display: none;" onclick="deleteImage('4');" >Remove</a>
                        </div>
                    </div>
                    
                </div>

                {{-- 
                <div class="row">
                    <div class="col-lg-12 mt-20">
                        <div class="attach-box">
                            <div class="file-wrap mt-10">
                                <input class="custom-file-input text-file" type="file" id="upload_photo"
                                    name="upload_file[]" multiple="">
                                <span class="txt">No file chosen</span>
                                <label for="upload_photo" class="upload">Upload File </label>
                            </div>
                        </div>
                        @if ($errors->has('upload_photo'))
                        <span class="text-danger">&nbsp;{{ $errors->first('upload_photo') }}</span>
                        @endif
                    </div>
                </div>
                --}}

                <div class="checkbox mt-30">
                    <input type="checkbox" id="terms_condition" name="terms_condition" required>
                    <label for="information">I acknowledge and agree to the collection, use and disclosure of my personal data which has been provided for the purpose of advertising and marketing my car, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.
                    </label>
                    @if ($errors->has('terms_condition'))
                    <span class="text-danger">&nbsp;{{ $errors->first('terms_condition') }}</span>
                    @endif
                </div>
                <div class="output-2">
                    <button class="btn-1 minw-190" type="submit">SUBMIT <i class="fas fa-arrow-right"></i></button>
                </div>
                {{-- <div class="captcha">
                    <!-- Google reCAPTCHA widget -->
                    <div class="google-recaptcha">
                        <div class="g-recaptcha" data-callback="setResponse" data-size="invisible"
                            data-sitekey="{{config('system_settings')->recaptcha_site_key}}"></div>
                        <input type="hidden" id="captcha-response" name="captcha_response" />
                    </div>
                    <!-- Google reCAPTCHA widget -->
                </div> --}}
            </form>
        </div>
    </div>
</div>
<!-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback" async defer></script> -->
@if(!empty(session()->get('myinfoadvertisecar')))
<script>
    // $('input').prop('readonly',true);
    // $('#fullname').prop('readonly',true);
    // $('#nric').prop('readonly',true);
    // $('#gender').prop('readonly',true);
    // $('#countrycode').prop('readonly',true);
    // $('#vehiclenumber').prop('readonly',true);
    // $('#vehicleDetails :input').prop('readonly',true);
    // $('#mileage').prop('readonly',false);
</script>
@endif
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', "#specification_group input[type='checkbox']", function () {
            var content = [];
            var i = 0;
            $("#specification_group input[type='checkbox']:checked").each(function () {
                i++;
                content.push(i + '. ' + $(this).next("label").text() + '<br>');
            });
            $('#specification_list').html(content);
        });

        $(document).on('change', "#additional_accessories_checkbox input[type='checkbox']", function () {
            var content = [];
            var i = 0;
            $("#additional_accessories_checkbox input[type='checkbox']:checked").each(function () {
                i++;
                content.push(i + '. ' + $(this).next("label").text() + '<br>');
            });
            $('#accessories_list').html(content);
        });

    });
    $('#add_specification').click(function () {
        var numItems = $('#specification_group div.checkbox').length;
        numItems = numItems + 1;
        var text = $('#add_specification_val').val();
        if (text != "") {
            $('#specification_group').append('<div class="checkbox" style="display:block"><input value="' + text + '" name="specification[]" type="checkbox" checked id="sp' + numItems + '"/> <label for="sp' + numItems + '" style="text-transform:uppercase">' + text + '</label></div>');
            $('#add_specification_val').val('');
            
            checkcheckbox();
            
        }
        else {
            alert('Please add specification value.');
        }

        return false;
    });

    function checkcheckbox(){
        var checked = [];
        var content = [];
        var i = 0;
        $("#specification_group input[type='checkbox']:checked").each(function () {
                i++;
                content.push(i + '. ' + $(this).next("label").text() + '<br>');
            });
            $('#specification_list').html(content);
    }
    

    $('#add_additional_accessories').click(function () {
        var numItems = $('#additional_accessories_checkbox div.checkbox').length;
        numItems = numItems + 1;
        //alert(numItems);
        var text = $('#additional_accessories_checkbox_val').val();
        if (text != "") {
            $('#additional_accessories_checkbox').append('<div class="checkbox"><input value="' + text + '" name="additional_accessories[]" type="checkbox" checked id="ac' + numItems + '"/> <label for="ac' + numItems + '" style="text-transform:uppercase">' + text + '</label></div>');
            $('#additional_accessories_checkbox_val').val('');
            checkcheckboxAcc();
        }
        else {
            alert('Please add additional accessories value.');
        }
        return false;
    });

    function checkcheckboxAcc(){
        var content = [];
        var i = 0;
            $("#additional_accessories_checkbox input[type='checkbox']:checked").each(function () {
                i++;
                content.push(i + '. ' + $(this).next("label").text() + '<br>');
            });
            $('#accessories_list').html(content);
    }

    $(function () {
        $("#askingprice,#minimumparfbenefit,#quota_premium,#open_market_value,#max_weight,#mileage").on('keyup', function () {
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

// var onloadCallback = function() {
// 		grecaptcha.execute();
// 	};

// function setResponse(response) {
//     document.getElementById('captcha-response').value = response;
// }
</script>
@if($errors->any())
<script>
    $(document).ready(function() {
        $('html, body').animate({
        scrollTop: $(".add-my-car").offset().top
    }, 2000);  
    });
</script>
@endif
<script>
    $(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
            });
            
    function callAuthoriseApi() {
        let authApiUrl = 'https://api.myinfo.gov.sg/com/v3/authorise';
        let clientId = 'PROD-200501881C-AUTOLINK-ADVERTISECAR';
        let redirectUrl = 'https://www.diycars.com/advertise-car/callback';
        let attributes = 'uinfin,name,sex,email,mobileno,vehicles.vehicleno,vehicles.type,vehicles.make,vehicles.model,vehicles.yearofmanufacture,vehicles.originalregistrationdate,vehicles.enginecapacity,vehicles.type,vehicles.primarycolour,vehicles.scheme,vehicles.enginecapacity,vehicles.propellant,vehicles.powerrate,vehicles.roadtaxexpirydate,vehicles.coeexpirydate,vehicles.quotapremium,vehicles.openmarketvalue,vehicles.minimumparfbenefit,vehicles.nooftransfers,vehicles.coecategory,vehicles.firstregistrationdate,vehicles.co2emission,vehicles.maximumunladenweight';
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
        let clientId = 'PROD-200501881C-AUTOLINK-MIB-ADVERTISECAR';
        let redirectUrl = 'https://www.diycars.com/mib-advertise-car/callback';
        let attributes = 'name,sex,email,mobileno';
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

    function remove(val){
        $('#button'+val).show();
    }

    function deleteImage(val){
        $('#upload_photo_'+val).val('');
        $('#upload_photo_name_'+val).text('');
        $('#button'+val).hide();
    }
</script>
@endsection