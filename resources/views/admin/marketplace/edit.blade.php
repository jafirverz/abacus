@extends('admin.layout.app')

@section('content')
<style>.licon { position: relative; }.licon .ltext { align-items: center; bottom: 0; left: 0; line-height: 42px; position: absolute; text-align: center; top: 0; width: 40px; }.licon .form-control { padding-left: 40px !important; }</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('marketplace.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_marketplace_crud', 'Edit', route('marketplace.edit', $car->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('marketplace.update', $car->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Owner's Particulars
                                    <hr/>
                                </h5>
                                <div class="form-group">
                                    <label for="seller">Seller User</label>
                                    <!-- <input type="text" name="seller_id" class="form-control" id="" value=""> -->
                                    <div>
                                        <select name="seller" class="form-control">
                                            <option value="">Select seller user</option>
                                            @if(getAllUsers())
                                            @foreach(getAllUsers() as $key=>$value)
                                            <option value="{{ $value->id }}" @if($car->seller_id == $value->id) selected @endif>{{ $value->name }}</option>
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
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" id="" value="{{ $car->full_name }}">
                                    @if ($errors->has('full_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nric">NRIC</label>
                                    <input type="text" name="nric" class="form-control" id="" value="{{ $car->detail['nric'] }}">
                                    @if ($errors->has('nric'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('nric') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" id="" value="{{ $car->email }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
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
                                                <option value="{{ $item->phonecode }}" @if($item->phonecode==$car->country) selected @endif>{{ $item->nicename }}</option>
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
                                            <label for="country">Country Code</label>
                                            <input type="text" name="country" class="form-control" id="" value="{{ old('country', $car->country ?? '+65') }}">
                                            @if ($errors->has('country'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('country') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="form-group">
                                            <label for="contact_number">Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control" id="" value="{{ $car->contact_number }}">
                                            @if ($errors->has('contact_number'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('contact_number') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" tabindex="-98">
                                        <option value="Male" @if($car->gender=='Male' || $car->gender=='MALE') selected @endif>Male</option>
                                        <option value="Female" @if($car->gender=='Female' || $car->gender=='FEMALE') selected @endif>Female</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_number">Vehicle Number</label>
                                    <input type="text" name="vehicle_number" class="form-control" id="" value="{{ old('vehicle_number', $car->detail['vehicle_number']) }}">
                                    @if ($errors->has('vehicle_number'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_number') }}</strong>
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
                                    <label for="vehicle_make">Vehicle Make</label>
                                    <input type="text" name="vehicle_make" class="form-control" id="" value="{{ old('vehicle_make', $car->detail['vehicle_make']) }}">
                                    {{--
                                    <div>
                                        <select name="vehicle_make" class="form-control">
                                            <option value="">Vehicle Make</option>
                                            @if(getFilterValByType(__('constant.MAKE')))
                                            @foreach(getFilterValByType(__('constant.MAKE')) as $key=>$value)
                                            <option value="{{ $value->title }}" @if($car->detail['vehicle_make'] == $value->title) selected @elseif(old('vehicle_make') == $value->title) selected @endif>{{ $value->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        
                                    </div>
                                    --}}
                                    @if ($errors->has('vehicle_make'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('vehicle_make') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_model">Vehicle Model</label>
                                    <input type="text" name="vehicle_model" class="form-control" id="" value="{{ old('vehicle_model', $car->detail['vehicle_model']) }}">
                                    {{--
                                    <div>
                                        <select name="vehicle_model" class="form-control">
                                        <option value="">Vehicle Model</option>
                                        @if(getFilterValByType(__('constant.MODEL')))
                                        @foreach(getFilterValByType(__('constant.MODEL')) as $key=>$value)
                                        <option value="{{ $value->title }}" @if($car->detail['vehicle_model'] == $value->title) selected @elseif(old('vehicle_model') == $value->title) selected @endif>{{ $value->title }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    --}}
                                    @if ($errors->has('vehicle_model'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_model') }}</strong>
                                    </span>
                                    @endif
                                    
                                </div>
                                <div class="form-group">
                                    <label for="primary_color">Primary Color</label>
                                    <input type="text" name="primary_color" class="form-control" id="" value="{{ old('primary_color', $car->detail['primary_color']) }}">
                                    @if ($errors->has('primary_color'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('primary_color') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="year_of_mfg">Year Of Manufacture</label>
                                    <input type="text" name="year_of_mfg" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="" value="{{ old('year_of_mfg', $car->detail['year_of_mfg']) }}">
                                    @if ($errors->has('year_of_mfg'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('year_of_mfg') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="open_market_value">Open Market Value</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="open_market_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="open_market_value" value="{{ old('open_market_value', number_format($car->detail['open_market_value'])) }}">
                                    </div>
                                    @if ($errors->has('open_market_value'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('open_market_value') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($car->detail['orig_reg_date'])){
                                    $ord = date('d-m-Y', strtotime($car->detail['orig_reg_date']));
                                    if($ord == '01-01-1970'){
                                        $ord = date('d-m-Y');
                                    }
                                }else{
                                    $ord = date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="orig_reg_date">Original Registration Date</label>
                                    <input type="text" class="form-control datepicker547" name="orig_reg_date" id="orig_reg_date" value="{{ old('orig_reg_date', $ord) }}" />
                                    @if ($errors->has('orig_reg_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('orig_reg_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($car->detail['first_reg_date'])){
                                    $frd = date('d-m-Y', strtotime($car->detail['first_reg_date']));
                                    if($frd == '01-01-1970'){
                                        $frd = date('d-m-Y');
                                    }
                                }else{
                                    $frd = date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="first_reg_date">First Registration Date</label>
                                    <input type="text" class="form-control datepicker547" name="first_reg_date" id="first_reg_date" value="{{ old('first_reg_date', $frd) }}" />
                                    @if ($errors->has('first_reg_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('first_reg_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="no_of_transfers">No. Of Transfers</label>
                                    <input type="text" name="no_of_transfers" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="" value="{{ old('no_of_transfers', $car->detail['no_of_transfers']) }}">
                                    @if ($errors->has('no_of_transfers'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('no_of_transfers') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="min_parf_benefit">Minimum PARF Benefit</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="min_parf_benefit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="min_parf_benefit" value="{{ old('min_parf_benefit', number_format($car->detail['min_parf_benefit'])) }}">
                                    </div>
                                    @if ($errors->has('min_parf_benefit'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('min_parf_benefit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($car->detail['coe_expiry_date'])){
                                    $coeed = date('d-m-Y', strtotime($car->detail['coe_expiry_date']));
                                    if($coeed == '01-01-1970'){
                                        $coeed = date('d-m-Y');
                                    }
                                }else{
                                    $coeed = date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="coe_expiry_date">COE Expiry Date</label>
                                    <input type="text" class="form-control datepicker547" name="coe_expiry_date" id="coe_expiry_date" value="{{ old('coe_expiry_date', $coeed) }}" />
                                    @if ($errors->has('coe_expiry_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('coe_expiry_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="coe_category">COE Category</label>
                                    <input type="text" name="coe_category" class="form-control" id="" value="{{ old('coe_category', $car->detail['coe_category']) }}">
                                    @if ($errors->has('coe_category'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('coe_category') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="quota_premium">Quota Premium</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="quota_premium" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="quota_premium" value="{{ old('quota_premium', number_format($car->detail['quota_premium'])) }}">
                                    </div>
                                    @if ($errors->has('quota_premium'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('quota_premium') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_type">Vehicle Type</label>
                                    <!-- <input type="text" name="vehicle_type" class="form-control" id="" value="{{ $car->detail['vehicle_type'] }}"> -->
                                    <div>
                                        <select name="vehicle_type" class="form-control">
                                            <option value="">Vehicle Type</option>
                                            @if(getFilterValByType(__('constant.VEHICLE_TYPE')))
                                            @foreach(getFilterValByType(__('constant.VEHICLE_TYPE')) as $key=>$value)
                                            <option value="{{ $value->title }}" @if($car->detail['vehicle_type'] == $value->title) selected @elseif (old('vehicle_type') == $value->title) selected @endif>{{ $value->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @if ($errors->has('vehicle_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="propellant">Propellant</label>
                                    <div>
                                        <select name="propellant" class="form-control">
                                            @foreach(getPropellantType() as $key=>$value)
                                            <option value="{{ $key }}" @if(strtolower($car->detail['propellant']) == $key) selected @elseif(old('propellant') == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('propellant'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('propellant') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="power_rate">Power Rate</label>
                                    <input type="text" name="power_rate" class="form-control" id="" value="{{ old('power_rate', $car->detail['power_rate']) }}">
                                    @if ($errors->has('power_rate'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('power_rate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="co2_emission_rate">Vehicle CO2 Emission Rate</label>
                                    <input type="text" name="co2_emission_rate" class="form-control" id="" value="{{ old('co2_emission_rate', $car->detail['co2_emission_rate']) }}">
                                    @if ($errors->has('co2_emission_rate'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('co2_emission_rate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="max_unladden_weight">Max Unladen Weight</label>
                                    <input type="text" name="max_unladden_weight" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="max_unladden_weight" value="{{ old('max_unladden_weight', number_format($car->detail['max_unladden_weight'])) }}">
                                    @if ($errors->has('max_unladden_weight'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('max_unladden_weight') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_scheme">Vehicle Scheme</label>
                                    <input type="text" name="vehicle_scheme" class="form-control" id="" value="{{ old('vehicle_scheme', $car->detail['vehicle_scheme']) }}">
                                    @if ($errors->has('vehicle_scheme'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_scheme') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="engine_cc">Engine Capacity</label>
                                    <input type="text" name="engine_cc" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="engine_cc" value="{{ old('engine_cc', number_format($car->detail['engine_cc'])) }}">
                                    @if ($errors->has('engine_cc'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('engine_cc') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(!empty($car->detail['road_tax_expiry_date'])){
                                    $rted = date('d-m-Y', strtotime($car->detail['road_tax_expiry_date']));
                                    if($rted == '01-01-1970'){
                                        $rted = date('d-m-Y');
                                    }
                                }else{
                                    $rted = date('d-m-Y');
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="road_tax_expiry_date">Road Tax Expiry Date</label>
                                    <input type="text" class="form-control datepicker547" name="road_tax_expiry_date" id="road_tax_expiry_date" value="{{ old('road_tax_expiry_date', $rted) }}" />
                                    @if ($errors->has('road_tax_expiry_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('road_tax_expiry_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Price and Mileage
                                    <hr/>
                                </h5>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="price" value="{{ old('price', number_format($car->detail['price'])) }}">
                                    </div>
                                    @if ($errors->has('price'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="mileage">Mileage</label>
                                    <input type="text" name="mileage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="mileage" value="{{ old('mileage', number_format($car->detail['mileage'])) }}">
                                    @if ($errors->has('mileage'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mileage') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Additional Details
                                    <hr/>
                                </h5>
                                <div class="form-group">
                                    <div class="control-label">Specifications</div>
                                    <div class="check-inline ad-checkline" id="specification_group">
                                        @php $specs_arr = json_decode($car->specification); @endphp
                                        @if(get_specifications())
                                            @foreach (get_specifications() as $key=>$item)
                                            <div class="checkbox">
                                                <input type="checkbox" id="sp{{$key}}" value="{{$item->specification}}" name="specification[]" @if(isset($specs_arr) && in_array($item->specification, $specs_arr)) checked @endif>
                                                <label for="sp{{$key}}">{{$item->specification}}</label>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-lg-12 text-right">
                                        <div class="inrow add-plus empty">
                                            <input type="text" id="add_specification_val" class="form-control">
                                            <button id="add_specification">Add +</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Additional accessories</div>
                                    @php $attr_arr = json_decode($car->additional_accessories); @endphp
                                    <div class="check-inline ad-checkline" id="additional_accessories_checkbox">
                                        @if(get_attributes())
                                            @foreach (get_attributes() as $key=>$item)
                                            <div class="checkbox">
                                                <input type="checkbox" value="{{$item->attribute_title }}" id="ac{{$key}}" name="additional_accessories[]" @if(isset($attr_arr) && in_array($item->attribute_title, $attr_arr)) checked @endif>
                                                <label for="ac{{$key}}">{{$item->attribute_title }}</label>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        @if ($errors->has('additional_accessories.*'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('additional_accessories.*') }}</strong>
                                        </span>
                                        @endif
                                        <div class="col-lg-12 text-right">
                                            <div class="inrow add-plus empty">
                                                <input type="text" id="additional_accessories_checkbox_val" class="form-control">
                                                <button id="add_additional_accessories">Add +</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-label" for="status">Seller Comment</div>
                                        <textarea name="sellercomment" rows="6" cols="30" class="form-control">{{ $car->seller_comment }}</textarea>
                                    </div>
                                <div class="form-group">
                                    <div class="control-label">Photos/Videos: </div>
                                    <div class="col-lg-12 mt-20">
                                        {{--
                                        <div class="file-box">
                                            @php $uploaded_files = json_decode($car->detail['upload_file']); @endphp
                                            @if(isset($uploaded_files))
                                                @foreach($uploaded_files as $key=>$item)
                                                <a href="{{ url($item) }}">{{ $item }}</a><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        --}}
                                        <div class="attach-box">
                                            <div class="file-wrap mt-10">
                                                <input class="" type="file" id="upload_photo" name="upload_file[]" multiple="">
                                            </div>
                                        </div>
                                        @if ($errors->has('upload_photo'))
                                            <span class="text-danger">&nbsp;{{ $errors->first('upload_photo') }}</span>
                                        @endif
                                    </div>
                                    <br>
                                    @php $uploaded_files = json_decode($car->detail['upload_file']);
                                    $carId = $car->detail['id'];

                                    @endphp
                                            @if(isset($uploaded_files))
                                                @foreach($uploaded_files as $key=>$item)
                                                <a href="{{ asset($item) }}" target="_blank"><img src="{{ asset($item) }}" width="150px"></a> 
                                                <div><a href="javascript::void(0);" onclick="removeImage('{{$carId }}', '{{ $item }}');">Remove</a></div><br>
                                                @endforeach
                                            @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label" for="status">Status</div>
                                    <div class="">
                                        <select name="status" class="form-control" tabindex="-98">
                                            @php $statusArr = ['1'=>'Processing', '2'=>'Reserved', '3'=>'Sold', '4'=>'Cancelled', '5'=>'Publish']; @endphp
                                            @for ($i=1; $i<=5; $i++)
                                                <option value="{{ $i }}" @if($car->status == $i) selected @endif>{{ $statusArr[$i] }}</option>
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
<script type="text/javascript">
function removeImage(carId, imageName){
    if (confirm("Are you sure, you want to delete the image?")) {
        // alert(imageName);
        $.ajax({
            url: "{{route('image.delete')}}",
            type: "post",
            data: {"_token": "{{ csrf_token() }}",carId:carId, imageName:imageName},
            success: function(response){ // What to do if we succeed
                console.log(response);
                if(response.success == true){
                    // alert(response.success); 
                    location.reload();
                } else {
                    alert("Some error occured"); 
                }
            }
        });
    }
    return false;
    
}

$(function () {
        $("#open_market_value,#min_parf_benefit,#price, #quota_premium, #mileage, #engine_cc, #max_unladden_weight").on('keyup', function () {
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
$('#add_specification').click(function() {
    var numItems = $('#specification_group div.checkbox').length;
    numItems=numItems+1;
    var text = $('#add_specification_val').val();
    if(text){
        $('#specification_group').append('<div class="checkbox"><input value="' + text + '" name="specification[]" type="checkbox" id="sp'+numItems+'"/> <label for="sp'+numItems+'">' + text + '</label></div>');
        $('#add_specification_val').val('')
    }else{
        alert('Please enter specification text first');
        $('#add_specification_val').focus();
    }
    return false;
});

$('#add_additional_accessories').click(function() {
    var numItems = $('#additional_accessories_checkbox div.checkbox').length;
    numItems=numItems+1;
    var text = $('#additional_accessories_checkbox_val').val();
    if(text){
        $('#additional_accessories_checkbox').append('<div class="checkbox"><input value="' + text + '" name="additional_accessories[]" type="checkbox" id="ac'+numItems+'"/> <label for="ac'+numItems+'">' + text + '</label></div>');
        $('#additional_accessories_checkbox_val').val('')
    }else{
        alert('Please enter accessories text first');
        $('#additional_accessories_checkbox_val').focus();
    }
    return false;
});
</script>
@endsection