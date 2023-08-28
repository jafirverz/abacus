@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ $title ?? '-' }}</h1>



    </div>
    <form action="{{ route('reports-worksheet.search') }}" method="get">
      @csrf
      <div class="section-body">

        <div class="row">

          <div class="col-lg-4"><label>Level:</label>
            <select name="level" class="form-control">
              <option value="">-- Select --</option>
              @foreach($levels as $level)
              <option value="{{ $level->id }}">{{ $level->title }}</option>
              @endforeach
            </select>
          </div>


            <div class="col-lg-4"><label>Start date:</label>
              <input type="text" name="start_date" value="" class="form-control datepicker1">
            </div>

            <div class="col-lg-4"><label>End date:</label>
              <input type="text" name="end_date" value="" class="form-control datepicker1">
            </div>
            


        </div>

        <br />
        <div class="row">

          <div class="col-lg-4"><label>Student:</label>
            <select name="student" class="form-control">
              <option value="">-- Select --</option>
              @foreach($students as $student)
              <option value="{{ $student->id }}">{{ $student->name }}</option>
              @endforeach
            </select>
          </div>


        </div>

        <br />

        <div class="row">
          <div class="col-lg-4">
            <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
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

      <!-- <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <a href="javascript:void(0);" class="btn btn-info mr-1 d-none excel" onclick="event.preventDefault();document.getElementById('excel').submit();"><i class="fas fa-file-download"></i> Excel</a>
          
              <form id="excel" action="{{ route('salesexcel') }}" method="post">
                @csrf
                @method('POST')
                <input type="hidden" name="excel_id">
                <input type="hidden" name="level" value="{{ $_GET['level'] ?? '' }}">
                <input type="hidden" name="start_date" value="{{ $_GET['start_date'] ?? '' }}">
                <input type="hidden" name="end_date" value="{{ $_GET['end_date'] ?? '' }}">
              </form>
              
              <h4></h4>

            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-md">
                  <thead>
                    <tr>
                      <th>
                        <div class="custom-checkbox custom-control">
                          <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                            class="custom-control-input" id="checkbox-all">
                          <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                        </div>
                      </th>
                      <th>S/N</th>
                      <th>Student Name</th>
                      <th>Amount</th>
                      <th>Order Date</th>
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
                    
                    @endphp
                    <tr>
                        <td>
                          <div class="custom-checkbox custom-control"> <input type="checkbox"
                                  data-checkboxes="mygroup" class="custom-control-input"
                                  id="checkbox-{{ ($i) }}" value="{{ $value->id }}">
                              <label for="checkbox-{{ ($i) }}"
                                  class="custom-control-label">&nbsp;</label></div>
                        </td>
                        <td>{{ ($i) }}</td>
                        <td>{{ $users->name }}</td>
                        <td>{{ $value->total_amount ?? '' }}</td>
                        <td>{{ $value->created_at ?? '-' }}</td>

                        
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

            </div>
          </div>
        </div>
      </div> -->
    </div>
  </section>
</div>
@endsection