@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('competition.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                                <label for="title">Title</label>: {{ $competition->title ?? '' }}
                            </div>

                            <div class="form-group">
                                <label for="title">Competition Type</label>:{{ ucwords($competition->competition_type) }}
                            </div>

                            <div class="form-group">
                                <label for="status">Category</label>: {{ implode(',', $categoyy) ?? '' }}
                            </div>

                            <div class="form-group">
                                <label for="status">Date</label>: {{ $competition->date_of_competition ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="status">Competition Time </label>: {{ $competition->start_time_of_competition }} @if($competition->start_time_of_competition <= 12) am @else pm @endif -  {{ $competition->end_time_of_competition }} @if($competition->end_time_of_competition <= 12) am @else pm @endif
                                (GMT+08:00) Singapore Standard Time
                            </div>
                            <div class="form-group">
                                <label for="status">Description</label>: {{ $competition->description }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
