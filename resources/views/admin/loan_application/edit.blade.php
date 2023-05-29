@extends('admin.layout.app')

@section('content')
<style>.licon { position: relative; }.licon .ltext { align-items: center; bottom: 0; left: 0; line-height: 42px; position: absolute; text-align: center; top: 0; width: 40px; }.licon .form-control { padding-left: 40px !important; }</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('loan-application.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_loan_crud', 'Edit', route('loan-application.edit', $loan_application->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="loan_application" action="{{ route('loan-application.update', $loan_application->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <h2 class="section-title">Vehicle Info (Seller's Car)</h2>
                                <div class="form-group">
                                    <label for="vehicle_registration_no">Vehicle Registration No</label>
                                    <input type="text" name="vehicle_registration_no" class="form-control" id=""
                                        value="{{ old('vehicle_registration_no') ?? $loan_application->vehicle_registration_no ?? '' }}" >
                                    @if ($errors->has('vehicle_registration_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_registration_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="owner_id_type">Owner ID Type</label>
                                    <input type="text" name="owner_id_type" class="form-control" id=""
                                        value="{{ old('owner_id_type') ?? $loan_application->owner_id_type ?? '' }}" >
                                </div>
                                
                                <div class="form-group">
                                    <label for="nric_company_registration_no">Last 4 Character NRIC/Business ID/Company Registration No</label>
                                    <input type="text" name="nric_company_registration_no" class="form-control" id=""
                                        value="{{ old('nric_company_registration_no') ?? $loan_application->nric_company_registration_no ?? '' }}" minlength="4" maxlength="4" >
                                    @if ($errors->has('nric_company_registration_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('nric_company_registration_no') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <h2 class="section-title">Applicant Information</h2>
                                <div class="form-group">
                                    <label for="name">Applicant Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        value="{{ old('name', $loan_application->user->name ?? '') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="name">NRIC</label>
                                    <input type="text" name="owner_nric" class="form-control" id=""
                                        value="{{ old('owner_nric', $loan_application->owner_nric ?? '')  }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="name">Passport</label>
                                    <input type="text" name="passport" class="form-control" id=""
                                        value="{{ old('passport', $loan_application->passport ?? '')  }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">Applicant Email</label>
                                    <input type="text" name="email" class="form-control" id=""
                                        value="{{ old('email', $loan_application->applicant_email ?? '' ) }}" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="name">Country Code</label>
                                            <input type="text" name="country_code" class="form-control" id=""
                                                value="{{ old('country_code', $loan_application->country_code) ?? '+65' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="form-group">
                                            <label for="mobile">Applicant Mobile</label>
                                            <input type="text" name="mobile" class="form-control" id=""
                                                value="{{ old('mobile', $loan_application->applicant_contact) ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label for="name">Nationality</label>
                                    <input type="text" name="nationality" class="form-control" id=""
                                        value="{{ old('', $loan_application->nationality) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Address</label>
                                    <input type="text" name="address" class="form-control" id=""
                                        value="{{ old('address', $loan_application->address) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Gender</label>
                                    <input type="text" name="gender" class="form-control" id=""
                                        value="{{ old('gender',$loan_application->gender) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Marital Status</label>
                                    <input type="text" name="marital_status" class="form-control" id=""
                                        value="{{ old('marital_status', $loan_application->marital_status) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">DOB</label>
                                    <input type="text" name="dob" class="form-control" id=""
                                        value="{{ old('dob', date('d-m-Y', strtotime($loan_application->dob))) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Employer Name</label>
                                    <input type="text" name="company_name" class="form-control" id=""
                                        value="{{ old('company_name', $loan_application->company_name) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Employer Address</label>
                                    <input type="text" name="company_address" class="form-control" id=""
                                        value="{{ old('company_address', $loan_application->company_address) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Employer Postal Code</label>
                                    <input type="text" name="company_postal_code" class="form-control" id=""
                                        value="{{ old('company_postal_code', $loan_application->company_postal_code) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Occupation</label>
                                    <input type="text" name="occupation" class="form-control" id=""
                                        value="{{ old('occupation', $loan_application->occupation) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Period Of Service Years</label>
                                    <input type="text" name="service_period_year" class="form-control" id=""
                                        value="{{ old('service_period_year', $loan_application->service_period_year) ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Period Of Service Months</label>
                                    <input type="text" name="service_period_month" class="form-control" id=""
                                        value="{{ old('service_period_month', $loan_application->service_period_month) ?? '' }}" readonly>
                                </div>
                                @php 
                                if(!empty($loan_application->monthly_salary)){
                                    $monthlySalary = number_format( $loan_application->monthly_salary);
                                }else{
                                    $monthlySalary = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="name">Monthly Salary</label>

                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="monthly_salary" class="form-control" id=""
                                        value="{{ old('monthly_salary', $monthlySalary) ?? '' }}" readonly>
                                    </div>
                                </div>

                                <h2 class="section-title">Loan Information</h2>
                                <div class="form-group">
                                    <label for="loan_purchase_price">Purchase Price</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="loan_purchase_price" class="form-control positive-integer" id="loan_purchase_price"
                                        value="{{ old('loan_purchase_price') ?? number_format($loan_application->loan_purchase_price) ?? 0 }}" >
                                    </div>
                                    @if ($errors->has('loan_purchase_price'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('loan_purchase_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="loan_amount">Loan Amount</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="loan_amount" class="form-control positive-integer" id="loan_amount"
                                        value="{{ old('loan_amount') ?? number_format($loan_application->loan_amount) ?? '' }}" >
                                    </div>
                                    @if ($errors->has('loan_amount'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('loan_amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="bank_id">Bank and Interest Rate</label>
                                    <select name="bank_id" class="form-control">
                                        <option value="">-- Select Bank and Interest Rate</option>
                                        @if(getBankDetail())
                                            @foreach (getBankDetail() as $value)
                                                <option value="{{ $value->id }}" @if(old('bank_id')) @if(old('bank_id')==$value->id) selected @endif @elseif(isset($loan_application->bank_id)) @if($loan_application->bank_id==$value->id) selected @endif @endif>{{ $value->title }} - {{ $value->interest.'%' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('bank_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('bank_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            @if(tenor())
                                                @foreach (tenor() as $key => $value)
                                                <div class="form-check form-check-inline">
                                                    <input  name="tenor" class="form-check-input" type="radio" id="inlineradio{{ $key }}" value="{{ $key }}" @if(old('tenor')==$key) checked @elseif($loan_application->tenor==$key) checked @elseif($key==1) checked @endif>
                                                    <label class="form-check-label" for="inlineradio{{ $key }}">{{ $value }}</label>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <input name="year" type="text" class="form-control positive-integer"  value="{{ old('year') ?? $loan_application->year ?? '' }}" maxlength="4" minlength="4" />
                                            @if ($errors->has('year'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('year') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Month</label>
                                            <input name="month" type="text" class="form-control positive-integer"  value="{{ old('month') ?? $loan_application->month ?? '' }}" maxlength="2" minlength="2" />
                                            @if ($errors->has('month'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('month') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="down_payment">Down Payment</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="down_payment" class="form-control positive-integer" id="down_payment"
                                        value="{{ old('down_payment') ?? number_format($loan_application->down_payment) ?? 0 }}" >
                                    </div>
                                    @if ($errors->has('down_payment'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('down_payment') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php
                                if(!empty($loan_application->estimated_monthly_installment)){
                                    $emIns = number_format($loan_application->estimated_monthly_installment);
                                }else{
                                    $emIns = '';
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="estimated_monthly_installment">Estimated Monthly Installment</label>
                                    <div class="licon">
                                        <div class="ltext">$</div>
                                        <input type="text" name="estimated_monthly_installment" class="form-control positive-integer" id="estimated_monthly_installment"
                                        value="{{ old('estimated_monthly_installment') ?? $emIns ?? 0 }}" >
                                    </div>
                                    @if ($errors->has('estimated_monthly_installment'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('estimated_monthly_installment') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                
                                <h2 class="section-title">Need us to Quote your Trade In?</h2>
                                <div class="form-group">
                                    @if(getYesNo())
                                        @foreach (getYesNo() as $key => $value)
                                        <div class="form-check form-check-inline">
                                            <input  name="quote_trade" class="form-check-input" type="radio" id="inlineradio{{ $key }}" value="{{ $key }}" @if(old('quote_trade')==$key) checked @elseif($loan_application->quote_trade==$key) checked @elseif($key==1) checked @endif>
                                            <label class="form-check-label" for="inlineradio{{ $key }}">{{ $value }}</label>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tradin">
                                    @php
                                        $trade_details = $loan_application->trade_details ? json_decode($loan_application->trade_details) : null;
                                    @endphp
                                    <div class="form-group">
                                        <label for="vehicle_no">Vehicle No</label>
                                        <input type="text" name="vehicle_no" class="form-control" id=""
                                            value="{{ old('vehicle_no') ?? $trade_details->vehicle_no ?? '' }}" >
                                        @if ($errors->has('vehicle_no'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('vehicle_no') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="nric">Last 4 Characters NRIC No</label>
                                        <input type="text" name="nric" class="form-control" id=""
                                            value="{{ old('nric') ?? $trade_details->nric ?? '' }}"  minlength="4" maxlength="4">
                                        @if ($errors->has('nric'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('nric') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="owner_id_typee">ID Type</label>
                                        <input type="text" name="owner_id_typee" class="form-control" id=""
                                            value="{{ old('owner_id_typee') ?? $trade_details->owner_id_typee ?? '' }}" >
                                        
                                    </div>
                                    @php 
                                    if(!empty($trade_details->estimated_mileage)){
                                        $estimatedMileage = number_format($trade_details->estimated_mileage);
                                    }else{
                                        $estimatedMileage = 0;
                                    }
                                    @endphp
                                    <div class="form-group">
                                        <label for="estimated_mileage">Estimated Mileage</label>
                                        <input type="text" name="estimated_mileage" class="form-control positive-integer" id="estimated_mileage"
                                            value="{{ old('estimated_mileage') ?? $estimatedMileage ?? 0 }}" >
                                        @if ($errors->has('estimated_mileage'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('estimated_mileage') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    @php
                                        $file_format = 'jpg, png, gif, xlsx, xls, pdf, doc, docx';
                                    @endphp
                                    <label for="estimated_mileage">Upload Document</label>
                                    <input type="file" name="other_document" class="form-control custom-file" id=""
                                         >
                                    <span class="muted-text">{{ fileReadText($file_format ? explode(', ', $file_format) : '', '5MB') }}</span>
                                    <input type="hidden" name="uploadfiles[photo]" value="{{ $file_format ?? '' }}">
                                    @if ($errors->has('other_document'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('estimated_mileage') }}</strong>
                                    </span>
                                    @endif
                                    <div class="col-12 attachment_data">
                                        @if(isset($loan_application->cpfcontributionhistory))
                                        @php
                                            $other_documents = json_decode($loan_application->cpfcontributionhistory);
                                        @endphp
                                        @foreach ($other_documents as $photovalue)
                                        <div class="uploaded_file">
                                            <i class="fas fa-minus-circle text-danger remove_file" style="cursor: pointer;"></i>
                                            <a href="{{asset('documents/'.$photovalue)}}" target="_blank">
                                               CPF Contribution History
                                            </a>
                                        </div>
                                        @endforeach
                                        @endif

                                        @if(isset($loan_application->noticeofassessment))
                                        @php
                                            $other_documents = json_decode($loan_application->noticeofassessment);
                                        @endphp
                                        @foreach ($other_documents as $photovalue)
                                        <div class="uploaded_file">
                                            <i class="fas fa-minus-circle text-danger remove_file" style="cursor: pointer;"></i>
                                            <a href="{{asset('documents/'.$photovalue)}}" target="_blank">
                                               Notice of Assessment
                                            </a>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                @php
                                if(!empty($loan_application->cpfhistory)){
                                    $cpfHistory = json_decode($loan_application->cpfhistory);
                                }else{
                                    $cpfHistory = '';
                                }
                                @endphp
            
                                @if(!empty($cpfHistory))
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
            
                                    @foreach($cpfHistory as $histroy)
                                    <tr>
                                        <td><strong>{{ $histroy->month }}</strong></td>
                                        <td>{{ $histroy->paidon }}</td>
                                        <td>${{ $histroy->amount }}</td>
                                        <td>{{ $histroy->employer }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                @endif

                                <!-- //Noa History -->
                    @php
                    if(!empty($loan_application->noahistory)){
                        $noahistory = json_decode($loan_application->noahistory);
                    }else{
                        $noahistory = '';
                    }
                    @endphp

                    @if(!empty($noahistory))
                    <h3 class="title-6"><span><strong>Notice Of Assessment (Detailed)</strong></span></h3>
                    <table class="tb-1 mt-3">
                        <tr>
                            <th><strong>Year of Assessment:</strong> {{ $noahistory[0]->year_of_assessment ?? ''}}</th>
                            <th><strong>Year of Assessment:</strong> {{ $noahistory[1]->year_of_assessment ?? '' }}</th>

                        </tr>

                        <tr>
                            <td><strong>Type:</strong> {{ $noahistory[0]->type ?? '' }}</td>
                            <td><strong>Type:</strong> {{ $noahistory[1]->type ?? '' }}</td>

                        </tr>

                        <tr>
                            <td><strong>Assesable Income:</strong> ${{ $noahistory[0]->amount }}</td>
                            <td><strong>Assesable Income:</strong> ${{ $noahistory[1]->amount }}</td>

                        </tr>

                        <tr>
                            <td>
                                <strong>Income Breakdown:</strong>
                                <ul>
                                    <li>Employment: ${{ number_format($noahistory[0]->employment) }}</li>
                                    <li>Trade: ${{ $noahistory[0]->trade ?? 0 }}</li>
                                    <li>Rent: ${{ $noahistory[0]->rent ?? 0 }}</li>
                                    <li>Interest: ${{ $noahistory[0]->interest ?? 0 }}</li>
                                </ul>
                            </td>
                            <td>
                                <strong>Income Breakdown:</strong>
                                <ul>
                                    <li>Employment: ${{ number_format($noahistory[1]->employment) }}</li>
                                    <li>Trade: ${{ $noahistory[1]->trade ?? 0 }}</li>
                                    <li>Rent: ${{ $noahistory[1]->rent ?? 0 }}</li>
                                    <li>Interest: ${{ $noahistory[1]->interest ?? 0 }}</li>
                                </ul>
                            </td>
                        </tr>

                    </table>
                @endif

                <br><br>


                @if(!empty($loan_application->myinfo_cpf))
                    <p><a href="{{asset('loanpdf/'.$loan_application->myinfo_cpf)}}">CPF Contribution History PDF Download</a></p>
                @endif

                @if(!empty($loan_application->myinfo_noa))
                    <p><a href="{{asset('loanpdf/'.$loan_application->myinfo_noa)}}">Notice of Assessment PDF Download</a></p>
                @endif

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getLoanStatus())
                                            @foreach (getLoanStatus() as $key => $value)
                                                <option value="{{ $key }}" @if(old('status')) @if(old('status')==$key) selected @endif @elseif(isset($loan_application->status)) @if($loan_application->status==$key) selected @endif @endif>{{ $value }}</option>
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
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Update</button>
                                @if(!empty($loan_application->docu_sent == 1))
                                <a class="btn btn-primary" href="javascript::void(0);" >PDF already sent<i class="fas fa-arrow-right"></i></a>
                                @endif
                                @if(!empty($loan_application->pdf_name))
                                <a class="btn btn-primary" href="{{ url('admin/loan-application/loan', ['id'=>$loan_application->id]) }}" >Docusign Send PDF <i class="fas fa-arrow-right"></i></a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
    $(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var max_limit = 10;
        $("input.custom-file").on("change", function (e) {
            e.preventDefault();
            $("section.section").LoadingOverlay("show");
            var ref = $(this);
            $("input[name='_method']").remove();
            if (ref.parents("div.form-group").find("div.attachment_data").find(".uploaded_file").length < max_limit) {
                if (ref.val()) {
                    ref.attr("readonly", true);
                    $.ajax({
                        method: "POST",
                        url: '{{ url("admin/loan-application/upload-files") }}',
                        data: new FormData($("form#loan_application")[0]),
                        cache: false,
                        async: true,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            //console.log(data);
                            $("form#loan_application").append('<input type="hidden" name="_method" value="PUT">');
                            ref.parents("div.form-group").find("div.attachment_data").append(data);
                        },
                        error: function(error)
                        {
                            var response = JSON.parse(error.responseText);
                            alert(response[1]);
                        },
                        complete: function(data)
                        {
                            $("section.section").LoadingOverlay("hide");
                            ref.attr("readonly", false);
                            ref.val('');
                        }
                    });
                }
            } else {
                ref.attr("readonly", false);
                ref.val('');
                alert("Maximum limit "+max_limit+" is reached.");
            }
        });

        $("body").on("click", ".remove_file", function () {
            $(this).parents("div.uploaded_file").remove();
        });

        $("input[name='tenor']").on("change", function() {
            var tenor = $("input[name='tenor']:checked").val();
            $("input[name='year'], input[name='month']").attr("disabled", true);
            if(tenor==2)
            {
                $("input[name='year'], input[name='month']").attr("disabled", false);
            }
        });

        $("input[name='quote_trade']").on("change", function() {
            var quote_trade = $("input[name='quote_trade']:checked").val();
            $("div.tradin").addClass("d-none");
            if(quote_trade==1)
            {
                $("div.tradin").removeClass("d-none");
            }
        });

        $('.positive-integer').numeric(
            {negative: false}
        );

        $("form").on("submit", function() {
            $(this).find("button").attr("disabled", true);
        });

        $("input[name='tenor'], input[name='quote_trade']").trigger("change");
    });

    $(function () {
        $("#loan_purchase_price,#loan_amount,#estimated_monthly_installment,#down_payment,#estimated_mileage").on('keyup', function () {
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
</script>
@endsection