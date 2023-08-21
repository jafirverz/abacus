@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('competition.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Edit', route('bank.edit', $bank->id))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('results.update', $competitionPaperSubmitted->id) }}" method="post" enctype="multipart/form-data">
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
                                        value="{{ $competitionPaperSubmitted->competition->title }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                

                                
                                <div class="form-group">
                                    <label for="title">Date of competition</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->competition->date_of_competition }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="title">Category Name</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->category->category_name }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Paper Name</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->paper->title }}">
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
                                    <label for="title">User Marks</label>
                                    <input type="text" name="" class="form-control" id="" disabled
                                        value="{{ $competitionPaperSubmitted->user_marks }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Prize</label>
                                    <input type="text" name="prize" class="form-control" id=""
                                        value="{{ $competitionPaperSubmitted->prize }}">
                                    @if ($errors->has('prize'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('prize') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Result</label>
                                    <select class="form-control" name="result">
                                        <option value="">Please select</option>
                                        <option value="Pass" @if($competitionPaperSubmitted->result == 'Pass') selected @endif>Pass</option>
                                        <option value="Fail" @if($competitionPaperSubmitted->result == 'Fail') selected @endif>Fail</option>
                                    </select>
                                    @if ($errors->has('result'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('result') }}</strong>
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
