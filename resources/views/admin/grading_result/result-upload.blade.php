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
                                        <option value="{{ $grade->id }}"  @if(isset($_GET['grade_id']) && $_GET['grade_id']==$grade->id) selected @endif>{{ $grade->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('grading_id'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('grading_id') }}</strong>
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
