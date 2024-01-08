@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('test-paper.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('test_paper_crud', 'Create', route('test-paper.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('test-paper.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="paper_type">Paper Type</label>
                                    <select  class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select --</option>
                                        @if(getPaperType())
                                        @foreach (getPaperType() as $key => $item)
                                            <option  value="?paper-type={{ $key }}" @if(old('paper_type')==$key) selected @elseif(isset($_GET['paper-type']) && $key==$_GET['paper-type']) selected @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" name="paper_type" value=" @if(isset($_GET['paper-type'])) {{ $_GET['paper-type'] }} @endif">
                                    @if ($errors->has('paper_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('paper_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if(isset($_GET['paper-type']) && $_GET['paper-type']!="")
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
                                <div class="form-group">
                                    <label for="question_template_id">Question Template</label>
                                    <select name="question_template_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($questions)
                                            @foreach ($questions as $key=>$item)
                                            <option @if(isset($_GET['paper-type']) && $_GET['paper-type']==1 && in_array($item->id,[1,2])) disabled @endif value="{{ $item->id }}" @if(old('question_template_id')==$item->id)
                                                selected
                                                @endif>{{ $item->title }}</option>
                                            @endforeach
                                            @if(isset($_GET['paper-type']) && $_GET['paper-type']==1)
                                                <option  @if(old('question_template_id')==11)
                                                    selected
                                                    @endif value="11">Other</option>
                                            @endif
                                        @endif
                                    </select>
                                    @if ($errors->has('question_template_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_template_id') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                @endif
                                @if(isset($_GET['paper-type']) && $_GET['paper-type']==2)
                                <div class="form-group">
                                    <label for="title">Video Upload</label>
                                    <input type="file" name="video_file" class="form-control" id="">
                                    @if ($errors->has('video_file'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('video_file') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">PDF Upload</label>
                                    <input type="file" name="pdf_file" class="form-control" id="">
                                    @if ($errors->has('pdf_file'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('pdf_file') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Powerpoint Upload</label>
                                    <input type="file" name="powerpoint_file" class="form-control" id="">
                                    @if ($errors->has('powerpoint_file'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('powerpoint_file') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Abacus Simulator Link</label>
                                    <input type="text" name="simulator_link" class="form-control" id="">
                                    @if ($errors->has('simulator_link'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('simulator_link') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea class="form-control my-editor" name="description">{{ old('description') }}</textarea>
                                </div>
                               @endif

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
