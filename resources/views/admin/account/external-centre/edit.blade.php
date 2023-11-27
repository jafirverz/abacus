@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('external-centre-account.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('external_centre_account_crud', 'Edit',
            route('external-centre-account.edit', $customer->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('external-centre-account.update', $customer->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Centre Name <span class="required">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $customer->name) }}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Person In-Charge Name <span class="required">*</span></label>
                                    <input type="text" name="in_charge_name" class="form-control"
                                        value="{{ old('in_charge_name', $customer->in_charge_name) }}">
                                    @if ($errors->has('in_charge_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('in_charge_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Email Address <span class="required">*</span></label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>




                                <div class="form-group">
                                    <label for="">Phone <span class="required">*</span></label>
                                    <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control" name="country_code_phone">
                                                    @foreach($country_phone as $countr)
                                                    <option value="{{ $countr->phonecode }} " @if(old('country_code_phone', $customer->country_code_phone) == $countr->phonecode) selected @elseif('65' == $countr->phonecode) selected @endif>+ {{ $countr->phonecode }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_code_phone'))
                                                <span class="text-danger d-block">
                                                    <strong>{{ $errors->first('country_code_phone') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-9">
                                                    <input type="text" name="mobile" class="form-control"
                                                        value="{{ old('mobile', $customer->mobile) }}">
                                                    @if ($errors->has('mobile'))
                                                    <span class="text-danger d-block">
                                                        <strong>{{ $errors->first('mobile') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Gender <span class="required">*</span></label>
                                    <select name="gender" class="form-control" tabindex="-98">
                                        <option value="1" @if(old('gender', $customer->gender)=="1") selected @endif>Male
                                        </option>
                                        <option value="2" @if(old('gender', $customer->gender)=="2") selected @endif>Female
                                        </option>
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('name', $customer->address) }}">
                                    @if ($errors->has('address'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Centre Location</label>
                                    <input type="text" name="centre_location" class="form-control" value="{{ old('centre_location', $customer->centre_location) }}">
                                    @if ($errors->has('centre_location'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('centre_location') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Password <span class="required">*</span></label>
                                    <input type="password" name="password" class="form-control">
                                    @if ($errors->has('password'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="status">Status <span class="required">*</span></label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status', $customer->approve_status)==$key) selected @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
