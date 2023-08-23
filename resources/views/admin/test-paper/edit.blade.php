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
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('test_paper_crud', 'Edit', route('test-paper.edit', $paper->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('test-paper.update', $paper->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $paper->title) }}">
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
                                            <option value="{{ $item->id }}" @if(old('question_template_id',$paper->question_template_id)==$item->id)
                                                selected
                                                @endif>{{ $item->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('question_template_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_template_id') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="paper_type">Paper Type</label>
                                    <select disabled name="paper_type" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getPaperType())
                                        @foreach (getPaperType() as $key => $item)
                                            <option value="{{ $key }}" @if(old('paper_type', $paper->paper_type)==$key) selected  @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('paper_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('paper_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @if($paper->paper_type==2)
                                <div class="form-group">
                                    <label for="title">Video Upload</label>
                                    <input type="file" name="video_file" class="form-control" id="">
                                    @if ($errors->has('video_file'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('video_file') }}</strong>
                                    </span>
                                    @endif
                                    @if($paper->video_file)
                                    <a href="{{ asset($paper->video_file) }}" target="_blank">Video</a>
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
                                    @if($paper->pdf_file)
                                    <a href="{{ asset($paper->pdf_file) }}" target="_blank">PDF</a>
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
                                    @if($paper->powerpoint_file)
                                    <a href="{{ asset($paper->powerpoint_file) }}" target="_blank">Powerpoint</a>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Abacus Simulator Link</label>
                                    <input type="text" name="simulator_link" class="form-control" value="{{ old('simulator_link',$paper->simulator_link) }}" id="">
                                    @if ($errors->has('simulator_link'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('simulator_link') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea class="form-control my-editor" name="description">{{ old('description',$paper->description) }}</textarea>
                                </div>
                               @endif
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
@endsection
