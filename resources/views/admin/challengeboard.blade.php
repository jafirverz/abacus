@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ $title ?? '-' }}</h1>



    </div>
    <form action="{{ route('challenge.delete') }}" method="get" id="myForm">
      @csrf
      <div class="section-body">

        <div class="row">

          @php 
          if(!empty($_REQUEST['start_date'])){
            $start_date = $_REQUEST['start_date'];
          }else{
            $start_date = '';
          }

          if(!empty($_REQUEST['end_date'])){
            $end_date = $_REQUEST['end_date'];
          }else{
            $end_date = '';
          }
          @endphp

            <div class="col-lg-4"><label>Start date:</label>
              <input type="text" name="start_date" value="{{ $start_date }}" class="form-control datepicker1" required>
            </div>

            <div class="col-lg-4"><label>End date:</label>
              <input type="text" name="end_date" value="{{ $end_date }}" class="form-control datepicker1" required>
            </div>
            
            <input type="hidden" name="show" value="" id="showw">

        </div>

        <br />
        <div class="row">
          <div class="col-lg-4">
            <button type="submit" class="btn btn-primary"> Delete</button>&nbsp;&nbsp;
            @if(request()->get('_token'))
            <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
            @else
            <button type="reset" class="btn btn-primary">Clear All</button>
            @endif
            <button type="button" class="btn btn-primary" onclick="submitform();"> Show</button>
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
                      <th>Level</th>
                      <th>Best Result</th>
                      <th>Student Name</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(isset($worksheetSub) && count($worksheetSub) > 0)
                    
                    @php 
                    $i = 1;
                    @endphp
                    @foreach($worksheetSub as $checkLe)

                    @php 
                    $worksheetSubAns = \App\WorksheetSubmitted::where('created_at', '>=', $start_date)->where('updated_at', '<=', $end_date)->where('question_template_id', 6)->where('level_id', $checkLe->level_id)->orderBy('user_marks', 'desc')->get();
                    @endphp
                    
                    @foreach($worksheetSubAns as $value)

                    @php 
                    $worksheetUser = \App\User::where('id', $value->user_id)->first();
                    $Level = \App\Level::where('id', $value->level_id)->first();
                    @endphp
                    <tr>
                        <!-- <td>
                          <div class="custom-checkbox custom-control"> <input type="checkbox"
                                  data-checkboxes="mygroup" class="custom-control-input"
                                  id="checkbox-{{ ($i) }}" value="{{ $value->id }}">
                              <label for="checkbox-{{ ($i) }}"
                                  class="custom-control-label">&nbsp;</label></div>
                        </td> -->
                        <td>{{ ($i) }}</td>
                        <td>{{ $Level->title }}</td>
                        <td>{{ $value->user_marks ?? '' }}</td>
                        <td>{{ $worksheetUser->name ?? '' }}</td>
                        <td>@if($worksheetUser->approve_status == 1) Approved @elseif($worksheetUser->approve_status == 2) Rejected @else InActive @endif</td>

                        
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    @endforeach
                    @else
                    <tr>
                        <td colspan="27" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                    </tr>
                    @endif
                </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
  function submitform(){
    $('#showw').val(1);
    $('form#myForm').submit();
  }
</script>
@endsection