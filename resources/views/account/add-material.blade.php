@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
           <div class="menu-aside">
                @include('inc.intructor-account-sidebar')

            </div>
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <h1 class="title-3">My Profile</h1>
                <div class="box-1">
                    <div class="row align-items-center title-type">
                        <div class="col-md">
                            <h2 class="title-2">Add Teaching Materials</h2>
                        </div>
                    </div>
                <form method="post" name="student" id="student" enctype="multipart/form-data" action="">
                    @csrf
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-12 sp-col">
                            <label class="lb-1">Title <span class="required">*</span></label>
                            <input class="form-control" name="title" type="text" value="{{ old('title') }}"  />
                            @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-12 sp-col">
                            <label class="lb-1">Uploaded Files</label>
                            <input type="file" name="uploaded_files" class="form-control">
                            @if ($errors->has('uploaded_files'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('uploaded_files') }}</strong>
                                    </span>
                                    @endif
                        </div>
                    </div>
                    
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-12 sp-col">
                            <label class="lb-1">Description</label>
                            <input name="description" class="form-control" type="text" value="{{ old('description') }}"  />
                        </div>
                    </div>


                    <div class="output-2">
                        <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </form>
                </div>

            </div>
        </div>

    </div>
</main>

@endsection
