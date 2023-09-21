@extends('layouts.app')
@section('content')
<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
        @include('inc.account-sidebar')
      @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <h1 class="title-3">My Membership</h1>
        <div class="box-1">
          <div class="xscrollbar">
            <table class="tb-2 tbtype-4">
              <thead>
                <tr class="text-uppercase">
                  <th>Order No.</th>
                  <th>Level Name</th>
                  <th>Membership Period</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Paid Amount</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orderDetails as $order)
                  @php
                  $levelId = $order->level_id;
                  $levelDetails = \App\Level::where('id', $levelId)->first();
                  @endphp
                @if($levelId)
                <tr>
                  <td><em>{{ $order->order_id }}</em></td>
                  <td><em><a href="/level/{{ $order->level->slug ?? '' }}">{{ $order->name }} {{ $order->level_id }}</a></em></td>
                  <td><em>{{ $levelDetails->premium_months ?? '' }} </em></td>
                  <td><em>{{ date('Y-m-d', strtotime($order->created_at)) }}</em></td>
                  <td><em>{{ $order->expiry_date }}</em></td>
                  <td>${{ $order->amount }}</td>
                </tr>
                @endif
                @endforeach
                
              </tbody>
            </table>
          </div>
          <ul class="page-numbers mt-30">
            {{$orderDetails->links()}}
          </ul>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection