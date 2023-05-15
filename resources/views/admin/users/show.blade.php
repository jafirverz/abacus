@extends('admin.layout.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $title }} <small class="text-muted">{{ $secondary_title }}</small></h1>
        @include('admin.inc.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('admin_users_account_crud', 'Show',
        route('users-account.show', $users_account->id))])
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4></h4>
                <div class="card-header-action">
                    <a href="{{ route('users-account.index') }}" class="btn btn-primary"><i
                            class="fas fa-long-arrow-alt-left    "></i> Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <strong>Profile</strong>:
                    @if($users_account->profile && file_exists($users_account->profile))
                    <img src="{{ asset($users_account->profile) }}" alt="" width="200px">
                    @endif
                </div>
                <div class="form-group">
                    <strong>Entity</strong>: {{ getEntity($users_account->entity)->entity_name }}
                </div>
                <div class="form-group">
                    <strong>Staff Name</strong>: {{ $users_account->staff_name }}
                </div>
                <div class="form-group">
                    <strong>Department</strong>: {{ getDepartment($users_account->department)->department_name }}
                </div>
                <div class="form-group">
                    <strong>CMS License Holder</strong>: @if($users_account->cms_license_holder==1) Yes @else No @endif
                </div>
                <div class="form-group">
                    <strong>Manager</strong>: {{ getManager($users_account->manager) }}
                </div>
                <div class="form-group">
                    <strong>Training Admin</strong>: @if(getStaffType($users_account->id, 'training_admin')) Yes @else No @endif
                </div>
                <div class="form-group">
                    <strong>HR Admin</strong>: @if(getStaffType($users_account->id, 'hr_admin')) Yes @else No @endif
                </div>
                <div class="form-group">
                    <strong>DID No.</strong>: {{ $users_account->did_no ?? '-' }}
                </div>
                <div class="form-group">
                    <strong>Mobile</strong>: {{ $users_account->mobile ?? '-' }}
                </div>
                <div class="form-group">
                    <strong>Email</strong>: {{ $users_account->email }}
                </div>
                <div class="form-group">
                    <strong>Created At</strong>: {{ $users_account->created_at->format('d M, Y h:i A') }}
                </div>
                <div class="form-group">
                    <strong>Updated At</strong>: {{ $users_account->updated_at->format('d M, Y h:i A') }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
