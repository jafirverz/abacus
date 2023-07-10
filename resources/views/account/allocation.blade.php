@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            @include('inc.account-sidebar')
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <h1 class="title-3">Test and Survey Allocation</h1>
                <div class="box-1">
                    <h2 class="title-4">Online Test</h2>
                    <ul class="list-4">
                        @if($test->count())
                        @foreach ($test as $key => $item)
                        <li><a href="{{ url('allocation/test/'.$item->id) }}">{{ $item->title }}</a></li>
                        @endforeach
                        @else
                        <li>{{ __('constant.NO_DATA_FOUND') }}</li>
                         @endif
                    </ul>
                    <h2 class="title-4 mt-40">Surveys</h2>
                    <ul class="list-4">
                        @if($survey->count())
                        @foreach ($survey as $key => $item)
                        <li><a href="{{ url('allocation/survey/'.$item->id) }}">{{ $item->title }}</a></li>
                        @endforeach
                        @else
                        <li>{{ __('constant.NO_DATA_FOUND') }}</li>
                         @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
