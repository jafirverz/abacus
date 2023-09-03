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
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('grading_exam_crud', 'Create', route('grading-exam.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-exam.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title') }}">
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
                                        <option value="{{ $key }}" @if(old('type')==$item)
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
                                        <option value="{{ $key }}" @if(old('type')==$item)
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
                                        value="{{ old('exam_date') }}">
                                    @if ($errors->has('exam_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('exam_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exam_venue">Exam Venue</label>
                                    <input type="text" name="exam_venue" class="form-control" id=""
                                        value="{{ old('exam_venue') }}">
                                    @if ($errors->has('exam_venue'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('exam_venue') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exam_type">Paper Type</label>
                                    <select name="exam_type" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option @if(old('exam_type')==1) selected @endif value="1">Actual</option>
                                        <option @if(old('exam_type')==2) selected @endif value="2">Practice</option>
                                    </select>
                                    @if ($errors->has('exam_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('exam_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="important_note">Notes</label>
                                    <textarea name="important_note" class="form-control my-editor" id="" cols="30"
                                    rows="10"> {{ old('important_note') }} </textarea>
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
                                        <option value="{{ $key }}" @if(old('status')==$key)
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
                                    Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
