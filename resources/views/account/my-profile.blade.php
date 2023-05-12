@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
    @include('inc.banner')

    <form action="{{ route('my-profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container main-inner">

            <div class="row">

                <div class="col-lg-3 mb-991-30">
                    @include('inc.account-profile-image')
                    @include('inc.account-sidebar')

                </div>
                <div class="col-lg-9">
                    @include('inc.messages')
                    <div class="title-5">
                        <h1>My profile</h1>
                    </div>
                    <label class="lb">Company Name</label>
                    <input type="text" name="company_name" class="form-control"
                        value="{{old('company_name',$user->company_name)}}">
                    @if ($errors->has('company_name'))
                    <span class="text-danger d-block">
                        <strong>{{ $errors->first('company_name') }}</strong>
                    </span>
                    @endif
                    <label class="lb mt-20">Contact Person</label>
                    <input type="text" name="name" class="form-control" value="{{old('name',$user->name)}}">
                    @if ($errors->has('name'))
                    <span class="text-danger d-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                    <label class="lb mt-20">Email Address</label>
                    <input type="text" name="email" readonly="readonly" class="form-control"
                        value="{{old('email',$user->email)}}">

                    <div class="row sp-col-5">
                        <div class="col-auto sp-col">
                            <div class="inrow">
                                <label class="lb mt-20">Country Code</label>
                                <input type="text" name="country_code" value="{{old('country_code',$user->country_code)}}" placeholder="+65" class="form-control">
                                @if ($errors->has('country_code'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('country_code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col sp-col">
                            <div class="inrow"> <label class="lb mt-20"> Contact Number</label> <input type="text"
                                    class="form-control" name="mobile"
                                    value="{{old('mobile',$user->mobile)}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" /> </div>
                            @if ($errors->has('mobile'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                            @endif
                        </div>

                    </div>

                    <label class="lb mt-20">Address</label>
                    <input type="text" name="address" class="form-control" value="{{old('address',$user->address)}}">
                    @if ($errors->has('address'))
                    <span class="text-danger d-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <label class="lb mt-20">Gender</label>
                            <div class="dropdown bootstrap-select">
                                <select name="gender" class="selectpicker" tabindex="-98">
                                    <option value="1" @if(old('gender', $user->gender)=="1") selected @endif>Male
                                    </option>
                                    <option value="2" @if(old('gender', $user->gender)=="2") selected @endif>Female
                                    </option>
                                </select>
                            </div>
                            @if ($errors->has('gender'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-6 inpico-wrap">
                            <label class="lb mt-20">Password</label>
                            <input type="password" class="form-control" value="" name="password" id="password">
                            <i class="fa fa-eye seteyepass" onclick="myFunction('password');" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="mt-30">
                        <button class="btn-1 minw-190" type="submit">SAVE CHANGES <i
                                class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function myFunction(id) {
        var x = document.getElementById(id);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endsection
