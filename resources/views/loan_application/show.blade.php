@extends('layouts.app')

@section('content')
<div class="main-wrap">
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $title ?? '' }}</h1>

        <h2 class="title-2 mt-50 mt-991-30">Apply Loan</h2>
            @php
                $user = Auth::user();
            @endphp
            <!-- <h3 class="title-3 mb-20">Vehicle Info (Seller's Car)</h3> -->
                <div class="form-ani">
                    <h3 class="title-6"><span><strong>Vehicle Information of The Car You’re Purchasing </strong></span></h3>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Vehicle No. (Ex: SBY1234A)</label>
                                <input type="text" name="vehicle_registration_no"
                                    class="form-control" readonly value="{{ $loan_application->vehicle_registration_no }}" />
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Owner ID</label>
                                <input type="text" name="vehicle_registration_no"
                                    class="form-control" readonly value="{{ $loan_application->owner_id_type }}" />
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Owner's ID: (Last 4 Char. Ex: 123A)</label>
                                <input name="nric_company_registration_no" type="text"
                                    class="form-control"
                                    value="{{ $loan_application->nric_company_registration_no }}" readonly maxlength="4" minlength="4"
                                     />
                            </div>
                            
                        </div>
                    </div>
                    <h3 class="title-6"><span><strong>Applicant’s Information</strong></span></h3>
                    <div class="row">
                        
                        <div class="col-lg-6">
                            <div class="inrow">
                                <label>Full Name as in NRIC/Passport</label>
                                <input type="text" name="applicant_name" readonly
                                    class="form-control"
                                    value="{{ $loan_application->applicant_name }}" />
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="inrow">
                                <label>NRIC/FIN</label>
                                <input type="text" class="form-control" readonly
                                    name="owner_nric" value="{{ $loan_application->owner_nric }}"/>
                            </div>
                            
    
                        </div>
                        <div class="col-lg-3">
                            <div class="inrow">
                                <label>Passport (Optional)</label>
                                <input type="text" name="passport" type="text" readonly
                                    class="form-control" value="{{ $loan_application->passport ?? '' }}"
                                     />
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-5 col-lg-6">
                            <div class="row sp-col-10 break-425">
                                <div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
                                    <div class="inrow">
                                        <label>Country Code</label>
                                        <input type="text" name="country_code" type="text" readonly
                                            class="form-control"
                                            value="{{ $loan_application->country_code }}" maxlength="4" minlength="4"
                                             />
                                    </div>
                                    
                                </div>
                                <div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
                                    <div class="inrow">
                                        <label>Contact No.</label>
                                        <input name="applicant_contact" type="text"
                                            class="form-control"
                                            value="{{ $loan_application->applicant_contact }}" readonly />
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6">
                            <div class="inrow">
                                <label>Email Address (Ex: janedoe@gmail.com)</label>
                                <input name="applicant_email" type="text"
                                    class="form-control"
                                    value="{{ $loan_application->applicant_email }}" readonly />
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Nationality</label>
                                <input name="applicant_email" type="text"
                                    class="form-control"
                                    value="Singapore" readonly />
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="inrow">
                                <label>Address (Block Number), (Street Name), (Floor)-(Unit Number), Singapore (Postal Code)</label>
                                <input name="address" type="text" class="form-control"
                                    value="{{ $loan_application->address }}" readonly />
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-20">
                                <div class="inrow">
                                    <label>Gender</label>
                                    <input name="address" type="text" class="form-control"
                                        value="{{ $loan_application->gender }}" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mt-20">
                                <div class="inrow">
                                    <label>Marital Status</label>
                                    <input name="address" type="text" class="form-control"
                                        value="{{ $loan_application->marital_status }}" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow date-wrap datepicker-wrap">
                                <label>Date Of Birth</label>
                                <input name="dob" type="text" class="form-control" readonly
                                    value="{{ date('d-m-Y', strtotime($loan_application->dob)) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow">
                                <label>Name of Employer</label>
                                <input name="company_name" type="text"
                                    class="form-control" readonly
                                    value="{{ $loan_application->company_name }}" />
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="inrow">
                                <label>Employer’s Address</label>
                                <input name="company_address" type="text" readonly
                                    class="form-control"
                                    value="{{ $loan_application->company_address }}" />
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="inrow">
                                <label>Employer’s Postal Code</label>
                                <input name="company_postal_code" type="text" readonly
                                    class="form-control"
                                    value="{{ $loan_application->company_postal_code }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6">
                            <div class="inrow">
                                <label>Occupation</label>
                                <input name="occupation" type="text" readonly
                                    class="form-control"
                                    value="{{ $loan_application->occupation }}" />
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="inrow">
                                <label>Period of Service (Years)</label>
                                <input name="service_period_year" type="text" readonly
                                    class="form-control"
                                    value="{{ $loan_application->service_period_year }}" />
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="inrow">
                                <label>Period of Service (Months)</label>
                                <input name="service_period_month" type="text" readonly
                                    class="form-control"
                                    value="{{ $loan_application->service_period_month }}" />
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="inrow">
                                <label>Monthly Salary</label>
                                <input name="monthly_salary" type="text" readonly
                                    class="form-control"
                                    value="{{ number_format($loan_application->monthly_salary) }}" />
                            </div>
                        </div>
                    </div>
    
                    
    
    
    
                    <h3 class="title-6"><span><strong>Loan Details</strong></span></h3>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow inptxt lefttxt">
                                <label>Purchase Price</label>
                                <span class="txt">$</span>
                                <input name="loan_purchase_price" type="text" id="purchasePrice" readonly
                                    class="form-control"
                                    value="{{ number_format($loan_application->loan_purchase_price) }}"  />
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow inptxt lefttxt">
                                <label>Loan Amount</label>
                                <span class="txt">$</span>
                                <input name="loan_amount" type="text" id="loanAmount" readonly
                                    class="form-control"
                                    value="{{ number_format($loan_application->loan_amount) }}"  />
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="inrow inptxt lefttxt">
                                <label>Down Payment</label>
                                <span class="txt">$</span>
                                <input name="down_payment" type="text" id="downPayment"
                                    class="form-control" value="{{ number_format($loan_application->down_payment) }}"
                                     readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mt-20">
                                <div class="inrow">
                                    <label>Bank Detail</label>
                                    <input name="down_payment" type="text" id="downPayment"
                                        class="form-control" value="{{ $loan_application->bank->title ?? '' }} - {{ $loan_application->bank->interest ?? '' }}%"
                                         readonly />
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-9">
                            <div class="row align-items-center mt-20 rowtype-1">
                                <div class="col-lg-5">
                                    <div class="check-inline">
                                        @if($loan_application->tenor == 1)
                                        <div class="radio">
                                            <input type="radio" id="tenor" name="tenor" disabled checked value="1"
                                                />
                                            <label for="tenor">Maximum Tenor</label>
                                        </div>
                                        @else
                                        <div class="radio">
                                            <input type="radio" id="months" name="tenor" disabled value="2" checked/>
                                            <label for="months">No. of Years and Months</label>
                                        </div>
                                        @endif
                                    </div>
                                    
                                </div>


                                @if($loan_application->tenor == 2)
                                <div class="col-lg-7"
                                    id="loanperiod">
                                    <div class="row break-425 so-col-10">
                                        <div class="col-6 sp-col">
                                            <div class="inrow mt-0">
                                                <label>Loan Period (Years)</label>
                                                <input name="year" type="text" readonly id="loanYears"
                                                    class="form-control"
                                                    value="{{ $loan_application->year }}" />
                                            </div>
                                            
                                        </div>
                                        <div class="col-6 sp-col mt-425-10">
                                            <div class="inrow mt-0">
                                                <label>Loan Period (Months)</label>
                                                <input name="month" type="text" readonly id="loanMonths"
                                                    class="form-control"
                                                    value="{{ $loan_application->month }}" />
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                @endif



                            </div>
                        </div>
                    </div>
                    @php
                                if(!empty($loan_application->estimated_monthly_installment)){
                                    $emIns = number_format($loan_application->estimated_monthly_installment);
                                }else{
                                    $emIns = '';
                                }
                                @endphp
                    <h3 class="title-6"><span><strong>Estimated Monthly Installment</strong></span></h3>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="inrow inptxt lefttxt">
                                <label>Amount</label>
                                <span class="txt">$</span>
                                <input type="text" class="form-control" readonly name="estimated_monthly_installment"
                                    id="estimated_monthly_installment" value="{{ $emIns ?? '' }}" />
                            </div>
                           
                        </div>
                    </div>
                   
                    
                    <div class="grtype mt-20">
                        <h3 class="title-6 item"><span><strong>Need a Quote For Your Trade In? </strong></span></h3>
                        <div class="check-inline item">
                            <div class="radio">
                                <input type="radio" id="yes" disabled name="quote_trade" readonly value="1" @if($loan_application->quote_trade == 1) checked @endif/>
                                <label for="yes">Yes</label>
                            </div>
                            <div class="radio">
                                <input type="radio" id="no" disabled name="quote_trade" readonly value="2" @if($loan_application->quote_trade == 2) checked @endif />
                                <label for="no">No</label>
                            </div>
                        </div>
                        
                    </div>

                    @if($loan_application->quote_trade == 1)
                    @php 
                    $tradeDetails = json_decode($loan_application->trade_details, true);
                    @endphp
                    <div class="row tradin">
                        <div class="col-xl-3 col-lg-6">
                            <div class="inrow">
                                <label>Vehicle No. (Ex: SBY1234A)</label>
                                <input type="text" class="form-control"
                                    name="vehicle_no" value="{{ $tradeDetails['vehicle_no'] ?? '' }}" readonly/>
                            </div>
                            
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="mt-20">
                                
                                <div class="inrow">
                                    <label>Owner’s ID Type:</label>
                                    <input type="text" class="form-control"
                                        name="vehicle_no" value="{{ $tradeDetails['owner_id_typee'] ?? '' }}" readonly/>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-xl-4 col-lg-8">
                            <div class="inrow">
                                <label>Owner's ID: (Last 4 Char. Ex: 123A)</label>
                                <input type="text" class="form-control" name="nric"
                                    value="{{ $tradeDetails['nric'] ?? '' }}" maxlength="4" minlength="4" readonly/>
                            </div>
                            
                        </div>
                        <div class="col-xl-2 col-lg-4">
                            <div class="inrow inptxt">
                                <label>Mileage</label>
                                <input type="text" readonly
                                    class="form-control"
                                    name="estimated_mileage" value="{{ number_format($tradeDetails['estimated_mileage']) }}"/>
                                    <span class="txt">km</span>
                            </div>
                            
                        </div>
                    </div>
                    @endif

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
                    
                </div>
                
    </div>
</div>
<script>
    $(function() {
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



        $("input[name='tenor'], input[name='quote_trade']").trigger("change");

        $("input, select, textarea").attr("disabled", true);
    });
</script>
@endsection
