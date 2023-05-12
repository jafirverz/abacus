@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
    @include('inc.banner')

    <div class="container main-inner">
        <h1 class="title-1 text-center">Quote My Car</h1>
        <ul class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Quote My Car</li>
        </ul>
        <div class="add-my-car">
            @include('inc.messages')
            <form action="{{ url('quote-my-car-form') }}" method="post" enctype="multipart/form-data" class="form-ani">
                @csrf
                <h3 class="title-6 item"><span><strong>Owner's Particulars </strong></span></h3>
                <div class="mt-10 row">
                    <div class="col-xl-4">
                        <div class="empty">
                            <label>Full Name</label>
                            <input name="full_name" type="text" required class="form-control" value="{{ old('full_name') }}">
                        </div>
                        @if ($errors->has('full_name'))
                            <span class="text-danger">&nbsp;{{ $errors->first('full_name') }}</span>
                        @endif
                    </div>

                    <div class="col-xl-4 col-md-4">
                        <div class="row">
                            <div class="dropdown bootstrap-select col-md-5">
                                <label for="">Country Code</label>
                                <select required name="country" class="selectpicker" tabindex="-98">
                                    @if(country())
                                    @foreach (country() as $item)
                                        <option value="{{ $item->phonecode }}" @if($item->phonecode=='65') selected @endif>+{{ $item->phonecode }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            @if ($errors->has('country'))
                                <span class="text-danger">&nbsp;{{ $errors->first('country') }}</span>
                            @endif

                            <div class="col-xl-7 col-md-7">
                                <div class="empty">
                                    <label>Mobile Number</label>
                                    <input required name="contact_number" value="{{ old('contact_number') }}" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                                @if ($errors->has('contact_number'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('contact_number') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4">
                        <div class="empty">
                            <label>Email Address (Ex: janedoe@gmail.com)</label>
                            <input required name="email" value="{{ old('email') }}" type="email" class="form-control">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger">&nbsp;{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="mt-10 col-md-4">
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
                <h3 class="title-6 mt-30"><span><strong>Vehicle Details </strong></span></h3>

                <div class="mt-10 row">
                    <div class="col-xl-4 col-md-4">
                        <div class="empty">
                            <label>Vehicle number</label>
                            <input required name="vehicle_number" value="{{ old('vehicle_number') }}" type="text" class="form-control">
                        </div>
                        @if ($errors->has('vehicle_number'))
                            <span class="text-danger">&nbsp;{{ $errors->first('vehicle_number') }}</span>
                        @endif
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="empty">
                            <label>NRIC/FIN (Last 4 Characters)</label>
                            <input required name="nric" value="{{ old('nric') }}" type="text" class="form-control" minlength="4" maxlength="4" >
                        </div>
                        @if ($errors->has('nric'))
                            <span class="text-danger">&nbsp;{{ $errors->first('nric') }}</span>
                        @endif
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="info-wrap empty">
                            <label>Mileage (Estimated)</label>
                            <input required value="{{ old('mileage') }}" name="mileage" type="text" class="form-control">
                            <span class="input-info"> km </span>
                        </div>
                        @if ($errors->has('mileage'))
                            <span class="text-danger">&nbsp;{{ $errors->first('mileage') }}</span>
                        @endif
                    </div>
                    <div class="mt-10 col-xl-4 col-md-4">
                        <label for="handing_over_date">Handing Over Date</label>
                        <div class="date-wrap datepicker-wrap">
                            <input type="text" class="form-control datepicker" name="handing_over_date" id="handing_over_date" value="" />
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @if ($errors->has('handing_over_date'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('handing_over_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <h3 class="title-6 mb-30 mt-30"><span><strong>Optional </strong></span></h3>
                <div class="mt-20 empty">
                    <label for="">Remarks about condition of the vehicle (If any):</label>
                    <textarea value="{{ old('seller_remarks') }}" name="seller_remarks" rows="6" cols="30" placeholder="Insert text here" class="form-control"></textarea>
                </div>
                @if ($errors->has('seller_remarks'))
                    <span class="text-danger">&nbsp;{{ $errors->first('seller_remarks') }}</span>
                @endif
                <h3 class="title-6 mb-30 mt-30"><span><strong>Upload Photos</strong></span></h3>
                <div class="row">
                    <div class="col-lg-12 mt-20">
                        <div class="attach-box">
                            <div class="file-wrap mt-10">
                                <input required class="custom-file-input text-file" type="file" id="upload_photo" name="upload_file[]" multiple="">
                                <span class="txt">No file chosen</span>
                                <label for="upload_photo" class="upload">Upload File </label>
                            </div>
                        </div>
                        @if ($errors->has('upload_photo'))
                            <span class="text-danger">&nbsp;{{ $errors->first('upload_photo') }}</span>
                        @endif
                    </div>
                </div>

                <div class="checkbox mt-30">
                    <input type="checkbox" id="terms_condition" name="terms_condition">
                    <label for="information">I acknowledge and agree to the collection, use and disclosure of my personal data which has been provided for the purposes of procuring insurance products &amp; services, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012.</label>
                    @if ($errors->has('terms_condition'))
                    <span class="text-danger">&nbsp;{{ $errors->first('terms_condition') }}</span>
                    @endif
                </div>
                <div class="output-2">
                    <button class="btn-1 minw-190" type="submit">SUBMIT <i class="fas fa-arrow-right"></i></button>
                </div>
                {{-- <div class="captcha">
                    <!-- Google reCAPTCHA widget -->
                    <div class="google-recaptcha">
                        <div class="g-recaptcha" data-callback="setResponse" data-size="invisible"
                            data-sitekey="{{config('system_settings')->recaptcha_site_key}}"></div>
                            <input type="hidden" id="captcha-response" name="captcha_response" />
                    </div>
                    <!-- Google reCAPTCHA widget -->
                </div> --}}
            </form>
        </div>
    </div>
</div>
@endsection
