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
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('worksheet.store') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <!-- <div class="form-group">
                                    <label for="type">Topics</label>
                                    @php
                                    $postTopic = old('topic') ?? [];
                                    @endphp
                                    <select name="topic[]" class="form-control" id="" style="height: 200px;" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($topics as $topic)
                                            <option value="{{$topic->id}}" @if(in_array($topic->id, $postTopic)) selected @endif>{{$topic->title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('topic'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('topic') }}</strong>
                                    </span>
                                    @endif
                                </div> -->

                                <div class="form-group">
                                    <label for="type">Level</label>
                                    @php
                                    $postLevel = old('level') ?? [];
                                    @endphp
                                    <select name="level[]" class="form-control" id="" style="height: 100px;" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($levels as $topic)
                                            <option value="{{$topic->id}}" @if(in_array($topic->id, $postLevel)) selected @endif>{{$topic->title}}</option>
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
                                        <option value="1" @if(old('fee') == 1) selected @endif>Free</option>
                                        <option value="2" @if(old('fee') == 2) selected @endif>Paid</option>
                                    </select>
                                    @if ($errors->has('fee'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('fee') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @php
                                $feeP = old('fee') ?? '';
                                if(empty($feeP) || $feeP == 1){
                                    $stylee = 'display: none';
                                }else{
                                    $stylee = 'display: block';
                                }
                                @endphp
                                <div class="form-group" style="{{$stylee}}"  id="amountblock">
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
                                        @foreach($questionTempleates as $questionTemp)
                                        <option value="{{ $questionTemp->id }}" @if(old('questionTemp') == $questionTemp->id) selected @endif>{{ $questionTemp->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('questiontemplate'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('questiontemplate') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- <div class="form-group">
                                    <label for="title">Question Type</label>
                                    <select name="questiontype" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if(old('questiontype') == 1) selected @endif>Vertical</option>
                                        <option value="2" @if(old('questiontype') == 2) selected @endif>Horizontal</option>
                                    </select>
                                    @if ($errors->has('questiontype'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('questiontype') }}</strong>
                                    </span>
                                    @endif
                                </div> -->

                                <div class="form-group">
                                    <label for="title">Stopwatch timing</label>
                                    <select name="stopwatch" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if(old('stopwatch') == 1) selected @endif>Yes</option>
                                        <option value="2" @if(old('stopwatch') == 2) selected @endif>No</option>
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
                                        <option value="1" @if(old('presettiming') == 1) selected @endif>Yes</option>
                                        <option value="2" @if(old('presettiming') == 2) selected @endif>No</option>
                                    </select>
                                    @if ($errors->has('presettiming'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('presettiming') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Timing</label>
                                    <input type="text" name="timing" value="" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    @if ($errors->has('timing'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('timing') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" class="form-control my-editor" cols="30"
                                              rows="5">{{old('description')}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Account Accessibility</label>
                                    <select name="account_accessibility" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="8">Franchise</option>
                                        <option value="5">Instructor</option>
                                        <option value="1">Student</option>
                                        <option value="3">Online Student</option>
                                        <option value="10">Public</option>
                                        
                                    </select>
                                    @if ($errors->has('account_accessibility'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('account_accessibility') }}</strong>
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
