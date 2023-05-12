@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
    @include('inc.banner')

    <div class="container main-inner">
        <h1 class="title-1 text-center">Quote My Car</h1>
        <ul class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Quote My Car</li>
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
                            Myinfo</strong><br> <span>with <img src="images/tempt/singpass-logo.png"
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
        @php
        if(!empty(session()->get('myinfoquotemycar'))){
            $data = serialize(session()->get('myinfoquotemycar'));
            $test = unserialize($data);
            if(sizeof($test)>0){
                $uinfin1 = $test['uinfin'] ?? '';
                $name1 = $test['name'] ?? '';
                $email1 = $test['email'] ?? '';
                $mobileno1 = $test['mobileno'] ?? '';
                $sex1 = $test['sex'] ?? '';
                $vehiclesNo = $test['vehiclesNo'] ?? '';
                $type = $test['type'] ?? '';
                $make = $test['make'] ?? '';
                $model = $test['model'] ?? '';
                $yearofmanufacture = $test['yearofmanufacture'] ?? '';
                if(!empty($test['originalregistrationdate'])){
                    $originalregistrationdate = date('d-m-Y', strtotime($test['originalregistrationdate'])) ?? '';
                }else{
                    $originalregistrationdate = '';
                }
                
                $make_model = $test['make_model'] ?? '';
                //$enginecapacity = number_format($test['enginecapacity']) ?? '';
                if(!empty($test['enginecapacity'])){
                    $enginecapacity = number_format($test['enginecapacity']) ?? '';
                }else{
                    $enginecapacity = '';
                }
                $primarycolour = $test['primarycolour'] ?? '';
                $scheme = $test['scheme'] ?? '';
                $propellant = $test['propellant'] ?? '';
                $engineno = $test['engineno'] ?? '';
                if(!empty($test['firstregistrationdate'])){
                    $firstregistrationdate = date('d-m-Y', strtotime($test['firstregistrationdate'])) ?? '';
                }else{
                    $firstregistrationdate = '';
                }
                
                $coecategory = $test['coecategory'] ?? '';
                if(!empty($test['nooftransfers'])){
                    $nooftransfers = number_format($test['nooftransfers']) ?? '';
                }else{
                    $nooftransfers = '';
                }
                //$nooftransfers = number_format($test['nooftransfers']) ?? '';
                if(!empty($test['minimumparfbenefit'])){
                    $minimumparfbenefit = number_format($test['minimumparfbenefit']) ?? '';
                }else{
                    $minimumparfbenefit = '';
                }
                //$minimumparfbenefit = number_format($test['minimumparfbenefit']) ?? '';
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
                //$coeexpirydate = date('d-m-Y', strtotime($test['coeexpirydate'])) ?? '';
                if(!empty($test['roadtaxexpirydate'])){
                    $roadtaxexpirydate = date('d-m-Y', strtotime($test['roadtaxexpirydate'])) ?? '';
                }else{
                    $roadtaxexpirydate = '';
                }
                //$roadtaxexpirydate = date('d-m-Y', strtotime($test['roadtaxexpirydate'])) ?? '';
                $powerrate = $test['powerrate'] ?? '';
                $co2emission = $test['co2emission'] ?? '';
                $chassisno = $test['chassisno'] ?? '';
                $maximumunladenweight = $test['maximumunladenweight'] ?? '';
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
                $uinfin1 = '';
            }else{
                $name1 = '';
                $sex1 = '';
                $mobileno1 = '';
                $email1 = '';
                $countryCode = '';
                $uinfin1 = '';
                $maximumunladenweight = '';
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
            $chassisno = '';
        }
        if(!empty(session()->get('myinfoquotebusiness'))){
            $data = serialize(session()->get('myinfoquotebusiness'));
            $test = unserialize($data);
            if(sizeof($test)>0){
                $uinfin1 = $test['uinfin'] ?? '';
                $name1 = $test['name'] ?? '';
                $email1 = $test['email'] ?? '';
                $mobileno1 = $test['mobileno'] ?? '';

                
            }
        }
        @endphp

        <div class="add-my-car">
            @include('inc.messages')
            <form action="{{ url('quote-my-car-form') }}" method="post" enctype="multipart/form-data" class="form-ani" autocomplete="off">
                @csrf
                <h3 class="title-6 item"><span><strong>Owner's Particulars </strong></span></h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="inrow">
                            @if(!empty(session()->get('myinfoquotemycar')))
                            <label>Full Name</label>
                            @else
                            <label>Full Name/ Company Name</label>
                            @endif
                            <input name="full_name" type="text" class="form-control" id="fullname" @if(!empty($name1) && !empty(session()->get('myinfoquotemycar'))) readonly="readonly" @endif
                                value="{{ old('full_name', $name1 ?? '') }}">
                        </div>
                        @if(empty($name1) && empty(old('full_name')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('full_name'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('full_name'))
                        <span class="text-danger">&nbsp;{{ $errors->first('full_name') }}</span>
                        @endif
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="inrow">
                            @if(!empty(session()->get('myinfoquotemycar')))
                            <label>NRIC/FIN</label>
                            @else
                            <label>NRIC/FIN/UEN</label>
                            @endif
                            <input name="nric" value="{{ old('nric', $uinfin1) }}" type="text" id="nric"  @if(!empty($uinfin1)) readonly="readonly" @endif
                                class="form-control" >
                        </div>
                        @if(empty($uinfin1) && empty(old('nric')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('nric'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('nric'))
                        <span class="text-danger">&nbsp;{{ $errors->first('nric') }}</span>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <div class="row break-425">
                            <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                                <div class="inrow">
                                    <label>Country Code</label>
                                    <input name="country" value="+65"  @if(!empty(session()->get('myinfoquotemycar'))) readonly="readonly" @endif type="text" class="form-control" id="countrycode"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                                @if ($errors->has('country'))
                                <span class="text-danger">&nbsp;{{ $errors->first('country') }}</span>
                                @endif
                            </div>
                            <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                                <div class="inrow">
                                    <label>Mobile Number</label>
                                    <input name="contact_number"
                                        value="{{ old('contact_number', $mobileno1) }}" type="text" class="form-control"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                                @if(empty($mobileno1) && empty(old('contact_number')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('contact_number'))
                                <span class="text-danger">This field is required</span>
                                @endif
                                @if ($errors->has('contact_number'))
                                <span class="text-danger">&nbsp;{{ $errors->first('contact_number') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="inrow">
                            <label>Email Address</label>
                            <input name="email" value="{{ old('email', $email1) }}" type="email"
                                class="form-control">
                        </div>
                        @if(empty($email1) && empty(old('email')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('email'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('email'))
                        <span class="text-danger">&nbsp;{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    @if(!empty(session()->get('myinfoquotemycar')))
                    <div class="col-lg-3 col-md-6">
                        <div class="inrow">
                            <label>Vehicle Number</label>
                            <input name="vehicle_number" value="{{ old('vehicle_number', $vehiclesNo) }}" type="text" id="vehiclenumber" @if(!empty($vehiclesNo)) readonly="readonly" @endif
                                class="form-control">
                        </div>
                        @if(empty($vehiclesNo) && empty(old('vehicle_number')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('vehicle_number'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('vehicle_number'))
                        <span class="text-danger">&nbsp;{{ $errors->first('vehicle_number') }}</span>
                        @endif
                    </div>
                    @endif
                    <div class="col-lg-3 col-md-6">
                        @if(empty(session()->get('myinfoquotemycar')))
                        <div class="mt-20">
                            <select class="selectpicker" name="gender" data-title="Gender">
                                <option value="1" @if(old('gender') == 1) selected @endif>Male</option>
                                <option value="2" @if(old('gender') == 2) selected @endif>Female</option>
                            </select>
                            @if ($errors->has('gender'))
                            <span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                        @else
                            @if(empty($sex1))
                            <div class="mt-20">
                                <select class="selectpicker" name="gender" data-title="Gender">
                                    <option value="1" @if(old('gender') == 1) selected @endif>Male</option>
                                    <option value="2" @if(old('gender') == 2) selected @endif>Female</option>
                                </select>
                                @if(empty($sex1) && empty(old('gender')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('gender'))
                                <span class="text-danger">This field is required</span>
                                @endif
                                @if ($errors->has('gender'))
                                <span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                            @else
                            <div class="inrow">
                                <label>Gender</label>
                                <input name="gender" value="{{ $sex1 ?? '' }}" type="text" id="gender" @if(!empty($sex1)) readonly="readonly" @endif
                                    class="form-control">
                            </div>
                            @endif
                        @endif
                    </div>
                </div>



                @if(empty(session()->get('myinfoquotemycar')))
                <h3 class="title-6 mt-30"><span><strong>Vehicle Details </strong></span></h3>
                <div id="vehicleDetails">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Vehicle Number</label>
                                <input name="vehicle_number" value="{{ old('vehicle_number', $vehiclesNo) }}" type="text" id="vehiclenumber"
                                    class="form-control">
                            </div>
                            @if ($errors->has('vehicle_number'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_number') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Mileage (Estimated)</label>
                                <input id="manual_mileage" value="{{ old('mileage') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="mileage" type="text"
                                    class="form-control">
                                <span class="input-info"> km </span>
                            </div>
                            @if ($errors->has('mileage'))
                            <span class="text-danger">&nbsp;{{ $errors->first('mileage') }}</span>
                            @endif
                        </div>
                        
                    </div>
                    

                </div>
                @endif





                @if(!empty(session()->get('myinfoquotemycar')))

                <h3 class="title-6 mt-30"><span><strong>Vehicle Details </strong></span></h3>
                <div id="vehicleDetails">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Vehicle Make</label>
                                <input type="text" class="form-control" name="vehicle_make" @if(!empty($make)) readonly="readonly" @endif
                                    value="{{ old('vehicle_make', $make) }}" />
                            </div>
                            @if(empty($make) && empty(old('vehicle_make')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('vehicle_make'))
                            <span class="text-danger">This field is required</span>
                            @endif 
                            @if ($errors->has('vehicle_make'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_make') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Vehicle Model</label>
                                <input type="text" class="form-control" name="vehicle_model" @if(!empty($model)) readonly="readonly" @endif
                                    value="{{ old('vehicle_model', $model) }}" />
                            </div>
                            @if(empty($model) && empty(old('vehicle_model')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('vehicle_model'))
                            <span class="text-danger">This field is required</span>
                            @endif 
                            @if ($errors->has('vehicle_model'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_model') }}</span>
                            @endif
                        </div>
                        @if(!empty($primarycolour) )
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Primary Color</label>
                                <input type="text" class="form-control" name="primary_color" @if(!empty($primarycolour)) readonly="readonly" @endif
                                    value="{{ old('primary_color', $primarycolour) }}" />
                            </div>
                        </div>
                        @else
                        <div class="col-lg-4">
                            <div class="mt-20">
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
                                @if(empty($primarycolour) && empty(old('primary_color')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('primary_color'))
                                <span class="text-danger">This field is required</span>
                                @endif 
                                @if ($errors->has('primary_color'))
                                <span class="text-danger">&nbsp;{{ $errors->first('primary_color') }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Year of Manufacture</label>
                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="4" maxlength="4" name="year_of_manufacture"
                                    value="{{ old('year_of_manufacture', $yearofmanufacture) }}" @if(!empty($yearofmanufacture)) readonly="readonly" @endif />
                            </div>
                            @if(empty($yearofmanufacture) && empty(old('year_of_manufacture')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('year_of_manufacture'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('year_of_manufacture'))
                            <span class="text-danger">&nbsp;{{ $errors->first('year_of_manufacture') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow inptxt lefttxt">
                                <label>Open Market Value</label>
								<span class="txt">$</span>                                
                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="open_market_value" id="open_market_value"
                                    value="{{ old('open_market_value', $openmarketvalue) }}" @if(!empty($openmarketvalue)) readonly="readonly" @endif />
                            </div>
                            @if(empty($openmarketvalue) && empty(old('open_market_value')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('open_market_value'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('open_market_value'))
                            <span class="text-danger">&nbsp;{{ $errors->first('open_market_value') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>Original Registration Date</label>
                                <input type="text" class="form-control" name="orig_reg_date" @if(!empty($originalregistrationdate)) readonly="readonly" @endif
                                    value="{{ old('orig_reg_date', $originalregistrationdate) }}" />
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @if(empty($originalregistrationdate) && empty(old('orig_reg_date')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('orig_reg_date'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('orig_reg_date'))
                            <span class="text-danger">&nbsp;{{ $errors->first('orig_reg_date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>First Registratio Date</label>
                                <input type="text" class="form-control" name="first_reg_date" @if(!empty($firstregistrationdate)) readonly="readonly" @endif
                                    value="{{ old('first_reg_date', $firstregistrationdate) }}" />
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @if(empty($firstregistrationdate) && empty(old('first_reg_date')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('first_reg_date'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('first_reg_date'))
                            <span class="text-danger">&nbsp;{{ $errors->first('first_reg_date') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>No. of Transfer</label>
                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="no_of_transfer" @if(!empty($nooftransfers)) readonly="readonly" @endif
                                    value="{{ old('no_of_transfer', $nooftransfers) }}" />
                            </div>
                            @if(empty($nooftransfers) && empty(old('no_of_transfer')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('no_of_transfer'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('no_of_transfer'))
                            <span class="text-danger">&nbsp;{{ $errors->first('no_of_transfer') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow inptxt lefttxt">
                                <label>Minimum PARF Benefit</label>
								<span class="txt">$</span>  
                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="minimumparfbenefit" id="minimumparfbenefit"
                                    value="{{ old('minimumparfbenefit', $minimumparfbenefit) }}" @if(!empty($minimumparfbenefit)) readonly="readonly" @endif />
                            </div>
                            @if(empty($minimumparfbenefit) && empty(old('minimumparfbenefit')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('minimumparfbenefit'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('minimumparfbenefit'))
                            <span class="text-danger">&nbsp;{{ $errors->first('minimumparfbenefit') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>COE expiry Date</label>
                                <input type="text" class="form-control" name="coe_expiry_date"
                                    value="{{ old('coe_expiry_date', $coeexpirydate) }}" @if(!empty($coeexpirydate)) readonly="readonly" @endif />
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @if(empty($coeexpirydate) && empty(old('coe_expiry_date')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('coe_expiry_date'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('coe_expiry_date'))
                            <span class="text-danger">&nbsp;{{ $errors->first('coe_expiry_date') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>COE Category</label>
                                <input type="text" class="form-control" name="coe_category" @if(!empty($coecategory)) readonly="readonly" @endif
                                    value="{{ old('coe_category', $coecategory) }}" />
                            </div>
                            @if(empty($coecategory) && empty(old('coe_category')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('coe_category'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('coe_category'))
                            <span class="text-danger">&nbsp;{{ $errors->first('coe_category') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow inptxt lefttxt">
                                <label>Quota Premium</label>
								<span class="txt">$</span>  
                                <input type="text" class="form-control" name="quota_premium" id="quota_premium" @if(!empty($quotapremium)) readonly="readonly" @endif
                                    value="{{ old('quota_premium', $quotapremium) }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            </div>
                            @if(empty($quotapremium) && empty(old('quota_premium')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('quota_premium'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('quota_premium'))
                            <span class="text-danger">&nbsp;{{ $errors->first('quota_premium') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @if(!empty($type))
                            <div class="inrow">
                                <label>Vehicle Type</label>
                                <input type="text" class="form-control" name="vehicle_type" @if(!empty($type)) readonly="readonly" @endif
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
                            @if(empty($type) && empty(old('vehicle_type')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('vehicle_type'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('vehicle_type'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_type') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            @if(!empty($propellant))
                            <div class="inrow">
                                <label>Propellant</label>
                                <input type="text" class="form-control" name="propellant" value="{{ old('propellant', $propellant) }}" @if(!empty($propellant)) readonly="readonly" @endif />
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
                            @if(empty($propellant) && empty(old('propellant')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('propellant'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('propellant'))
                            <span class="text-danger">&nbsp;{{ $errors->first('propellant') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Engine capacity</label>
                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="engine_capacity" id="engine_capacity"
                                    value="{{ old('engine_capacity', $enginecapacity) }}" @if(!empty($enginecapacity)) readonly="readonly" @endif />
                            </div>
                            @if(empty($enginecapacity) && empty(old('engine_capacity')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('engine_capacity'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('engine_capacity'))
                            <span class="text-danger">&nbsp;{{ $errors->first('engine_capacity') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Engine Number</label>
                                <input type="text" class="form-control" name="engine_no" value="{{ old('engine_no', $engineno) }}" @if(!empty($engineno)) readonly="readonly" @endif />
                            </div>
                            @if(empty($engineno) && empty(old('engine_no')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('engine_no'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('engine_no'))
                            <span class="text-danger">&nbsp;{{ $errors->first('engine_no') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Chassis Number</label>
                                <input type="text" class="form-control" name="chassis_no" value="{{ old('chassis_no', $chassisno ?? '') }}" @if(!empty($chassisno)) readonly="readonly" @endif />
                            </div>
                            @if(empty($chassisno) && empty(old('chassis_no')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('chassis_no'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('chassis_no'))
                            <span class="text-danger">&nbsp;{{ $errors->first('chassis_no') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Max Unladen Weight</label>
                                <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="max_unladen_weight" id="max_unladen_weight"
                                    value="{{ old('max_unladen_weight', $maximumunladenweight) }}" @if(!empty($maximumunladenweight)) readonly="readonly" @endif />
                            </div>
                            @if(empty($maximumunladenweight) && empty(old('max_unladen_weight')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('max_unladen_weight'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('max_unladen_weight'))
                            <span class="text-danger">&nbsp;{{ $errors->first('max_unladen_weight') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @if(!empty($scheme))
                            <div class="inrow">
                                <label>Vehicle Scheme (- represents normal)</label>
                                <input type="text" class="form-control" name="vehicle_scheme" @if(!empty($scheme)) readonly="readonly" @endif
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
                            @if(empty($scheme) && empty(old('vehicle_scheme')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('vehicle_scheme'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('vehicle_scheme'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_scheme') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>Road Tax Expiry Date</label>
                                <input type="text" class="form-control" name="roadtaxexpirydate" @if(!empty($roadtaxexpirydate)) readonly="readonly" @endif
                                    value="{{ old('roadtaxexpirydate', $roadtaxexpirydate) }}" />
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @if(empty($roadtaxexpirydate) && empty(old('roadtaxexpirydate')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('roadtaxexpirydate'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('roadtaxexpirydate'))
                            <span class="text-danger">&nbsp;{{ $errors->first('roadtaxexpirydate') }}</span>
                            @endif
                        </div>
                    </div>

                </div>
                @endif

                <h3 class="title-6 mt-30"><span><strong>Additional Information</strong></span></h3>
                <div class="row">
                    @if(!empty(session()->get('myinfoquotemycar')))
                    <div class="col-lg-6">
                        <div class="inrow">
                            <label>Mileage (Estimated)</label>
                            <input id="estimated_mileage" value="{{ old('mileage') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="mileage" type="text"
                                class="form-control">
                            <span class="input-info"> km </span>
                        </div>
                        @if(empty(old('mileage')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('mileage'))
                            <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('mileage'))
                        <span class="text-danger">&nbsp;{{ $errors->first('mileage') }}</span>
                        @endif
                    </div>
                    @endif
                    <div class="col-lg-6">
                        <div class="inrow date-wrap datepicker-wrap">
                            <label>Handing Over Date (Estimated)</label>
                            <input type="text" class="form-control datepicker" name="handing_over_date"
                                id="handing_over_date" value="{{ old('handing_over_date') }}" />
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @if(empty(old('handing_over_date')) && !empty(session()->get('myinfoquotemycar')) && !$errors->has('handing_over_date'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('handing_over_date'))
                        <span class="text-danger d-block">
                            {{ $errors->first('handing_over_date') }}
                        </span>
                        @endif
                    </div>
                </div>


                <div class="inrow">
                    <label>Remarks about the condition of the vehicle (If any)</label>
                    <input type="text" class="form-control" name="seller_remarks" value="{{ old('seller_remarks') }}" />

                </div>
                @if ($errors->has('seller_remarks'))
                <span class="text-danger">&nbsp;{{ $errors->first('seller_remarks') }}</span>
                @endif









                <h3 class="title-6 mt-30"><span><strong>Upload Photos</strong></span></h3>
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
                    <label for="information">I acknowledge and agree to the collection, use and disclosure of my
                        personal data which has been provided for the purposes of getting a quotation for my car, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.</label>
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
@if(!empty(session()->get('myinfoquotemycar')))
<script>
    // $('input').prop('readonly',true);
    // $('#fullname').prop('readonly',true);
    // $('#nric').prop('readonly',true);
    // $('#gender').prop('readonly',true);
    // $('#countrycode').prop('readonly',true);
    // $('#vehiclenumber').prop('readonly',true);
    // $('#vehicleDetails :input').prop('readonly',true);
</script>
@endif
<script>
    $(function () {
        $("#open_market_value,#minimumparfbenefit,#max_unladen_weight,#quota_premium,#engine_capacity,#estimated_mileage,#manual_mileage").on('keyup', function () {
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
    function callAuthoriseApi() {
        let authApiUrl = 'https://api.myinfo.gov.sg/com/v3/authorise';
        let clientId = 'PROD-200501881C-AUTOLINK-QUOTEMYCAR';
        let redirectUrl = 'https://www.diycars.com/quote-my-car/callback';
        let attributes = 'uinfin,name,email,mobileno,vehicles.vehicleno,vehicles.type,vehicles.make,vehicles.model,vehicles.yearofmanufacture,vehicles.originalregistrationdate,vehicles.enginecapacity,vehicles.type,vehicles.primarycolour,vehicles.scheme,vehicles.enginecapacity,vehicles.propellant,vehicles.roadtaxexpirydate,vehicles.coeexpirydate,vehicles.quotapremium,vehicles.openmarketvalue,vehicles.minimumparfbenefit,vehicles.nooftransfers,vehicles.coecategory,vehicles.firstregistrationdate,sex,vehicles.engineno,vehicles.chassisno,vehicles.maximumunladenweight';
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
        let clientId = 'PROD-200501881C-AUTOLINK-MIB-QUOTEMYCAR';
        let redirectUrl = 'https://www.diycars.com/mib-quote-my-car/callback';
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

    $(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
            });
</script>
@endsection