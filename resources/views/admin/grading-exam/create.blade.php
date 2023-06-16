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
                                    <label for="timed">Timed</label>
                                    <input type="text" name="timed" class="form-control" id=""
                                        value="{{ old('timed') }}">
                                    @if ($errors->has('timed'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('timed') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="marks">Marks</label>
                                    <input type="text" name="marks" class="form-control" id=""
                                        value="{{ old('marks') }}">
                                    @if ($errors->has('marks'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('marks') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="student_id">Student</label>
                                    <select multiple name="student_id[]" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($students)
                                        @foreach ($students as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('student_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('student_id') }}</strong>
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
