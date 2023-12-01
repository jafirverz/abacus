@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('customer-account.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('customer_account_crud', 'Edit',
            route('customer-account.edit', $customer->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('customer-account.update', $customer->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Full Name <span class="required">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $customer->name) }}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('name') }}</strong>
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
                                    <label for="">Date Of Birth <span class="required">*</span></label>
                                    <input type="text" name="dob" class="form-control datepicker1" value="{{ old('dob', $customer->dob) }}">
                                    @if ($errors->has('dob'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Phone <span class="required">*</span></label>
                                    <div class="row">
                                            <div class="col-md-3">

                                                <select name="country_code_phone" class="form-control">
                                                    @foreach($country as $phonecode)
                                                    <option value="{{ $phonecode->phonecode }}" @if($phonecode->phonecode == $customer->country_code_phone) selected @endif>+ {{ $phonecode->phonecode }}</option>
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

                                @php
                                $levelDecode = json_decode($customer->level_id);
                                @endphp
                                <div class="form-group">
                                    <label for="">Level <span class="required">*</span></label>
                                    <select name="level[]" class="selectpicker" tabindex="-98" multiple>
                                        @foreach($levels as $level)
                                        <option value="{{ $level->id }}" @if(old('level')==$level->id) selected @elseif(isset($levelDecode) && in_array($level->id, $levelDecode)) selected @endif>{{ $level->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="country_code">Country <span class="required">*</span></label>
                                    <select name="country_code" class="form-control" id="country_code">
                                        <option value="">-- Select --</option>
                                        @if($country)
                                        @foreach ($country as $item)
                                        <option value="{{ $item->id }}" @if(old('country_code', $customer->country_code)==$item->id) selected @endif>{{ $item->nicename }}
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
                                    <label for="user_type_id">User Type <span class="required">*</span></label>
                                    <select disabled  class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (getUserTypes())
                                        @foreach (getUserTypes()  as $key => $item)
                                        <option value="{{ $key }}" @if(old('user_type_id', $customer->user_type_id)==$key)
                                            selected
                                            @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('user_type_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('user_type_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="instructor_id">@if($customer->user_type_id==4) External Centre Account @else Instructor @endif</label>
                                    <select name="instructor_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($instructors)
                                        @foreach ($instructors as $item)
                                        <option value="{{ $item->id }}" @if(old('instructor_id', $customer->instructor_id)==$item->id)
                                            selected
                                            @endif>{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('instructor_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('instructor_id') }}</strong>
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
