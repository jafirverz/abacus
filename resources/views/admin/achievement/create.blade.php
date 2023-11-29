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
                                    <label for="type">Type</label>
                                    <select required name="type" class="form-control" id="type">
                                        <option value="">-- Select --</option>
                                        @foreach(achievementType() as $key=>$val)
                                        <option value="{{ $key }}"    @if(isset($_GET['type']) && $_GET['type']==$key) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="event">Grading/Competition</label>
                                    <select required name="event" class="form-control" id="event">
                                        <option value="">-- Select --</option>
                                @if(isset($_GET['type']) && $_GET['type']==1)


                                        @foreach($grading as $grade)
                                        <option value="{{ $grade->id }}"  @if(isset($_GET['grading']) && $_GET['grading']==$grade->id) selected @endif>{{ $grade->title }}</option>
                                        @endforeach


                                @elseif(isset($_GET['type']) && $_GET['type']==2)

                                        @foreach($competition as $comp)
                                        <option value="{{ $comp->id }}"  @if(isset($_GET['competition']) && $_GET['competition']==$comp->id) selected @endif>{{ $comp->title }}</option>
                                        @endforeach



                                @endif
                                        </select>
                                        @if ($errors->has('event'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('event') }}</strong>
                                        </span>
                                        @endif
                                </div>

                                @if(isset($_GET['competition']) && $_GET['competition']!='')
                                    @php
                                    $compCategory = \App\CategoryCompetition::where('competition_id', $_GET['competition'])->get();
                                    @endphp
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select required name="category" class="form-control" id="category">
                                            <option value="">-- Select --</option>
                                            @foreach($compCategory as $key=>$val)
                                            <option value="{{ $val->category_id }}"    @if(isset($_GET['competetion_ctegory']) && $_GET['competetion_ctegory']==$val->category_id) selected @endif>{{ $val->category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span class="text-danger d-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                        @endif
                                    </div>




                                    @if(isset($_GET['competetion_ctegory']) && $_GET['competetion_ctegory']!='')
                                        @php
                                        $students = \App\CompetitionStudent::where('competition_controller_id', $_GET['competition'])->where('category_id', $_GET['competetion_ctegory'])->get();
                                        @endphp
                                        <div class="form-group">
                                            <label for="user_id">Students</label>
                                            <select required name="user_id" class="form-control" id="category">
                                                <option value="">-- Select --</option>
                                                @foreach($students as $key=>$val)
                                                <option value="{{ $val->user_id }}">{{ $val->student->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('user_id'))
                                                <span class="text-danger d-block">
                                                <strong>{{ $errors->first('user_id') }}</strong>
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
                                    @endif
                                @else
                                    @if(isset($_GET['grading']) && $_GET['grading']!='')
                                        @php
                                        $students = \App\GradingStudent::where('grading_exam_id', $_GET['grading'])->get();
                                        @endphp
                                        <div class="form-group">
                                            <label for="user_id">Students</label>
                                            <select required name="user_id" class="form-control" id="category">
                                                <option value="">-- Select --</option>
                                                @foreach($students as $key=>$val)
                                                <option value="{{ $val->user_id }}">{{ $val->student->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('user_id'))
                                                <span class="text-danger d-block">
                                                <strong>{{ $errors->first('user_id') }}</strong>
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
                                    @endif
                                @endif
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

<script>
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
    </script>
@endsection
