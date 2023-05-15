@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('loan-application.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_loan_crud', 'Create', route('loan-application.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="loan_application" action="{{ route('loan-application.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <h2 class="section-title">Vehicle Info (Seller's Car)</h2>
                                <div class="form-group">
                                    <label for="vehicle_registration_no">Vehicle Registration No</label>
                                    <input type="text" name="vehicle_registration_no" class="form-control" id=""
                                        value="{{ old('vehicle_registration_no') ?? '' }}" >
                                    @if ($errors->has('vehicle_registration_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_registration_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nric_company_registration_no">Last 4 Character NRIC/Business ID/Company Registration No</label>
                                    <input type="text" name="nric_company_registration_no" class="form-control" id=""
                                        value="{{ old('nric_company_registration_no') ?? '' }}"  minlength="4" maxlength="4">
                                    @if ($errors->has('nric_company_registration_no'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('nric_company_registration_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <h2 class="section-title">Loan Information</h2>
                                <div class="form-group">
                                    <label for="name">Applicant Name</label>
                                    <select name="name" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if($users->count())
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name ?? '' }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="loan_purchase_price">Purchase Price</label>
                                    <input type="text" name="loan_purchase_price" class="form-control positive-integer" id=""
                                        value="{{ old('loan_purchase_price') ?? 0 }}" >
                                    @if ($errors->has('loan_purchase_price'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('loan_purchase_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="loan_amount">Loan Amount</label>
                                    <input type="text" name="loan_amount" class="form-control positive-integer" id=""
                                        value="{{ old('loan_amount') ?? '' }}" >
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
                                                <option value="{{ $value->id }}" @if(old('bank_id')) @if(old('bank_id')==$value->id) selected @endif @endif>{{ $value->title }} - {{ $value->interest.'%' }}</option>
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
                                                    <input  name="tenor" class="form-check-input" type="radio" id="inlineradio{{ $key }}" value="{{ $key }}" @if(old('tenor')==$key) checked @elseif($key==1) checked @endif>
                                                    <label class="form-check-label" for="inlineradio{{ $key }}">{{ $value }}</label>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <input name="year" type="text" class="form-control positive-integer"  value="{{ old('year') ?? '' }}" maxlength="4" minlength="4" />
                                            @if ($errors->has('year'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('year') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Month</label>
                                            <input name="month" type="text" class="form-control positive-integer"  value="{{ old('month') ?? '' }}" maxlength="2" minlength="2" />
                                            @if ($errors->has('month'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('month') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h2 class="section-title">Need us to Quote your Trade In?</h2>
                                <div class="form-group">
                                    @if(getYesNo())
                                        @foreach (getYesNo() as $key => $value)
                                        <div class="form-check form-check-inline">
                                            <input  name="quote_trade" class="form-check-input" type="radio" id="inlineradio{{ $key }}" value="{{ $key }}" @if(old('quote_trade')==$key) checked @elseif($key==1) checked @endif>
                                            <label class="form-check-label" for="inlineradio{{ $key }}">{{ $value }}</label>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tradin">
                                    <div class="form-group">
                                        <label for="vehicle_no">Vehicle No</label>
                                        <input type="text" name="vehicle_no" class="form-control" id=""
                                            value="{{ old('vehicle_no') ?? '' }}" >
                                        @if ($errors->has('vehicle_no'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('vehicle_no') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="nric">Last 4 Characters NRIC No</label>
                                        <input type="text" name="nric" class="form-control" id=""
                                            value="{{ old('nric') ?? '' }}"  minlength="4" maxlength="4">
                                        @if ($errors->has('nric'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('nric') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="estimated_mileage">Estimated Mileage</label>
                                        <input type="text" name="estimated_mileage" class="form-control positive-integer" id=""
                                            value="{{ old('estimated_mileage') ?? 0 }}" >
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

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getLoanStatus())
                                            @foreach (getLoanStatus() as $key => $value)
                                                <option value="{{ $key }}" @if(old('status')) @if(old('status')==$key) selected  @endif @endif>{{ $value }}</option>
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
                                    Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var max_limit = 10;
        $("input.custom-file").on("change", function (e) {
            e.preventDefault()
            var ref = $(this);
            if (ref.parents("div.form-group").next("div.attachment_data").find(".uploaded_file").length < max_limit) {
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
                            ref.parents("div.form-group").next("div.attachment_data").append(data);
                        },
                        error: function(error)
                        {
                            var response = JSON.parse(error.responseText);
                            alert(response[1]);
                        },
                        complete: function(data)
                        {
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
</script>
@endsection
