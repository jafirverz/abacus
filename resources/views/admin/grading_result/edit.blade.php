@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">

                <a href="{{ route('grading-students.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-students.update', $grading->id) }}" method="post">

                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="mental_grade">Mental Grade</label>
                                    <select name="mental_grade" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if($mental_grades)
                                        @foreach($mental_grades as $item)
                                        <option value="{{ $item->id }}" @if(old('mental_grade',$grading->mental_grade)==$item->id)
                                            selected
                                            @endif>{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('mental_grade'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('mental_grade') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="abacus_grade">Abacus Grade</label>
                                    <select name="abacus_grade" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if($abacus_grades)
                                        @foreach($abacus_grades as $item)
                                        <option value="{{ $item->id }}" @if(old('abacus_grade',$grading->abacus_grade)==$item->id)
                                            selected
                                            @endif>{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('abacus_grade'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('abacus_grade') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" name="remarks" class="form-control" id="" value="{{ old('remarks', $grading->remarks) }}">

                                    @if ($errors->has('remarks'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('remarks') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">

                                    <label for="approve_status">Status</label>
                                    <select name="approve_status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (getRegisterStatus())
                                        @foreach (getRegisterStatus() as $key => $value)
                                        <option value="{{ $key }}" @if(old('approve_status',$grading->approve_status)==$key)
                                            selected
                                            @endif>{{ $value }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('approve_status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('approve_status') }}</strong>

                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
