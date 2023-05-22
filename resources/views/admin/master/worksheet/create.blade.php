@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('worksheet.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('topic.store') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="type">Topics</label>
                                    <select name="level" class="form-control" id="" style="height: 200px;" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($topics as $topic)
                                            <option value="{{$topic->id}}">{{$topic->title}}</option>
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
                                        value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Free/Paid</label>
                                    <select name="fee" class="form-control" onchange="showAmount(this.value);">
                                        <option value="">-- Select --</option>
                                        <option value="1">Free</option>
                                        <option value="2">Paid</option>
                                    </select>
                                    @if ($errors->has('fee'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('fee') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group" style="display: none" id="amountblock">
                                    <label for="title">Amount</label>
                                    <input type="text" name="amount" class="form-control" id=""
                                           value="{{ old('amount') }}">
                                    @if ($errors->has('amount'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Question Template</label>
                                    <select name="questiontemplate" class="form-control">
                                        <option value="">-- Select --</option>
                                    </select>
                                    @if ($errors->has('questiontemplate'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('questiontemplate') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Stopwatch timing</label>
                                    <select name="stopwatch" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                    @if ($errors->has('stopwatch'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('stopwatch') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Preset Timing</label>
                                    <select name="presettiming" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                    @if ($errors->has('presettiming'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('presettiming') }}</strong>
                                    </span>
                                    @endif
                                </div>




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
    function showAmount(val){
        if(val==2){
            $('#amountblock').show();
        }else{
            $('#amountblock').hide();
        }
    }
</script>
@endsection
