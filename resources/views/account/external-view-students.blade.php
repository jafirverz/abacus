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
                <h1 class="title-3">My Profile</h1>
                <div class="box-1">
                    <div class="row align-items-center title-type">
                        <div class="col-md">
                            <h2 class="title-2">Personal Information</h2>
                        </div>
                    </div>
                
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input readonly class="form-control" name="name" type="text" value="{{ old('name', $customer->name) }}"  />
                            
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Email <span class="required">*</span></label>
                            <input readonly name="email"  class="form-control" type="text" value="{{ old('email', $customer->email) }}"  />
                            
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Password <span class="required">*</span></label>
                            <input readonly name="password" class="form-control" type="password" placeholder="*****"  />
                            
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Date of Birth <span class="required">*</span></label>
                            <div class="date-wrap ">
                                <i class="fa-solid fa-calendar-days ico"></i>
                                <input readonly name="dob" class="form-control" type="text" value="{{ old('dob', $customer->dob) }}"  />
                                
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Phone <span class="required">*</span></label>
                            <div class="row sp-col-10">
                                <div class="col-auto sp-col">
                                    <select disabled name="country_code_phone" class="selectpicker" >
                                        @foreach($country as $phonecode)
                                            <option value="{{ $phonecode->phonecode }}" >+ {{ $phonecode->phonecode }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="col sp-col">
                                    <input readonly class="form-control" name="mobile" type="text" value="{{ old('dob', $customer->mobile) }}"  />
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Gender <span class="required">*</span></label>
                            <select disabled name="gender" class="selectpicker" >
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
                            <select disabled class="selectpicker"  name="country_code">
                                @if(getCountry())
                                @foreach (getCountry() as $key => $item)
                                <option value="{{ $key }}" @if(old('country_code', $customer->country_code)==$key) selected @endif>{{ $item }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                           
                        </div>
                            @php
                                $level_ids=json_decode($customer->level_id,true);
                                //dd( $level_ids);
                            @endphp
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Level <span class="required">*</span></label>
                            <select disabled class="selectpicker"  name="level[]" multiple>
                                @foreach($levels as $level)
                                <option value="{{ $level->id }}" @if(isset($level_ids) && in_array($level->id,$level_ids)) selected @endif>{{ $level->title }}
                                </option>
                                @endforeach
                            </select>

                            
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1" for="status">Status</label>
                            <select disabled name="status" class="selectpicker" id="">
                                <option value="">-- Select --</option>
                                @if(getActiveStatus())
                                @foreach (getActiveStatus() as $key => $item)
                                <option value="{{ $key }}" @if(old('status', $customer->approve_status)==$key) selected @endif>{{ $item }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            
                        </div>
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Address</label>
                            <input readonly="readonly" name="address" class="form-control" type="text" value="{{ old('address', $customer->address) }}"  />
                        </div>


                    </div>

                </div>

            </div>
        </div>

    </div>
</main>

@endsection
