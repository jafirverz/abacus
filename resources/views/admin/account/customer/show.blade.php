@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('customer-account.index') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('customer_account_crud', 'Show',
            route('customer-account.show', $customer->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Company Name</label>: {{ $customer->company_name ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Customer Name</label>: {{ $customer->name ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Email Address</label>: {{ $customer->email ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Gender</label>:
                                @if($customer->gender=='1') Male
                                @elseif($customer->gender == '2') Female
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Contact Number</label>: {{ $customer->mobilewithcountrycode ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>: {{ $customer->address ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Created At</label>: {{ $customer->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <label for="">Updated At</label>: {{ $customer->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
