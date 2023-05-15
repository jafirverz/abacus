@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('bank.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Show',
            route('bank.show', $bank->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>: {{ $bank->title ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="interest">Interest (%)</label>: {{ $bank->interest ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="terms_and_condition">Terms and Condition</label>: {{ $bank->terms_and_condition ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="view_order">View Order</label>: {{ $bank->view_order ?? 0 }}
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>: {{ getActiveStatus($bank->status) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
