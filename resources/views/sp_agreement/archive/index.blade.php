@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
    <div class="bn-inner bg-get-image">
        <img class="bgimg" src="{{ asset('images/tempt/bn-loan.jpg') }}" alt="Loan Applications">
    </div>
    <div class="container main-inner">
        <div class="row">
            <div class="col-lg-3 mb-991-30">
                @include('inc.account-profile-image')
                @include('inc.account-sidebar')

            </div>
            <div class="col-lg-9">
                <div class="title-5">
                    <h1>{{ $title ?? '' }}</h1>
                </div>
                @include('inc.messages')

                <div class="table-responsive">
                    <table class="tb-1 type">
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th>Form Type</th>
                                <th>Seller's Name</th>
                                <th>Buyer's Name</th>
                                <th>Vehicle Reg. No.</th>
                                <th>Make/Model</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($seller_particular->count())
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($seller_particular as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td>S&P Agreement</td>
                                    <td>{{ $item->user->name ?? '' }}</td>
                                    <td>{{ $item->userbuyer->name ?? '' }}</td>
                                    <td>{{ $item->vehicleparticular->registration_no ?? '' }}</td>
                                    <td>{{ $item->vehicleparticular->make . ' ' . $item->vehicleparticular->model }}</td>
                                    <td>
                                        <a class="lnk-1" href="{{ url('forms/form-details/view/'.strtotime($item->created_at).'/'.$item->id) }}">View Form</a><br/>
                                        <a href="{{ url('my-forms/archived/active', $item->id) }}"  class="lnk-1">Set Active</a>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            @endif
                            <tr><td colspan="7">{{ $seller_particular->links() }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
