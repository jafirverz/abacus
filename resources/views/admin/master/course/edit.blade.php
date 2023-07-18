@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('course.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
         @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('course_crud', 'Edit', route('course.edit', $course->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('course.update', $course->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Level</label>
                                    <select name="level" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @foreach($levels as $level)
                                            <option value="{{$level->id}}" @if($level->id == $course->level_id) selected @endif>{{$level->title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $course->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group non-external">
                                    <label for="content">Content</label>
                                    <textarea name="content" class="form-control my-editor" id="" cols="30"
                                        rows="10">{!! old('content', $course->content) !!}</textarea>
                                    @if ($errors->has('content'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="paper_id">Paper</label>
                                    <select name="paper_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($papers)
                                        @foreach ($papers as $item)
                                        <option value="{{ $item->id }}" @if(old('paper_id',$course->paper_id)==$item->id)
                                            selected
                                            @endif>{{ $item->title }}</option>
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
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                            <option value="{{ $key }}" @if(isset($course->status)) @if($course->status==$key) selected @endif @elseif(old('status')==$key) selected @elseif($key==1) selected @endif>{{ $item }}</option>
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
