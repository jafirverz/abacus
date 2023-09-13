@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('customer.pendingRequest') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('customer.update', $customer->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Full Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $customer->name) }}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Email Address</label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="">Date Of Birth</label>
                                    <input type="text" name="dob" class="form-control datepicker" value="{{ old('dob', $customer->dob) }}">
                                    @if ($errors->has('dob'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Phone Code</label>
                                    <input type="text" name="country_code_phone" class="form-control"
                                        value="{{ old('country_code_phone', $customer->country_code_phone) }}">
                                    @if ($errors->has('country_code_phone'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country_code_phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" name="mobile" class="form-control"
                                        value="{{ old('mobile', $customer->mobile) }}">
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Gender</label>
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

                                @php
                                $countrycode = str_replace('+', '', $customer->country_code);
                                @endphp
                                <div class="form-group">
                                    <label for="country_code">Country</label>
                                    <select name="country_code" class="form-control" id="country_code">
                                        <option value="">-- Select --</option>
                                        @if(getCountry())
                                        @foreach (getCountry() as $key => $item)
                                        <option value="{{ $key }}" @if(old('country_code', $countrycode)==$key) selected @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('country_code'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country_code') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                


                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        <option value="1">Approve</option>
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
