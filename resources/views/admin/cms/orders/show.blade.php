@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('orders.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Show',--}}
{{--            route('bank.show', $bank->id))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach($orderDetails as $orderDetail)
                            <div class="form-group">
                                <label for="title">Order Id</label>: {{ $orderDetail->order->id ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="title">Student Name</label>: {{ $orderDetail->order->user->name }} 
                            </div>
                            <div class="form-group">
                                <label for="title">Order Name</label>: {{ ucwords($orderDetail->name) }} 
                            </div>
                            <div class="form-group">
                                <label for="title">Order Amount</label>: {{ $orderDetail->amount }} 
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Order Status</label>: {{ $orderDetail->order->payment_status ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="status">Expiry Date</label>: {{ $orderDetail->expiry_date ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="status">Created At</label>: {{ $orderDetail->created_at ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="status">Updated At</label>: {{ $orderDetail->updated_at ?? '' }}
                            </div>
                            <hr>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
