@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('marketplace.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_marketplace_crud', 'Show', route('marketplace.show', $car->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Owner's Particulars
                                <hr/>
                            </h5>
                            <div class="form-group">
                                <strong>Full Name</strong>: {{ $car->full_name }}
                            </div>
                            <div class="form-group">
                                <strong>NRIC</strong>: {{ $car->detail['nric'] }}
                            </div>
                            <div class="form-group">
                                <strong>Email</strong>: {{ $car->email }}
                            </div>
                            <div class="form-group">
                                <strong>Contact Number</strong>: {{ "+".$car->country." ".$car->contact_number }}
                            </div>
                            <div class="form-group">
                                <strong>Gender</strong>: {{ $car->gender }}
                            </div>
                            <div class="form-group">
                                <strong>Vehicle Number</strong>: {{ $car->detail['vehicle_number'] }}
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Vehicle Details
                                <hr/>
                            </h5>
                            <div class="form-group">
                                <strong>Vehicle Make</strong>: {{ $car->detail['vehicle_make'] }}
                            </div>
                            <div class="form-group">
                                <strong>Vehicle Model</strong>: {{ $car->detail['vehicle_model'] }}
                            </div>
                            <div class="form-group">
                                <strong>Primary Color</strong>: {{ $car->detail['primary_color'] }}
                            </div>
                            <div class="form-group">
                                <strong>Year of manufacture</strong>: {{ $car->detail['year_of_mfg'] }}
                            </div>
                            <div class="form-group">
                                <strong>Open Market Value</strong>: {{ isset($car->detail['open_market_value']) ? '$'.number_format($car->detail['open_market_value']) : '' }}
                            </div>
                            @php
                            if(!empty($car->detail['orig_reg_date'])){
                                $crd = date('d-m-Y', strtotime($car->detail['orig_reg_date']));
                                if($crd == '01-01-1970'){
                                    $crd = date('d-m-Y');
                                }
                            }else{
                                $crd = '';
                            }
                            @endphp
                            <div class="form-group">
                                <strong>Original Registration Date</strong>: {{ $crd }}
                            </div>
                            @php
                            if(!empty($car->detail['first_reg_date'])){
                                $first_reg_date = date('d-m-Y', strtotime($car->detail['first_reg_date']));
                                if($first_reg_date == '01-01-1970'){
                                    $first_reg_date = date('d-m-Y');
                                }
                            }else{
                                $first_reg_date = '';
                            }
                            @endphp
                            <div class="form-group">
                                <strong>First Registration Date</strong>: {{ $first_reg_date }}
                            </div>
                            <div class="form-group">
                                <strong>No. Of Tansfers</strong>: {{ $car->detail['no_of_transfers'] }}
                            </div>
                            <div class="form-group">
                                <strong>Minimum PARF Benefit</strong>: {{ isset($car->detail['min_parf_benefit']) ? '$'.number_format($car->detail['min_parf_benefit']) : '' }}
                            </div>
                            @php
                            if(!empty($car->detail['coe_expiry_date'])){
                                $coe_expiry_date = date('d-m-Y', strtotime($car->detail['coe_expiry_date']));
                                if($coe_expiry_date == '01-01-1970'){
                                    $coe_expiry_date = date('d-m-Y');
                                }
                            }else{
                                $coe_expiry_date = '';
                            }
                            @endphp
                            <div class="form-group">
                                <strong>COE Expiry Date</strong>: {{ $coe_expiry_date }}
                            </div>
                            <div class="form-group">
                                <strong>COE Category</strong>: {{ $car->detail['coe_category'] }}
                            </div>
                            <div class="form-group">
                                <strong>Quota Premium</strong>: {{ isset($car->detail['quota_premium']) ? '$'.number_format($car->detail['quota_premium']) : '' }}
                            </div>
                            <div class="form-group">
                                <strong>Vehicle Type</strong>: {{ $car->detail['vehicle_type'] }}
                            </div>
                            <div class="form-group">
                                <strong>Propellant</strong>: {{ $car->detail['propellant'] }}
                            </div>
                            <div class="form-group">
                                <strong>Power Rate</strong>: {{ isset($car->detail['power_rate']) ? $car->detail['power_rate'].' kw' : '' }}
                            </div>
                            <div class="form-group">
                                <strong>Vehicle CO2 Emission rate</strong>: {{ $car->detail['co2_emission_rate'] }}
                            </div>
                            <div class="form-group">
                                <strong>Max Unladden Weight</strong>: {{ isset($car->detail['max_unladden_weight']) ? $car->detail['max_unladden_weight'].' kg' : '' }}
                            </div>
                            <div class="form-group">
                                <strong>Vehicle Scheme</strong>: {{ $car->detail['vehicle_scheme'] }}
                            </div>
                            <div class="form-group">
                                <strong>Engine Capacity</strong>: {{ isset($car->detail['engine_cc']) ? $car->detail['engine_cc'].' cc' : '' }}
                            </div>
                            @php
                            if(!empty($car->detail['road_tax_expiry_date'])){
                                $road_tax_expiry_date = date('d-m-Y', strtotime($car->detail['road_tax_expiry_date']));
                                if($road_tax_expiry_date == '01-01-1970'){
                                    $road_tax_expiry_date = date('d-m-Y');
                                }
                            }else{
                                $road_tax_expiry_date = '';
                            }
                            @endphp
                            <div class="form-group">
                                <strong>Road Tax Expiry Date</strong>: {{ $road_tax_expiry_date }}
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
                                <strong>Price</strong>: {{ isset($car->detail['price']) ? '$'.number_format($car->detail['price']) : '' }}
                            </div>
                            <div class="form-group">
                                <strong>Mileage</strong>: {{ isset($car->detail['mileage']) ? number_format($car->detail['mileage']).' km' : '' }}
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
                                <strong>Specifications: </strong>
                                @php $specs_arr = json_decode($car->specification); @endphp
                                @if(isset($specs_arr))
                                <ul>
                                    @foreach($specs_arr as $key=>$item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            <div class="form-group">
                                <strong>Additional Accessories:</strong>
                                @php $attr_arr = json_decode($car->additional_accessories); @endphp
                                @if(isset($attr_arr))
                                <ul>
                                    @foreach($attr_arr as $key=>$item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            <div class="form-group">
                                <strong>Seller's Comment</strong>: {{ $car->seller_comment }}
                            </div>
                            <div class="form-group">
                                <strong>Photos/Videos:</strong>
                                @php $uploaded_files = json_decode($car->detail['upload_file']); @endphp
                                @if(isset($uploaded_files))
                                <ul>
                                    @foreach($uploaded_files as $key=>$item)
                                    <li><a href="{{ url($item) }}">{{ $item }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            <div class="form-group">
                                @php $statusArr = ['0'=>'', '1'=>'Processing', '2'=>'Reserved', '3'=>'Sold', '4'=>'Cancelled', '5'=>'Published']; @endphp
                                <strong>Status</strong>: {{ $statusArr[$car->status] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
