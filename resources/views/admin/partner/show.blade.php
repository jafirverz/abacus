@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('partner.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_partner_crud', 'Show', route('partner.show', $partner->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                    <strong>Partner Name</strong>:
                                    {{$partner->partner_name}}
                                </div>
                                <div class="form-group">
                                    <strong>URL</strong>:
                                    {{$partner->url}}
                                </div>
                                <div class="form-group">
                                    <strong>Logo</strong>:
                                     @if(isset($partner->logo))
                                    <div  class="d-block">
                                        <a href="{{ asset($partner->logo) }}" target="_blank"><img src="{{ asset($partner->logo) }}" alt="" width="200px"></a>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <strong>View Order</strong>:
                                    {{$partner->view_order}}
                                </div>
                               
                                 <div class="form-group">
                                    <strong>Status</strong>: {{ getActiveStatus($partner->status) }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $partner->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $partner->updated_at->format('d M, Y h:i A') }}
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("input, textarea, select").attr("disabled", true);
    });
</script>
@endsection
