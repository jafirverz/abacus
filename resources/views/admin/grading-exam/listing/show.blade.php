@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('grading-exam.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
           @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('grading_exam_crud', 'Show', route('grading-exam.show', $exam->id))])
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>: {{ $exam->title ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>: {{ gradingExamType($exam->type) ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="layout">Layout</label>: {{ gradingExamLayout($exam->layout) ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="exam_date">Exam Date</label>: {{ $exam->exam_date ?? '' }}
                            </div>
                            @php
                            $student_id=json_decode($exam->student_id);
                            @endphp
                            <div class="form-group">
                                <label for="layout">Student</label>:
                                @foreach($student_id as $id)
                                {{ get_user_detail($id)->name ?? '' }}<br>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="title">Notes</label>: {{ $exam->important_note ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>: {{ getStatuses($exam->status) ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
