@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            @if(Auth::user()->user_type_id == 6)
            <div class="menu-aside">
             @include('inc.account-sidebar-external')
            </div>
            @else
            <div class="menu-aside">
             @include('inc.intructor-account-sidebar')
            </div>
            @endif
        </div>

        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="row title-wrap-1">
                    <div class="col-md-6 order-md-first mt-767-20">
                        <h1 class="title-3">Grading Examinations</h1>
                    </div>
                </div>
                @if($grading_exam)
                @foreach($grading_exam as $grade)
                <div class="grid-13">
                    <div class="gday">
                        {{ date('j M Y',strtotime($grade->date_of_competition)) }}
                    </div>
                    <div class="gtitle">
                        {{ $grade->title }}
                    </div>
                    <a class="link-fix" href="{{ url('grading-examination',$grade->id) }}">View details</a>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</main>

@endsection
