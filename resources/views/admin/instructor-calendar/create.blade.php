@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('instructor-calendar.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_instructor_calendar_crud', 'Create', route('instructor-calendar.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('instructor-calendar.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" id=""
                                        value="{{ old('full_name') }}">
                                    @if ($errors->has('full_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="text" name="start_date" class="form-control datepicker" id=""
                                        value="{{ old('start_date') }}">
                                    @if ($errors->has('start_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <input type="text" name="start_time" class="form-control timepicker" id=""
                                        value="{{ old('start_time') }}">
                                    @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('start_time') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" class="form-control" id="">{{ old('note') }}</textarea>
                                    @if ($errors->has('note'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="reminder">Set Reminder ?</label>
                                    <div class="radiotype">
                                        <input id="yes" type="radio" value="1" name="reminder" checked />
                                        <label for="yes">Yes</label>

                                        <input id="no" type="radio" value="2" name="reminder" />
                                        <label for="no">No</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="teacher_id">Teacher</label>
                                    <select data-live-search="true" name="teacher_id[]" class="form-control selectpicker" multiple>
                                        <option value="">-- Select --</option>
                                        @if ($instructors)
                                        @foreach ($instructors as $item)
                                        <option value="{{ $item->id }}" @if(old('teacher_id') && in_array($item->id,old('teacher_id')))
                                            selected
                                            @endif>{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('teacher_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('teacher_id') }}</strong>
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
