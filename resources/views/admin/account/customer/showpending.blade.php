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

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="">Name</label>: {{ $customer->name ?? '' }}
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
                                <label for="">Instructor</label>: {{ $instructors->name ?? '' }}
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