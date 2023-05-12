@extends('layouts.app')

@section('content')
<div class="main-wrap">
    <div class="bn-inner bg-get-image">
        <img class="bgimg" src="images/tempt/bn-loan.jpg" alt="Loan" />
    </div>
    <div class="container main-inner">
        <h1 class="title-1 text-center">Car Loan</h1>
        <ul class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Loan</li>
        </ul>

        @php
	    $seocontent = json_decode($page->json_content);
	    @endphp

        <h2 class="title-2" id="car-loan">DIY Cars - Car Loan Singapore</h2>
        <div style="margin-bottom: 20px">
            {!! $seocontent->section_1 ?? '' !!}
        </div>
        <div class="row grid-1">
            <div class="col-md-4">
                <div class="inner">
                    <figure><img src="images/tempt/img-apply.jpg" alt="" /></figure>
                    <div class="number">1</div>
                    <h3>APPLY</h3>
                    <p>Submit loan information on line via DIY Car Loan</p>
                    <div class="type">Time Required: 5-10 Mins</div>
                    <p class="mt-30">Submit confidential income proof using MyInfo (Singpass)</p>
                    <div class="type">Time Required: 2 Mins</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="inner">
                    <figure><img src="images/tempt/img-approve.jpg" alt="img-approve" /></figure>
                    <div class="number">2</div>
                    <h3>APPROVE</h3>
                    <p>Receive approval notification almost immediately (terms &amp; conditions applies*</p>
                    <div class="type">Time Required: As fast as 60 Secs</div>
                    <p class="mt-30">*Subject to Credit Bureau, Income and Valuation clearance</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="inner">
                    <figure><img src="images/tempt/img-accept.jpg" alt="Accept" /></figure>
                    <div class="number">3</div>
                    <h3>ACCEPT</h3>
                    <p>Accept loan approval via MyInfo (Singpass)</p>
                    <div class="type">Time Required: 2 MinS</div>
                </div>
            </div>
        </div>
        <h2 class="title-2 mt-50 mt-991-30" id="bank-interest">Bank Interest Rate Table</h2>
        <div style="margin-bottom: 20px">
            {!! $seocontent->section_2 ?? '' !!}
        </div>
        <div class="table-responsive">
            <table class="tb-1">
                <thead>
                    <tr>
                        <th><span class="mr-2">Bank and Finance Company</span> <i class="far fa-credit-card"></i></th>
                        <th><span class="mr-2">Lowest Interest Rate</span> <i class="fas fa-percent"></i></th>
                        <th><span class="mr-2">Terms and Conditions</span> <i class="fas fa-file-alt"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if(getBankDetail())
                    @foreach (getBankDetail() as $value)
                    <tr>
                        <td><strong>{{ $value->title ?? '' }}</strong></td>
                        <td>{{ $value->interest ?? 0 }}%</td>
                        <td>{{ $value->terms_and_condition ?? '' }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <h2 class="title-2 mt-50 mt-991-30" id="loan-calculator">Car Loan Calculator Using Lowest Interest Rate</h2>
        <div style="margin-bottom: 20px">
            {!! $seocontent->section_3 ?? '' !!}
        </div>
        <div class="box-wrap">
            <div class="row">
                <div class="col-lg-4">
                    <label>Number of Installment (Months)</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="loan_tenor" minlength="4" maxlength="4" class="form-control"
                            placeholder="Enter months" />
                    </div>
                </div>
                <div class="col-lg-4 mt-991-20">
                    <label>Purchase Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text type">S$</span>
                        </div>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="purchase_price" class="form-control positive-integer" id="purchaseCalPrice"
                            placeholder="Enter amount" />
                    </div>
                </div>
                <div class="col-lg-4 mt-991-20">
                    <label>Downpayment</label>
                    <select class="selectpicker" name="downpayment" id="selDownPayment" data-title="Select Percentage">
                        <option value="30">30%</option>
                        <option value="40">40%</option>
                    </select>
                </div>
            </div>
            <div class="output text-center">
                <button class="btn-1 minw-190 popup_price_chart" type="submit" >CALCULATE <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
        <div id="showcalculation"></div>
        <!-- <div class="modal fade pp-cash" id="pp-cash">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        <div class="table-responsive content_display">
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        @if(Auth::check())
        <div class="note-2" id="apply-loan">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-7 col-md-8">
                    <h4>Faster form filling with Singpass  (Individual).</h4>
                    <p>Singpass enables you to retrieve your personal data from participating Government agencies.
                        With your consent, we can auto-fill this, making your application convenient.</p>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-4 last">
                    <a href="javascript::void(0);" onclick="callAuthoriseApi();" class="btn-6"><strong>Retrieve
                            Myinfo</strong> <br> <span>with <img src="images/tempt/singpass-logo.png"
                                alt="singpass" /></span></a>
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
                            Myinfo Business</strong> <br> <span>with <img src="images/tempt/singpass-logo.png"
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
                            href="mailto:info@diycars.com"><strong>info@diycars.com</strong></a></p>
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
                            href="mailto:info@diycars.com"><strong>info@diycars.com</strong></a></p>
                </div>
            </div>
        </div>
        --}}
        @endif
        @php
        if(!empty(session()->get('myinfoloan'))){
            $data = serialize(session()->get('myinfoloan'));
            $test = unserialize($data);
            if(sizeof($test)>0){
                $uinfin1 = $test['uinfin'] ?? '';
                $name1 = $test['name'] ?? '';
                $sex1 = $test['sex'] ?? '';
                $nationality1 = $test['nationality'] ?? '';
                $dob1 = date('d-m-Y', strtotime($test['dob'])) ?? '';
                $email1 = $test['email'] ?? '';
                $mobileno1 = $test['mobileno'] ?? '';
                $marital1 = $test['marital'] ?? '';
                $nric = substr($uinfin1, -4) ?? '';
                $countryCode = $test['countryCode'] ?? '';
                $cpfhistory = $test['cpfhistory'] ?? '';
                $noahistory = $test['noahistory'] ?? '';
                $employment = $test['employment'] ?? '';
                $occupation = $test['occupation'] ?? '';
                $address = $test['address'] ?? '';
            }
        }else{
            if(Auth::user()){
                $name1 = Auth::user()->name ?? '';
                $mobileno1 = Auth::user()->mobile;
                $email1 = Auth::user()->email;
                $countryCode = Auth::user()->country_code;
                $cpfhistory = '';
                $noahistory = '';
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
                $cpfhistory = '';
                $noahistory = '';
                $employment = '';
                $occupation = '';
            }
            $dob1 = '';
            $marital1 = '';
            $nric = '';
            $address = '';
        }

        @endphp

        @php
        if(!empty(session()->get('myinfoloanbusiness'))){
            $data = serialize(session()->get('myinfoloanbusiness'));
            $test = unserialize($data);
            if(sizeof($test)>0){
                $uinfin1 = $test['uinfin'] ?? '';
                $name1 = $test['name'] ?? '';
                $sex1 = $test['sex'] ?? '';
                $nationality1 = $test['nationality'] ?? '';
                $dob1 = date('d-m-Y', strtotime($test['dob'])) ?? '';
                $email1 = $test['email'] ?? '';
                $mobileno1 = $test['mobileno'] ?? '';
                $marital1 = $test['marital'] ?? '';
                $nric = substr($uinfin1, -4) ?? '';
                $countryCode = $test['countryCode'] ?? '';
                $cpfhistory = $test['cpfhistory'] ?? '';
                $noahistory = $test['noahistory'] ?? '';
            }
        }

        @endphp

        <div id="apply-loan-content">
		    <div class="container">
		        <div class="row">
		            <div class="col mt-5 text-center">
		                <h2>Get Your Pre-Approved Car Loan Now!</h2><br>
		                <a href="{{ url('login') }}" class="btn-1">Apply <i class="fas fa-arrow-right"></i></a>
		            </div>
		        </div>
		    </div>
		</div>

		<div id="apply-loan-form">

        <h2 class="title-2 mt-50 mt-991-30">Apply Loan</h2>

        <form action="{{ url('loan/update') }}" method="POST" class="form-ani" enctype="multipart/form-data">
            @csrf
            <div class="form-ani">
                <h3 class="title-6"><span><strong>Vehicle Information of The Car You’re Purchasing </strong></span></h3>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="inrow">
                            <label>Vehicle No. (Ex: SBY1234A)</label>
                            <input type="text" name="vehicle_registration_no"
                                class="form-control @if(!Auth::check())login-popup @endif" @if(!Auth::check())
                                readonly="readonly" @endif value="{{ old('vehicle_registration_no') }}" />
                        </div>
                        @if(empty(old('vehicle_registration_no')) && !empty(session()->get('myinfoloan')) && !$errors->has('vehicle_registration_no'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('vehicle_registration_no'))
                        <span class="text-danger d-block">
                           {{ $errors->first('vehicle_registration_no') }}
                        </span>
                        @endif
                    </div>
                    @php
                    $selectedDropdown = old('owner_id_type') ?? '';
                    @endphp
                    <div class="col-lg-4">
                        <select name="owner_id_type"  class="selectpicker mt-20" data-title="Select Owner ID Type">
							<option value="Business" @if($selectedDropdown == 'Business') selected @endif>Business (e.g. 51234567M)</option>
                            <option value="Club/Association/Organisation"  @if($selectedDropdown == 'Club/Association/Organisation') selected @endif>Club/Association/Organisation (e.g. T08PQ1234A)</option>
                            <option value="Company"  @if($selectedDropdown == 'Company') selected @endif>Company (e.g. 198912345K)</option>
                            <option value="Foreign Company"  @if($selectedDropdown == 'Foreign Company') selected @endif>Foreign Company (e.g. T08FC1234A)</option>
                            <option value="Foreign Identification Number"  @if($selectedDropdown == 'Foreign Identification Number') selected @endif>Foreign Identification Number (e.g. F/G/M1234567N)</option>
                            <option value="Foreign Passport"  @if($selectedDropdown == 'Foreign Passport') selected @endif>Foreign Passport (e.g. 12345678)</option>
                            <option value="Government"  @if($selectedDropdown == 'Government') selected @endif>Government (e.g. T08GA1234A)</option>
                            <option value="Limited Liability Partnership"  @if($selectedDropdown == 'Limited Liability Partnership') selected @endif>Limited Liability Partnership (e.g. T08LL1234A)</option>
                            <option value="Limited Partnership"  @if($selectedDropdown == 'Limited Partnership') selected @endif>Limited Partnership (e.g. T08LP1234A)</option>
                            <option value="Malaysia NRIC"  @if($selectedDropdown == 'Malaysia NRIC') selected @endif>Malaysia NRIC (e.g. 200312345678)</option>
                            <option value="Professional"  @if($selectedDropdown == 'Professional') selected @endif>Professional (e.g. T08PQ1234A)</option>
                            <option value="Singapore NRIC"  @if($selectedDropdown == 'Singapore NRIC') selected @endif>Singapore NRIC (e.g. S1234567D)</option>
                            <option value="Statutory Board"  @if($selectedDropdown == 'Statutory Board') selected @endif>Statutory Board (e.g. T08GB1234A)</option>
                        </select>
                        @if(empty(old('owner_id_type')) && !empty(session()->get('myinfoloan')) && !$errors->has('owner_id_type'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('owner_id_type'))
                        <span class="text-danger d-block">
                           {{ $errors->first('owner_id_type') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow">
                            <label>Owner's ID: (Last 4 Char. Ex: 123A)</label>
                            <input name="nric_company_registration_no" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('nric_company_registration_no') }}" maxlength="4" minlength="4"
                                @if(!Auth::check()) readonly="readonly" @endif />
                        </div>
                        @if(empty(old('nric_company_registration_no')) && !empty(session()->get('myinfoloan')) && !$errors->has('nric_company_registration_no'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('nric_company_registration_no'))
                        <span class="text-danger d-block">
                            {{ $errors->first('nric_company_registration_no') }}
                        </span>
                        @endif
                    </div>
                </div>
                <h3 class="title-6"><span><strong>Applicant’s Information</strong></span></h3>
                <div class="row">
                    <!-- <div class="col-lg-4">
                    <div class="mt-20">
                        <select class="selectpicker" name="salutation">
                            <option>Salutation</option>
                            <option value="aa">Option 1</option>
                            <option value="bb">Option 2</option>
                            <option value="cc">Option 3</option>
                            <option value="dd">Option 4</option>
                        </select>
                    </div>
                </div> -->
                    <div class="col-lg-6">
                        <div class="inrow">
                            <label>Full Name as in NRIC/Passport</label>
                            <input type="text" name="applicant_name" @if(!empty($name1) && !empty(session()->get('myinfoloan'))) readonly="readonly" @endif
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('applicant_name', $name1 ?? '') }}" />
                        </div>
                        @if(empty($name1) && empty(old('applicant_name')) && !empty(session()->get('myinfoloan')) && !$errors->has('applicant_name'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('applicant_name'))
                        <span class="text-danger d-block">
                            {{ $errors->first('applicant_name') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-3">
                        <div class="inrow">
                            <label>NRIC/FIN</label>
                            <input type="text" class="form-control @if(!Auth::check())login-popup @endif" id="nric"
                                name="owner_nric" value="{{ old('owner_nric', $uinfin1 ?? '') }}" @if(!empty($uinfin1)) readonly="readonly" @endif />
                        </div>
                        <div class="note-4">*Full ID Required for Loan Application</div>
                        @if(empty($uinfin1) && empty(old('owner_nric')) && !empty(session()->get('myinfoloan')) && !$errors->has('owner_nric'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('owner_nric'))
                        <span class="text-danger d-block">
                            {{ $errors->first('owner_nric') }}
                        </span>
                        @endif

                    </div>
                    <div class="col-lg-3">
                        <div class="inrow">
                            <label>Passport (Optional)</label>
                            <input type="text" name="passport" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif" value="{{ old('passport') }}"
                                 />
                        </div>
                        @if ($errors->has('passport'))
                        <span class="text-danger d-block">
                            {{ $errors->first('passport') }}
                        </span>
                        @endif
                        <!-- <div class="note-4">*Full ID Required for Loan Application</div> -->
                    </div>
                </div>
                <div class="row">

                    <!-- <div class="col-lg-4">
                    <div class="inrow">
                        <label>UEN</label>
                        <input type="text" name="uen" type="text"
                        class="form-control @if(!Auth::check())login-popup @endif"
                        value="{{ old('uen') }}"  @if(!Auth::check())
                        readonly="readonly" @endif />
                    </div>
                    <div class="note-4">*Full ID Required for Loan Application</div>
                </div> -->

                </div>
                <div class="row">
                    <div class="col-xl-5 col-lg-6">
                        <div class="row sp-col-10 break-425">
                            <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                                @if(empty(session()->get('myinfoloan')))
                                <div class="mt-20">
                                    <select class="selectpicker" name="country_code" data-title="Country Code" >
                                        <option value="+65" @if(old('country_code')=="+65" ) selected="selected" @elseif(empty(old('country_code'))) selected @endif>+65</option>
                                        <option value="+66" @if(old('country_code')=="+66" ) selected="selected" @endif>+66</option>
                                        <option value="+673" @if(old('country_code')=="+673" ) selected="selected" @endif>+673</option>

                                    </select>
                                    @if ($errors->has('country_code'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('country_code') }}
                                    </span>
                                    @endif
                                </div>
                                @else 
                                    @if(empty($countryCode))
                                    <div class="mt-20">
                                        <select class="selectpicker" name="country_code" data-title="Country Code" >
                                            <option value="+65" @if(old('country_code')=="+65" ) selected="selected" @elseif(empty(old('country_code'))) selected @endif>+65</option>
                                            <option value="+66" @if(old('country_code')=="+66" ) selected="selected" @endif>+66</option>
                                            <option value="+673" @if(old('country_code')=="+673" ) selected="selected" @endif>+673</option>
    
                                        </select>
                                        @if(empty($countryCode) && empty(old('country_code')) && !empty(session()->get('myinfoloan')) && !$errors->has('country_code'))
                                        <span class="text-danger">This field is required</span>
                                        @endif
                                        @if ($errors->has('country_code'))
                                        <span class="text-danger d-block">
                                           {{ $errors->first('country_code') }}
                                        </span>
                                        @endif
                                    </div>
                                    @else 
                                    <div class="inrow">
                                        <label>Contact No.</label>
                                        <input name="country_code" type="text" @if(!empty($countryCode)) readonly="readonly" @endif
                                        class="form-control" 
                                        value="{{ $countryCode ?? '' }}" />
                                    </div>
                                    @endif
                                @endif
                            </div>
                            <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                                <div class="inrow">
                                    <label>Contact No.</label>
                                    <input name="applicant_contact" type="text"
                                        class="form-control @if(!Auth::check())login-popup @endif"
                                        value="{{ old('applicant_contact', $mobileno1 ?? '') }}" />
                                </div>
                                @if(empty($mobileno1) && empty(old('applicant_contact')) && !empty(session()->get('myinfoloan')) && !$errors->has('applicant_contact'))
                                <span class="text-danger">This field is required</span>
                                @endif
                                @if ($errors->has('applicant_contact'))
                                <span class="text-danger d-block">
                                    {{ $errors->first('applicant_contact') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="inrow">
                            <label>Email Address (Ex: janedoe@gmail.com)</label>
                            <input name="applicant_email" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('applicant_email', $email1 ?? '') }}" />
                        </div>
                        @if(empty($email1) && empty(old('applicant_email')) && !empty(session()->get('myinfoloan')) && !$errors->has('applicant_email'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('applicant_email'))
                        <span class="text-danger d-block">
                           {{ $errors->first('applicant_email') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                    @if(empty(session()->get('myinfoloan')))
                        <div class="mt-20">
                            <select class="selectpicker" name="nationality" data-title="Nationality">
                                @if(country())
                                @foreach (country() as $item)
                                <option value="{{ $item->nicename }}" @if(old('nationality')==$item->nicename ) selected @endif>{{ $item->nicename }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('nationality'))
                        <span class="text-danger d-blockr">{{ $errors->first('nationality') }}</span>
                        @endif
					@else
                        @if(empty($nationality1))
                            <div class="mt-20">
                                <select class="selectpicker" name="nationality" data-title="Nationality">
                                    @if(country())
                                    @foreach (country() as $item)
                                    <option value="{{ $item->nicename }}" @if(old('nationality')==$item->nicename ) selected @endif>{{ $item->nicename }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if(empty($nationality1) && empty(old('nationality')) && !empty(session()->get('myinfoloan')) && !$errors->has('nationality'))
                                <span class="text-danger">This field is required</span>
                                @endif
                                @if ($errors->has('nationality'))
                                <span class="text-danger d-block">{{ $errors->first('nationality') }}</span>
                                @endif
                            </div>
                           
                        @else
                            <div class="inrow">
                                <label>Nationality</label>
                                <input type="text" @if(!empty($nationality1)) readonly="readonly" @endif class="form-control" name="nationality" value="{{ $nationality1 ?? '' }}" id="nationality" readonly />
                            </div>
                        @endif
                    @endif
                        {{--
                        <div class="mt-20">
                            <select class="selectpicker" name="nationality">
                                <option value="Singapore">Singapore</option>
                            </select>
                        </div>
                        --}}
                    </div>
                    <div class="col-lg-8">
                        <div class="inrow">
                            <label>Address (Block Number), (Street Name), (Floor)-(Unit Number), Singapore (Postal Code)</label>
                            <input name="address" @if(!empty($address)) readonly="readonly" @endif id="address" type="text" class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('address', $address ?? '') }}" />
                        </div>
                        @if(empty($address) && empty(old('address')) && !empty(session()->get('myinfoloan')) && !$errors->has('address'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('address'))
                        <span class="text-danger d-block">
                            {{ $errors->first('address') }}
                        </span>
                        @endif
                    </div>
                    {{-- <div class="col-lg-3">
                        <div class="inrow">
                            <label>Postal Code</label>
                            <input name="postal_code" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('postal_code') }}" />
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        @if(empty(session()->get('myinfoloan')))
                        <div class="mt-20">
                            <select class="selectpicker" name="gender" data-title="Gender">
                                <option value="Male" @if($sex1 == 'MALE') selected @elseif(old('gender') == 'Male') selected @endif>Male</option>
                                <option value="Female" @if($sex1 == 'FEMALE') selected @elseif(old('gender') == 'Female') selected @endif>Female</option>
                            </select>
                            @if ($errors->has('gender'))
                            <span class="text-danger d-block">
                                {{ $errors->first('gender') }}
                            </span>
                            @endif
                        </div>
                        @else
                            @if(empty($sex1))
                                <div class="mt-20">
                                    <select class="selectpicker" name="gender" data-title="Gender">
                                        <option value="Male" @if($sex1 == 'MALE') selected @elseif(old('gender') == 'Male') selected @endif>Male</option>
                                        <option value="Female" @if($sex1 == 'FEMALE') selected  @elseif(old('gender') == 'Female') selected @endif>Female</option>
                                    </select>
                                    @if(empty($sex1) && empty(old('gender')) && !empty(session()->get('myinfoloan')) && !$errors->has('gender'))
                                    <span class="text-danger">This field is required</span>
                                    @endif
                                    @if ($errors->has('gender'))
                                    <span class="text-danger d-block">
                                       {{ $errors->first('gender') }}
                                    </span>
                                    @endif
                                </div>
                               
                            @else
                                <div class="inrow">
                                    <label>Gender</label>
                                    <input name="gender" type="text" id="gender" @if(!empty($sex1)) readonly="readonly" @endif
                                        class="form-control" value="{{ $sex1 }}" />
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="mt-20">
                            <select class="selectpicker" name="marital_status" data-title="Marital Status">
                                <option value="single" @if($marital1 == 'SINGLE') selected @elseif(old('marital_status') == 'single') selected @endif>Single</option>
                                <option value="married" @if($marital1 == 'MARRIED') selected @elseif(old('marital_status') == 'married') selected @endif>Married</option>

                            </select>
                            @if(empty($marital1) && empty(old('marital_status')) && !empty(session()->get('myinfoloan')) && !$errors->has('marital_status'))
                            <span class="text-danger">This field is required</span>
                            @endif
                            @if ($errors->has('marital_status'))
                            <span class="text-danger d-block">
                               {{ $errors->first('marital_status') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow date-wrap datepicker-wrap">
                            <label>Date Of Birth</label>
                            <input name="dob" @if(!empty($dob1)) readonly="readonly" @endif type="text" id="dob" class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('dob', $dob1) }}" />
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        @if(empty($dob1) && empty(old('dob')) && !empty(session()->get('myinfoloan')) && !$errors->has('dob'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('dob'))
                            <span class="text-danger d-block">
                               {{ $errors->first('dob') }}
                            </span>
                            @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="inrow">
                            <label>Name of Employer</label>
                            <input name="company_name" type="text" id="employername"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('company_name', $employment ?? '') }}" />
                        </div>
                        @if(empty($employment) && empty(old('company_name')) && !empty(session()->get('myinfoloan')) && !$errors->has('company_name'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('company_name'))
                            <span class="text-danger d-block">
                                {{ $errors->first('company_name') }}
                            </span>
                            @endif
                    </div>
                    <div class="col-lg-5">
                        <div class="inrow">
                            <label>Employer’s Address</label>
                            <input name="company_address" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('company_address') }}" />
                        </div>
                        @if(empty(old('company_address')) && !empty(session()->get('myinfoloan')) && !$errors->has('company_address'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('company_address'))
                        <span class="text-danger d-block">
                            {{ $errors->first('company_address') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-3">
                        <div class="inrow">
                            <label>Employer’s Postal Code</label>
                            <input name="company_postal_code" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="4" maxlength="6"
                                value="{{ old('company_postal_code') }}" />
                        </div>
                        @if(empty(old('company_postal_code')) && !empty(session()->get('myinfoloan')) && !$errors->has('company_postal_code'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('company_postal_code'))
                        <span class="text-danger d-block">
                           {{ $errors->first('company_postal_code') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="inrow">
                            <label>Occupation</label>
                            <input name="occupation" type="text" id="occupation"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('occupation',$occupation ?? '') }}" />
                        </div>
                        @if(empty($occupation) && empty(old('occupation')) && !empty(session()->get('myinfoloan')) && !$errors->has('occupation'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('occupation'))
                        <span class="text-danger d-block">
                            {{ $errors->first('occupation') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="inrow">
                            <label>Period of Service (Years)</label>
                            <input name="service_period_year" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('service_period_year') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="2" maxlength="4" />
                        </div>
                        @if(empty(old('service_period_year')) && !empty(session()->get('myinfoloan')) && !$errors->has('service_period_year'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('service_period_year'))
                        <span class="text-danger d-block">
                           {{ $errors->first('service_period_year') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="inrow">
                            <label>Period of Service (Months)</label>
                            <input name="service_period_month" type="text"
                                class="form-control @if(!Auth::check())login-popup @endif"
                                value="{{ old('service_period_month', 0) }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="1" maxlength="2" />
                        </div>
                        @if ($errors->has('service_period_month'))
                        <span class="text-danger d-block">
                            {{ $errors->first('service_period_month') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="inrow inptxt lefttxt empty">                             <label>Monthly Salary</label>                            <span class="txt">$</span>
                           
                            <input name="monthly_salary" type="text" id="monthly_salary" class="form-control" value="{{ old('monthly_salary') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                        </div>
                        @if(empty(old('monthly_salary')) && !empty(session()->get('myinfoloan')) && !$errors->has('monthly_salary'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('monthly_salary'))
                        <span class="text-danger d-block">
                            {{ $errors->first('monthly_salary') }}
                        </span>
                        @endif
                    </div>
                </div>



                @if(!empty($cpfhistory))

                <h3 class="title-6"><span><strong>CPF Contribution History</strong></span></h3>
                    <table class="tb-1 mt-3">
                        <tr>
                            <th colspan="4" style="background: #eeeeee; color: #aaaaaa;"><h4 class="mb-0">Employment Contributions</h4></th>
                        </tr>
                        <tr>
                            <th class="text-center">Month</th>
                            <th class="text-center">Paid On</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Employer</th>
                        </tr>

                        @foreach($cpfhistory as $histroy)
                        <tr>
                            <td><strong>{{ strtoupper( date('M Y', strtotime( $histroy['month']['value'] ) ) ) }}</strong></td>
                            <td>{{ date('d M Y', strtotime( $histroy['date']['value'] ) ) }}</td>
                            <td>${{ number_format( $histroy['amount']['value'], 2 ) }}</td>
                            <td>{{ $histroy['employer']['value'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                @endif


                @if(!empty($noahistory))
                <h3 class="title-6"><span><strong>Notice Of Assessment (Detailed)</strong></span></h3>
                    <table class="tb-1 mt-3">
                        <tr>
                            <th><strong>Year of Assessment:</strong> {{ $noahistory[0]['yearofassessment']['value'] }}</th>
                            <th><strong>Year of Assessment:</strong> {{ $noahistory[1]['yearofassessment']['value'] }}</th>

                        </tr>

                        <tr>
                            <td><strong>Type:</strong> {{ $noahistory[0]['category']['value'] }}</td>
                            <td><strong>Type:</strong> {{ $noahistory[1]['category']['value'] }}</td>

                        </tr>

                        <tr>
                            <td><strong>Assesable Income:</strong> ${{ number_format( $noahistory[0]['amount']['value'], 2 ) }}</td>
                            <td><strong>Assesable Income:</strong> ${{ number_format( $noahistory[1]['amount']['value'], 2 ) }}</td>

                        </tr>

                        <tr>
                            <td>
                                <strong>Income Breakdown:</strong>
                                <ul>
                                    <li>Employment: ${{ number_format( $noahistory[0]['employment']['value'], 2 ) }}</li>
                                    <li>Trade: ${{ number_format( $noahistory[0]['trade']['value'], 2 ) ?? 0 }}</li>
                                    <li>Rent: ${{ number_format( $noahistory[0]['rent']['value'], 2 ) ?? 0 }}</li>
                                    <li>Interest: ${{ number_format( $noahistory[0]['interest']['value'], 2 ) ?? 0 }}</li>
                                </ul>
                            </td>
                            <td>
                                <strong>Income Breakdown:</strong>
                                <ul>
                                    <li>Employment: ${{ number_format( $noahistory[1]['employment']['value'], 2 ) }}</li>
                                    <li>Trade: ${{ number_format( $noahistory[1]['trade']['value'], 2 ) ?? 0 }}</li>
                                    <li>Rent: ${{ number_format( $noahistory[1]['rent']['value'], 2 ) ?? 0 }}</li>
                                    <li>Interest: ${{ number_format( $noahistory[1]['interest']['value'], 2 ) ?? 0 }}</li>
                                </ul>
                            </td>
                        </tr>

                    </table>
                @endif


                <h3 class="title-6"><span><strong>Loan Details</strong></span></h3>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="inrow inptxt lefttxt">
                            <label>Purchase Price</label>
                            <span class="txt">$</span>
                            <input name="loan_purchase_price" type="text" id="purchasePrice"
                                onkeyup="calculateDownPayment();" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                class="form-control positive-integer @if(!Auth::check())login-popup @endif"
                                value="{{ old('loan_purchase_price') }}" @if(!Auth::check()) readonly="readonly"
                                @endif />
                        </div>
                        @if(empty(old('loan_purchase_price')) && !empty(session()->get('myinfoloan')) && !$errors->has('loan_purchase_price'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('loan_purchase_price'))
                        <span class="text-danger d-block">
                           {{ $errors->first('loan_purchase_price') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow inptxt lefttxt">
                            <label>Loan Amount</label>
                            <span class="txt">$</span>
                            <input name="loan_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" id="loanAmount" onkeyup="calculateDownPayment();"
                                class="form-control positive-integer @if(!Auth::check())login-popup @endif"
                                value="{{ old('loan_amount') }}" @if(!Auth::check()) readonly="readonly" @endif />
                        </div>
                        @if(empty(old('loan_amount')) && !empty(session()->get('myinfoloan')) && !$errors->has('loan_amount'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('loan_amount'))
                        <span class="text-danger d-block">
                           {{ $errors->first('loan_amount') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="inrow inptxt lefttxt">
                            <label>Down Payment</label>
                            <span class="txt" id="aabb">$</span>
                            <input name="down_payment" type="text" id="downPayment"
                                class="form-control positive-integer @if(!Auth::check())login-popup @endif" value="{{ old('down_payment') }}"
                                @if(!Auth::check()) readonly="readonly" @endif readonly />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mt-20">
                            <select class="selectpicker" name="bank_id" id="bank_id"
                                onchange="calculateMonthlyInstallment();">
                                @if(getBankDetail())
                                @foreach (getBankDetail() as $value)
                                <option value="{{ $value->id }}" data-loan="{{ $value->interest }}" @if(old('bank_id'))
                                    @if(old('bank_id')==$value->id) selected
                                    @endif
                                    @endif>{{ $value->title }} - {{ $value->interest.'%' }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('bank_id'))
                        <span class="text-danger d-block">
                           {{ $errors->first('bank_id') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-9">
                        <div class="row align-items-center mt-20 rowtype-1">
                            <div class="col-lg-5">
                                <div class="check-inline">
                                    <div class="radio">
                                        <input type="radio" id="tenor" name="tenor" checked value="1"
                                            @if(old('tenor')==1) checked @endif />
                                        <label for="tenor">Maximum Tenor</label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" id="months" name="tenor" value="2" @if(old('tenor')==2)
                                            checked @endif />
                                        <label for="months">No. of Years and Months</label>
                                    </div>
                                </div>
                                @if ($errors->has('tenor'))
                                <span class="text-danger d-block">
                                    {{ $errors->first('tenor') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-7 @if(old('tenor') == 1 || old('tenor') == '') d-none @endif"
                                id="loanperiod">
                                <div class="row break-425 so-col-10">
                                    <div class="col-6 sp-col">
                                        <div class="inrow mt-0">
                                            <label>Loan Period (Years)</label>
                                            <input name="year" type="text" id="loanYears" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                onkeyup="calculateMonthlyInstallment();"
                                                class="form-control positive-integer @if(!Auth::check())login-popup @endif"
                                                value="{{ old('year') }}" minlength="1" maxlength="2" />
                                        </div>
                                        @if(empty(old('year')) && !empty(session()->get('myinfoloan')) && !$errors->has('year'))
                                        <span class="text-danger">This field is required</span>
                                        @endif
                                        @if ($errors->has('year'))
                                        <span class="text-danger d-block">
                                           {{ $errors->first('year') }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-6 sp-col mt-425-10">
                                        <div class="inrow mt-0">
                                            <label>Loan Period (Months)</label>
                                            <input name="month" type="text" id="loanMonths" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" minlength="1" maxlength="2"
                                                onkeyup="calculateMonthlyInstallment();"
                                                class="form-control positive-integer @if(!Auth::check())login-popup @endif"
                                                value="0" />
                                        </div>
                                        @if(empty(old('month')) && !empty(session()->get('myinfoloan')) && !$errors->has('month'))
                                        <span class="text-danger">This field is required</span>
                                        @endif
                                        @if ($errors->has('month'))
                                        <span class="text-danger d-block">
                                            {{ $errors->first('month') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="title-6"><span><strong>Estimated Monthly Installment</strong></span></h3>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="inrow inptxt lefttxt">
                            <label>Amount</label>
                            <span class="txt" id="aacc">$</span>
                            <input type="text" class="form-control" name="estimated_monthly_installment" readonly
                                id="estimated_monthly_installment" value="{{ old('estimated_monthly_installment') }}" />
                        </div>
                        @if ($errors->has('estimated_monthly_installment'))
                        <span class="text-danger d-block">
                           {{ $errors->first('estimated_monthly_installment') }}
                        </span>
                        @endif
                    </div>
                </div>
                @php
                $cpfhistoryarray = array();
                $detailHistory = array();
                $noahistoryarray = array();
                $noaHistory = array(); 
                @endphp
                @if(!empty($cpfhistory) || !empty($noahistory))
                    @if(!empty($cpfhistory))
                        @foreach($cpfhistory as $histroy)
                            @php 
                            $detailHistory['month']=strtoupper( date('M Y', strtotime( $histroy['month']['value'] ) ) );
                            $detailHistory['paidon']=date('d M Y', strtotime( $histroy['date']['value'] ) );
                            $detailHistory['amount']=number_format( $histroy['amount']['value'], 2 );
                            $detailHistory['employer']=$histroy['employer']['value'];
                            array_push($cpfhistoryarray,$detailHistory);
                            @endphp
                        @endforeach
                    @endif
                    @if(!empty($noahistory))
                        @foreach($noahistory as $noahis)
                        @php 
                            $noaHistory['year_of_assessment'] = $noahis['yearofassessment']['value'] ?? '';
                            $noaHistory['type'] = $noahis['category']['value'] ?? '';
                            $noaHistory['amount'] = number_format($noahis['amount']['value'], 2) ?? '';
                            $noaHistory['employment'] = $noahis['employment']['value'] ?? '';
                            $noaHistory['trade'] = number_format( $noahis['trade']['value'], 2 ) ?? 0;
                            $noaHistory['rent'] = number_format( $noahis['rent']['value'], 2 ) ?? 0;
                            $noaHistory['interest'] = number_format( $noahis['interest']['value'], 2 ) ?? 0;
                            array_push($noahistoryarray,$noaHistory);
                        @endphp
                        @endforeach
                    @endif
                    
                    <input type="hidden" name="cpfhistory1" value="{{ json_encode($cpfhistoryarray) }}">
                    <input type="hidden" name="noahistory1" value="{{ json_encode($noahistoryarray) }}">
                @else
                <h3 class="title-6"><span><strong>Attach Income Proof</strong></span></h3>
                <div class="row">
                    <div class="col-lg mt-20">
                        <h4 class="title-8">Employee</h4>
                        <div class="attach-box mt-10">
                            <h5 class="title-9">Past 15 Months CPF Contribution History</h5>
                            <div class="file-wrap mt-10">
                                <input class="custom-file-input text-file" type="file" onchange="removeId('upload_photo');" id="upload_photo"
                                    name="cpfcontributionhistory[]">
                                <span class="txt" id="id1">No file chosen</span>
                                <a href="javascript::void(0);" id="removeId1" style="display: none;" onclick="removeDocument('upload_photo')">Remove</a>
                                <label for="upload_photo" class="upload">Upload File</label>
                            </div>
                            <div class="file-wrap mt-10">
                                <input class="custom-file-input text-file" type="file" onchange="removeId('upload_photoaa');" id="upload_photoaa" name="cpfcontributionhistory[]">
                                <span class="txt" id="id1aa">No file chosen</span>
                                <a href="javascript::void(0);" id="removeId1aa" style="display: none;" onclick="removeDocument('upload_photoaa')">Remove</a>
                                <label for="upload_photoaa" class="upload">Upload File</label>
                            </div>
                        </div>
                        @if ($errors->has('cpfcontributionhistory'))
                            <span class="text-danger d-block">
                                {{ $errors->first('cpfcontributionhistory') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-lg-auto title-9 align-self-center mt-20">
                        Or
                    </div>
                    <div class="col-lg mt-20">
                        <h4 class="title-8">Self-Employed</h4>
                        <div class="attach-box mt-10">
                            <h5 class="title-9">Past 2 Years Notice of Assessment (NOA)</h5>
                            <div class="file-wrap mt-10">
                                <input class="custom-file-input text-file" type="file" onchange="removeId('upload_photo2');" id="upload_photo2"
                                    name="noticeofassessment[]">
                                <span class="txt" id="id2">No file chosen</span>
                                <a href="javascript::void(0);" id="removeId2" style="display: none;" onclick="removeDocument('upload_photo2')">Remove</a>
                                <label for="upload_photo2" class="upload">Upload File</label>
                            </div>
                            <div class="file-wrap mt-10">
                                <input class="custom-file-input text-file" type="file" onchange="removeId('upload_photo2aa');" id="upload_photo2aa"
                                    name="noticeofassessment[]">
                                <span class="txt" id="id2aa">No file chosen</span>
                                <a href="javascript::void(0);" id="removeId2aa" style="display: none;" onclick="removeDocument('upload_photo2aa')">Remove</a>
                                <label for="upload_photo2aa" class="upload">Upload File</label>
                            </div>
                        </div>
                    </div>
                </div>

                
                @endif


                <div class="grtype mt-20">
                    <h3 class="title-6 item"><span><strong>Need a Quote For Your Trade In? </strong></span></h3>
                    <div class="check-inline item">
                        <div class="radio">
                            <input type="radio" id="yes" name="quote_trade" value="1" @if(old('quote_trade')==1) checked
                                 @endif @if(!Auth::check()) disabled="disabled"
                                @endif />
                            <label for="yes">Yes</label>
                        </div>
                        <div class="radio">
                            <input type="radio" id="no" name="quote_trade" value="2" @if(old('quote_trade')==2) checked
                            @elseif(old('quote_trade')!=1) checked @endif @if(!Auth::check()) disabled="disabled" @endif />
                            <label for="no">No</label>
                        </div>
                    </div>
                    @if ($errors->has('quote_trade'))
                    <span class="text-danger d-block">
                       {{ $errors->first('quote_trade') }}
                    </span>
                    @endif
                </div>
                <div class="row tradin @if(old('quote_trade')==1) @else d-none @endif">
                    <div class="col-xl-3 col-lg-6">
                        <div class="inrow">
                            <label>Vehicle No. (Ex: SBY1234A)</label>
                            <input type="text" class="form-control @if(!Auth::check())login-popup @endif"
                                name="vehicle_no" value="{{ old('vehicle_no') }}" @if(!Auth::check())
                                readonly="readonly" @endif />
                        </div>
                        @if(empty(old('vehicle_no')) && !empty(session()->get('myinfoloan')) && !$errors->has('vehicle_no'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('vehicle_no'))
                        <span class="text-danger d-block">
                           {{ $errors->first('vehicle_no') }}
                        </span>
                        @endif
                    </div>
                    @php
                    $selectedDropdown1 = old('owner_id_typee') ?? '';
                    @endphp
                    <div class="col-xl-3 col-lg-6">
                        <div class="mt-20">
                            <select name="owner_id_typee"  class="selectpicker">
                                <option value="" selected="selected">Select Owner ID Type</option>
                                <option value="Business" @if($selectedDropdown1 == 'Business') selected @endif>Business (e.g. 51234567M)</option>
                                <option value="Club/Association/Organisation"  @if($selectedDropdown1 == 'Club/Association/Organisation') selected @endif>Club/Association/Organisation (e.g. T08PQ1234A)</option>
                                <option value="Company"  @if($selectedDropdown1 == 'Company') selected @endif>Company (e.g. 198912345K)</option>
                                <option value="Foreign Company"  @if($selectedDropdown1 == 'Foreign Company') selected @endif>Foreign Company (e.g. T08FC1234A)</option>
                                <option value="Foreign Identification Number"  @if($selectedDropdown1 == 'Foreign Identification Number') selected @endif>Foreign Identification Number (e.g. F/G/M1234567N)</option>
                                <option value="Foreign Passport"  @if($selectedDropdown1 == 'Foreign Passport') selected @endif>Foreign Passport (e.g. 12345678)</option>
                                <option value="Government"  @if($selectedDropdown1 == 'Government') selected @endif>Government (e.g. T08GA1234A)</option>
                                <option value="Limited Liability Partnership"  @if($selectedDropdown1 == 'Limited Liability Partnership') selected @endif>Limited Liability Partnership (e.g. T08LL1234A)</option>
                                <option value="Limited Partnership"  @if($selectedDropdown1 == 'Limited Partnership') selected @endif>Limited Partnership (e.g. T08LP1234A)</option>
                                <option value="Malaysia NRIC"  @if($selectedDropdown1 == 'Malaysia NRIC') selected @endif>Malaysia NRIC (e.g. 200312345678)</option>
                                <option value="Professional"  @if($selectedDropdown1 == 'Professional') selected @endif>Professional (e.g. T08PQ1234A)</option>
                                <option value="Singapore NRIC"  @if($selectedDropdown1 == 'Singapore NRIC') selected @endif>Singapore NRIC (e.g. S1234567D)</option>
                                <option value="Statutory Board"  @if($selectedDropdown1 == 'Statutory Board') selected @endif>Statutory Board (e.g. T08GB1234A)</option>
                            </select>

                        </div>
                        @if(empty(old('owner_id_typee')) && !empty(session()->get('myinfoloan')) && !$errors->has('owner_id_typee'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('owner_id_typee'))
                        <span class="text-danger d-block">
                            {{ $errors->first('owner_id_typee') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-8">
                        <div class="inrow">
                            <label>Owner's ID: (Last 4 Char. Ex: 123A)</label>
                            <input type="text" class="form-control @if(!Auth::check())login-popup @endif" name="nric"
                                value="{{ old('nric') }}" maxlength="4" minlength="4" @if(!Auth::check())
                                readonly="readonly" @endif />
                        </div>
                        @if(empty(old('nric')) && !empty(session()->get('myinfoloan')) && !$errors->has('nric'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('nric'))
                        <span class="text-danger d-block">
                           {{ $errors->first('nric') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-xl-2 col-lg-4">
                        <div class="inrow inptxt righttxt empty">                            
                            <label>Mileage</label>
                            <input type="text" id="estimated_mileage"
                                class="form-control positive-integer @if(!Auth::check())login-popup @endif"
                                name="estimated_mileage" value="{{ old('estimated_mileage') }}" @if(!Auth::check())
                                readonly="readonly" @endif />							<span class="txt">km</span>
                        </div>
                        @if(empty(old('estimated_mileage')) && !empty(session()->get('myinfoloan')) && !$errors->has('estimated_mileage'))
                        <span class="text-danger">This field is required</span>
                        @endif
                        @if ($errors->has('estimated_mileage'))
                        <span class="text-danger d-block">
                            {{ $errors->first('estimated_mileage') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="checkbox mt-30">
                    <input type="checkbox" id="information" name="data_protection" value="1" required />
                    <label for="information"><strong class="d-block mb-10">Data Protection</strong> DIY CARS requires
                        that
                        you provide us the personal data of the hirer and guarantor listed for the purpose of car loan
                        application. By disclosing such information to us, you agree and undertake to DIY CARS that all
                        necessary consents from the relevant individuals to whom the personal data relates either have
                        been
                        obtained for the disclosure of their personal data to DIY CARS, for DIY CARS's collection, use
                        and/or disclosure for the aforesaid purposes and that such consents have not been withdrawn, in
                        accordance with the standards set out in the Singapore Personal Data Protection Act
                        2012.</label>
                </div>
                <div class="captcha">
                    <img class="bgimg" src="images/tempt/captcha.png" alt="captcha" />
                </div>
            </div>
            <div class="mt-30 text-center">
                @if(Auth::check())
                <button class="btn-1 minw-190" type="submit">APPLY <i class="fas fa-arrow-right"></i></button>
                @endif

                <div class="mt-30">This is a non-obligatory submission. You can terminate this application at any point
                    of
                    time.</div>
            </div>
        </form>


        </div>

    </div>
</div>
@php
$previousUrl = url()->previous();
$word = 'login';
if(strpos($previousUrl, $word) !== false){
    $foundd = 1;
} else{
    $foundd = 0;
}
@endphp
@if($foundd == 1 || !empty(session()->get('myinfoloan')))
<script>
 $(document).ready(function() {
            $('html, body').animate({
            scrollTop: $(".popup_price_chart").offset().top
        }, 2000);
        });
</script>
@endif
@if(!empty(session()->get('myinfoloan')))
<script>
    // $('input').prop('readonly',true);
    // $('#fullname').prop('readonly',true);
    // $('#nric').prop('readonly',true);
    // $('#gender').prop('readonly',true);
    // $('#countrycode').prop('readonly',true);
    // $('#address').prop('readonly',true);
    // $('#dob').prop('readonly',true);
    // $('#employername').prop('readonly',true);
    // $('#occupation').prop('readonly',true);
    // $('#vehicleDetails :input').prop('readonly',true);
</script>
@endif
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
<script
    src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    @if($errors->any())
    <script>
        $(document).ready(function() {
            $('html, body').animate({
            scrollTop: $(".popup_price_chart").offset().top
        }, 2000);
        });
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
        // if (auth_check == false) {
        //     $("#messagepp").modal("show");
        // }

        if(auth_check == true) {
		    $('#apply-loan-content').hide();
		    $('#apply-loan-form').show();
		} else {
		    $('#apply-loan-content').show();
		    $('#apply-loan-form').hide();
		}

        $(".login-popup").on("click", function () {
            $("#messagepp").modal("show");
        });
        $(".login-popup-radio").on("click", function () {
            if ($(this).attr('name') == 'data_protection') {
                $('input[name=' + $(this).attr('name') + ']').get(0).checked = false;
            } else {
                $('input[name=' + $(this).attr('name') + ']').get(0).checked = true;
            }
            $("#messagepp").modal("show");
        });
        $("input[name='tenor']").on("change", function () {
            var tenor = $("input[name='tenor']:checked").val();
            $("#loanperiod").addClass("d-none");
            $("input[name='year'], input[name='month']").attr("readonly", true);
            if (tenor == 2) {
                $("input[name='year'], input[name='month']").attr("readonly", false);
                $("#loanperiod").removeClass("d-none");
            }
            if (tenor == 1) {
                $('#estimated_monthly_installment').val('');
            }

        });

        $("input[name='quote_trade']").on("change", function () {
            var quote_trade = $("input[name='quote_trade']:checked").val();
            $("div.tradin").addClass("d-none");
            if (quote_trade == 1) {
                $("div.tradin").removeClass("d-none");
            }
        });

        $("button.popup_price_chart").on("click", function () {

            var loan_tenor = $("input[name='loan_tenor']").val();
            var purchase_price = $("input[name='purchase_price']").val();
            var selDownPayment = $('#selDownPayment').val();
            if (loan_tenor == '') {
                alert("Please enter loan tenor."); return false;
            }
            else if (purchase_price == '') {
                alert("Please enter purchase price."); return false;
            }
            if (selDownPayment == '') {
                alert("Please select down payment."); return false;
            }

            $("div.main-wrap").LoadingOverlay("show");
            $.ajax({
                method: "post",
                url: '{{ url("loan-application/display-loan-chart") }}',
                data: {
                    loan_tenor: loan_tenor,
                    purchase_price: purchase_price,
                    selDownPayment: selDownPayment,
                },
                cache: false,
                async: true,
                success: function (data) {
                    // console.log(data);
                    if (data) {
                        // $("div.content_display").html(data);
                        // $(".pp-cash").modal("show");
                        $('#showcalculation').html(data);
                    }
                },
                error: function (error) {
                    console.log(response);
                    var response = JSON.parse(error.responseText);
                    alert(response[1]);
                },
                complete: function (data) {
                    $("div.main-wrap").LoadingOverlay("hide");
                }
            });
        });

        $('.positive-integer').numeric(
            { negative: false }
        );

        $("form").on("submit", function () {
            $(this).find("button").attr("disabled", true);
        });

        $("input[name='tenor'], input[name='quote_trade']").trigger("change");
    });

    $(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
            });

    function calculateDownPayment() {
        let purchasePrice = $('#purchasePrice').val();
        let loanAmount = $('#loanAmount').val();
        purchasePrice = purchasePrice.replace(/,/g, '');
        loanAmount = loanAmount.replace(/,/g, '');
        let loanPer = (purchasePrice * 70) / 100;
        if(loanAmount > loanPer){
            $('#loanAmount').val(0);
            $('#downPayment').val(0);
            alert("Max loan amount should be 70% of purchase prices");
            return false;
        }
        let downPayment = 0;
        // console.log(purchasePrice);
        // console.log(loanAmount);
        if (loanAmount != '' && purchasePrice != '') {
            downPayment = purchasePrice - loanAmount;
            downPayment = downPayment.toLocaleString('en-EN', 3);
            $("#downPayment").closest("div").addClass('not-empty');
            $('#aabb').css("display", "block");
            $('#downPayment').val(downPayment);
            $('#downPayment').attr("readonly", true);
        }
        calculateMonthlyInstallment();
    }

    function calculateMonthlyInstallment() {
        let purchasePrice = $('#purchasePrice').val();
        let loanAmount = $('#loanAmount').val();
        let loanYears = $('#loanYears').val();
        let loanMonths = $('#loanMonths').val();
        purchasePrice = purchasePrice.replace(/,/g, '');
        loanAmount = parseInt(loanAmount.replace(/,/g, ''));
        let monthlyInstallment = 0;
        let interest = 0;
        let monthlyPayment = 0;
        let interestRate = $("#bank_id option:selected").data('loan');
        console.log(interestRate);
        let interestRateNew = interestRate / 100;
        if (loanYears != '' && loanMonths != '' && loanAmount != '') {
            // console.log(loanAmount);
            // console.log(interestRate);
            let yearintomonths = loanYears * 12;
            yearintomonths = parseInt(yearintomonths) + parseInt(loanMonths);
            // console.log(yearintomonths);
            // console.log(loanAmount);
            monthlyPayment = loanAmount / yearintomonths;
            // console.log(loanAmount);
            // console.log(interestRate);
            // console.log(yearintomonths);
            // console.log(((((loanAmount * (interestRate / 100)) / 12) * yearintomonths) + loanAmount));
            interest = ((((loanAmount * (interestRate / 100)) / 12) * yearintomonths) + loanAmount) / yearintomonths;
            console.log("cc3");
            console.log(interest);
            // monthlyInstallment = parseInt(monthlyPayment + interest) ;
            // monthlyInstallment = monthlyInstallment.toLocaleString('en-EN', 3);
            monthlyInstallment = parseInt(interest) ;
            monthlyInstallment = monthlyInstallment.toLocaleString('en-EN', 3);
            $("#estimated_monthly_installment").closest("div").addClass('not-empty');
            $('#aacc').css("display", "block");
            $('#estimated_monthly_installment').val(monthlyInstallment);
        } else {
            $('#estimated_monthly_installment').val('');
        }
    }

    function removeId(val){
        if(val == 'upload_photo'){
            $('#removeId1').show();
        }else if(val == 'upload_photo2'){
            $('#removeId2').show();
        }else if(val == 'upload_photoaa'){
            $('#removeId1aa').show();
        }else if(val == 'upload_photo2aa'){
            $('#removeId2aa').show();
        }
    }

    function removeDocument(val){
        if(val == 'upload_photo'){
            $('#upload_photo').val('');
            $('#id1').text('');
            $('#removeId1').hide();
        }else if(val == 'upload_photo2'){
            $('#upload_photo2').val('');
            $('#id2').text('');
            $('#removeId2').hide();
        }else if(val == 'upload_photoaa'){
            $('#upload_photoaa').val('');
            $('#id1aa').text('');
            $('#removeId1aa').hide();
        }else if(val == 'upload_photo2aa'){
            $('#upload_photo2aa').val('');
            $('#id2aa').text('');
            $('#removeId2aa').hide();
        }
    }
    $(function () {
        $("#monthly_salary,#purchasePrice,#loanAmount,#estimated_monthly_installment,#purchaseCalPrice, #estimated_mileage").on('keyup', function () {
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

    // function numberWithCommas(nStr, id) {
    //     nStr += '';
    //     x = nStr.split('.');
    //     x1 = x[0];
    //     x2 = x.length > 1 ? '.' + x[1] : '';
    //     var rgx = /(\d+)(\d{3})/;
    //     while (rgx.test(x1)) {
    //             x1 = x1.replace(rgx, '$1' + ',' + '$2');
    //     }
    //     let val = x1 + x2;
    //     $('#'+id).val(val);
    // }
</script>
<script>
    function callAuthoriseApi() {
        let authApiUrl = 'https://api.myinfo.gov.sg/com/v3/authorise';
        let clientId = 'PROD-200501881C-AUTOLINK-CARLOAN';
        let redirectUrl = 'https://www.diycars.com/car-loan/callback';
        let attributes = 'uinfin,name,sex,nationality,dob,email,mobileno,regadd,marital,cpfcontributions,noahistory';
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
        let clientId = 'PROD-200501881C-AUTOLINK-MIB-CARLOAN';
        let redirectUrl = 'https://www.diycars.com/mib-car-loan/callback';
        let attributes = 'uinfin,name,sex,nationality,dob,email,mobileno,regadd,marital,cpfcontributions,noahistory';
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
