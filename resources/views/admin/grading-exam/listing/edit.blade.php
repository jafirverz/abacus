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
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('grading_exam_crud', 'Edit', route('grading-exam.edit', $exam->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-exam.update', $exam->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $exam->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (gradingExamType())
                                        @foreach (gradingExamType() as $key=>$item)
                                        <option value="{{ $key }}" @if(old('type', $exam->type)==$key)
                                            selected
                                            @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('type') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="layout">Layout</label>
                                    <select name="layout" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (gradingExamLayout())
                                        @foreach (gradingExamLayout() as $key=>$item)
                                        <option value="{{ $key }}" @if(old('layout', $exam->layout)==$key)
                                            selected
                                            @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('layout'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('layout') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exam_date">Exam Date</label>
                                    <input type="text" name="exam_date" class="form-control datetimepicker" id=""
                                        value="{{ old('exam_date', $exam->exam_date) }}">
                                    @if ($errors->has('exam_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('exam_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php
                                 $student_id=json_decode($exam->student_id);
                                @endphp
                                @endphp
                                <div class="form-group">
                                    <label for="student_id">Student</label>
                                    <select multiple name="student_id[]" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($students)
                                        @foreach ($students as $item)
                                        <option value="{{ $item->id }}" @if(in_array($item->id,$student_id)==$item->id)
                                            selected
                                            @endif>{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('student_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('student_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="important_note">Notes</label>
                                    <textarea name="important_note" class="form-control my-editor" id="" cols="30"
                                    rows="10"> {{ old('important_note', $exam->important_note) }} </textarea>
                                    @if ($errors->has('important_note'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('important_note') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (getStatuses())
                                        @foreach (getStatuses() as $key => $value)
                                        <option value="{{ $key }}" @if(old('status', $exam->status)==$key)
                                        selected
                                        @endif>{{ $value }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
