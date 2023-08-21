@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">

                <a href="{{ route('certificate.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
           

        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $certificate->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Subject</strong>: {{ $certificate->subject }}
                                </div>
                                <div class="form-group">
                                    <strong>Content Type</strong>: {{ $certificate->content }}
                                </div>
                                <div class="form-group">
                                    <strong>Certificate Type</strong>: {{ $certificate->certification_type }}
                                </div>
                                <div class="form-group">
                                    <strong>Status</strong>: @if($certificate->status == 1) Active @else In Active @endif
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $certificate->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $certificate->updated_at->format('d M, Y h:i A') }}

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
