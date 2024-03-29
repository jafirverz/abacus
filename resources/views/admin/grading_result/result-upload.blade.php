@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('/admin/grading-result-upload') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                <a href="{{ url('upload-file/Grading-Results-Upload.xlsx') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Download Sample</a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
          @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading.result.upload') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                @if(isset($_GET['type']) && $_GET['type'] == 'physical')
                                <input type="hidden" name="competionT" id="competionT" value="2">
                                @else
                                <input type="hidden" name="competionT" id="competionT" value="1">
                                @endif


                                <div class="form-group">
                                    <label for="title">Grading</label>
                                    <select name="competitionn" class="form-control" id="competition" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select --</option>
                                        @foreach($competition as $comp)
                                        <option value="<?php echo url('/'); ?>/admin/grading-result-upload?comp_id={{ $comp->id }}&type={{ $comp->competition_type }}" data-comp="{{ $comp->competition_type }}" @if(isset($_GET['comp_id']) && $_GET['comp_id']==$comp->id) selected @endif>{{ $comp->title }}</option>
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
