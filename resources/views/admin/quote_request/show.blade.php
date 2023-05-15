@extends('admin.layout.app')

@section('content')
<style>.licon { position: relative; }.licon .ltext { align-items: center; bottom: 0; left: 0; line-height: 42px; position: absolute; text-align: center; top: 0; width: 40px; }.licon .form-control { padding-left: 40px !important; }</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('quoterequest.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_quoterequest_crud', 'Show', route('quoterequest.show', $quote_request->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('quoterequest.update', $quote_request->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- @if($errors->any())
                            {{ implode('', $errors->all('<div>:message</div>')) }}
                        @endif -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Owner's Particulars
                                    <hr/>
                                </h5>
                                {{-- 
                                <div class="form-group">
                                    <label for="seller">Seller User</label>
                                    <!-- <input type="text" name="seller_id" class="form-control" id="" value=""> -->
                                    <div>
                                        <select name="seller" class="form-control">
                                            <option value="">Select seller user</option>
                                            @if(getAllUsers())
                                            @foreach(getAllUsers() as $key=>$value)
                                            <option value="{{ $value->id }}" @if($quote_request->seller_id == $value->id) selected @endif>{{ $value->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('seller'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('seller') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                --}}
                                <div class="form-group">
                                    <label for="full_name">Full Name/Company Name</label>
                                    <input type="text" name="full_name" class="form-control" id="" value="{{ old('full_name', $quote_request->full_name) }}">
                                    @if ($errors->has('full_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nric">NRIC/FIN/UEN</label>
                                    <input type="text" name="nric" class="form-control" id="" value="{{ old('nric', $quote_request->nric) }}">
                                    @if ($errors->has('nric'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('nric') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                {{--
                                <div class="form-group">
                                    <div class="control-label" for="country">Country</div>
                                    <div>
                                        <select name="country" class="form-control" tabindex="-98">
                                            @if(country())
                                            @foreach (country() as $item)
                                                <option value="{{ $item->phonecode }}" @if($item->phonecode==$quote_request->country) selected @endif>{{ $item->nicename }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @if ($errors->has('country'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                --}}
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country_code">Country Code</label>
                                            <input type="text" name="country_code" class="form-control" id="" value="{{ old('country_code', $quote_request->country ?? '+65') }}">
                                            @if ($errors->has('country_code'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('country_code') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-10">

                                        <div class="form-group">
                                            <label for="contact_number">Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control" id="" value="{{ old('contact_number', $quote_request->contact_number) }}">
                                            @if ($errors->has('contact_number'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('contact_number') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" id="" value="{{ $quote_request->email }}" readonly>
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select  class="form-control" name="gender" id="gender"
                                        required="required">
                                        <option value="">Please select</option>
                                        <option value="1" @if($quote_request->gender == 1) selected @endif>Male</option>
                                        <option value="2" @if($quote_request->gender == 2) selected @endif>Female</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Vehicle details
                                    <hr/>
                                </h5>
                                <div class="form-group">
                                    <label for="vehicle_number">Vehicle Number</label>
                                    <input type="text" name="vehicle_number" class="form-control" id="" value="{{ old('vehicle_number', $quote_request->vehicle_number) }}">
                                    @if ($errors->has('vehicle_number'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_make">Vehicle Make</label>
                                    <input type="text" name="vehicle_make" class="form-control" id="" value="{{ old('vehicle_make', $quote_request->vehicle_make) }}">
                                    @if ($errors->has('vehicle_make'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_make') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_model">Vehicle Model</label>
                                    <input type="text" name="vehicle_model" class="form-control" id="" value="{{ old('vehicle_model', $quote_request->vehicle_model) }}">
                                    @if ($errors->has('vehicle_model'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_model') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="primary_color">Primary Color</label>
                                    <input type="text" name="primary_color" class="form-control" id="" value="{{ old('primary_color', $quote_request->primary_color) }}">
                                    @if ($errors->has('primary_color'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('primary_color') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="year_of_manufacture">Manufacuture Year</label>
                                    <input type="text" name="year_of_manufacture" class="form-control" id="" value="{{ old('year_of_manufacture', $quote_request->year_of_manufacture) }}">
                                    @if ($errors->has('year_of_manufacture'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('year_of_manufacture') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @php 
                                if(!empty($quote_request->open_market_value)){
                                    $omValu = number_format($quote_request->open_market_value);
                                }else{
                                    $omValu = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="open_market_value">Open Market Value</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="open_market_value" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="open_market_value" value="{{ old('open_market_value', $omValu) }}">
                                    </div>
                                    @if ($errors->has('open_market_value'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('open_market_value') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php
                                if(!empty($quote_request->orig_reg_date)){
                                    $ord = date('d-m-Y', strtotime($quote_request->orig_reg_date));
                                    if($ord == '01-01-1970'){
                                        $ord = date('d-m-Y');
                                    }
                                }else{
                                    $ord =  date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="orig_reg_date">Original Registration Date</label>
                                    <input type="text" name="orig_reg_date" class="form-control datepicker547" id="" value="{{ old('orig_reg_date', $ord) ?? '' }}">
                                    @if ($errors->has('orig_reg_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('orig_reg_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php
                                if(!empty($quote_request->first_reg_date)){
                                    $frd = date('d-m-Y', strtotime($quote_request->first_reg_date));
                                    if($frd == '01-01-1970'){
                                        $frd =  date('d-m-Y');
                                    }
                                }else{
                                    $frd =  date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="first_reg_date">First Registration Date</label>
                                    <input type="text" name="first_reg_date" class="form-control datepicker547" id="" value="{{ old('first_reg_date', $frd) }}">
                                    @if ($errors->has('first_reg_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('first_reg_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="no_of_transfer">No. of Transfer</label>
                                    <input type="text" name="no_of_transfer" class="form-control" id="" value="{{ old('no_of_transfer', $quote_request->no_of_transfer) }}">
                                    @if ($errors->has('no_of_transfer'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('no_of_transfer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($quote_request->minimumparfbenefit)){
                                    $mpBenefit = number_format($quote_request->minimumparfbenefit);
                                }else{
                                    $mpBenefit = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="minimumparfbenefit">Minimum PARF Benefit</label>									<div class="licon">										<div class="ltext">$</div>
										<input type="text"  name="minimumparfbenefit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="minimumparfbenefit" value="{{ old('minimumparfbenefit', $mpBenefit) }}">									</div>
                                    @if ($errors->has('minimumparfbenefit'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('minimumparfbenefit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php
                                if(!empty($quote_request->coe_expiry_date)){
                                    $coeed = date('d-m-Y', strtotime($quote_request->coe_expiry_date));
                                    if($coeed == '01-01-1970'){
                                        $coeed =  date('d-m-Y');
                                    }
                                }else{
                                    $coeed =  date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="coe_expiry_date">COE Expiry Date</label>
                                    <input type="text" name="coe_expiry_date" class="form-control datepicker547" id="" value="{{ old('coe_expiry_date', $coeed) }}">
                                    @if ($errors->has('coe_expiry_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('coe_expiry_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="coe_category">COE Category</label>
                                    <input type="text" name="coe_category" class="form-control" id="" value="{{ old('coe_category', $quote_request->coe_category) }}">
                                    @if ($errors->has('coe_category'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('coe_category') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($quote_request->quota_premium)){
                                    $qP = number_format($quote_request->quota_premium);
                                }else{
                                    $qP = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="quota_premium">Quota Premium</label>									<div class="licon">										<div class="ltext">$</div>
										<input type="text" name="quota_premium" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="quota_premium" value="{{ old('quota_premium', $qP) }}">									</div>
                                    @if ($errors->has('quota_premium'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('quota_premium') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_type">Vehicle Type</label>
                                    <input type="text" name="vehicle_type" class="form-control" id="" value="{{ old('vehicle_type', $quote_request->vehicle_type) }}">
                                    @if ($errors->has('vehicle_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="propellant">Propellant</label>
                                    <input type="text" name="propellant" class="form-control" id="" value="{{ old('propellant', $quote_request->propellant) }}">
                                    @if ($errors->has('propellant'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('propellant') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($quote_request->engine_capacity)){
                                    $eCapacity = number_format($quote_request->engine_capacity);
                                }else{
                                    $eCapacity = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="engine_capacity">Engine Capacity</label>
                                    <input type="text" name="engine_capacity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="engine_capacity" value="{{ old('engine_capacity', $eCapacity) }}">
                                    @if ($errors->has('engine_capacity'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('engine_capacity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="engine_no">Engine Number</label>
                                    <input type="text" name="engine_no" class="form-control" id="" value="{{ old('engine_no', $quote_request->engine_no) }}">
                                    @if ($errors->has('engine_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('engine_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="chassis_no">Chassis Number</label>
                                    <input type="text" name="chassis_no" class="form-control" id="" value="{{ old('chassis_no', $quote_request->chassis_no) }}">
                                    @if ($errors->has('chassis_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('chassis_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($quote_request->max_unladen_weight)){
                                    $muWeight = number_format($quote_request->max_unladen_weight);
                                }else{
                                    $muWeight = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="max_unladen_weight">Max Unladen Weight</label>
                                    <input type="text" name="max_unladen_weight" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="max_unladen_weight" value="{{ old('max_unladen_weight', $muWeight) }}">
                                    @if ($errors->has('max_unladen_weight'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('max_unladen_weight') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_scheme">Vehicle Scheme</label>
                                    <input type="text" name="vehicle_scheme" class="form-control" id="" value="{{ old('vehicle_scheme', $quote_request->vehicle_scheme) }}">
                                    @if ($errors->has('vehicle_scheme'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_scheme') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                @php
                                if(!empty($quote_request->roadtaxexpirydate)){
                                    $rted = date('d-m-Y', strtotime($quote_request->roadtaxexpirydate));
                                    if($rted == '01-01-1970'){
                                        $rted =  date('d-m-Y');
                                    }
                                }else{
                                    $rted =  date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="roadtaxexpirydate">Road Tax Expiry Date</label>
                                    <input type="text" name="roadtaxexpirydate" class="form-control datepicker547" id="" value="{{ old('roadtaxexpirydate', $rted) }}">
                                    @if ($errors->has('roadtaxexpirydate'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('roadtaxexpirydate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Additional Information
                                    <hr/>
                                </h5>
                                @php 
                                if(!empty($quote_request->mileage)){
                                    $mileage = number_format($quote_request->mileage);
                                }else{
                                    $mileage = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="mileage">Mileage</label>
                                    <input type="text" name="mileage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="mileage" value="{{ old('mileage', $mileage) }}">
                                    @if ($errors->has('mileage'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mileage') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($quote_request->handing_over_date)){
                                    $hod = date('d-m-Y', strtotime($quote_request->handing_over_date));
                                    if($quote_request->handing_over_date == '0000-00-00'){
                                        $hod =  date('d-m-Y');
                                    }
                                }else{
                                    $hod =  date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="handing_over_date">Handing Over Date</label>
                                    <input type="text" class="form-control datepicker547" name="handing_over_date" id="handing_over_date" value="{{ old('handing_over_date', $hod) }}" />
                                    @if ($errors->has('handing_over_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('handing_over_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="seller_remarks">Remarks About the Condition of the Vehilce</label>
                                    <input type="text" class="form-control" name="seller_remarks" id="seller_remarks" value="{{ old('seller_remarks', $quote_request->seller_remarks) }}" />
                                    
                                </div>
                        </div>
                        </div>


                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Other Details
                                    <hr/>
                                </h5>
                                
                                <div class="form-group">
                                    <div class="control-label">Photos/Videos: </div>
                                    <div class="col-lg-12 mt-20">
                                        <div class="file-box">
                                            @php $uploaded_files = json_decode($quote_request->upload_file); @endphp
                                            @if(isset($uploaded_files))
                                                @foreach($uploaded_files as $key=>$item)
                                                <a href="{{ url($item) }}" target="_blank"><img src="{{url($item)}}" height="100px;" width="100px;" ></a><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="attach-box">
                                            <div class="file-wrap mt-10">
                                                <input class="" type="file" id="upload_photo" name="upload_file[]" multiple="">
                                            </div>
                                        </div>
                                        @if ($errors->has('upload_photo'))
                                            <span class="text-danger">&nbsp;{{ $errors->first('upload_photo') }}</span>
                                        @endif
                                    </div>
                                </div>

                                @php
                                if(!empty($quote_request->quote_price)){
                                    $qPrice = number_format($quote_request->quote_price);
                                }else{
                                    $qPrice = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="quote_price">Quote Price</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="quote_price" id="quote_price" value="{{ old('quote_price', $qPrice) }}" />
                                    </div>
                                    @if ($errors->has('quote_price'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('quote_price') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                @php
                                if(!empty($quote_request->quote_expiry_date)){
                                    $qeDate = date('d-m-Y', strtotime($quote_request->quote_expiry_date));
                                }else{
                                    $todayDate = strtotime(date('d-m-Y'));
                                    $qeDate = date('d-m-Y', strtotime("+14 day", $todayDate));
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="quote_expiry_date">Quote Expiry Date</label>
                                    <input type="text" class="form-control datepicker547" name="quote_expiry_date" id="quote_expiry_date" value="{{ old('quote_expiry_date', $qeDate) }}" />
                                    @if ($errors->has('quote_expiry_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('quote_expiry_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="control-label" for="status">Status</div>
                                    <div class="">
                                        <select name="status" class="form-control" tabindex="-98">
                                            <option value="">-- Select Status --</option>
                                            @php $statusArr = ['1'=>'Pending', '2'=>'Quoted']; @endphp
                                            @for ($i=1; $i<=2; $i++)
                                                <option value="{{ $i }}" @if($quote_request->status == $i) selected @endif>{{ $statusArr[$i] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    @if ($errors->has('status'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function() {



        $("input, select, textarea").attr("disabled", true);
    });
</script>
@endsection
