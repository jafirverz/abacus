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
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Edit', route('bank.edit', $bank->id))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-exam.update', $competition->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">



                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $competition->title) ?? '' }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Type</label>
                                    <select name="competition_type" class="form-control" disabled>
                                        <option value="">-- Select --</option>
                                        <option value="online" @if(old('competition_type', $competition->competition_type) == 'online') selected @endif>Online</option>
                                        <option value="physical" @if(old('competition_type', $competition->competition_type) == 'physical') selected @endif>Physical</option>
                                    </select>
                                    @if ($errors->has('competition_type'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('competition_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @php
                                if(isset($competition->grade) && $competition->grade!='')
                                {
                                    $grade_json=json_decode($competition->grade);
                                }
                                else {
                                    # code...
                                    $grade_json=[];
                                }
                                //dd($grade);
                                @endphp
                                {{-- <div class="form-group">
                                    <label for="title">Grade</label>
                                    <select name="grade[]" class="form-control selectpicker" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($grades as $grade)
                                        <option value="{{ $grade->id}}" @if(isset($grade_json)) @if(in_array($grade->id, $grade_json)) selected @endif @endif>{{$grade->title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('grade'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('grade') }}</strong>
                                    </span>
                                    @endif
                                </div> --}}



                                <div class="form-group">
                                    <label for="title">Grade</label><br>
                                    @foreach($competitionCategory as $cate)
                                    <input type="checkbox" name="category[]" value="{{ $cate->id }}" @if(in_array($cate->id, $categoryCompetition)) checked @endif> {{ $cate->category_name }} <br>
                                    @endforeach


                                    @if ($errors->has('category'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="exam_venue">Exam Venue</label>
                                    <input type="text" name="exam_venue" class="form-control" id=""
                                        value="{{ old('exam_venue', $competition->exam_venue) }}">
                                    @if ($errors->has('exam_venue'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('exam_venue') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Exam Date</label>
                                    <input type="text" name="date_of_competition" class="form-control datepicker1" id=""
                                        value="{{ old('date_of_competition', $competition->date_of_competition) }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Start Time</label>
                                    <input type="text" name="start_time_of_competition" class="form-control timepicker" id="" value="{{ old('start_time_of_competition', $competition->start_time_of_competition) }}">

                                    @if ($errors->has('start_time_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('start_time_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="title">End Time</label>
                                    <input type="text" name="end_time_of_competition" class="form-control timepicker" id="" value="{{ old('end_time_of_competition', $competition->end_time_of_competition) }}">


                                    @if ($errors->has('end_time_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('end_time_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="title">Image Overview Page</label>
                                    <input type="file" name="compoverimage" value="">
                                </div>
                                @if($competition->overview_image)
                                <img src="{{ asset($competition->overview_image) }}" width="200px;">
                                @endif

                                <div class="form-group">
                                    <label for="title">Image Competition Page</label>
                                    <input type="file" name="compimage" value="">
                                </div>
                                @if($competition->comp_image)
                                <img src="{{ asset($competition->comp_image) }}" width="200px;">
                                @endif


                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" class="form-control my-editor" cols="30"
                                              rows="5">{{old('description', $competition->description)}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if(old('status', $competition->status) == 1) selected @endif>Active</option>
                                        <option value="2" @if(old('status', $competition->status) == 2) selected @endif>Draft</option>
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
<script>
    function showAmount(val){
        if(val==2){
            $('#amountblock').show();
        }else{
            $('#amountblock').hide();
        }
    }
</script>
@endsection
