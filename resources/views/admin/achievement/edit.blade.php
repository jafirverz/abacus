@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">

                <a href="{{ route('achievement.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_achievement_crud', 'Edit', route('achievement.edit', $event->id))])

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('achievement.update', $event->id) }}" method="post">

                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="studentss">Student</label>
                                    <select required name="studentss" class="form-control selectpicker" id="type"  data-live-search="true">
                                        <option value="">-- Select --</option>
                                        @foreach($students as $key=>$val)
                                        <option value="{{ $val->id }}" @if($event->user_id == $val->id) selected @endif >{{ $val->name }}, Instructor: {{ getInstructor($val->instructor_id)->name ?? '' }},Learning Location: {{ getLearningLocation($val->learning_locations)->title ?? '' }}, DOD: {{ $val->dob }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('studentss'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('studentss') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input required type="text" name="year" class="form-control datepicker1" id="" value="{{ old('year', $event->competition_date) ?? '' }}">
                                    @if ($errors->has('year'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="event_title">Event Title</label>
                                    <input required type="text" name="event_title" class="form-control" id="" value="{{ old('event_title', $event->title) ?? '' }}">

                                    @if ($errors->has('event_title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('event_title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="result">Result</label>
                                    <input required type="text" name="result" class="form-control" id="" value="{{ old('result', $event->result) ?? '' }}">

                                    @if ($errors->has('result'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('result') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <!-- <div class="form-group">
                                    <label for="rank">Rank</label>
                                    <input required type="text" name="rank" class="form-control" id="" value="{{ old('rank', $event->rank) ?? '' }}">

                                    @if ($errors->has('rank'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('rank') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="marks">Total Marks</label>
                                    <input required type="text" name="marks" class="form-control" id="" value="{{ old('marks', $event->total_marks) ?? '' }}">

                                    @if ($errors->has('marks'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('marks') }}</strong>
                                    </span>
                                    @endif
                                </div> -->
                                

                                
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $("input[name='title']").on("change", function () {
            var title = slugify($(this).val());
            $("input[name='slug']").val(title);
        });
    });

</script>
@endsection
