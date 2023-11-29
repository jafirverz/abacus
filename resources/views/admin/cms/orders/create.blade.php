@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('admin/orders') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('orders.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" class="form-control" id=""
                                        value="{{ old('amount') }}">
                                    @if ($errors->has('amount'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                  <label for="expirydate">Expiry Date</label>
                                  <input type="text" name="expirydate" class="form-control datepicker1" id=""
                                      value="{{ old('expirydate') }}">
                                  @if ($errors->has('expirydate'))
                                  <span class="text-danger d-block">
                                      <strong>{{ $errors->first('expirydate') }}</strong>
                                  </span>
                                  @endif
                              </div>

                                


                                <div class="form-group">
                                    <label for="title">Select Student</label>
                                    <select name="studen" class="form-control" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id}}" @if(old('studen')==$student->id) selected @endif>{{$student->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('studen'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('studen') }}</strong>
                                    </span>
                                    @endif
                                </div>

                               

                                <div class="form-group">
                                    <label for="title">Level</label>
                                    <select name="level[]" class="form-control" multiple>
                                        <option value="">-- Select --</option>
                                        @foreach($levels as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level'))
                                        <span class="text-danger d-block">
                                        <strong>{{ $errors->first('level') }}</strong>
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
