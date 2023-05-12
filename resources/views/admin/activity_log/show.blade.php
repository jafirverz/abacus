@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('activitylog.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_activitylog_crud', 'Show', route('activity-log.show', $activity_log->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                @php
                                $item = $activity_log;
                                $subject_type = '';
                                if($item->subject_type)
                                {
                                $subject_type = explode('\\', $item->subject_type);
                                }
                                if($item->properties)
                                {
                                $properties = json_decode($item->properties);
                                }
                                @endphp
                                <strong>Page Name</strong>: {{ $subject_type[1] }}
                            </div>

                            {{-- <div class="form-group">
                                <strong>Subject</strong>: {{ $sms_template->subject }}
                            </div> --}}
                            <div class="form-group">
                                <strong>Updated By</strong>: {{ $item->firstname . ' ' . $item->lastname }}
                            </div>

                            <div class="form-group">
                                <strong>Updated At</strong>: {{ date('d M, Y h:i A', strtotime($item->activity_log_updated)) }}
                            </div>
                            <div class="form-group">
                                <strong>Fields Updated</strong>:
                                @foreach($properties->attributes as $key => $val)
                                {{ $key.', ' }}
                                @endforeach
                            </div>
                            <div class="form-group">
                                <strong>View Action</strong>: {{ ucfirst($item->description) ?? '' }}
                            </div>
                            <div class="form-group">
                                <strong>IP Address</strong>: {{ getCauserIp($item->causer_id) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
