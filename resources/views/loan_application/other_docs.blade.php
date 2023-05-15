@extends('layouts.app')

@section('content')
<div class="main-wrap">
    <div class="container main-inner">
        <h2 class="title-2 mt-50 mt-991-30">{{ $title ?? '' }}</h2>
        <div class="table-responsive">
            <table class="tb-1 detail text-center">
                <thead>
                    <tr>
                        <th rowspan="1" colspan="2">Name</th>
                        <!-- <th rowspan="2">Additional Documents</th> -->
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($loan_application->cpfcontributionhistory))
                    @php 
                    $cpfHistory = json_decode($loan_application->cpfcontributionhistory, true);
                    @endphp
                    <tr>
                        @if($cpfHistory)
                        @foreach($cpfHistory as $value)
                        <td>
                            <a href="{{ asset('documents/'.$value) }}" target="_blank">
                                CPF Contribution History Attachement
                            </a>
                        </td>
                        @endforeach
                        @endif
                    </tr>
                    @endif
                    @if(!empty($loan_application->noticeofassessment))
                    @php 
                    $noaHistory = json_decode($loan_application->noticeofassessment, true);
                    @endphp
                    <tr>
                        @if($noaHistory)
                        @foreach($noaHistory as $value)
                        <td>
                            <a href="{{ asset('documents/'.$value) }}" target="_blank">
                                Notice of Assessment
                            </a>
                        </td>
                        @endforeach
                        @endif
                    </tr>
                    
                    @endif

                    @if(empty($loan_application->cpfcontributionhistory) && empty($loan_application->noticeofassessment))
                    <tr>
                        <td colspan="2">No Data Available</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
