@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ $title ?? '-' }}</h1>



    </div>
    <form action="{{ route('reports-sales.search') }}" method="get">
      @csrf
      <div class="section-body">

        <div class="row">
          @php
          if(!empty($_GET['country'])){
            $countryy = $_GET['country'];
          }else{
            $countryy = '';
          }
          @endphp

          <div class="col-lg-4"><label>Country:</label>
            <select name="country" class="form-control">
              <option value="">--Please Select--</option>
              @foreach($countries as $country)
              <option value="{{ $country->id }}" @if($countryy == $country->id) selected @endif>{{ $country->nicename }}</option>
              @endforeach
            </select>
          </div>

          @php
          if(!empty($_GET['start_date'])){
            $starDate = $_GET['start_date'];
          }else{
            $starDate = '';
          }

          if(!empty($_GET['end_date'])){
            $enddDate = $_GET['end_date'];
          }else{
            $enddDate = '';
          }
          @endphp

            <div class="col-lg-4"><label>Start date:</label>
              <input type="text" name="start_date" value="{{ $starDate }}" class="form-control datepicker1">
            </div>

            <div class="col-lg-4"><label>End date:</label>
              <input type="text" name="end_date" value="{{ $enddDate }}" class="form-control datepicker1">
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
                      <th>
                        <div class="custom-checkbox custom-control">
                          <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                            class="custom-control-input" id="checkbox-all">
                          <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                        </div>
                      </th>
                      <th>S/N</th>
                      <th>Student Name</th>
                      <th>Item Purchased</th>
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
                    $orderDetails = \App\OrderDetail::where('order_id', $value->id)->pluck('name')->toArray();
                    $orderDetails = implode(', ',$orderDetails);
                    @endphp
                    <tr>
                        <td>
                          <div class="custom-checkbox custom-control"> <input type="checkbox"
                                  data-checkboxes="mygroup" class="custom-control-input"
                                  id="checkbox-{{ ($i) }}" value="{{ $value->id }}">
                              <label for="checkbox-{{ ($i) }}"
                                  class="custom-control-label">&nbsp;</label></div>
                        </td>
                        <td>{{ $i }}</td>
                        <td>{{ $users->name }}</td>
                        <td>{{ $orderDetails ?? '' }}</td>
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
              @if(isset($allOrders) && count($allOrders) > 0)
              {{ $allOrders->links() }}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection