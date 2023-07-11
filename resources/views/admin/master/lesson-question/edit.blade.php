@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lesson-questions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Edit', route('bank.edit', $bank->id))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('lesson-questions.update', $question->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="status">Select Question Template</label>
                                    <select name="questionTemplate" class="form-control" disabled >
                                        <option value="">-- Select Question Template --</option>
                                        @foreach($questionTemplates as $key => $item)
                                            <option value="" @if($question->question_template_id==$item->id) selected @endif>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('questionTemplate'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('questionTemplate') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">Select Lesson</label>
                                    <select name="lesson" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($lessons as $key => $item)
                                            <option value="{{ $item->id }}" @if($question->lesson_id==$item->id) selected @endif>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('lesson'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('lesson') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $question->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Video Upload</label>
                                    <input type="file" name="videofile" class="form-control" id="">
                                    @if ($errors->has('videofile'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('videofile') }}</strong>
                                    </span>
                                    @endif
                                    @if($question->video)
                                    <a href="{{ asset($question->video) }}" target="_blank">Video</a>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">PDF Upload</label>
                                    <input type="file" name="pdf" class="form-control" id="">
                                    @if ($errors->has('pdf'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('pdf') }}</strong>
                                    </span>
                                    @endif
                                    @if($question->pdf)
                                    <a href="{{ asset($question->pdf) }}" target="_blank">PDF</a>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Powerpoint Upload</label>
                                    <input type="file" name="powerpoint" class="form-control" id="">
                                    @if ($errors->has('powerpoint'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('powerpoint') }}</strong>
                                    </span>
                                    @endif
                                    @if($question->powerpoint)
                                    <a href="{{ asset($question->powerpoint) }}" target="_blank">Powerpoint</a>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Abacus Simulator Link</label>
                                    <input type="text" name="abacus" class="form-control" id="" value="{{ old('', $question->abacus_link) }}">
                                    @if ($errors->has('abacus'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('abacus') }}</strong>
                                    </span>
                                    @endif
                                </div>



                                

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea class="form-control my-editor" name="description">{{ old('description', $question->description) }}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                            <option value="{{ $key }}" @if(isset($question->status)) @if($question->status==$key) selected @endif @elseif(old('status')==$key) selected @elseif($key==1) selected @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
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
@endsection
