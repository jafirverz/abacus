@extends('layouts.app')

@section('content')
    <main class="main-wrap">
        <div class="row sp-col-0 tempt-2">
            <div class="col-lg-3 sp-col tempt-2-aside">
                @if(Auth::user()->user_type_id == 1)
                    @include('inc.account-sidebar')
                @endif
            </div>
            <div class="col-lg-9 sp-col tempt-2-inner">
                @if(Auth::user()->user_type_id == 1)
                    @include('inc.my_profile_view')
                @elseif(Auth::user()->user_type_id == 5)
                    @include('account.instructor-overview')
                @endif

            </div>
        </div>
    </main>
@endsection
