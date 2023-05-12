@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('chat-window.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_chat_window_crud', 'Show', route('chat-window.show', $chatWindow->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                    <strong>Title</strong>:
                                    {{$chatWindow->title}}
                                </div>
                                <div class="form-group">
                                    <strong>URL</strong>:
                                    {{$chatWindow->url}}
                                </div>
                                <div class="form-group">
                                    <strong>Icon</strong>:
                                     @if(isset($chatWindow->icon))
                                    <div  class="d-block">
                                        <a href="{{ asset($chatWindow->icon) }}" target="_blank"><img src="{{ asset($chatWindow->icon) }}" alt="" width="200px"></a>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <strong>View Order</strong>:
                                    {{$chatWindow->view_order}}
                                </div>
                               
                                 <div class="form-group">
                                    <strong>Status</strong>: {{ getActiveStatus($chatWindow->status) }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $chatWindow->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $chatWindow->updated_at->format('d M, Y h:i A') }}
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
