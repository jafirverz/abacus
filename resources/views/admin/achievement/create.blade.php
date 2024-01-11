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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_achievement_crud', 'Create', route('achievement.create'))])

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('achievement.store') }}" method="post">

                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="studentss">Student</label>
                                    <select required name="studentss[]" class="form-control selectpicker" id="type" multiple data-live-search="true">
                                        <option value="">-- Select --</option>
                                        @foreach($students as $key=>$val)
                                        <option value="{{ $val->id }}" >{{ $val->name }}, Instructor: {{ getInstructor($val->instructor_id)->name ?? '' }},Learning Location: {{ getLearningLocation($val->learning_locations)->title ?? '' }}, DOD: {{ $val->dob }}</option>
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
                                    <input required type="text" name="year" class="form-control datepicker1" id="" value="{{ old('year') }}">
                                    @if ($errors->has('year'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="event_title">Event Title</label>
                                    <input required type="text" name="event_title" class="form-control" id="" value="{{ old('event_title') }}">

                                    @if ($errors->has('event_title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('event_title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="result">Result</label>
                                    <input required type="text" name="result" class="form-control" id="" value="{{ old('result') }}">

                                    @if ($errors->has('result'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('result') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="rank">Rank</label>
                                    <input required type="text" name="rank" class="form-control" id="" value="{{ old('rank') }}">

                                    @if ($errors->has('rank'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('rank') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="marks">Total Marks</label>
                                    <input required type="text" name="marks" class="form-control" id="" value="{{ old('marks') }}">

                                    @if ($errors->has('marks'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('marks') }}</strong>
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

<!-- <script>
    $('#type').on('change', function(){
    window.location = "{{ url('/') }}/admin/achievement/create?type="+$(this).val();
    });
    @if(isset($_GET['type']) && $_GET['type']==2)
    $('#event').on('change', function(){
    window.location = "{{ url('/') }}/admin/achievement/create?type={{ $_GET['type'] }}&competition="+$(this).val();
    });
    @endif
    @if(isset($_GET['type']) && $_GET['type']==1)
    $('#event').on('change', function(){
    window.location = "{{ url('/') }}/admin/achievement/create?type={{ $_GET['type'] }}&grading="+$(this).val();
    });
    @endif
    @if(isset($_GET['competition']) && $_GET['type']==2)
    $('#category').on('change', function(){
    window.location = "{{ url('/') }}/admin/achievement/create?type={{ $_GET['type'] }}&competition={{ $_GET['competition'] }}&competetion_ctegory="+$(this).val();
    });
    @endif
    </script> -->
@endsection
