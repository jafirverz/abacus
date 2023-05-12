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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_marketplace_crud', 'Create', route('marketplace.create'))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('marketplace.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <!-- @if($errors->any())
                            {{ implode('', $errors->all('<div>:message</div>')) }}
                        @endif -->
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
                                            <option value="{{ $value->id }}" @if($value->id == old('seller')) selected @endif>{{ $value->name }}</option>
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
                                    <input type="text" name="full_name" class="form-control" id="" value="{{old('full_name')}}">
                                    @if ($errors->has('full_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nric">NRIC</label>
                                    <input type="text" name="nric" class="form-control" id="" value="{{old('nric')}}">
                                    @if ($errors->has('nric'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('nric') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" id="" value="{{old('email')}}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="contact_number">Country Code</label>
                                            <input type="text" name="country" class="form-control" id="" value="+65">
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
                                            <input type="text" name="contact_number" class="form-control" id="" value="{{old('contact_number')}}">
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
                                        <option value="Male" @if(old('gender')=='Male') selected @endif>Male</option>
                                        <option value="Female" @if(old('gender')=='Female') selected @endif>Female</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="vehicle_number">Vehicle Number</label>
                                    <input type="text" name="vehicle_number" class="form-control" id="" value="{{old('vehicle_number')}}">
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
                                    <input type="text" name="vehicle_make" class="form-control" id="" value="{{old('vehicle_make')}}">
                                        
                                        @if ($errors->has('vehicle_make'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('vehicle_make') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_model">Vehicle Model</label>
                                    <input type="text" name="vehicle_model" class="form-control" id="" value="{{old('vehicle_model')}}">
                                    @if ($errors->has('vehicle_model'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_model') }}</strong>
                                    </span>
                                    @endif
                                    
                                </div>
                                <div class="form-group">
                                    <label for="primary_color">Primary Color</label>
                                    <input type="text" name="primary_color" class="form-control" id="" value="{{old('primary_color')}}">
                                    @if ($errors->has('primary_color'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('primary_color') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="year_of_mfg">Year Of Manufacture</label>
                                    <input type="text" name="year_of_mfg" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="" value="{{old('year_of_mfg')}}">
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
                                        <input type="text" name="open_market_value" class="form-control" id="open_market_value" value="{{old('open_market_value')}}">
                                    </div>
                                    @if ($errors->has('open_market_value'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('open_market_value') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="orig_reg_date">Original Registration Date</label>
                                    <input type="text" class="form-control datepicker547" name="orig_reg_date" id="orig_reg_date" value="{{old('orig_reg_date')}}" />
                                    @if ($errors->has('orig_reg_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('orig_reg_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="first_reg_date">First Registration Date</label>
                                    <input type="text" class="form-control datepicker547" name="first_reg_date" id="first_reg_date" value="{{old('first_reg_date')}}" />
                                    @if ($errors->has('first_reg_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('first_reg_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="no_of_transfers">No. Of Transfers</label>
                                    <input type="text" name="no_of_transfers" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="" value="{{old('no_of_transfers')}}">
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
                                        <input type="text" name="min_parf_benefit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="min_parf_benefit" value="{{old('min_parf_benefit')}}">
                                    </div>
                                    @if ($errors->has('min_parf_benefit'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('min_parf_benefit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="coe_expiry_date">COE Expiry Date</label>
                                    <input type="text" class="form-control datepicker547" name="coe_expiry_date" id="coe_expiry_date" value="{{old('coe_expiry_date')}}" />
                                    @if ($errors->has('coe_expiry_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('coe_expiry_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="coe_category">COE Category</label>
                                    <input type="text" name="coe_category" class="form-control" id="" value="{{old('coe_category')}}">
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
                                        <input type="text" name="quota_premium" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="quota_premium" value="{{old('quota_premium')}}">
                                    </div>
                                    @if ($errors->has('quota_premium'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('quota_premium') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_type">Vehicle Type</label>
                                    <div class="">
                                        <select name="vehicle_type" class="form-control">
                                            <option value="">Vehicle Type</option>
                                            @if(getFilterValByType(__('constant.VEHICLE_TYPE')))
                                            @foreach(getFilterValByType(__('constant.VEHICLE_TYPE')) as $key=>$value)
                                            <option value="{{ $value->title }}" @if($value->title == old('vehicle_type')) selected @endif>{{ $value->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('vehicle_type'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('vehicle_type') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="propellant">Propellant</label>
                                    <div class="">
                                        <select name="propellant" class="form-control">
                                            @foreach(getPropellantType() as $key=>$value)
                                            <option value="{{ $key }}" @if($key == old('propellant')) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('propellant'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('propellant') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="power_rate">Power Rate</label>
                                    <input type="text" name="power_rate" class="form-control" id="" value="{{old('power_rate')}}">
                                    @if ($errors->has('power_rate'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('power_rate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="co2_emission_rate">CO2 Emission Rate</label>
                                    <input type="text" name="co2_emission_rate" class="form-control" id="" value="{{old('co2_emission_rate')}}">
                                    @if ($errors->has('co2_emission_rate'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('co2_emission_rate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="max_unladden_weight">Max Unladden Weight</label>
                                    <input type="text" name="max_unladden_weight" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="max_unladden_weight" value="{{old('max_unladden_weight')}}">
                                    @if ($errors->has('max_unladden_weight'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('max_unladden_weight') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_scheme">Vehicle Scheme</label>
                                    <input type="text" name="vehicle_scheme" class="form-control" id="" value="{{old('vehicle_scheme')}}">
                                    @if ($errors->has('vehicle_scheme'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_scheme') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="engine_cc">Engine Capacity</label>
                                    <input type="text" name="engine_cc" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="engine_cc" value="{{old('engine_cc')}}">
                                    @if ($errors->has('engine_cc'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('engine_cc') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="road_tax_expiry_date">Road Tax Expiry Date</label>
                                    <input type="text" class="form-control datepicker547" name="road_tax_expiry_date" id="road_tax_expiry_date" value="{{old('road_tax_expiry_date')}}" />
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
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="price" class="form-control" id="price" value="{{old('price')}}">
                                    </div>
                                    @if ($errors->has('price'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="mileage">Mileage</label>
                                    <input type="text" name="mileage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="mileage" value="{{old('mileage')}}">
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
                                        @if(get_specifications())
                                            @foreach (get_specifications() as $key=>$item)
                                            <div class="checkbox">
                                                <input type="checkbox" id="sp{{$key}}" value="{{$item->specification}}" name="specification[]">
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
                                    <div class="check-inline ad-checkline" id="additional_accessories_checkbox">
                                        @if(get_attributes())
                                            @foreach (get_attributes() as $key=>$item)
                                            <div class="checkbox">
                                                <input type="checkbox" value="{{$item->attribute_title }}" id="ac{{$key}}" name="additional_accessories[]">
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
                                    <div class="control-label">Seller's Comment: </div>
                                    <textarea class="form-control" name="seller_comment" id="seller_comment"></textarea>
                                    @if ($errors->has('seller_comment'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('seller_comment') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Photos/Videos: </div>
                                    <div class="col-lg-12 mt-20">
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
                                <div class="form-group">
                                    <div class="control-label" for="status">Status</div>
                                    <div class="">
                                        <select name="status" class="form-control" tabindex="-98">
                                            @php $statusArr = ['1'=>'Processing', '2'=>'Reserved', '3'=>'Sold', '4'=>'Cancelled', '5'=>'Publish']; @endphp
                                            @for ($i=1; $i<=5; $i++)
                                                <option value="{{ $i }}">{{ $statusArr[$i] }}</option>
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