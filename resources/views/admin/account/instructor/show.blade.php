@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('instructor-account.index') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('instructor_account_crud', 'Show',
            route('instructor-account.show', $customer->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Account ID</label>: {{ $customer->account_id ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Full Name</label>: {{ $customer->instructor_full_name ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Instructor Display Name</label>: {{ $customer->name ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>: {{ $customer->email ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Date Of Birth</label>: {{ $customer->dob ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>: {{ $customer->mobile ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Gender</label>:
                                @if($customer->gender=='1') Male
                                @elseif($customer->gender == '2') Female
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Address</label>: {{ $customer->address ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Country</label>: {{ getCountry($customer->country_code) ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Year Attained Qualified Instructor Certification</label>

                                {{  $customer->year_attained_qualified_instructor }}
                            </div>
                            <div class="form-group">
                                <label for="">Year Attained Senior Instructor Certification</label>
                                {{  $customer->year_attained_senior_instructor }}

                            </div>
                            <div class="form-group">
                                <label for="">Highest Abacus Grade Attained</label>

                                {{  $customer->highest_abacus_grade }}
                            </div>
                            <div class="form-group">
                                <label for="">Highest Mental Grade Attained</label>
                                {{  $customer->highest_mental_grade }}
                            </div>
                            <div class="form-group">
                                <label for="">Awards</label>

                                {{  $customer->awards }}
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
