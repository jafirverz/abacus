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
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
          @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('assign-grading.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                              <input type="hidden" name="competitionId" value="{{ $competition->id }}">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $competition->title) }}" disabled>
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select name="category" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($competitionCategory as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                    @endif
                                </div>




                                <div class="form-group">
                                    <label for="title">Select Student</label>
                                    <select name="students[]" class="form-control" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student ->id}}">{{$student->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('students'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('students') }}</strong>
                                    </span>
                                    @endif
                                </div>










                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if(old('status') == 1) selected @endif>Approved</option>
                                        <option value="0" @if(old('status') == 0) selected @endif>Not Approved/Pending</option>
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
