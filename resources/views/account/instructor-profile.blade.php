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
                            <h2 class="title-2">Personal Information</h2>
                        </div>
                        <div class="col-md-auto mt-767-10">
                            <a class="link-1" href="#">Edit My Information</a>
                        </div>
                    </div>
                    <div class="mt-20"><label>Account ID:</label> {{ $user->account_id }}</div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $user->name }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Email <span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $user->email  }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Password <span class="required">*</span></label>
                            <input class="form-control" type="password" placeholder="*****" disabled />
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Date of Birth <span class="required">*</span></label>
                            <div class="date-wrap disabled">
                                <i class="fa-solid fa-calendar-days ico"></i>
                                <input class="form-control" type="text" value="{{ $user->dob  }}" disabled />
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Phone <span class="required">*</span></label>
                            <div class="row sp-col-10">
                                <div class="col-auto sp-col">
                                    <select class="selectpicker" disabled>
                                        <option>{{ $user->country_code_phone  }}</option>
                                    </select>
                                </div>
                                <div class="col sp-col">
                                    <input class="form-control" type="text" value="{{ $user->mobile  }}" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Gender <span class="required">*</span></label>
                            <select class="selectpicker" disabled>
                                <option>Please Select</option>
                                <option @if($user->gender==2) selected @endif>Female</option>
                                <option @if($user->gender==1) selected @endif>Male</option>
                            </select>
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Country <span class="required">*</span></label>
                            <select class="selectpicker" disabled>
                                @if(getCountry())
                                @foreach (getCountry() as $key => $item)
                                <option value="{{ $key }}" @if($user->country_code==$key) selected @endif>{{ $item }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Address</label>
                            <input class="form-control" type="text" value="{{ $user->address  }}" disabled />
                        </div>
                    </div>
                    <h2 class="title-2 mt-50">Academic Information</h2>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Year Attained Qualified Instructor Certification</label>
                            <input class="form-control" type="text" value="{{ $user->year_attained_qualified_instructor  }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Year Attained Senior Instructor Certification</label>
                            <input class="form-control" type="text" value="{{ $user->year_attained_senior_instructor  }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Highest Abacus Grade Attained</label>
                            <input class="form-control" type="text" placeholder="{{ $user->highest_abacus_grade  }}" disabled />
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Highest Mental Grade Attained</label>
                            <input class="form-control" type="text" value="{{ $user->highest_mental_grade  }}" disabled />
                        </div>
                    </div>
                    <label class="lb-1">Awards:</label>
                    <div class="txtwrap">
                        {!! $user->awards  !!}
                    </div>
                    <div class="output-2">
                        <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
                <div class="row sp-col-20 grid-9">
                    <div class="col-sm-6 sp-col">
                        <div class="inner">
                            <h4>My Students' Best Grading Examination Achievement</h4>
                            <h5>Student Name</h5>
                            <p>Jonathan Lee Than</p>
                            <h5>Year</h5>
                            <p>Grade 7</p>
                            <h5>Highest Grade (mental)</h5>
                            <p>Super Degree</p>
                            <h5>Highest Grade (Abacus)</h5>
                            <p>Grade 1</p>
                        </div>
                    </div>
                    <div class="col-sm-6 sp-col">
                        <div class="inner">
                            <h4>My Students' Best Competition Achievement</h4>
                            <h5>Student Name</h5>
                            <p>Jonathan Lee Than</p>
                            <h5>Year</h5>
                            <p>Grade 7</p>
                            <h5>Competition</h5>
                            <p>Super Degree</p>
                            <h5>Price</h5>
                            <p>1st</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
