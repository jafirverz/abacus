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
                @endif

            </div>
        </div>
    </main>
@endsection
