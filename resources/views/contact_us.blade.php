@extends('layouts.app')
@section('content')

<div class="main-wrap">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">Contact Us</h1>
        @include('inc.breadcrumb')
        <div class="tempt-1 text-center">
            We want to hear from you. Please don’t hesitate to get in touch with us.
        </div>
        <div class="row">
            <div class="col-lg-6 mt-30">
                <form action="{{ route('contact-enquiry-submit') }}" class="form-ani" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @include('inc.messages')
                    <div class="inrow mt-0">
                        <label><span class="required">*</span> Name</label>
                        <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" />
                    </div>
                    @if ($errors->has('full_name'))
                    <span class="text-danger">&nbsp;{{ $errors->first('full_name') }}</span>
                    @endif
                    <div class="inrow">
                        <label><span class="required">*</span> Email Address</label>
                        <input type="text" class="form-control" name="email_id" value="{{ old('email_id') }}" />
                    </div>
                    @if ($errors->has('email_id'))
                    <span class="text-danger">&nbsp;{{ $errors->first('email_id') }}</span>
                    @endif <div class="row sp-col-5">
                        <div class="col-auto sp-col">
                            <div class="mt-20 wcode">
                                <input type="text" name="country_code" placeholder="+65" value="+65" class="form-control">
                                @if ($errors->has('country_code'))
                                <span class="text-danger">&nbsp;{{ $errors->first('country_code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col sp-col">
                            <div class="inrow"> <label><span class="required">*</span> Contact Number</label> <input
                                    type="text" class="form-control" name="contact_number"
                                    value="{{ old('contact_number') }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /> </div>
                            @if ($errors->has('contact_number'))
                            <span class="text-danger">&nbsp;{{ $errors->first('contact_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="url" value="">

                    <div class="inrow atop">
                        <label><span class="required">*</span> Message</label>
                        <textarea rows="6" cols="30" class="form-control" name="message">{{ old('message') }}</textarea>
                    </div>
                    @if ($errors->has('message'))
                    <span class="text-danger">&nbsp;{{ $errors->first('message') }}</span>
                    @endif
                    <div class="captcha">
                        <!-- Google reCAPTCHA widget -->
                        <div class="google-recaptcha">
                            <div class="g-recaptcha" data-callback="setResponse" data-size="invisible"
                                data-sitekey="{{config('system_settings')->recaptcha_site_key}}"></div>
                            <input type="hidden" id="captcha-response" name="captcha_response" />

                        </div>
                        <!-- Google reCAPTCHA widget -->
                    </div>
                    <div class="mt-30">
                        <button class="btn-1 minw-190" type="submit">Submit <i class="fas fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 mt-30 contact-info">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback" async defer></script>
<script>
    var onloadCallback = function () {
        grecaptcha.execute();
    };

    function setResponse(response) {
        document.getElementById('captcha-response').value = response;
    }

</script>
@endsection
