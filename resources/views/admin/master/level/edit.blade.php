@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('level.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Edit', route('bank.edit', $bank->id))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('level.update', $level->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $level->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea class="form-control" name="description">{{ old('description', $level->description) }}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="title">Image</label>
                                    <input type="file" name="image" class="form-control" >
                                    
                                </div>

                                <div class="form-group">
                                    <label for="title">Premium Months</label>
                                    <input type="text" name="months" class="form-control" id=""
                                        value="{{ old('months', $level->premium_months) }}">
                                    @if ($errors->has('months'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('months') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Premium Amount</label>
                                    <input type="text" name="amount" class="form-control" id=""
                                        value="{{ old('amount', $level->premium_amount) }}">
                                    @if ($errors->has('amount'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                            <option value="{{ $key }}" @if(isset($level->status)) @if($level->status==$key) selected @endif @elseif(old('status')==$key) selected @elseif($key==1) selected @endif>{{ $item }}</option>
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
