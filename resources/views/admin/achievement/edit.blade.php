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
                                    <label for="type">Type</label>
                                    <select disabled name="type" class="form-control" id="type">
                                        <option value="">-- Select --</option>
                                        @foreach(achievementType() as $key=>$val)
                                        <option value="{{ $key }}"    @if($type==$key) selected @endif>{{ $val }}</option>
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
                                    <select disabled required name="event" class="form-control" id="event">
                                        <option value="">-- Select --</option>
                                @if($type==1)


                                        @foreach($grading as $grade)
                                        <option value="{{ $grade->id }}"  @if(isset($_GET['event']) && $_GET['event']==$grade->id) selected @endif>{{ $grade->title }}</option>
                                        @endforeach


                                @elseif($type==2)

                                        @foreach($competition as $comp)
                                        <option value="{{ $comp->id }}"  @if($event->competition_id ==$comp->id) selected @endif>{{ $comp->title }}</option>
                                        @endforeach



                                @endif
                                        </select>
                                        @if ($errors->has('event'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('event') }}</strong>
                                        </span>
                                        @endif
                                </div>

                                @if(isset($event->competition_id))
                                    @php
                                    $compCategory = \App\CategoryCompetition::where('competition_id', $event->competition_id)->get();
                                    @endphp
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select disabled required name="category" class="form-control" id="category">
                                            <option value="">-- Select --</option>
                                            @foreach($compCategory as $key=>$val)
                                            <option value="{{ $val->category_id }}"    @if($event->category_id ==$val->category_id) selected @endif>{{ $val->category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span class="text-danger d-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                        @endif
                                    </div>


                                @endif

                                @if(isset($event->category_id))
                                    @php
                                    $students = \App\CompetitionStudent::where('competition_controller_id', $event->competition_id)->where('category_id', $event->category_id)->get();
                                    @endphp
                                    <div class="form-group">
                                        <label for="user_id">Students</label>
                                        <select disabled required name="user_id" class="form-control" id="category">
                                            <option value="">-- Select --</option>
                                            @foreach($students as $key=>$val)
                                            <option @if($event->user_id ==$val->user_id) selected @endif value="{{ $val->user_id }}">{{ $val->student->name }}</option>
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
                                        <input required type="text" name="result" class="form-control" id="" value="{{ old('result',$event->result) }}">

                                        @if ($errors->has('result'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('result') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="rank">Rank</label>
                                        <input required type="text" name="rank" class="form-control" id="" value="{{ old('rank',$event->rank) }}">

                                        @if ($errors->has('rank'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('rank') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                @endif
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
