@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            <div class="menu-aside">
                @if(Auth::user()->user_type_id == 6)
                @include('inc.account-sidebar-external')
                @else
                @include('inc.intructor-account-sidebar')
                @endif
            </div>
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <h1 class="title-3">My Student Profile</h1>
                <div class="box-1">
                    <div class="row align-items-center title-type">
                        <div class="col-md">
                            <h2 class="title-2">Personal Information</h2>
                        </div>
                    </div>
                <form method="post" name="student" id="student" enctype="multipart/form-data" action="{{route('external-profile.add-students.edit', $customer->id)}}">
                    @csrf
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input class="form-control" name="name" type="text" value="{{ old('name', $customer->name) }}"  />
                            @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                           @endif
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Email <span class="required">*</span></label>
                            <input name="email"  class="form-control" type="text" value="{{ old('email', $customer->email) }}"  />
                            @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Password <span class="required">*</span></label>
                            <input name="password" class="form-control" type="password" placeholder="*****"  />
                            @if ($errors->has('password'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Date of Birth <span class="required">*</span></label>
                            <div class="date-wrap ">
                                <i class="fa-solid fa-calendar-days ico"></i>
                                <input name="dob" class="form-control" type="text" value="{{ old('dob', $customer->dob) }}"  />
                                @if ($errors->has('dob'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Phone <span class="required">*</span></label>
                            <div class="row sp-col-10">
                                <div class="col-auto sp-col">
                                    <select data-live-search="true" name="country_code_phone" class="selectpicker" >
                                        @foreach($country as $phonecode)
                                            <option value="{{ $phonecode->phonecode }}" >+ {{ $phonecode->phonecode }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country_code_phone'))
                                                <span class="text-danger d-block">
                                                    <strong>{{ $errors->first('country_code_phone') }}</strong>
                                                </span>
                                                @endif
                                </div>
                                <div class="col sp-col">
                                    <input class="form-control" name="mobile" type="text" value="{{ old('mobile', $customer->mobile) }}"  />
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Gender <span class="required">*</span></label>
                            <select name="gender" class="selectpicker" >
                                <option>Please Select</option>
                                <option value="1" @if(old('gender', $customer->gender)=="1") selected @endif>Male
                                </option>
                                <option value="2" @if(old('gender', $customer->gender)=="2") selected @endif>Female
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Country <span class="required">*</span></label>
                            <select disabled data-live-search="true" class="selectpicker">
                                @if(getCountry())
                                @foreach (getCountry() as $key => $item)
                                <option value="{{ $key }}" @if(old('country_code', $customer->country_code)==$key) selected @endif>{{ $item }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('country_code'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country_code') }}</strong>
                                    </span>
                            @endif
                            <input type="hidden" name="country_code" value="{{ $customer->country_code }}">
                        </div>
                            @php
                                $level_ids=json_decode($customer->level_id,true);
                                //dd( $level_ids);
                            @endphp
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Level <span class="required">*</span></label>
                            <select data-live-search="true" class="selectpicker"  name="level[]" multiple>
                                @foreach($levels as $level)
                                <option value="{{ $level->id }}" @if(isset($level_ids) && in_array($level->id,$level_ids)) selected @endif>{{ $level->title }}
                                </option>
                                @endforeach
                            </select>

                            @if ($errors->has('level'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('level') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row sp-col-xl-30">
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Learning Locations </label>
                            <select data-live-search="true" name="learning_locations" class="selectpicker" data-title="Select Option">
                                @if($locations)
                                @foreach($locations as $item)
                                <option @if(old('learning_locations',$customer->learning_locations)==$item->id) selected @endif  value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('learning_locations'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('learning_locations') }}</strong>
                                    </span>
                           @endif
                        </div>
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Learning Updates </label>
                            <textarea class="form-control" name="learning_updates">{{ old('learning_updates', $customer->learning_updates) }}</textarea>
                            @if ($errors->has(' learning_updates'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('learning_updates') }}</strong>
                                    </span>
                           @endif
                        </div>
                    </div>

                    <div class="row sp-col-xl-30">
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1" for="status">Status</label>
                            <select name="status" class="selectpicker" id="">
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
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Address</label>
                            <input name="address" class="form-control" type="text" value="{{ old('address', $customer->address) }}"  />
                        </div>


                    </div>


                    <div class="output-2">
                        <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </form>
                </div>

            </div>
        </div>

    </div>
</main>

@endsection
