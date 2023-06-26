@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('papers.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('papers.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                @if(isset($_GET['type']) && $_GET['type'] == 'physical')
                                <input type="hidden" name="competionT" id="competionT" value="2">
                                @else
                                <input type="hidden" name="competionT" id="competionT" value="1">
                                @endif


                                <div class="form-group">
                                    <label for="title">Competition</label>
                                    <select name="competitionn" class="form-control" id="competition" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select --</option>
                                        @foreach($competition as $comp)
                                        <option value="<?php echo url('/'); ?>/admin/papers/create?comp_id={{ $comp->id }}&type={{ $comp->competition_type }}" data-comp="{{ $comp->competition_type }}" @if(isset($_GET['comp_id']) && $_GET['comp_id']==$comp->id) selected @endif>{{ $comp->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @if(isset($_GET['comp_id']))
                                <input type="hidden" name="competition" value="{{ $_GET['comp_id'] }}">
                                @endif

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php 
                                if(isset($_GET['comp_id'])){
                                    $compId = $_GET['comp_id'];
                                    if($compId){
                                        $catComp = \App\CategoryCompetition::where('competition_id', $compId)->pluck('category_id')->toArray();
                                        $compCat = \App\CompetitionCategory::whereIn('id', $catComp)->get();
                                    }
                                    else{
                                        $compCat = array();
                                    }
                                }
                                
                                @endphp
                                
                                @if(isset($_GET['comp_id']))
                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select name="category[]" class="form-control" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($compCat as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @endif

                                @if(isset($_GET['type']) && $_GET['type'] == 'physical')

                                <div class="form-group physicalclass" >
                                    <label for="title">Price</label>
                                    <input type="text" name="price" class="form-control" id=""
                                        value="{{ old('price') }}">
                                    @if ($errors->has('price'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group physicalclass">
                                    <label for="title">PDF Upload</label>
                                    <input type="file" name="pdf_upload" class="form-control" >
                                    @if ($errors->has('pdf_upload'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('pdf_upload') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @endif


                                @if(isset($_GET['type']) && $_GET['type'] == 'online')
                                <div class="form-group onlineclass" >
                                    <label for="title">Question Template</label>
                                    <select name="questiontemplate" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($questionTempleates as $questionTemp)
                                        <option value="{{ $questionTemp->id }}" @if(old('questionTemp') == $questionTemp->id) selected @endif>{{ $questionTemp->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('questiontemplate'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('questiontemplate') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                

                                <div class="form-group onlineclass" >
                                    <label for="title">Time</label>
                                    <input type="text" name="time" class="form-control" id=""
                                        value="{{ old('time') }}">
                                    @if ($errors->has('time'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group onlineclass">
                                    <label for="title">Question Type</label>
                                    <select name="question_type" class="form-control" >
                                        <option value="">-- Select --</option>
                                        <option value="vertical" @if(old('question_type') == 'vertical') selected @endif>Vertical</option>
                                        <option value="horizontal" @if(old('question_type') == 'horizontal') selected @endif>Horizontal</option>
                                    </select>
                                    @if ($errors->has('question_type'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                               

                                <div class="form-group onlineclass" >
                                    <label for="title">Timer</label>
                                    <select name="timer" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
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
                                              rows="5">{{old('description')}}</textarea>
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
