@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
    <div class="bn-inner bg-get-image">
        <img class="bgimg" src="images/tempt/bn-loan.jpg" alt="Loan Applications">
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
                

                <div class="table-responsive">
                    <table class="tb-1 type">
                        <thead>
                            <tr>
                                
                                <th class="text-center">Sr. No.</th>
                                <th>Vehicle No.</th>
                                <th>Name</th>
                                <th>NRIC</th>
                                <th>Contact No.</th>
                                <th>Loan Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($loan_application->count())
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($loan_application as $item)
                            <tr>
                                
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ $item->vehicle_registration_no ?? '' }}</td>
                                <td>{{ $item->user->name ?? '' }}</td>
                                <td>{{ $item->nric_company_registration_no ?? '' }}</td>
                                <td>{{ $item->user->mobile ?? '' }}</td>
                                <td>{{ '$'.$item->loan_amount ?? 0 }}</td>
                                <td>{{ getLoanStatus($item->status) }}</td>
                                <td>
                                    <a class="lnk-1"
                                        href="{{ url('loan-applications/'.strtotime($item->created_at).'/'.$item->id) }}">View
                                        Application</a>
                                    <br /><a
                                        href="{{ url('loan-applications/other-docs/'.strtotime($item->created_at).'/'.$item->id) }}"
                                        class="lnk-1" target="_blank">View Other Docs</a>
                                </td>
                            </tr>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                            @endif
                            <tr>
                                <td colspan="8">{{ $loan_application->links() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#checkbox-all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
                $('.badge-transparent').text('5');
            }else{
                 $('.checkbox').each(function(){
                    this.checked = false;
                });
                $('.destroy').addClass('d-none');
            }
        });
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });

    function confirmDeleteData(event){
        var employee = [];  
        $(".checkbox:checked").each(function() {  
            employee.push($(this).data('id'));
        });	
        if(employee.length <=0)  {  
            alert("Please select records.");  
        }else{
            if (confirm("Are you sure you want to archive the form?")) {
                $('#multiple_archive').val(employee);
                $('#destroy').submit();
            }
            return false;
            
        }
    }
    </script>
@endsection