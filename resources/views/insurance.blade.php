@extends('layouts.app')

@section('content')
<?php
	$content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }

?>

<div class="main-wrap">
	@include('inc.banner')
	<div class="container main-inner">
		@php
	    $seocontent = json_decode($page->json_content);
	  @endphp
	  <div style="margin-bottom: 20px">
      {!! $seocontent->section_2 ?? '' !!}
    </div>
		<h1 class="title-1 text-center">Car Insurance</h1>
		@include('inc.breadcrumb')

		@if(!Auth::check())
		{!! $page->content !!}
		@else

		<div class="discount-wrap mb-5">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<img src="images/sale-off.jpg" alt="" />
				</div>
				<div class="col-sm-6 content">
					<h2>Promotional Discount</h2>
					<h3>(For Limited Time Only)</h3>
				</div>
			</div>
		</div>
		<div class="note-2">
			<div class="row align-items-center">
				<div class="col-xl-8 col-lg-7 col-md-8">
					<h4>Faster form filling with Singpass (Individual).</h4>
					<p>Singpass enables you to retrieve your personal data from participating Government agencies.
						With your consent, we can auto-fill this, making your application convenient.</p>
				</div>
				<div class="col-xl-4 col-lg-5 col-md-4 last">
					<a href="javascript::void(0);" onclick="callAuthoriseApi();" class="btn-6"><strong>Retrieve Myinfo</strong> <br><span>with <img
								src="images/tempt/singpass-logo.png" alt="singpass" /></span></a>
				</div>
			</div>
		</div>
		
		<!-- <div class="note-2">
			<div class="row align-items-center">
					<div class="col-xl-8 col-lg-7 col-md-8">
							<h4>Faster form filling with Singpass (Business).</h4>
							<p>Singpass enables you to retrieve your personal data from participating Government agencies.
									With your consent, we can auto-fill this, making your application convenient.</p>
					</div>
					<div class="col-xl-4 col-lg-5 col-md-4 last">
							<a href="javascript::void(0);" onclick="callAuthoriseApiBusiness();" class="btn-6"><strong>Retrieve
											Myinfo Business</strong><br> <span>with <img src="images/tempt/singpass-logo.png"
													alt="singpass" /></span></a>
					</div>
			</div>
	    </div> -->
		{{--
		<div class="note-2">
				<div class="row align-items-center">
						<div class="col-xl-8 col-lg-7 col-md-8">
								<p>Myinfo Business is currently unvailable.<br /> For business applications, kindly contact us at <a
												href="tel:8939 3383"><strong>8939 3383</strong></a> or <a
												href="mailto:info@diyicars.com"><strong>info@diyicars.com</strong></a></p>
						</div>
						<div class="col-xl-4 col-lg-5 col-md-4 last"> <a href="#myinfo" class="btn-6"
										data-toggle="modal"><strong>Retrieve Myinfo Business</strong> <br><span>with <img
														src="{{ asset('images/tempt/singpass-logo.png') }}" alt="singpass" /></span></a> </div>
				</div>
		</div>
		<div id="myinfo" class="modal pp-agreement ppbg" tabindex="-1">
				<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content"> <button type="button" class="ppclose" data-dismiss="modal" aria-label="Close"><i
												class="fas fa-times-circle"></i></button>
								<p>Myinfo Business is currently unvailable.<br /> For business applications, kindly contact us at <a
												href="tel:8939 3383"><strong>8939 3383</strong></a> or <a
												href="mailto:info@diyicars.com"><strong>info@diyicars.com</strong></a></p>
						</div>
				</div>
		</div>
		--}}
		@php 
		$addclass = '';
		if(!empty(session()->get('myinfodetails'))){
		    $data = serialize(session()->get('myinfodetails'));
		    $test = unserialize($data);
    		if(sizeof($test)>0){
						//$addclass = 'disableclass';
    		    $uinfin1 = $test['uinfin'] ?? '';
    		    $name1 = $test['name'] ?? '';
    		    $sex1 = $test['sex'] ?? '';
    		    $nationality1 = $test['nationality'] ?? '';
    		    $dob1 = date('d-m-Y', strtotime($test['dob'])) ?? '';
    		    $email1 = $test['email'] ?? '';
    		    $mobileno1 = $test['mobileno'] ?? '';
    		    $marital1 = ucfirst(strtolower($test['marital'])) ?? '';
    		    $nric = substr($uinfin1, -4) ?? '';
						$occupation = $test['occupation'] ?? '';
    		    $vehiclesNo = $test['vehiclesNo'] ?? '';
						$type = $test['type'] ?? '';
						$make = $test['make'] ?? '';
						$model = $test['model'] ?? '';
						$yearofmanufacture = $test['yearofmanufacture'] ?? '';
						if(!empty($test['originalregistrationdate']))
						{
								$originalregistrationdate = date('d-m-Y', strtotime($test['originalregistrationdate'])) ?? '';
						}else{
								$originalregistrationdate = '';
						}
				
						$make_model = $test['make_model'] ?? '';
						if(!empty($test['enginecapacity'])){
							$enginecapacity = number_format($test['enginecapacity']) ?? '';
						}else{
							$enginecapacity = '';
						}
						
						$chassisno = $test['chassisno'] ?? '';
						$primarycolour = $test['primarycolour'] ?? '';
						$scheme = $test['scheme'] ?? '';
						$propellant = $test['propellant'] ?? '';
						$engineno = $test['engineno'] ?? '';
						$address = $test['address'] ?? '';
						$employment = $test['employment'] ?? '';

						$meritstatus = $test['meritstatus'] ?? '';
						$validity = $test['validity'] ?? '';
						$drivinglicenseclass = $test['drivinglicenseclass'] ?? '';
    		}
		}else{
		    if(Auth::user()){
		        $name1 = Auth::user()->name ?? '';
		        $mobileno1 = Auth::user()->mobile;
		        $email1 = Auth::user()->email;
		        $countryCode = Auth::user()->country_code;
		        if(Auth::user()->gender==1){
    		        $sex1 = 'MALE';
    		    }elseif(Auth::user()->gender==2){
    		        $sex1 = 'FEMALE';
    		    }
		    }else{
		        $name1 = '';
		        $sex1 = '';
		        $mobileno1 = '';
		        $email1 = '';
		        $countryCode = '';
		        $primarycolour = '';
		        $propellant = '';
		    }
				$dob1 = '';
				$marital1 = '';
				$nric = '';
				$vehiclesNo = '';
				$type = '';
				$make = '';
				$model = '';
				$yearofmanufacture = '';
				$originalregistrationdate = '';
				$make_model = '';
				$enginecapacity = '';
				$occupation = '';
				$address = '';
				$employment = '';
				$meritstatus = '';
				$validity = '';
				$drivinglicenseclass = '';
				$primarycolour = '';
				$engineno = '';
				$chassisno = '';
		}
		
		if(!empty(session()->get('myinfoinsurancebusiness'))){
			$data = serialize(session()->get('myinfoinsurancebusiness'));
			$test = unserialize($data);
			if(sizeof($test)>0){
				$uinfin1 = $test['uinfin'] ?? '';
				$name1 = $test['name'] ?? '';
				$sex1 = $test['sex'] ?? '';
				$nationality1 = $test['nationality'] ?? '';
				$dob1 = date('d-m-Y', strtotime($test['dob'])) ?? '';
				$email1 = $test['email'] ?? '';
				$mobileno1 = $test['mobileno'] ?? '';
				$marital1 = ucfirst(strtolower($test['marital'])) ?? '';
				$nric = substr($uinfin1, -4) ?? '';
				$occupation = $test['occupation'] ?? '';
				$vehiclesNo = $test['vehiclesNo'] ?? '';
				$type = $test['type'] ?? '';
				$make = $test['make'] ?? '';
				$model = $test['model'] ?? '';
				$yearofmanufacture = $test['yearofmanufacture'] ?? '';
				$originalregistrationdate = date('d-m-Y', strtotime($test['originalregistrationdate'])) ?? '';
				$make_model = $test['make_model'] ?? '';
				$enginecapacity = $test['enginecapacity'] ?? '';
				$chassisno = $test['chassisno'] ?? '';
				$primarycolour = $test['primarycolour'] ?? '';
				$scheme = $test['scheme'] ?? '';
				$propellant = $test['propellant'] ?? '';
				$engineno = $test['engineno'] ?? '';
				$address = $test['address'] ?? '';
				$employment = $test['employment'] ?? '';
			}
		}
		@endphp

        @include('inc.messages')

		<form method="post" class="form-ani" action="{{ route('insurance.store') }}" enctype="multipart/form-data">
			@csrf
			<h2 class="title-2 mb-0 mt-30">Section 1: Main Driver's Particulars</h2>		 

			<div class="row">
				<div class="col-lg-4">
					<div class="inrow {{$addclass}}">
						<label>Full name</label>
						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" name="main_driver_full_name" @if(!empty($name1) && !empty(session()->get('myinfodetails'))) readonly="readonly" @endif id="main_driver_full_name"
							value="{{old('main_driver_full_name', $name1 ?? '')}}" />
						
					</div>
					@if(empty($name1) && empty(old('main_driver_full_name')) && !empty(session()->get('myinfodetails')) && !$errors->has('main_driver_full_name'))
					<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('main_driver_full_name', $name1 ?? ''))
						<span class="text-danger">&nbsp;{{ $errors->first('main_driver_full_name') }}</span>
					@endif
				</div>
				<div class="col-lg-4">
					<div class="inrow {{$addclass}}">
						<label>NRIC/FIN</label>
						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!empty($uinfin1)) readonly="readonly" @endif  name="main_driver_nric" id="main_driver_nric"
							value="{{old('main_driver_nric', $uinfin1 ?? '')}}" />
					</div>
					@if(empty($uinfin1) && empty(old('main_driver_nric')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_nric'))
					<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('main_driver_nric'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_nric') }}</span>
					@endif
				</div>
				<div class="col-lg-4">
					<div class="inrow">
						<label>Passport Number (Optional) </label>
						<input type="text" name="main_driver_passport" class="form-control @if(!Auth::check())login-popup @endif"
							value="{{old('main_driver_passport')}}" />
					</div>
					@if ($errors->has('main_driver_passport'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_passport') }}</span>
					@endif
				</div>
			</div>		
			<div class="row">
				<div class="col-xl-6">
					<div class="row sp-col-10 break-425">
						<div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
							<div class="mt-20">
								<div class="inrow {{$addclass}}">
									<label>Country Code </label>
									<input type="text" name="main_driver_country_code" class="form-control @if(!Auth::check())login-popup @endif" @if(!empty(session()->get('myinfodetails'))) readonly="readonly" @endif
										value="+65" id="countrycode" />
								</div>
								@if ($errors->has('main_driver_country_code'))
								<span class="text-danger">&nbsp;{{ $errors->first('main_driver_country_code') }}</span>
								@endif
							</div>
						</div>
						<div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
							<div class="inrow">
								<label>Mobile Number</label>
								<input type="text" class="form-control positive-integer @if(!Auth::check())login-popup @endif"
									@if(!Auth::check()) readonly="readonly" @endif name="main_driver_contact_number"
									id="main_driver_contact_number" value="{{old('main_driver_contact_number',$mobileno1 ?? '')}}" />
							</div>
							@if(empty($mobileno1) && empty(old('main_driver_contact_number')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_contact_number'))
							<span class="text-danger">This field is required</span>
							@endif
							@if ($errors->has('main_driver_contact_number'))
							<span class="text-danger">&nbsp;{{ $errors->first('main_driver_contact_number') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="inrow">
						<label>Email Address</label>
						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check())
							readonly="readonly" @endif name="main_driver_email" id="main_driver_email"
							value="{{old('main_driver_email', $email1 ?? '')}}" />
					</div>
					@if(empty($email1) && empty(old('main_driver_email')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_email'))
							<span class="text-danger">This field is required</span>
							@endif
					@if ($errors->has('main_driver_email'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_email') }}</span>
					@endif
				</div>
			</div>
			<div class="row">
					
				<div class="col-lg-3">
				@if(empty(session()->get('myinfodetails')))
					<div class="mt-20">
						<select class="selectpicker" name="main_driver_nationality" data-title="Nationality">
							@if(country())
							@foreach (country() as $item)
							<option value="{{ $item->nicename }}" @if(old('main_driver_nationality')==$item->nicename ) selected @endif>{{ $item->nicename }}</option>
							@endforeach
							@endif
						</select>
					</div>
					@if ($errors->has('main_driver_nationality'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_nationality') }}</span>
					@endif
				@else
						<div class="inrow {{$addclass}}">
							<label>Nationality</label>
							<input type="text" class="form-control" name="main_driver_nationality" value="{{ $nationality1 ?? '' }}" id="main_driver_nationality" @if(!empty($nationality1)) readonly="readonly" @endif />
						</div>
						@if(empty($nationality1) && empty(old('main_driver_nationality')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_nationality'))
							<span class="text-danger">This field is required</span>
						@endif
						@if ($errors->has('main_driver_nationality'))
						<span class="text-danger">&nbsp;{{ $errors->first('main_driver_nationality') }}</span>
						@endif
				@endif
				
				</div>
				
				<div class="col-lg-9">	
					<div class="inrow {{$addclass}}">
						<label>Registered address</label>
						<input type="text" class="form-control positive-integer @if(!Auth::check())login-popup @endif"
						@if(!empty($address)) readonly="readonly" @endif name="main_driver_address"
									id="main_driver_address" value="{{old('main_driver_address', $address ?? '')}}" />
					</div>
					@if(empty($address) && empty(old('main_driver_address')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_address'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('main_driver_address'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_address') }}</span>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-xl-4">
					<div class="mt-20 {{$addclass}}">
						@if(empty(session()->get('myinfodetails')))
						<select class="selectpicker" name="main_driver_gender" data-title="Gender">
							<option @if(old('main_driver_gender')=="Male" ) selected="selected" @elseif($sex1=='MALE')
								selected="selected" @endif value="Male">Male</option>
							<option @if(old('main_driver_gender')=="Female" ) selected="selected" @elseif($sex1=='FEMALE')
								selected="selected" @endif value="Female">Female</option>
						</select>
						@else
						<input type="text" class="form-control" value="{{ $sex1 ?? '' }}" name="main_driver_gender" id="main_driver_gender" @if(!empty($sex1)) readonly="readonly" @endif/>
						@if(empty($sex1) && empty(old('main_driver_gender')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_gender'))
						<span class="text-danger">This field is required</span>
						@endif
						@endif

						@if ($errors->has('main_driver_gender'))
						<span class="text-danger">&nbsp;{{ $errors->first('main_driver_gender') }}</span>
						@endif
					</div>
				</div>
				@if(empty(session()->get('myinfodetails')))
				<div class="col-xl-4">		
					<div class="mt-20">
						<select class="selectpicker" name="main_driver_marital_status" data-title="Marital Status">
							<option value="Single" @if($marital1 == 'Single') selected @elseif(old('main_driver_marital_status') == 'Single') selected @endif>Single</option>
							<option value="Married" @if($marital1 == 'Married') selected @elseif(old('main_driver_marital_status') == 'Married') selected @endif>Married</option>
							<option value="Divorced" @if($marital1 == 'Divorced') selected @elseif(old('main_driver_marital_status') == 'Divorced') selected @endif>Divorced</option>
							<option value="Widowed" @if($marital1 == 'Widowed') selected @elseif(old('main_driver_marital_status') == 'Widowed') selected @endif>Widowed</option>
							<option value="Separated" @if($marital1 == 'Separated') selected @elseif(old('main_driver_marital_status') == 'Separated') selected @endif>Separated</option>
						</select>
						@if ($errors->has('main_driver_marital_status'))
						<span class="text-danger">&nbsp;{{ $errors->first('main_driver_marital_status') }}</span>
						@endif
					</div>	
				</div>
				@else 
					@if(empty($marital1) && !empty(session()->get('myinfodetails')))
					<div class="col-xl-4">		
						<div class="mt-20">
							<select class="selectpicker" name="main_driver_marital_status" data-title="Marital Status">
								<option value="Single" @if($marital1 == 'Single') selected @elseif(old('main_driver_marital_status') == 'Single') selected @endif>Single</option>
								<option value="Married" @if($marital1 == 'Married') selected @elseif(old('main_driver_marital_status') == 'Married') selected @endif>Married</option>
								<option value="Divorced" @if($marital1 == 'Divorced') selected @elseif(old('main_driver_marital_status') == 'Divorced') selected @endif>Divorced</option>
								<option value="Widowed" @if($marital1 == 'Widowed') selected @elseif(old('main_driver_marital_status') == 'Widowed') selected @endif>Widowed</option>
								<option value="Separated" @if($marital1 == 'Separated') selected @elseif(old('main_driver_marital_status') == 'Separated') selected @endif>Separated</option>
							</select>
							@if(empty($marital1) && empty(old('main_driver_marital_status')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_marital_status'))
							<span class="text-danger">This field is required</span>
							@endif
							@if ($errors->has('main_driver_marital_status'))
							<span class="text-danger">&nbsp;{{ $errors->first('main_driver_marital_status') }}</span>
							@endif
						</div>	
					</div>
					@else
					<div class="col-xl-4">		
						<div class="mt-20">
							<select class="selectpicker" name="main_driver_marital_status" data-title="Marital Status">
								<option value="Single" @if($marital1 == 'Single') selected @elseif(old('main_driver_marital_status') == 'Single') selected @endif>Single</option>
								<option value="Married" @if($marital1 == 'Married') selected @elseif(old('main_driver_marital_status') == 'Married') selected @endif>Married</option>
								<option value="Divorced" @if($marital1 == 'Divorced') selected @elseif(old('main_driver_marital_status') == 'Divorced') selected @endif>Divorced</option>
								<option value="Widowed" @if($marital1 == 'Widowed') selected @elseif(old('main_driver_marital_status') == 'Widowed') selected @endif>Widowed</option>
								<option value="Separated" @if($marital1 == 'Separated') selected @elseif(old('main_driver_marital_status') == 'Separated') selected @endif>Separated</option>
							</select>
							@if ($errors->has('main_driver_marital_status'))
							<span class="text-danger">&nbsp;{{ $errors->first('main_driver_marital_status') }}</span>
							@endif
						</div>	
					</div>
					@endif
				@endif
				<div class="col-md-4 sp-col">													
					<div class="inrow date-wrap datepicker-wrap {{$addclass}}">
						<label>Date Of Birth</label>
						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!empty($dob1)) readonly="readonly" @endif name="main_driver_date_of_birth" id="main_driver_date_of_birth"
							value="{{old('main_driver_date_of_birth', $dob1 ?? '')}}" />
						<i class="fas fa-calendar-alt"></i>
					</div>
					@if(empty($dob1) && empty(old('main_driver_date_of_birth')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_date_of_birth'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('main_driver_date_of_birth'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_date_of_birth') }}</span>
					@endif
				</div>
			</div>		
			<div class="row">
				<div class="col-lg-5">
					<div class="inrow">
						<label>Occupation</label>
						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!empty($occupation)) readonly="readonly" @endif name="main_driver_occupation" id="main_driver_occupation"
							value="{{old('main_driver_occupation', $occupation ?? '')}}" />
					</div>
					@if(empty($occupation) && empty(old('main_driver_occupation')) && !empty(session()->get('myinfodetails')) && !$errors->has('main_driver_occupation'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('main_driver_occupation'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_occupation') }}</span>
					@endif
				</div>
				<div class="col-lg-7">
					<div class="inrow">
						<label>Name of employer</label>
						<input type="text" class="form-control @if(!Auth::check())login-popup @endif" @if(!empty($employment)) readonly="readonly" @endif name="main_driver_employer" id="main_driver_employer"
							value="{{old('main_driver_employer', $employment ?? '')}}" />
					</div>
					@if(empty($employment) && empty(old('main_driver_employer')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_employer'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('main_driver_employer'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_employer') }}</span>
					@endif
				</div>
				
			</div>
			<div class="row">
			    <div class="col-lg-4">
					<div class="inrow {{$addclass}}">
						<label>Qualified driving License class (Ex: 3, YYYY-MM-DD) </label>
						<input type="text" class="form-control" name="main_driver_licence_class" value="{{ old('main_driver_licence_class', $drivinglicenseclass ?? '') }}" id="main_driver_licence_class" @if(!empty($drivinglicenseclass)) readonly="readonly" @endif />
					</div>
					@if(empty($drivinglicenseclass) && empty(old('main_driver_licence_class')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_licence_class'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('main_driver_licence_class'))
					<span class="text-danger">&nbsp;{{ $errors->first('main_driver_licence_class') }}</span>
					@endif
				</div>
				<div class="col-xl-4">	
					@if(empty(session()->get('myinfodetails')))	
						<div class="mt-20">
								<select class="selectpicker" name="main_driver_licence_validity" data-title="Qualified Driving License Validity">
										<option value="Valid" @if($validity == 'Valid') selected @elseif(old('main_driver_licence_validity') == 'Valid') selected @endif>Valid</option>
										<option value="Expired" @if($validity == 'Expired') selected @elseif(old('main_driver_licence_validity') == 'Expired') selected @endif>Expired</option>
										<option value="Invalid" @if($validity == 'Invalid') selected @elseif(old('main_driver_licence_validity') == 'Invalid') selected @endif>Invalid</option>
										<option value="Not Holding QDL" @if($validity == 'Not Holding Qdl') selected @elseif(old('main_driver_licence_validity') == 'Not Holding QDL') selected @endif>Not Holding QDL</option>
									</select>
								@if ($errors->has('main_driver_licence_validity'))
									<span class="text-danger">&nbsp;{{ $errors->first('main_driver_licence_validity') }}</span>
								@endif
						</div>
					@else 
						<div class="inrow {{$addclass}}">
							<label>Qualified Driving License Validity</label>
							<input type="text" class="form-control" name="main_driver_licence_validity" value="{{ $validity ?? '' }}" id="main_driver_licence_validity" @if(!empty($validity)) readonly="readonly" @endif />
						</div>
						@if(empty($validity) && empty(old('main_driver_licence_validity')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_licence_validity'))
						<span class="text-danger">This field is required</span>
						@endif
						@if ($errors->has('main_driver_licence_validity'))
									<span class="text-danger">&nbsp;{{ $errors->first('main_driver_licence_validity') }}</span>
						@endif
					@endif
				</div>
				<div class="col-xl-4">
					@if(empty(session()->get('myinfodetails')))		
						<div class="mt-20">
								<select class="selectpicker" name="main_driver_merit_status" data-title="Certificate of merit Status *">
									<option value="Eligible" @if($meritstatus == 'Eligible') selected @elseif(old('main_driver_merit_status') == 'Eligible') selected @endif>Eligible</option>
									<option value="Not Eligible" @if($meritstatus == 'Not Eligible') selected @elseif(old('main_driver_merit_status') == 'Not Eligible') selected @endif>Not Eligible</option>
								</select>
							@if ($errors->has('main_driver_merit_status'))
							<span class="text-danger">&nbsp;{{ $errors->first('main_driver_merit_status') }}</span>
							@endif
						</div>
					@else 
					<div class="inrow {{$addclass}}">
						<label>Certificate of merit Status</label>
						<input type="text" class="form-control" name="main_driver_merit_status" value="{{ $meritstatus ?? '' }}" id="main_driver_merit_status" @if(!empty($meritstatus)) readonly="readonly" @endif />
					</div>
						@if(empty($meritstatus) && empty(old('main_driver_merit_status')) && !empty(session()->get('myinfodetails'))  && !$errors->has('main_driver_merit_status'))
							<span class="text-danger">This field is required</span>
						@endif
						@if ($errors->has('main_driver_merit_status'))
							<span class="text-danger">&nbsp;{{ $errors->first('main_driver_merit_status') }}</span>
						@endif
					@endif
					
				</div>
			</div>

			@php 
			$selectedNamedDriver = old('nameddriver') ?? '';
			if(empty($selectedNamedDriver)){
				$selectedNamedDriver = 2;
				$classNamedDriver = 'd-none';
			}else{
				if($selectedNamedDriver == 2){
					$classNamedDriver = 'd-none';
				}else{
					$classNamedDriver = '';
				}
				
			}
			@endphp
			<h2 class="title-2 mb-0 mt-30">Section 2:</h2>	
			<!-- <div class="grtype mt-20">							
				<h3 class="title-6 item"><span><strong>Named Driver: </strong></span></h3>
				<div class="check-inline check-control item">
					<div class="radio">
						<input type="radio" id="yes" name="use" value="yesdriver" />
						<label for="yes">Yes</label>
					</div>
					<div class="radio">
						<input type="radio" name="use" id="no" value="nodriver" checked />
						<label for="no">No</label>
					</div>
				</div>
			</div> -->
			<div class="grtype mt-20">
				<h3 class="title-6 item"><span><strong>Named Driver: </strong></span></h3>
				<div class="check-inline item">
					<div class="radio">
						<input type="radio" id="yes" name="nameddriver" value="1" @if($selectedNamedDriver == 1) checked @endif />
						<label for="yes">Yes</label>
					</div>
					<div class="radio">
						<input type="radio" name="nameddriver" id="no" @if($selectedNamedDriver == 2) checked @endif value="2" />
						<label for="no">No</label>
					</div>
				</div>
			</div>

			<div id="nodriver" class="check-content">	
			</div>


			<div id="namedDriver" class="{{ $classNamedDriver }}">							
				<div class="row">
					<div class="col-lg-4">
						<div class="inrow">
							<label>Full name</label>
							<input type="text" class="form-control" name="driver_full_name" value="{{ old('driver_full_name') }}" />
						</div>
						@if ($errors->has('driver_full_name'))
						<span class="text-danger">&nbsp;{{ $errors->first('driver_full_name') }}</span>
						@endif
					</div>
					<div class="col-lg-4">
						<div class="inrow">
							<label>NRIC/FIN <span class="required">*</span></label>
							<input type="text" class="form-control" name="driver_nric" value="{{ old('driver_nric') }}" />
						</div>
						@if ($errors->has('driver_nric'))
						<span class="text-danger">&nbsp;{{ $errors->first('driver_nric') }}</span>
						@endif
					</div>	
					<div class="col-lg-4">
						<div class="inrow">
							<label>Passport Number (Optional)</label>
							<input type="text" class="form-control" name="driver_passport" value="{{ old('driver_passport') }}" />
						</div>
						@if ($errors->has('driver_passport'))
					<span class="text-danger">&nbsp;{{ $errors->first('driver_passport') }}</span>
					@endif
					</div>	
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div class="mt-20">
							<select class="selectpicker" name="driver_gender" data-title="Gender">
								<option @if(old('driver_gender')=="Male" ) selected="selected" @endif value="Male">Male</option>
								<option @if(old('driver_gender')=="Female" ) selected="selected" @endif value="Female">Female</option>
							</select>
							@if ($errors->has('driver_gender'))
							<span class="text-danger">&nbsp;{{ $errors->first('driver_gender') }}</span>
							@endif
						</div>
					</div>
					<div class="col-lg-4">
						<div class="inrow date-wrap datepicker-wrap">
							<label>Date Of Birth</label>
							<input type="text" class="form-control" name="driver_date_of_birth" value="{{ old('driver_date_of_birth') }}" />
							<i class="fas fa-calendar-alt"></i>
						</div>
						@if ($errors->has('driver_date_of_birth'))
					<span class="text-danger">&nbsp;{{ $errors->first('driver_date_of_birth') }}</span>
					@endif	
					</div>
					<div class="col-lg-4">
						<div class="mt-20">
							<select class="selectpicker" name="driver_nationality" data-title="Nationality">
							@if(country())
							@foreach (country() as $item)
							<option value="{{ $item->nicename }}" @if(old('driver_nationality')==$item->nicename ) selected @endif>{{ $item->nicename }}</option>
							@endforeach
							@endif
						</select>
						@if ($errors->has('driver_nationality'))
							<span class="text-danger">&nbsp;{{ $errors->first('driver_nationality') }}</span>
						@endif
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div class="inrow">
							<label>Occupation</label>
							<input type="text" class="form-control" name="driver_occupation" value="{{ old('driver_occupation') }}" />
						</div>
						@if ($errors->has('driver_occupation'))
						<span class="text-danger">&nbsp;{{ $errors->first('driver_occupation') }}</span>
						@endif
					</div>
					<div class="col-lg-4">	
						<div class="mt-20">
							<div class="inrow">
								<label>Relation</label>
								<select class="selectpicker" name="relationship_main_driver" data-title="Relation">
									<option value="Spouse" @if(old('relationship_main_driver')=="Spouse" ) selected="selected" @endif>Spouse</option>
									<option value="Siblings" @if(old('relationship_main_driver')=="Siblings" ) selected="selected" @endif>Siblings</option>
									<option value="Friends" @if(old('relationship_main_driver')=="Friends" ) selected="selected" @endif>Friends</option>
									<option value="Others" @if(old('relationship_main_driver')=="Others" ) selected="selected" @endif>Others</option>
								</select>
								
							</div>
							@if ($errors->has('relationship_main_driver'))
							<span class="text-danger">&nbsp;{{ $errors->first('relationship_main_driver') }}</span>
							@endif
						</div>
					</div>
					<div class="col-lg-4">
						<div class="mt-20">
							<select class="selectpicker" name="driver_marital_status" data-title="Marital Status">
								<option value="Single" @if(old('driver_marital_status')=="Single" ) selected="selected" @endif>Single</option>
								<option value="Married" @if(old('driver_marital_status')=="Married" ) selected="selected" @endif>Married</option>
								<option value="Divorced" @if(old('driver_marital_status')=="Divorced" ) selected="selected" @endif>Divorced</option>
								<option value="Widowed" @if(old('driver_marital_status')=="Widowed" ) selected="selected" @endif>Widowed</option>
								<option value="Separated" @if(old('driver_marital_status')=="Separated" ) selected="selected" @endif>Separated</option>
							</select>
							@if ($errors->has('driver_marital_status'))
					<span class="text-danger">&nbsp;{{ $errors->first('driver_marital_status') }}</span>
					@endif
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div class="inrow">
							<label>Qualified driving License class (Ex: 3, YYYY-MM-DD) </label>
							<input type="text" class="form-control" name="driver_license_class" value="{{ old('driver_license_class') }}" />
						</div>
						@if ($errors->has('driver_license_class'))
						<span class="text-danger">&nbsp;{{ $errors->first('driver_license_class') }}</span>
						@endif
					</div>
					<div class="col-lg-4">
						<div class="inrow">
							<label>Qualified Driving License Validity</label>
							<select class="selectpicker" name="driver_license_validity" data-title="Qualified Driving License Validity">
								<option value="Valid" @if(old('driver_license_validity')=="Valid" ) selected="selected" @endif>Valid</option>
								<option value="Expired" @if(old('driver_license_validity')=="Expired" ) selected="selected" @endif>Expired</option>
								<option value="Invalid" @if(old('driver_license_validity')=="Invalid" ) selected="selected" @endif>Invalid</option>
								<option value="Not Holding QDL" @if(old('driver_license_validity')=="Not Holding QDL" ) selected="selected" @endif>Not Holding QDL</option>
							</select>
							
						</div>
						@if ($errors->has('driver_license_validity'))
					<span class="text-danger">&nbsp;{{ $errors->first('driver_license_validity') }}</span>
					@endif	
					</div>

					<div class="col-lg-4">
						<div class="inrow">
							<label>Certificate of Merit Status</label>
							<select class="selectpicker" name="driver_merit_status" data-title="Certificate of merit Status">
								<option value="Eligible" @if(old('driver_merit_status')=="Eligible" ) selected="selected" @endif>Eligible</option>
								<option value="Not Eligible" @if(old('driver_merit_status')=="Not Eligible" ) selected="selected" @endif>Not Eligible</option>
							</select>
						</div>
						@if ($errors->has('driver_merit_status'))
					<span class="text-danger">&nbsp;{{ $errors->first('driver_merit_status') }}</span>
					@endif	
					</div>
					
				</div>
			</div>



		@php 
		$selectedVehicle = old('vehicle') ?? '';
		if(empty($selectedVehicle)){
			if(!empty($nric)){
				$selectedVehicle = 1;
				$classVehicle1 = '';
				$classVehicle2 = 'hide';
				$disablemanual = 'disabled';
			}else{
				$selectedVehicle = 2;
				$classVehicle1 = 'hide';
				$classVehicle2 = '';
				$disablemanual = '';
			}
		}else{
			if(!empty(session()->get('myinfodetails')) && $selectedVehicle==1){
				$selectedVehicle = 1;
				$classVehicle1 = '';
				$classVehicle2 = 'hide';
				$disablemanual = 'disabled';
			}
			else{
				if($selectedVehicle == 1){
					$selectedVehicle = 1;
					$classVehicle1 = '';
					$classVehicle2 = 'hide';
					$disablemanual = '';
				}else{
					$selectedVehicle = 2;
					$classVehicle1 = 'hide';
					$classVehicle2 = '';
					$disablemanual = '';
				}
			}
			
		}
		@endphp
			<h2 class="title-2 mt-30">Vehicle Details for Insurance Quotation</h2>	
			<div class="check-inline">
				<div class="radio">
					<input type="radio" id="myinfo" name="vehicle" value="1" @if($selectedVehicle == 1) checked @endif />
					<label for="myinfo">Vehicle Information using MyInfo</label>
				</div>
				<div class="radio">
					<input type="radio" name="vehicle" id="othervehicle" @if($selectedVehicle == 2) checked @endif value="2" />
					<label for="othervehicle">Get Quotation for Other Vehicle</label>
				</div>
			</div>

			<div id="myinfoForm" class="{{ $classVehicle1 }}">
			<div class="row">
				<div class="col-lg-4">	
					<div class="inrow {{$addclass}}">
						<label>Vehicle Number</label>
						<input type="text" class="form-control" name="car_plate_no1" value="{{ old('car_plate_no1', $vehiclesNo) }}" @if(!empty($vehiclesNo)) readonly="readonly" @endif />
					</div>
					@if(empty($vehiclesNo) && empty(old('car_plate_no1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('car_plate_no1'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('car_plate_no1'))
					<span class="text-danger">&nbsp;{{ $errors->first('car_plate_no1') }}</span>
					@endif
				</div>
				<div class="col-lg-4">
					@if(!empty($scheme))
						<div class="inrow {{$addclass}}">
							<label>Vehicle Scheme (- represents normal)</label>
							<input type="text" class="form-control" name="vehicle_schme1" value="{{ $scheme ?? '' }}" @if(!empty($scheme)) readonly="readonly" @endif />
						</div>
					@else

						<div class="mt-20">
							<select class="selectpicker" name="vehicle_schme1" data-title="Vehicle Scheme (- represents normal)">
								<option value="Normal" @if(old('vehicle_schme1')=="Normal" ) selected="selected" @endif>Normal</option>
								<option value="OPC (Off Peak Car)" @if(old('vehicle_schme1')=="OPC (Off Peak Car)" ) selected="selected" @endif>OPC (Off Peak Car)</option>
								<option value="Classic" @if(old('vehicle_schme1')=="Classic" ) selected="selected" @endif>Classic</option>
								<option value="Vintage" @if(old('vehicle_schme1')=="Vintage" ) selected="selected" @endif>Vintage</option>
							</select>
						</div>
						@if(empty($scheme) && empty(old('vehicle_schme1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vehicle_schme1'))
						<span class="text-danger">This field is required</span>
						@endif
						@if ($errors->has('vehicle_schme1'))
						<span class="text-danger">&nbsp;{{ $errors->first('vehicle_schme1') }}</span>
						@endif
					@endif

				</div>
				<div class="col-lg-4">	

					@if(!empty($type))
					<div class="inrow {{$addclass}}">
						<label>Vehicle Type</label>
						<input type="text" class="form-control" name="vehicle_type1" value="{{ $type ?? '' }}" @if(!empty($type)) readonly="readonly" @endif />
					</div>
					@else
					<div class="mt-20">
						<select class="selectpicker" name="vehicle_type1" data-title="Vehicle Type">
							<option value="Mid-Sized Sedan" @if(old('vehicle_type1')=="Mid-Sized Sedan" ) selected="selected" @endif>Mid-Sized Sedan</option>
							<option value="Luxury Sedan" @if(old('vehicle_type1')=="Luxury Sedan" ) selected="selected" @endif>Luxury Sedan</option>
							<option value="Hatchback" @if(old('vehicle_type1')=="Hatchback" ) selected="selected" @endif>Hatchback</option>
							<option value="SUV" @if(old('vehicle_type1')=="SUV" ) selected="selected" @endif>SUV</option>
							<option value="Passenger Car" @if(old('vehicle_type1')=="Passenger Car" ) selected="selected" @endif>Passenger Car</option>
							<option value="MPV" @if(old('vehicle_type1')=="MPV" ) selected="selected" @endif>MPV</option>
							<option value="Station Wagon" @if(old('vehicle_type1')=="Station Wagon" ) selected="selected" @endif>Station Wagon</option>
							<option value="Sports Car" @if(old('vehicle_type1')=="Sports Car" ) selected="selected" @endif>Sports Car</option>
							<option value="Commercial Vehicle" @if(old('vehicle_type1')=="Commercial Vehicle" ) selected="selected" @endif>Commercial Vehicle</option>
							<option value="Van" @if(old('vehicle_type1')=="Van" ) selected="selected" @endif>Van</option>
							<option value="Truck" @if(old('vehicle_type1')=="Truck" ) selected="selected" @endif>Truck</option>
							<option value="Bus/Mini Bus" @if(old('vehicle_type1')=="Bus/Mini Bus" ) selected="selected" @endif>Bus/Mini Bus</option>
							<option value="Others" @if(old('vehicle_type1')=="Others" ) selected="selected" @endif>Others</option>
						</select>
						@if(empty($type) && empty(old('vehicle_type1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vehicle_type1'))
						<span class="text-danger">This field is required</span>
						@endif
						@if ($errors->has('vehicle_type1'))
						<span class="text-danger">&nbsp;{{ $errors->first('vehicle_type1') }}</span>
						@endif
					</div>
					@endif	
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">	
					<div class="inrow {{$addclass}}">
						<label>Vehicle Make (Ex: Toyota)</label>
						<input type="text" class="form-control" name="vehicle_make1" value="{{ old('vehicle_make1',$make) }}" @if(!empty($make)) readonly="readonly" @endif />
					</div>
					@if(empty($make) && empty(old('vehicle_make1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vehicle_make1'))
					<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('vehicle_make1'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_make1') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow {{$addclass}}">
						<label>Vehicle Model (Ex: Corolla)</label>
						<input type="text" class="form-control" name="vehicle_model1" value="{{ old('vehicle_model1', $model) }}" @if(!empty($model)) readonly="readonly" @endif />
					</div>
					@if(empty($model) && empty(old('vehicle_model1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vehicle_model1'))
					<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('vehicle_model1'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_model1') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow date-wrap datepicker-wrap {{$addclass}}">
						<label>Original Registration Date</label>
						<input type="text" class="form-control" value="{{ old('date_of_registration1', $originalregistrationdate) }}" name="date_of_registration1" @if(!empty($originalregistrationdate)) readonly="readonly" @endif />
						<i class="fas fa-calendar-alt"></i>
					</div>
					@if(empty($originalregistrationdate) && empty(old('date_of_registration1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('date_of_registration1'))
					<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('date_of_registration1'))
					<span class="text-danger">&nbsp;{{ $errors->first('date_of_registration1') }}</span>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
						@if(!empty($primarycolour))
						<div class="inrow {{$addclass}}">
							<label>Primary Color</label>
							<input type="text" class="form-control" name="vehicle_primary_color1" value="{{ old('vehicle_primary_color1', $primarycolour) }}" @if(!empty($primarycolour)) readonly="readonly" @endif />
						</div>
						@else
						<div class="mt-20">
							<select class="selectpicker" name="vehicle_primary_color1" data-title="Primary Color" >
								<option value="White" @if(old('vehicle_primary_color1')=="White" ) selected="selected" @endif>White</option>
								<option value="Black" @if(old('vehicle_primary_color1')=="Black" ) selected="selected" @endif>Black</option>
								<option value="Grey" @if(old('vehicle_primary_color1')=="Grey" ) selected="selected" @endif>Grey</option>
								<option value="Silver" @if(old('vehicle_primary_color1')=="Silver" ) selected="selected" @endif>Silver</option>
								<option value="Red" @if(old('vehicle_primary_color1')=="Red" ) selected="selected" @endif>Red</option>
								<option value="Blue" @if(old('vehicle_primary_color1')=="Blue" ) selected="selected" @endif>Blue</option>
								<option value="Brown" @if(old('vehicle_primary_color1')=="Brown" ) selected="selected" @endif>Brown</option>
								<option value="Green" @if(old('vehicle_primary_color1')=="Green" ) selected="selected" @endif>Green</option>
								<option value="Beige" @if(old('vehicle_primary_color1')=="Beige" ) selected="selected" @endif>Beige</option>
								<option value="Orange" @if(old('vehicle_primary_color1')=="Orange" ) selected="selected" @endif>Orange</option>
								<option value="Gold" @if(old('vehicle_primary_color1')=="Gold" ) selected="selected" @endif>Gold</option>
								<option value="Yellow" @if(old('vehicle_primary_color1')=="Yellow" ) selected="selected" @endif>Yellow</option>
								<option value="Purple" @if(old('vehicle_primary_color1')=="Purple" ) selected="selected" @endif>Purple</option>
								<option value="Pink" @if(old('vehicle_primary_color1')=="Pink" ) selected="selected" @endif>Pink</option>
								<option value="Others" @if(old('vehicle_primary_color1')=="Others" ) selected="selected" @endif>Others</option>
							</select>
								@if(empty($primarycolour) && empty(old('vehicle_primary_color1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vehicle_primary_color1'))
								<span class="text-danger">This field is required</span>
								@endif
								@if ($errors->has('vehicle_primary_color1'))
								<span class="text-danger">&nbsp;{{ $errors->first('vehicle_primary_color1') }}</span>
								@endif
						</div>
						@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow {{$addclass}}">
						<label>Year of Manufacture</label>
						<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="year_of_manufacture1" value="{{ old('year_of_manufacture1', $yearofmanufacture) }}" @if(!empty($yearofmanufacture)) readonly="readonly" @endif />
					</div>
					@if(empty($yearofmanufacture) && empty(old('year_of_manufacture1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('year_of_manufacture1'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('year_of_manufacture1'))
					<span class="text-danger">&nbsp;{{ $errors->first('year_of_manufacture1') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow {{$addclass}}">
						<label>Engine Capacity (CC)</label>
						<input id="myinfoenginecapacity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control" name="engine_capacity1" value="{{ old('engine_capacity1', $enginecapacity) }}" @if(!empty($enginecapacity)) readonly="readonly" @endif />
					</div>
					@if(empty($enginecapacity) && empty(old('engine_capacity1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('engine_capacity1'))
						<span class="text-danger">This field is required</span>
						@endif
					@if ($errors->has('engine_capacity1'))
					<span class="text-danger">&nbsp;{{ $errors->first('engine_capacity1') }}</span>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">		
					<div class="inrow {{$addclass}}">
						<label>Engine Number</label>
						<input type="text" class="form-control" name="vehicle_engine_number1" value="{{ old('vehicle_engine_number1', $engineno) }}" @if(!empty($engineno)) readonly="readonly" @endif />
					</div>
					@if(empty($engineno) && empty(old('vehicle_engine_number1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vehicle_engine_number1'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('vehicle_engine_number1'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_engine_number1') }}</span>
					@endif
				</div>
				<div class="col-lg-4">		
					<div class="inrow {{$addclass}}">
						<label>Chassis Number</label>
						<input type="text" class="form-control" name="vechile_chasis_number1" value="{{ old('vechile_chasis_number1', $chassisno) }}" @if(!empty($chassisno)) readonly="readonly" @endif/>
					</div>
					@if(empty($chassisno) && empty(old('vechile_chasis_number1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vechile_chasis_number1'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('vechile_chasis_number1'))
					<span class="text-danger">&nbsp;{{ $errors->first('vechile_chasis_number1') }}</span>
					@endif
				</div>
				<div class="col-lg-4">
					@if(!empty($propellant))
					<div class="inrow {{$addclass}}">
						<label>Propellant</label>
						<input type="text" class="form-control" name="vechile_propellant1" value="{{ $propellant ?? '' }}" @if(!empty($propellant)) readonly="readonly" @endif/>
					</div>
					@else
					<div class="mt-20">
						<select class="selectpicker" name="vechile_propellant1" data-title="Propellant">
							<option value="Compressed Natural Gas" @if(old('vechile_propellant1')=="Compressed Natural Gas" ) selected="selected" @endif>Compressed Natural Gas</option>
							<option value="Diesel" @if(old('vechile_propellant1')=="Diesel" ) selected="selected" @endif>Diesel</option>
							<option value="Diesel-CNG" @if(old('vechile_propellant1')=="Diesel-CNG" ) selected="selected" @endif>Diesel-CNG</option>
							<option value="Diesel-Electric" @if(old('vechile_propellant1')=="Diesel-Electric" ) selected="selected" @endif>Diesel-Electric</option>
							<option value="Diesel-Electric (Plug-In)" @if(old('vechile_propellant1')=="Diesel-Electric (Plug-In)" ) selected="selected" @endif>Diesel-Electric (Plug-In)</option>
							<option value="Electric" @if(old('vechile_propellant1')=="Electric" ) selected="selected" @endif>Electric</option>
							<option value="Gas" @if(old('vechile_propellant1')=="Gas" ) selected="selected" @endif>Gas</option>
							<option value="Liquefied Petroleum Gas (LPG)" @if(old('vechile_propellant1')=="Liquefied Petroleum Gas (LPG)" ) selected="selected" @endif>Liquefied Petroleum Gas (LPG)</option>
							<option value="Petrol" @if(old('vechile_propellant1')=="Petrol" ) selected="selected" @endif>Petrol</option>
							<option value="Petrol-CNG" @if(old('vechile_propellant1')=="Petrol-CNG" ) selected="selected" @endif>Petrol-CNG</option>
							<option value="Petrol-Electric" @if(old('vechile_propellant1')=="Petrol-Electric" ) selected="selected" @endif>Petrol-Electric</option>
							<option value="Petrol-Electric (Plug-In)" @if(old('vechile_propellant1')=="Petrol-Electric (Plug-In)" ) selected="selected" @endif>Petrol-Electric (Plug-In)</option>
							<option value="Petrol-LPG" @if(old('vechile_propellant1')=="Petrol-LPG" ) selected="selected" @endif>Petrol-LPG</option>
						</select>
						@if(empty($propellant) && empty(old('vechile_propellant1')) && !empty(session()->get('myinfodetails'))  && !$errors->has('vechile_propellant1'))
							<span class="text-danger">This field is required</span>
						@endif
						@if ($errors->has('vechile_propellant1'))
						<span class="text-danger">&nbsp;{{ $errors->first('vechile_propellant1') }}</span>
						@endif
					</div>
					@endif
					
				</div>
			</div>
		</div>



		<div id="notMyinfoForm" class="{{ $classVehicle2 }}">
			<div class="row">
				<div class="col-lg-4">	
					<div class="inrow">
						<label>Vehicle Number</label>
						<input type="text" class="form-control" name="car_plate_no" value="{{ old('car_plate_no') }}" />
					</div>
					@if ($errors->has('car_plate_no'))
					<span class="text-danger">&nbsp;{{ $errors->first('car_plate_no') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="mt-20">
						<select class="selectpicker" name="vehicle_schme" data-title="Vehicle Scheme (- represents normal)">
							<option value="Normal" @if(old('vehicle_schme')=="Normal" ) selected="selected" @endif>Normal</option>
							<option value="OPC (Off Peak Car)" @if(old('vehicle_schme')=="OPC (Off Peak Car)" ) selected="selected" @endif>OPC (Off Peak Car)</option>
							<option value="Classic" @if(old('vehicle_schme')=="Classic" ) selected="selected" @endif>Classic</option>
							<option value="Vintage" @if(old('vehicle_schme')=="Vintage" ) selected="selected" @endif>Vintage</option>
						</select>
						@if ($errors->has('vehicle_schme'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_schme') }}</span>
					@endif
					</div>	
				</div>
				<div class="col-lg-4">	
					<div class="inrow">
						<label>Vehicle Type</label>
						<select class="selectpicker" name="vehicle_type" data-title="Vehicle Type">
							<option value="Mid-Sized Sedan" @if(old('vehicle_type')=="Mid-Sized Sedan" ) selected="selected" @endif>Mid-Sized Sedan</option>
							<option value="Luxury Sedan" @if(old('vehicle_type')=="Luxury Sedan" ) selected="selected" @endif>Luxury Sedan</option>
							<option value="Hatchback" @if(old('vehicle_type')=="Hatchback" ) selected="selected" @endif>Hatchback</option>
							<option value="SUV" @if(old('vehicle_type')=="SUV" ) selected="selected" @endif>SUV</option>
							<option value="Passenger Car" @if(old('vehicle_type')=="Passenger Car" ) selected="selected" @endif>Passenger Car</option>
							<option value="MPV" @if(old('vehicle_type')=="MPV" ) selected="selected" @endif>MPV</option>
							<option value="Station Wagon" @if(old('vehicle_type')=="Station Wagon" ) selected="selected" @endif>Station Wagon</option>
							<option value="Sports Car" @if(old('vehicle_type')=="Sports Car" ) selected="selected" @endif>Sports Car</option>
							<option value="Commercial Vehicle" @if(old('vehicle_type')=="Commercial Vehicle" ) selected="selected" @endif>Commercial Vehicle</option>
							<option value="Van" @if(old('vehicle_type')=="Van" ) selected="selected" @endif>Van</option>
							<option value="Truck" @if(old('vehicle_type')=="Truck" ) selected="selected" @endif>Truck</option>
							<option value="Bus/Mini Bus" @if(old('vehicle_type')=="Bus/Mini Bus" ) selected="selected" @endif>Bus/Mini Bus</option>
							<option value="Others" @if(old('vehicle_type')=="Others" ) selected="selected" @endif>Others</option>
						</select>
						
					</div>	
					@if ($errors->has('vehicle_type'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_type') }}</span>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">	
					<div class="inrow">
						<label>Vehicle Make (Ex: Toyota)</label>
						<input type="text" class="form-control" name="vehicle_make" value="{{ old('vehicle_make') }}" />
					</div>
					@if ($errors->has('vehicle_make'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_make') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow">
						<label>Vehicle Model (Ex: Corolla)</label>
						<input type="text" class="form-control" name="vehicle_model" value="{{ old('vehicle_model') }}" />
					</div>
					@if ($errors->has('vehicle_model'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_model') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow date-wrap datepicker-wrap">
						<label>Original Registration Date</label>
						<input type="text" class="form-control" value="{{ old('date_of_registration') }}" name="date_of_registration" />
						<i class="fas fa-calendar-alt"></i>
					</div>
					@if ($errors->has('date_of_registration'))
					<span class="text-danger">&nbsp;{{ $errors->first('date_of_registration') }}</span>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">	
					<div class="mt-20">
						<select class="selectpicker" name="vehicle_primary_color" data-title="Primary Color" >
							<option value="White" @if(old('vehicle_primary_color')=="White" ) selected="selected" @endif>White</option>
							<option value="Black" @if(old('vehicle_primary_color')=="Black" ) selected="selected" @endif>Black</option>
							<option value="Grey" @if(old('vehicle_primary_color')=="Grey" ) selected="selected" @endif>Grey</option>
							<option value="Silver" @if(old('vehicle_primary_color')=="Silver" ) selected="selected" @endif>Silver</option>
							<option value="Red" @if(old('vehicle_primary_color')=="Red" ) selected="selected" @endif>Red</option>
							<option value="Blue" @if(old('vehicle_primary_color')=="Blue" ) selected="selected" @endif>Blue</option>
							<option value="Brown" @if(old('vehicle_primary_color')=="Brown" ) selected="selected" @endif>Brown</option>
							<option value="Green" @if(old('vehicle_primary_color')=="Green" ) selected="selected" @endif>Green</option>
							<option value="Beige" @if(old('vehicle_primary_color')=="Beige" ) selected="selected" @endif>Beige</option>
							<option value="Orange" @if(old('vehicle_primary_color')=="Orange" ) selected="selected" @endif>Orange</option>
							<option value="Gold" @if(old('vehicle_primary_color')=="Gold" ) selected="selected" @endif>Gold</option>
							<option value="Yellow" @if(old('vehicle_primary_color')=="Yellow" ) selected="selected" @endif>Yellow</option>
							<option value="Purple" @if(old('vehicle_primary_color')=="Purple" ) selected="selected" @endif>Purple</option>
							<option value="Pink" @if(old('vehicle_primary_color')=="Pink" ) selected="selected" @endif>Pink</option>
							<option value="Others" @if(old('vehicle_primary_color')=="Others" ) selected="selected" @endif>Others</option>
						</select>
						@if ($errors->has('vehicle_primary_color'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_primary_color') }}</span>
					@endif
					</div>
				</div>
				<div class="col-lg-4">	
					<div class="inrow">
						<label>Year of Manufacture</label>
						<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="year_of_manufacture" value="{{ old('year_of_manufacture') }}" />
					</div>
					@if ($errors->has('year_of_manufacture'))
					<span class="text-danger">&nbsp;{{ $errors->first('year_of_manufacture') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow inptxt">
						<label>Engine Capacity (CC)</label>
						<input id="normalenginecapacity" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="engine_capacity" value="{{ old('engine_capacity') }}" />
						<span class="txt">CC</span>
					</div>
					@if ($errors->has('engine_capacity'))
					<span class="text-danger">&nbsp;{{ $errors->first('engine_capacity') }}</span>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">		
					<div class="inrow">
						<label>Engine Number</label>
						<input type="text" class="form-control" name="vehicle_engine_number" value="{{ old('vehicle_engine_number') }}" />
					</div>
					@if ($errors->has('vehicle_engine_number'))
					<span class="text-danger">&nbsp;{{ $errors->first('vehicle_engine_number') }}</span>
					@endif
				</div>
				<div class="col-lg-4">		
					<div class="inrow">
						<label>Chassis Number</label>
						<input type="text" class="form-control" name="vechile_chasis_number" value="{{ old('vechile_chasis_number') }}" />
					</div>
					@if ($errors->has('vechile_chasis_number'))
					<span class="text-danger">&nbsp;{{ $errors->first('vechile_chasis_number') }}</span>
					@endif
				</div>
				<div class="col-lg-4">		
					<div class="mt-20">
						<select class="selectpicker" name="vechile_propellant" data-title="Propellant">
							<option value="Compressed Natural Gas" @if(old('vechile_propellant')=="Compressed Natural Gas" ) selected="selected" @endif>Compressed Natural Gas</option>
							<option value="Diesel" @if(old('vechile_propellant')=="Diesel" ) selected="selected" @endif>Diesel</option>
							<option value="Diesel-CNG" @if(old('vechile_propellant')=="Diesel-CNG" ) selected="selected" @endif>Diesel-CNG</option>
							<option value="Diesel-Electric" @if(old('vechile_propellant')=="Diesel-Electric" ) selected="selected" @endif>Diesel-Electric</option>
							<option value="Diesel-Electric (Plug-In)" @if(old('vechile_propellant')=="Diesel-Electric (Plug-In)" ) selected="selected" @endif>Diesel-Electric (Plug-In)</option>
							<option value="Electric" @if(old('vechile_propellant')=="Electric" ) selected="selected" @endif>Electric</option>
							<option value="Gas" @if(old('vechile_propellant')=="Gas" ) selected="selected" @endif>Gas</option>
							<option value="Liquefied Petroleum Gas (LPG)" @if(old('vechile_propellant')=="Liquefied Petroleum Gas (LPG)" ) selected="selected" @endif>Liquefied Petroleum Gas (LPG)</option>
							<option value="Petrol" @if(old('vechile_propellant')=="Petrol" ) selected="selected" @endif>Petrol</option>
							<option value="Petrol-CNG" @if(old('vechile_propellant')=="Petrol-CNG" ) selected="selected" @endif>Petrol-CNG</option>
							<option value="Petrol-Electric" @if(old('vechile_propellant')=="Petrol-Electric" ) selected="selected" @endif>Petrol-Electric</option>
							<option value="Petrol-Electric (Plug-In)" @if(old('vechile_propellant')=="Petrol-Electric (Plug-In)" ) selected="selected" @endif>Petrol-Electric (Plug-In)</option>
							<option value="Petrol-LPG" @if(old('vechile_propellant')=="Petrol-LPG" ) selected="selected" @endif>Petrol-LPG</option>
						</select>
						@if ($errors->has('vechile_propellant'))
					<span class="text-danger">&nbsp;{{ $errors->first('vechile_propellant') }}</span>
					@endif
					</div>
				</div>
			</div>
		</div>








		<div class="{{ $classVehicle2 }}" id="quicksubmission">
			<div class="text-center mt-30">
				<div class="title-9">Or</div>
				<h4 class="title-7 mt-20 mb-20"><span><strong>For Quick Submission</strong></span></h4>
				<p>Upload 1 document (LTA Printout OR Vehicle Registration Document)</p>
			</div>
			<div class="row">
				<div class="col-lg-6 mt-20">
					<div class="attach-box">
						<h5 class="title-9">LTA Printout</h5>
						<div class="file-wrap mt-10">
							<input class="custom-file-input text-file" type="file" id="upload_photo" onchange="removeId('upload_photo');" name="upload_photo[]" multiple>
							<span class="txt" id="id1">No file chosen</span>
							<a href="javascript::void(0);" id="removeId1" style="display: none;" onclick="removeDocument('upload_photo')">Remove</a>
							<label for="upload_photo" class="upload">Upload File</label>
						</div>
					</div>
				</div>
				<div class="col-lg-6 mt-20">
					<div class="attach-box">
						<h5 class="title-9">Vehicle Registration Document</h5>
						<div class="file-wrap mt-10">
							<input class="custom-file-input text-file" type="file" id="upload_photo2" onchange="removeId('upload_photo2');" name="upload_photo[]" multiple>
							<span class="txt" id="id2">No file chosen</span>
							<a href="javascript::void(0);" id="removeId2" style="display: none;" onclick="removeDocument('upload_photo2')">Remove</a>
							<label for="upload_photo2" class="upload">Upload File</label>
						</div>
					</div>
				</div>
			</div>
		</div>




			<hr class="mt-40"/>
			<h2 class="title-2 mt-30">No Claim Discount (NCD)</h2>
			<div class="row">
				<div class="col-lg-4">	
					<div class="inrow">
						<label>Types of Quote</label>
						<select class="selectpicker" name="type_of_quote" data-title="Types of Quote">
							<option value="Normal" @if(old('type_of_quote')=="Normal" ) selected="selected" @endif>Normal</option>
							<option value="PHV (Private Hire Vehicle)" @if(old('type_of_quote')=="PHV (Private Hire Vehicle)" ) selected="selected" @endif>PHV (Private Hire Vehicle)</option>
							<option value="Company" @if(old('type_of_quote')=="Company" ) selected="selected" @endif>Company</option>
							<option value="Rental (no-PHV)" @if(old('type_of_quote')=="Rental (no-PHV)" ) selected="selected" @endif>Rental (no-PHV)</option>
						</select>
					</div>
					@if(empty(old('type_of_quote')) && !empty(session()->get('myinfodetails'))  && !$errors->has('type_of_quote'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('type_of_quote'))
					<span class="text-danger">&nbsp;{{ $errors->first('type_of_quote') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow">
						<label>NCD (%)</label>
						<select class="selectpicker" name="ncd_percentage" data-title="NCD (%)">
							<option value="0" @if(old('ncd_percentage')=="0" ) selected="selected" @endif>0%</option>
							<option value="10" @if(old('ncd_percentage')=="10" ) selected="selected" @endif>10%</option>
							<option value="20" @if(old('ncd_percentage')=="20" ) selected="selected" @endif>20%</option>
							<option value="30" @if(old('ncd_percentage')=="30" ) selected="selected" @endif>30%</option>
							<option value="40" @if(old('ncd_percentage')=="40" ) selected="selected" @endif>40%</option>
							<option value="50" @if(old('ncd_percentage')=="50" ) selected="selected" @endif>50%</option>
							<option value="Not sure" @if(old('ncd_percentage')=="Not sure" ) selected="selected" @endif>Not sure</option>
						</select>
					</div>
					@if(empty(old('ncd_percentage')) && !empty(session()->get('myinfodetails'))  && !$errors->has('ncd_percentage'))
						<span class="text-danger">This field is required</span>
					@endif
					@if ($errors->has('ncd_percentage'))
					<span class="text-danger">&nbsp;{{ $errors->first('ncd_percentage') }}</span>
					@endif
				</div>
				<div class="col-lg-4">	
					<div class="inrow">
						<label>Previous Vehicle No.</label>
						<input type="text" class="form-control" name="previous_vehicle_no" value="{{ old('previous_vehicle_no') }}" />
					</div>
					{{--
					@if(empty(old('previous_vehicle_no')) && !empty(session()->get('myinfodetails'))  && !$errors->has('previous_vehicle_no'))
						<span class="text-danger">This field is required</span>
					@endif
					--}}
					@if ($errors->has('previous_vehicle_no'))
					<span class="text-danger">&nbsp;{{ $errors->first('previous_vehicle_no') }}</span>
					@endif
				</div>
			</div>
			<div class="checkbox mt-30">
				<input type="checkbox" id="information" name="terms_condition" value="1" required />
				<label for="information">I acknowledge and agree to the collection, use and disclosure of my personal data, which has been provided to procure insurance products & services, in accordance with the standards set out in the Singapore Personal Data Protection Act 2012. </label>
			</div>		
			<div class="output-2">
				<button class="btn-1 minw-190" type="submit">SUBMIT <i class="fas fa-arrow-right"></i></button>
			</div>
		</form>



		@endif























		
	</div>
</div>
<div class="modal fade" id="messagepp" tabindex="-1" aria-labelledby="messagepp" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<p>Oops, we noticed you are not logged in.</p>
				<p>Please login to fill out the Insurance Application Form.</p>
				<div class="mt-20">
					<a href="{{ url('login') }}" class="btn-1" style="margin-right:10px; padding-right: 30px;">Login</a>
					<a href="{{ url('register') }}" class="btn-1" style="margin-left:10px; padding-right: 30px;">Signup</a>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.hide {
		display: none
	}

	.login-popup {
		background: #e9ecef !important;
	}
</style>
@if(!empty(session()->get('myinfodetails')))
<script>
    // $('input').prop('readonly',true);
  //   $('#main_driver_full_name').prop('readonly',true);
  //   $('#main_driver_nric').prop('readonly',true);
  //   $('#main_driver_gender').prop('readonly',true);
  //   $('#countrycode').prop('readonly',true);
  //   $('#main_driver_address').prop('readonly',true);
  //   $('#main_driver_date_of_birth').prop('readonly',true);
  //   // $('#main_driver_employer').prop('readonly',true);
  //   // $('#main_driver_occupation').prop('readonly',true);
	// $('#main_driver_licence_class').prop('readonly',true);
	// $('#main_driver_licence_validity').prop('readonly',true);
	// $('#main_driver_merit_status').prop('readonly',true);
  //   $('#myinfoForm :input').prop('readonly',true);
</script>
@endif
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback" async defer></script>
@if(Auth::check())
<script>
    $('form').submit(function() {
        window.onbeforeunload = null;
    });
    window.onbeforeunload = function(event) {
        return confirm("Confirm refresh");
    };
</script>
@endif
<script>
	$(function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var auth_check = '{{ Auth::check() }}';
		
		if(auth_check == true) {
		    $('#insurance-content').hide();
		    $('#insurance-form').show();
		} else {
		    $('#insurance-content').show();
		    $('#insurance-form').hide();
// 			$("#messagepp").modal("show");
		}

		$(".login-popup").on("click", function () {
			$("#messagepp").modal("show");
		});
		$(".login-popup-radio").on("click", function () {
			if ($(this).attr('name') == 'named_driver') {
				$('input[name=' + $(this).attr('name') + ']').get(1).checked = true;
			} else if ($(this).attr('name') == 'terms_condition') {
				$('input[name=' + $(this).attr('name') + ']').get(0).checked = false;
			} else {
				$('input[name=' + $(this).attr('name') + ']').get(0).checked = true;
			}
			$("#messagepp").modal("show");
		});
		$("input[name='nameddriver']").on("change", function () {
            var nameddriver = $("input[name='nameddriver']:checked").val();
            // $("#loanperiod").addClass("d-none");
            // $("input[name='year'], input[name='month']").attr("readonly", true);
            if (nameddriver == 2) {
                $("#namedDriver").addClass("d-none");
            }
            if (nameddriver == 1) {
							$("#namedDriver").removeClass("d-none");
            }
            
        });
	});

	$('.positive-integer').numeric(
		{ negative: false }
	);
	var onloadCallback = function () {
		grecaptcha.execute();
	};

	function setResponse(response) {
		document.getElementById('captcha-response').value = response;
	}

	<?php if($errors->count()>0) { ?>
	   $('html, body').animate({
              scrollTop: $("#p1").offset().top
        }, 800);
	<?php } ?>
</script>
<script type="text/javascript">
		$('input[type=radio][name=named_driver]').change(function () {
			if (this.value == 1) {
				$("#section2").removeClass("hide");
			}
			else if (this.value == 2) {
				$("#section2").addClass("hide");
			}
		});

		$('input[type=radio][name=vehicle]').change(function () {
			if (this.value == 1) {
				$("#quicksubmission").addClass("hide");
				$("#notMyinfoForm").addClass("hide");
				$("#myinfoForm").removeClass("hide");
			}
			else if (this.value == 2) {
				// $("#section2").addClass("hide");
				$("#quicksubmission").removeClass("hide");
				$("#notMyinfoForm").removeClass("hide");
				$("#myinfoForm").addClass("hide");
			}
		});
		
		function removeId(val){
        if(val == 'upload_photo'){
            $('#removeId1').show();
        }else if(val == 'upload_photo2'){
            $('#removeId2').show();
        }
    }

    function removeDocument(val){
        if(val == 'upload_photo'){
            $('#upload_photo').val('');
            $('#id1').text('');
        }else if(val == 'upload_photo2'){
            $('#upload_photo2').val('');
            $('#id2').text('');
        }
    }

		$(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
            });
</script>
<script>
	$(function () {
        $("#myinfoenginecapacity,#normalenginecapacity").on('keyup', function () {
            // $(this).val(numberWithCommas(parseFloat($(this).val().replace(/,/g, ""))));
            if($(this).val() == ''){
            }else{
                $(this).val(numberWithCommas(parseFloat($(this).val().replace(/,/g, ""))));
            }
        });
    });
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
	function callAuthoriseApi() {
		let authApiUrl = 'https://api.myinfo.gov.sg/com/v3/authorise';
		let clientId = 'PROD-200501881C-AUTOLINK-CARINSURANCE';
		let redirectUrl = 'https://www.diycars.com/car-insurance/callback';
		let attributes = 'uinfin,name,sex,nationality,dob,email,mobileno,regadd,marital,vehicles.vehicleno,vehicles.type,vehicles.make,vehicles.model,vehicles.yearofmanufacture,vehicles.originalregistrationdate,vehicles.enginecapacity,vehicles.type,vehicles.chassisno,vehicles.primarycolour,vehicles.scheme,vehicles.enginecapacity,vehicles.propellant,vehicles.engineno,drivinglicence.comstatus,drivinglicence.qdl.validity,drivinglicence.qdl.classes';
		let purpose = 'state the purpose of requesting the data. This will be shown to the Entity when requesting for their consent';
		let state = 'D43IoH6a64FuAujEgd5Hq29pfcydnAIFvouQ9rVt1642739624';
      var authoriseUrl = authApiUrl +
        "?client_id=" + clientId +
        "&attributes=" + attributes +
        "&purpose=" + purpose +
        "&state=" + state +
        "&redirect_uri=" + redirectUrl;
         
        window.location = authoriseUrl;
    }
    
    function callAuthoriseApiBusiness() {
        let authApiUrl = 'https://api.myinfo.gov.sg/biz/v2/authorise';
        let clientId = 'PROD-200501881C-AUTOLINK-MIB-CARINSURANCE';
        let redirectUrl = 'https://www.diycars.com/mib-car-insurance/callback';
        let attributes = 'uinfin,name,sex,nationality,dob,email,mobileno,regadd,marital';
        let purpose = 'state the purpose of requesting the data. This will be shown to the Entity when requesting for their consent';
        let state = 'D43IoH6a64FuAujEgd5Hq29pfcydnAIFvouQ9rVt1642739624';
        var authoriseUrl = authApiUrl +
            "?client_id=" + clientId +
            "&attributes=" + attributes +
            "&purpose=" + purpose +
            "&state=" + state +
            "&redirect_uri=" + redirectUrl;

        window.location = authoriseUrl;
    }
</script>
@endsection