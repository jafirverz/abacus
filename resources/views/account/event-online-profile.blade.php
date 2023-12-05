@extends('layouts.app')
@section('content')
<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @include('inc.account-sidebar-event-student')
    </div>
    @php
    $user = \App\User::where('id', Auth::user()->id)->first();
    @endphp
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <h1 class="title-3">My Profile</h1>
        <div class="box-1">
          <div class="row align-items-center title-type">
            <div class="col-md">
              <h2 class="title-2">Personal Information</h2>
              {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            </div>
            <div class="col-md-auto mt-767-10">
              <a class="link-1" href="javascript::void(0);" id="editinformation">Edit My Information</a>
            </div>
          </div>
          <div class="mt-20"><label>Account ID:</label> {{Auth::user()->account_id}}</div>
          <form method="post" name="profile" id="profileform" enctype="multipart/form-data" action="{{route('my-profile.update')}}">
            @csrf
            <input type="hidden" name="updateimage" value="1">
            <input type="hidden" name="updateprofile" id="updateprofile" value="1">
          <div class="row sp-col-xl-30">
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Full Name <span class="required">*</span></label>
              <input class="form-control" name="name" type="text" value="{{old('name', $user->name) ?? ''}}" disabled />
            </div>
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Email <span class="required">*</span></label>
              <input class="form-control" name="email" type="text" value="{{old('email', $user->email) ?? ''}}" disabled />
            </div>
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Password <span class="required">*</span></label>
              <input class="form-control" name="password" value="" type="password" placeholder="*****" disabled />
            </div>
          </div>
          <div class="row sp-col-xl-30">
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Date of Birth <span class="required">*</span></label>
              <div class="date-wrap disabled">
                <i class="fa-solid fa-calendar-days ico"></i>
                <input class="form-control" name="dob" type="text" value="{{old('dob',$user->dob) ?? ''}}" disabled />
              </div>
            </div>
            <div class="col-xl-4 sp-col" id="disablephone">
                <label class="lb-1">Phone <span class="required">*</span></label>
                <div class="row sp-col-10">
                    <div class="col-auto sp-col">
                        <select data-live-search="true" class="selectpicker" disabled>
                            @foreach($country_phone as $countr)
                            <option value="{{ $countr->phonecode}}" @if($user->country_code_phone == $countr->phonecode) selected @endif>+{{ $countr->phonecode}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col sp-col">
                        <input class="form-control" type="text" value="{{$user->mobile}}" disabled />
                    </div>
                </div>
            </div>
            @php
                $country_code_phone = $user->country_code_phone;
                if(old("country_code_phone")){
                    $country_code_phone = old("country_code_phone");
                }
            @endphp
            <div class="col-xl-4 sp-col" id="enablephone" style="display: none">
                <label class="lb-1">Phone <span class="required">*</span></label>
                <div class="row sp-col-10">
                    <div class="col-auto sp-col">
                        <select data-live-search="true" class="selectpicker" name="country_code_phone">
                            @foreach($country as $countr)
                            <option value="{{ $countr->phonecode}}" @if($country_code_phone == $countr->phonecode) selected @endif>+{{ $countr->phonecode}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country_code_phone'))
                            <span class="text-danger">&nbsp;{{ $errors->first('country_code_phone') }}</span>
                        @endif
                    </div>
                    <div class="col sp-col">
                        <input class="form-control" type="text" name="mobile" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{old('mobile', $user->mobile) ?? ''}}" disabled />
                    </div>
                    @if ($errors->has('mobile'))
                        <span class="text-danger">&nbsp;{{ $errors->first('mobile') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xl-4 sp-col" id="disablegender">
                <label class="lb-1">Gender <span class="required">*</span></label>
                <select class="selectpicker" disabled>
                    <option value="">Please Select</option>
                    <option value="1" @if($user->gender == '1') selected @endif>Male</option>
                    <option value="2" @if($user->gender == '2') selected @endif>Female</option>
                </select>
            </div>
            @php
                $gender = $user->gender;
                if(old("gender")){
                    $gender = old("gender");
                }
            @endphp
            <div class="col-xl-4 sp-col" id="enablegender" style="display: none">
                <label class="lb-1">Gender <span class="required">*</span></label>
                <select class="selectpicker" name="gender" >
                    <option value="" selected>Please Select</option>
                    <option value="1" @if($gender == '1' && !$errors->has('gender')) selected @endif>Male</option>
                    <option value="2" @if($gender == '2' && !$errors->has('gender')) selected @endif>Female</option>
                </select>
                @if ($errors->has('gender'))
                    <span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
                @endif
            </div>
          </div>
          <div class="row sp-col-xl-30">
            <div class="col-xl-8 sp-col">
              <label class="lb-1">Address</label>
              <input name="address" class="form-control" type="text" value="{{$user->address}}" disabled />
            </div>

            <div class="col-xl-4 sp-col">
              <label class="lb-1">Learning Location </label>
              <input readonly class="form-control" id="learning_locations" type="text" value="{{$user->location->title ?? ''}}" disabled />

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
@if($errors->any())
  <script>
          $("#profileform").find("input, select, textarea").attr("disabled", false);
          $('#disablephone').hide();
          $('#enablephone').show();
          $('#disablegender').hide();
          $('#enablegender').show();
          $('#disablecountry').hide();
          $('#enablecountry').show();
          //$('#disableinstructor').hide();
          //$('#enableinstructor').show();
          $('#updateprofile').val(1);
          // $('#profileform').hide();
          // $('#profileformedit').show();

  </script>
@endif
<script>
  $('#editinformation').click(function () {
        $("#profileform").find("input, select, textarea").attr("disabled", false);
        $('#disablephone').hide();
        $('#enablephone').show();
        $('#disablegender').hide();
        $('#enablegender').show();
        $('#disablecountry').hide();
        $('#enablecountry').show();
        //$('#disableinstructor').hide();
        //$('#enableinstructor').show();
        $('#updateprofile').val(1);
        // $('#profileform').hide();
        // $('#profileformedit').show();

    });
</script>
@endsection
