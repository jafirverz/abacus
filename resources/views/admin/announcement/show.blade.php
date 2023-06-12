@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('announcement.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_announcement_crud', 'Show',
            route('announcement.show', $announcement->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $announcement->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Image</strong>:
                                    @if(isset($announcement->image))
                                    <div class="d-block">
                                        <a href="{{ asset($announcement->image) }}" target="_blank"><img
                                                src="{{ asset($announcement->image) }}" alt="" width="200px"></a>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <strong>Date</strong>: {{ $announcement->announcement_date }}
                                </div>
                                <div class="form-group">
                                    <strong>Description</strong>: {{ $announcement->description }}
                                </div>
                                <div class="form-group">
                                    <strong>Function</strong>: {{ $announcement->function }}
                                </div>
                                <div class="form-group">
                                    <strong>Attachments</strong>:
                                    @if(isset($announcement->attachments)  && $announcement->attachments!='')
                                    @php
                                    $json=json_decode($announcement->attachments);
                                    for($i=0;$i<count($json);$i++)
                                    {
                                    @endphp

                                                <div class="form-group">
                                                    <input class="form-control"  value="{{ $json[$i] }}" name="input_1_old[]" type="hidden">
                                                    <a href="{{ url('/') }}/upload-file/{{ $json[$i] }}" target="_blank"> {{ $json[$i] }} </a>

                                                </div>
                                    @php } @endphp
                                    @endif
                                </div>
                                <div class="form-group">
                                    <strong>Teacher</strong>: {{ $announcement->teacher->name }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $announcement->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $announcement->updated_at->format('d M, Y h:i A') }}
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
