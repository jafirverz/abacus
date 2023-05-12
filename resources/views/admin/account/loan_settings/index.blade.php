@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_loan_settings')])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('admin/loan-calculator-settings') }}" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="section-title">Before Cash Discount (%)</h2>
                                        @php
                                            $before_cash_discount = $loan_calculator_settings->before_cash_rebate ? json_decode($loan_calculator_settings->before_cash_rebate, true) : null;
                                        @endphp
                                        @if(getLoanCalculatorRange())
                                        @foreach (getLoanCalculatorRange() as $item)
                                        <div class="form-group">
                                            <label for="">{{ $item }}</label>
                                            <input type="text" name="before_cash_discount[{{ inputSlug($item) }}]" class="form-control positive-integer" value="{{ old('before_cash_discount.'.inputSlug($item)) ?? $before_cash_discount[inputSlug($item)] ?? 0 }}">
                                            @if ($errors->has('before_cash_discount.'.inputSlug($item)))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('before_cash_discount.'.inputSlug($item)) }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <h2 class="section-title">After Cash Discount (%)</h2>
                                        @php
                                            $after_cash_discount = json_decode($loan_calculator_settings->after_cash_rebate, true);
                                        @endphp
                                        @if(getLoanCalculatorRange())
                                        @foreach (getLoanCalculatorRange() as $item)
                                        <div class="form-group">
                                            <label for="">{{ $item }}</label>
                                            <input type="text" name="after_cash_discount[{{ inputSlug($item) }}]" class="form-control positive-integer" value="{{ old('after_cash_discount.'.inputSlug($item)) ?? $after_cash_discount[inputSlug($item)]  ?? 0 }}">
                                            @if ($errors->has('after_cash_discount.'.inputSlug($item)))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('after_cash_discount.'.inputSlug($item)) }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Downpayment (%)</label>
                                            <input type="text" name="downpayment_percent" class="form-control positive-integer" value="{{ $loan_calculator_settings->downpayment_percent ?? '' }}">
                                            @if ($errors->has('downpayment_percent'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('downpayment_percent') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Loan Amount (%)</label>
                                            <input type="text" name="loanamount_percent" class="form-control positive-integer" value="{{ $loan_calculator_settings->loanamount_percent ?? '' }}">
                                            @if ($errors->has('loanamount_percent'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('loanamount_percent') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                        Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function() {
        $('.positive-integer').numeric(
            {negative: false}
        );
    });
</script>
@endsection
