@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('instructor-calendar.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_instructor_calendar_crud', 'Show',
            route('instructor-calendar.show', $calendar->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Full Name</strong>: {{ $calendar->full_name ?? '' }}
                                </div>
                                <div class="form-group">
                                    <strong>Start Date</strong>: {{ $calendar->start_date ?? '' }}
                                </div>
                                <div class="form-group">
                                    <strong>Note</strong>: {{ $calendar->note ?? '' }}
                                </div>
                                <div class="form-group">
                                    <strong>Teacher</strong>: {{ $calendar->teacher->name }}
                                </div>
                                <div class="form-group">
                                    <strong>Set Reminder ?</strong>: {{ $calendar->reminder==1?'Yes':'No' }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $calendar->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $calendar->updated_at->format('d M, Y h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
