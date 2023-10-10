@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('papers.index') }}" class="btn btn-icon" target="_blank"><i class="fas fa-arrow-left"></i></a><a href="{{ url('upload-file/Grading-Results-Upload.xlsx') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Download Sample</a>
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

                                <div class="form-group">
                                    <label for="title">Grading</label>
                                    <select name="grading_id" class="form-control" id="grading_id">
                                        <option value="">-- Select --</option>
                                        @foreach($grading as $grade)
                                        <option value="{{ $grade->id }}"  @if(isset($_GET['grading_id']) && $_GET['grading_id']==$grade->id) selected @endif>{{ $grade->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('grading_id'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('grading_id') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="list_id">Exam List</label>
                                    <select name="list_id" class="form-control" id="list_id">
                                        <option value="">-- Select --</option>
                                        @if(isset($_GET['grading_id']))
                                        @php
                                        $list = \App\GradingExamList::where('grading_exams_id', $_GET['grading_id'])->where('grading_exams_id',$_GET['grading_id'])->get();
                                        @endphp
                                            @foreach($list as $item)
                                            <option value="{{ $item->id }}"  @if(isset($_GET['list_id']) && $_GET['list_id']==$item->id) selected @endif>{{ $item->heading }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('list_id'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('list_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="paper_id">Paper</label>
                                    <select name="paper_id" class="form-control" id="paper_id">
                                        <option value="">-- Select --</option>
                                        @if(isset($_GET['list_id']))
                                        @php
                                        $paper = \App\GradingListingDetail::where('grading_listing_id', $_GET['list_id'])->get();
                                        @endphp
                                            @foreach($paper as $val)
                                            <option value="{{ $val->id }}"  @if(isset($_GET['list_id']) && $_GET['list_id']==$val->id) selected @endif>{{ $val->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('paper_id'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('paper_id') }}</strong>
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

        <script>
        $('#grading_id').on('change', function(){
        window.location = "{{ url('/') }}/admin/grading-result-upload?grading_id="+$(this).val();
        });
        @if(isset($_GET['grading_id']))
        $('#list_id').on('change', function(){
        window.location = "{{ url('/') }}/admin/grading-result-upload?grading_id={{ $_GET['grading_id'] }}&list_id="+$(this).val();
        });
        @endif
        </script>

@endsection
