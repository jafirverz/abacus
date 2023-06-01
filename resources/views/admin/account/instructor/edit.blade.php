@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('instructor-account.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('instructor_account_crud', 'Edit',
            route('instructor-account.edit', $customer->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('instructor-account.update', $customer->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Full Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $customer->name) }}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Email Address</label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="">Date Of Birth</label>
                                    <input type="text" name="dob" class="form-control datepicker" value="{{ old('dob', $customer->dob) }}">
                                    @if ($errors->has('dob'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="country_code_phone" class="form-control"
                                                    value="{{ old('country_code_phone', $customer->country_code_phone) }}">
                                                @if ($errors->has('country_code_phone'))
                                                <span class="text-danger d-block">
                                                    <strong>{{ $errors->first('country_code_phone') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-9">
                                                    <input type="text" name="mobile" class="form-control"
                                                        value="{{ old('mobile', $customer->mobile) }}">
                                                    @if ($errors->has('mobile'))
                                                    <span class="text-danger d-block">
                                                        <strong>{{ $errors->first('mobile') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <select name="gender" class="form-control" tabindex="-98">
                                        <option value="1" @if(old('gender', $customer->gender)=="1") selected @endif>Male
                                        </option>
                                        <option value="2" @if(old('gender', $customer->gender)=="2") selected @endif>Female
                                        </option>
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('name', $customer->address) }}">
                                    @if ($errors->has('address'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="country_code">Country</label>
                                    <select name="country_code" class="form-control" id="country_code">
                                        <option value="">-- Select --</option>
                                        @if(getCountry())
                                        @foreach (getCountry() as $key => $item)
                                        <option value="{{ $key }}" @if(old('country_code', $customer->country_code)==$key) selected @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('country_code'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country_code') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Year Attained Qualified Instructor Certification</label>
                                    <input type="text" name="year_attained_qualified_instructor" class="form-control" value="{{ old('year_attained_qualified_instructor', $customer->year_attained_qualified_instructor) }}">
                                    @if ($errors->has('year_attained_qualified_instructor'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('year_attained_qualified_instructor') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Year Attained Senior Instructor Certification</label>
                                    <input type="text" name="year_attained_senior_instructor" class="form-control" value="{{ old('year_attained_senior_instructor', $customer->year_attained_senior_instructor) }}">
                                    @if ($errors->has('year_attained_senior_instructor'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('year_attained_senior_instructor') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Highest Abacus Grade Attained</label>
                                    <input type="text" name="highest_abacus_grade" class="form-control" value="{{ old('highest_abacus_grade', $customer->highest_abacus_grade) }}">
                                    @if ($errors->has('highest_abacus_grade'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('highest_abacus_grade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Highest Mental Grade Attained</label>
                                    <input type="text" name="highest_mental_grade" class="form-control" value="{{ old('highest_mental_grade', $customer->highest_mental_grade) }}">
                                    @if ($errors->has('highest_mental_grade'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('highest_mental_grade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Awards</label>
                                    <textarea name="awards" class="form-control">{{ old('awards', $customer->awards) }}</textarea>
                                    @if ($errors->has('awards'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('awards') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control">
                                    @if ($errors->has('password'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status', $customer->approve_status)==$key) selected @endif>{{ $item }}
                                        </option>
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
