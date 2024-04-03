@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">

                <a href="{{ route('g-results.grading',$competitionPaperSubmitted->grading_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('g-results.update',$competitionPaperSubmitted->id) }}" method="post">

                            @csrf
                            @method('PUT')
                            <div class="card-body">

                            <div class="form-group">
                                    <label for="title">User Name</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{ $competitionPaperSubmitted->user->name }}" disabled>
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">User Account Id</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->user->account_id }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">User Email</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->user->email }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Competition Title</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->grading->title }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                

                                
                                <div class="form-group">
                                    <label for="title">Date of competition</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->grading->date_of_competition }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                

                                

                                <div class="form-group">
                                    <label for="title">Total Marks</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->total_marks }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                               

                                <div class="form-group">
                                    <label for="title">Result</label>
                                    <input type="text" name="result" class="form-control" id=""
                                        value="{{ $competitionPaperSubmitted->result }}">
                                    @if ($errors->has('result'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('result') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Abacus Result</label>
                                    <input type="text" name="abacus_results" class="form-control" id=""
                                        value="{{ $competitionPaperSubmitted->abacus_results }}">
                                    @if ($errors->has('abacus_results'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('abacus_results') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Mental Result</label>
                                    <input type="text" name="mental_results" class="form-control" id=""
                                        value="{{ $competitionPaperSubmitted->mental_results }}">
                                    @if ($errors->has('mental_results'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mental_results') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Rank</label>
                                    <input type="text" name="rank" class="form-control" id=""
                                        value="{{ $competitionPaperSubmitted->rank }}">
                                    @if ($errors->has('rank'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('rank') }}</strong>
                                    </span>
                                    @endif
                                </div>

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

@endsection
