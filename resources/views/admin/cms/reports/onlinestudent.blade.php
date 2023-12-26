@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ $title ?? '-' }}</h1>



    </div>
    <form action="{{ route('reports-online.search') }}" method="get" id="formreport">
      @csrf
      <div class="section-body">

        <div class="row">
          @php
          if(!empty($_GET['student'])){
            $student = $_GET['student'];
          }else{
            $student = '';
          }
          if(!empty($_GET['status'])){
            $status = $_GET['status'];
          }else{
            $status = '';
          }
          @endphp

          <div class="col-lg-4"><label>Status:</label>
            <select name="status" class="form-control">
              <option value="">--Please Select--</option>
              <option value="1" @if($status == 1) selected @endif>Active</option>
              <option value="2" @if($status == 2) selected @endif>Deactivated</option>
            </select>
          </div>

          <div class="col-lg-4"><label>Student:</label>
            <select name="student" class="form-control">
              <option value="">--Please Select--</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}" @if($student == $user->id) selected @endif>{{ $user->name }}, {{ $user->account_id }}</option>
              @endforeach
            </select>
          </div>




        </div>

        <br />
        <input type="hidden" name="downloadexcel" value="" id="downloadexcel">
        <div class="row">
          <div class="col-lg-4">
            <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" onclick="formsubmit();"> Export</button>&nbsp;&nbsp;
            @if(request()->get('_token'))
            <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
            @else
            <button type="reset" class="btn btn-primary">Clear All</button>
            @endif

          </div>



        </div>


      </div>
    </form><br />

    <div class="section-body">
      @include('admin.inc.messages')

      <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <a href="javascript:void(0);" class="btn btn-info mr-1 d-none excel" onclick="event.preventDefault();document.getElementById('excel').submit();"><i class="fas fa-file-download"></i> Excel</a>

              <form id="excel" action="{{ route('salesexcel') }}" method="post">
                @csrf
                @method('POST')
                <input type="hidden" name="excel_id">
                <input type="hidden" name="country" value="{{ $_GET['country'] ?? '' }}">
                <input type="hidden" name="start_date" value="{{ $_GET['start_date'] ?? '' }}">
                <input type="hidden" name="end_date" value="{{ $_GET['end_date'] ?? '' }}">
              </form>
              <!-- <a href="{{ route('pages.destroy', 'pages') }}" class="btn btn-danger d-none destroy"
                data-confirm="Do you want to continue?"
                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                  class="badge badge-transparent">0</span></a>
              <form id="destroy" action="{{ route('pages.destroy', 'pages') }}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="multiple_delete">
              </form> -->
              <h4></h4>

            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-md">
                  <thead>
                    <tr>
                      <!-- <th>
                        <div class="custom-checkbox custom-control">
                          <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                            class="custom-control-input" id="checkbox-all">
                          <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                        </div>
                      </th> -->
                      <th>S/N</th>
                      <th>Lesson Title</th>
                      <th>Lesson Status</th>
                      <th>Completion Date/Time</th>
                      <th>Survey Status</th>
                      <th>Certificate Issued on</th>
                      <th>Last Login</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(isset($allOrders) && count($allOrders) > 0)
                    @php
                    $i = 1;
                    @endphp
                    @foreach($allOrders as $value)

                    @php

                    $users = \App\User::where('id', $value->user_id)->first();
                    $orderDetails = \App\OrderDetail::where('order_id', $value->id)->pluck('name')->toArray();
                    $orderDetails = implode(', ',$orderDetails);
                    @endphp
                    <tr>
                        <!-- <td>
                          <div class="custom-checkbox custom-control"> <input type="checkbox"
                                  data-checkboxes="mygroup" class="custom-control-input"
                                  id="checkbox-{{ ($i) }}" value="{{ $value->id }}">
                              <label for="checkbox-{{ ($i) }}"
                                  class="custom-control-label">&nbsp;</label></div>
                        </td> -->
                        <td>{{ $i }}</td>
                        <td>{{ $value->course->title }}</td>
                        <td>@if(isset($value->submitted->is_submitted) && $value->submitted->is_submitted==1) Submitted @elseif(isset($value->submitted->is_submitted) && $value->submitted->is_submitted==2) In-progress @else - @endif</td>
                        <td>@if(isset($value->submitted->updated_at)){{ date('j F,Y H:i:s',strtotime($value->submitted->updated_at)) }}@endif</td>
                        <td></td>
                        <td>@if(isset($value->submitted->certificate_issued_on)){{ date('j F,Y',strtotime($value->submitted->certificate_issued_on)) }}@endif</td>
                        <td>{{ $value->user->last_login }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp

                    @endforeach
                    @else
                    <tr>
                        <td colspan="27" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                    </tr>
                    @endif
                </tbody>
                </table>
              </div>
              {{-- @if(isset($allOrders) && count($allOrders) > 0)
              {{ $allOrders->links() }}
              @endif --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  function formsubmit(){
      $("#downloadexcel").val(1);
      $('form#formreport').submit();
  }
</script>
@endsection
