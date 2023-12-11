@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('user-account.index') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('user_account_crud', 'Show',
            route('user-account.show', $admins->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">First Name</label>: {{ $admins->firstname ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Last Name</label>: {{ $admins->lastname ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>: {{ $admins->email ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Role</label>: {{ $admins->roles->name ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Country</label>: @if($admins->country_id!='') {{ getCountry($admins->country_id) ?? '' }} @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>: {{ getActiveStatus($admins->status) }}
                            </div>
                            <div class="form-group">
                                <label for="">Created At</label>: {{ $admins->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <label for="">Updated At</label>: {{ $admins->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
