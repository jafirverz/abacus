@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ $title ?? '-' }}</h1>



    </div>
    <form action="{{ route('reports-sales.search') }}" method="post">
      @csrf
      <div class="section-body">

        <div class="row">

          <div class="col-lg-4"><label>Country:</label>
            <select name="country" class="form-control">
              <option value="">-- Select --</option>
              <option value="">--Please Select--</option>
              @foreach($countries as $country)
              <option value="{{ $country->id }}">{{ $country->nicename }}</option>
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
              <a href="{{ route('pages.destroy', 'pages') }}" class="btn btn-danger d-none destroy"
                data-confirm="Do you want to continue?"
                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                  class="badge badge-transparent">0</span></a>
              <form id="destroy" action="{{ route('pages.destroy', 'pages') }}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="multiple_delete">
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
                      <th>Action</th>
                      <th>Title</th>
                      <th>View Order</th>
                      <th>Status</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                    </tr>
                  </thead>
                  <tbody>

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
@endsection