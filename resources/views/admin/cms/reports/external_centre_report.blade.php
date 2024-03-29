@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>



        </div>
        {{-- <form action="{{ route('reports-student.search') }}" method="post">
            @csrf
            <div class="section-body">

                <div class="row">

                    <div class="col-lg-4"><label>Student Name:</label><input type="text" name="name" class="form-control"
                            id="title" @if(isset($_GET['name']) && $_GET['name']!="" ) value="{{ $_GET['name'] }}"
                            @endif> </div>
                    <div class="col-lg-4">
                        <label>Instructor</label>
                        <select name="instructor[]" class="form-control" multiple>
                            <option value="">-- Select --</option>

                        </select>
                    </div>
                    <div class="col-lg-4">
                      <label>Student Type</label>
                      <select name="user_type" class="form-control">
                          <option value="">-- Select --</option>

                      </select>
                  </div>

                </div>
                <div class="row">
                    <div class="col-lg-4"><label>Status:</label>
                      <select name="status" class="form-control">
                        <option value="">-- Select --</option>
                        <option @if(isset($_GET['status']) && $_GET['status']==1) selected="selected"
                            @endif value="1">Active</option>
                        <option @if(isset($_GET['status']) && $_GET['status']==0) selected="selected"
                            @endif value="0">In Active</option>
                        <option @if(isset($_GET['status']) && $_GET['status']==2) selected="selected"
                            @endif value="2">Rejected</option>
                    </select>
                    </div>
                    <!-- <div class="col-lg-4"><label>End Date:</label>
                      <input type="text" name="enddate" class="form-control datepicker1"
                      id="title" @if(isset($_GET['enddate']) && $_GET['enddate']!="" ) value="{{ $_GET['enddate'] }}"
                      @endif>
                    </div> -->
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
        </form><br /> --}}

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
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>S/N</th>
                                            <th>Action</th>
                                            <th>Centre Name</th>
                                            <th>Centre Location</th>
                                            <th>Account Id</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($external_centre->count())
                                        @php
                                        $i=0;
                                        @endphp
                                        @foreach($external_centre as $key => $item)
                                        @php
                                        $i++;
                                        @endphp
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                {{ $i }}
                                            </td>
                                            <td>
                                                <a href="{{ route('reports-external-centre.student_list', $item->id) }}"
                                                    class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="Listing"><i class="fas fa-bars"></i></a>

                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td>
                                                --
                                            </td>
                                            <td>
                                                {{ $item->account_id ?? '' }}
                                            </td>
                                            <td>
                                                @if($item->approve_status) Approved @else Pending @endif
                                            </td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer">
                            {{ $external_centre->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
