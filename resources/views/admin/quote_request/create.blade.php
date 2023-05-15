@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('quoterequest.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_quoterequest_crud', 'Create', route('quoterequest.create'))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('quoterequest.store') }}" method="post" enctype="multipart/form-data">
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
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                                    <input type="text" name="full_name" class="form-control" id="" value="">
                                    @if ($errors->has('full_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label" for="country">Country</div>
                                    <div class="">
                                        <select name="country" class="form-control" tabindex="-98">
                                            @if(country())
                                            @foreach (country() as $item)
                                                <option value="{{ $item->phonecode }}" @if($item->phonecode==65) selected @endif>{{ $item->nicename }}</option>
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
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" name="contact_number" class="form-control" id="" value="">
                                    @if ($errors->has('contact_number'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('contact_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" id="" value="">
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Gender</label><br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="gender-male" name="gender" value="0" @if(!old('gender')) checked @elseif(old('gender')==0) checked @endif />
                                        <label class="form-check-label" for="gender-male">&nbsp;Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="gender-female" name="gender" value="1" @if(old('gender')==1) checked @endif/>
                                        <label class="form-check-label" for="gender-female">&nbsp;Female</label>
                                    </div>
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
                                    <input type="text" name="vehicle_number" class="form-control" id="" value="">
                                    @if ($errors->has('vehicle_number'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nric">NRIC</label>
                                    <input type="text" name="nric" class="form-control" id="" value="">
                                    @if ($errors->has('nric'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('nric') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="mileage">Mileage</label>
                                    <input type="text" name="mileage" class="form-control" id="" value="">
                                    @if ($errors->has('mileage'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mileage') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="handing_over_date">Handing Over Date</label>
                                    <input type="text" class="form-control datepicker" name="handing_over_date" id="handing_over_date" value="" />
                                    @if ($errors->has('handing_over_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('handing_over_date') }}</strong>
                                        </span>
                                    @endif
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
                                    <label for="seller_remarks">Seller Remarks</label>
                                    <textarea name="seller_remarks" class="form-control" id=""></textarea>
                                    @if ($errors->has('seller_remarks'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('seller_remarks') }}</strong>
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
                                    <label for="quote_price">Quote Price</label>
                                    <input type="text" name="quote_price" class="form-control" id="" value="">
                                    @if ($errors->has('quote_price'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('quote_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label" for="status">Status</div>
                                    <div class="">
                                        <select name="status" class="form-control" tabindex="-98">
                                            @php $statusArr = ['1'=>'Processing', '2'=>'Approve']; @endphp
                                            @for ($i=1; $i<=2; $i++)
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
@endsection