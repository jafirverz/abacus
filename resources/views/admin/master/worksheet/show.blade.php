@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('worksheet.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Show',--}}
{{--            route('bank.show', $bank->id))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>: {{ $worksheet->title ?? '' }}
                            </div>
                            @php
                            $topics = implode(', ', $topics);
                            @endphp
                            <div class="form-group">
                                <label for="title">Level</label>: {{ $topics }}
                            </div>

                            <div class="form-group">
                                <label for="status">Fee</label>: @if($worksheet->type == 1) Free @else Paid @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Amount</label>: {{ $worksheet->amount ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="status">Question Template</label>: {{ getQuestionTemplate($worksheet->question_template_id) }}
                            </div>
                            <!-- <div class="form-group">
                                <label for="status">Question Type</label>: @if($worksheet->question_type == 1) Vertical @else Horizontal @endif
                            </div> -->
                            <div class="form-group">
                                <label for="status">Stopwatch Timing</label>: @if($worksheet->stopwatch_timing == 1) Yes @else No @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Preset Timing</label>: @if($worksheet->preset_timing == 1) Yes @else No @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Description</label>: {{ $worksheet->description }}
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>: {{ getActiveStatus($worksheet->status) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
