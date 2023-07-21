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
                        <form action="{{ route('papers.update', $competitionPaper->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                @if($competitionPaper->comp_contro->competition_type == 'physical')
                                <input type="hidden" name="competionT" value="2">
                                @else
                                <input type="hidden" name="competionT" value="1">
                                @endif

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $competitionPaper->title) ?? '' }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group" >
                                    <label for="title">Paper Type</label>
                                    <select name="paper_type" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="practice" @if(old('paper_type', $competitionPaper->paper_type) == 'practice') selected @endif>Practice Paper</option>
                                        <option value="actual" @if(old('paper_type', $competitionPaper->paper_type) == 'actual') selected @endif>Actual Paper</option>
                                    </select>
                                    @if ($errors->has('paper_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('paper_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select name="category" class="form-control" >
                                        <option value="">-- Select --</option>
                                        @foreach($catComp as $cate)
                                        <option value="{{ $cate->category->id }}" @if($cate->category->id == $competitionPaper->category_id) selected @endif>{{ $cate->category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                
                                <div class="form-group">
                                    <label for="title">Competition</label>
                                    <select name="competitionn" class="form-control" disabled>
                                        <option value="">-- Select --</option>
                                        @foreach($competition as $comp)
                                        <option value="{{ $comp->id }}" @if($comp->id == $competitionPaper->competition_controller_id) selected @endif>{{ $comp->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('competition') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <input type="hidden" name="competition" value="{{ $competitionPaper->competition_controller_id }}">
                                
                                @if($competitionPaper->comp_contro->competition_type == 'physical')
                                <div class="form-group physicalclass" >
                                    <label for="title">Price</label>
                                    <input type="text" name="price" class="form-control" id=""
                                        value="{{ old('price', $competitionPaper->price) ?? '' }}">
                                    @if ($errors->has('price'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group physicalclass" >
                                    <label for="title">PDF Upload</label>
                                    <input type="file" name="pdf_upload" class="form-control" >
                                    @if ($errors->has('pdf_upload'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('pdf_upload') }}</strong>
                                    </span>
                                    @endif
                                    <a href="{{ url('/') }}/upload-file/{{  $competitionPaper->pdf_file }}" target="_blank">{{ $competitionPaper->pdf_file }}</a>
                                </div>

                                @else
                                <div class="form-group">
                                    <label for="title">Question Template</label>
                                    <select name="questiontemplate" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($questionTempleates as $questionTemp)
                                        <option value="{{ $questionTemp->id }}" @if($questionTemp->id == $competitionPaper->question_template_id ) selected @endif >{{ $questionTemp->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('questiontemplate'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('questiontemplate') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                

                                <div class="form-group">
                                    <label for="title">Time</label>
                                    <input type="text" name="time" class="form-control" id=""
                                        value="{{ old('time', $competitionPaper->time) }}">
                                    @if ($errors->has('time'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Question Type</label>
                                    <select name="question_type" class="form-control" >
                                        <option value="">-- Select --</option>
                                        <option value="vertical" @if(old('question_type', $competitionPaper->type) == 'vertical') selected @endif>Vertical</option>
                                        <option value="horizontal"  @if(old('question_type', $competitionPaper->type) == 'horizontal') selected @endif>Horizontal</option>
                                    </select>
                                    @if ($errors->has('question_type'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                               

                                <div class="form-group">
                                    <label for="title">Timer</label>
                                    <select name="timer" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="yes" @if(old('question_type', $competitionPaper->timer) == 'yes') selected @endif>Yes</option>
                                        <option value="no" @if(old('question_type', $competitionPaper->timer) == 'no') selected @endif>No</option>
                                    </select>
                                    @if ($errors->has('timer'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('timer') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @endif

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" class="form-control my-editor" cols="30"
                                              rows="5">{{old('description', $competitionPaper->description)}}</textarea>
                                </div>

                                {{-- 
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                            <option value="{{ $key }}" @if(old('status')==$key) selected @elseif($key==1) selected @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                --}}

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
