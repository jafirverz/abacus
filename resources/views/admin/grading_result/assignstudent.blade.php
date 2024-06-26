@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('/admin/assign-grading') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
          @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('assign-grading.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                              <input type="hidden" name="competitionId" value="{{ $competition->id }}">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $competition->title) }}" disabled>
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="mental_grade">Mental Grade </label>
                                    <select name="mental_grade" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($mental_grades as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('mental_grade'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mental_grade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="abacus_grade">Abacus Grade  </label>
                                    <select name="abacus_grade" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($abacus_grades as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('abacus_grade'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('abacus_grade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Select Instructor</label>
                                    <select data-live-search="true" name="instructor_id" class="selectpicker form-control">

                                        @foreach($instructors as $student)
                                       
                                        <option value="{{ $student ->id}}">{{$student->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('instructor'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('instructor') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Select Student</label>
                                    <select data-live-search="true" name="students[]" class="selectpicker form-control" multiple>

                                        @foreach($students as $student)
                                        @php
                                        $instructor = \App\User::where('id', $student->instructor_id)->first();
                                        $learningL = \App\LearningLocation::where('id', $student->learning_locations)->first();
                                        @endphp
                                        <option value="{{ $student ->id}}">{{$student->name}}, Instructor: {{ $instructor->name ?? '' }}, Learning Location: {{ $learningL->title ?? '' }}, DOB: {{ $student->dob }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('students'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('students') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if(old('status') == 1) selected @endif>Approved</option>
                                        <option value="0" @if(old('status') == 0) selected @endif>Not Approved/Pending</option>
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
