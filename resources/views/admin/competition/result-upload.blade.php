@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <!-- <a href="{{ route('papers.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a> -->
                <a href="{{ url('upload-file/CompetitionResultUpload.xlsx') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Download Sample</a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
          @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('comp.result.store') }}" method="post" enctype="multipart/form-data">
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
                                        <option value="<?php echo url('/'); ?>/admin/comp-result?comp_id={{ $comp->id }}&type={{ $comp->competition_type }}" data-comp="{{ $comp->competition_type }}" @if(isset($_GET['comp_id']) && $_GET['comp_id']==$comp->id) selected @endif>{{ $comp->title }}</option>
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
                                    <select name="category" class="form-control">
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

                                <div class="form-group">
                                    <label for="title">Result Publish Date</label>
                                    <input type="text" name="result_publish_date" class="form-control datepicker1">
                                    @if ($errors->has('result_publish_date'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('result_publish_date') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                  <label for="title">Upload</label>
                                  <input type="file" name="fileupload" class="form-control">
                                  @if ($errors->has('fileupload'))
                                      <span class="text-danger d-block">
                                      <strong>{{ $errors->first('fileupload') }}</strong>
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
