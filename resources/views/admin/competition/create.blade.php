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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('competition.store') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                

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
                                    <label for="title">Competition Type</label>
                                    <select name="competition_type" class="form-control" >
                                        <option value="">-- Select --</option>
                                        <option value="online" @if(old('competition_type') == 'online') selected @endif>Online</option>
                                        <option value="physical" @if(old('competition_type') == 'physical') selected @endif>Physical</option>
                                    </select>
                                    @if ($errors->has('competition_type'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('competition_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                               

                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select name="category[]" class="form-control" multiple>
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
                                    <label for="title">Date of competition</label>
                                    <input type="text" name="date_of_competition" class="form-control datepicker1" id=""
                                        value="{{ old('date_of_competition') }}">
                                    @if ($errors->has('date_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('date_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Start Time of competition</label>
                                    <select name="start_time_of_competition" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="10">10.00</option>
                                        <option value="11">11.00</option>
                                        <option value="12">12.00</option>
                                        <option value="13">13.00</option>
                                        <option value="14">14.00</option>
                                        <option value="15">15.00</option>
                                        <option value="16">16.00</option>
                                        <option value="17">17.00</option>
                                        <option value="18">18.00</option>
                                        <option value="19">19.00</option>
                                        <option value="20">20.00</option>
                                    </select>
                                    
                                    @if ($errors->has('start_time_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('start_time_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">End Time of competition</label>
                                    <select name="end_time_of_competition" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="10">10.00</option>
                                        <option value="11">11.00</option>
                                        <option value="12">12.00</option>
                                        <option value="13">13.00</option>
                                        <option value="14">14.00</option>
                                        <option value="15">15.00</option>
                                        <option value="16">16.00</option>
                                        <option value="17">17.00</option>
                                        <option value="18">18.00</option>
                                        <option value="19">19.00</option>
                                        <option value="20">20.00</option>
                                    </select>
                                    
                                    @if ($errors->has('end_time_of_competition'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('end_time_of_competition') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" class="form-control my-editor" cols="30"
                                              rows="5">{{old('description')}}</textarea>
                                </div>

                                {{-- 
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                            <option value="{{ $key }}" @if(old('status')==$key) selected @elseif($key==1) selected @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                --}}

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
