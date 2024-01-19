@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('test-management.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('test_management_crud', 'Show',
            route('test-management.show', $test->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $test->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Paper</strong>: {{ $test->paper->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Course</strong>: {{ $test->course->title }}
                                </div>

                                <div class="form-group">
                                    <strong>Instructor</strong>

                                        @if ($students)
                                        @foreach ($students as $item)
                                         @if(is_array($allocationInsList) && in_array($item->id,$allocationInsList)) {{ $item->name }}, @endif
                                        @endforeach
                                        @endif


                                </div>

                                <div class="form-group">
                                    <strong>Students</strong>

                                        @if ($userStudent)
                                        @foreach ($userStudent as $item)
                                         @if(is_array($allocationStudentList) && in_array($item->id,$allocationStudentList)) {{ $item->name }}, @endif
                                        @endforeach
                                        @endif


                                </div>
                                <div class="form-group">
                                    <strong>Start Date</strong>: {{ date('d M, Y h:i A',strtotime($test->start_date)) }}
                                </div>
                                <div class="form-group">
                                    <strong>End Date</strong>: {{ date('d M, Y h:i A',strtotime($test->end_date)) }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $test->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $test->updated_at->format('d M, Y h:i A') }}
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
