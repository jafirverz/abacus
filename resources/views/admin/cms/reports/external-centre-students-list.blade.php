@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('admin/reports-external-centre') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i> Go Back</a>
            </div>
            <h1>{{ $external_center->name ?? '-' }}</h1>



        </div>
        <form action="" method="get">
            @csrf
            <div class="section-body">


                <div class="row">
                    <div class="col-lg-4"><label>Status:</label>
                      <select name="status" class="form-control">
                        <option value="">-- Select --</option>
                        <option @if(isset($_GET['status']) && $_GET['status']==1) selected="selected"
                            @endif value="1">Active</option>

                        <option @if(isset($_GET['status']) && $_GET['status']==2) selected="selected"
                            @endif value="2">Inactive</option>
                        <option @if(isset($_GET['status']) && $_GET['status']==0) selected="selected"
                            @endif value="0">Pending</option>
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
                        <input type="hidden" name="user_id" value="{{ $external_center->id }}">
                        <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                        @if(isset($_GET['_token']))
                        <a class="btn btn-primary" href="{{ route('reports-external-centre.search',['status'=>$_GET['status'],'user_id'=>$external_center->id]) }}">Export</a>&nbsp;&nbsp;
                        @else
                        <a class="btn btn-primary" href="{{ route('reports-external-centre.search',['user_id'=>$external_center->id]) }}">Export</a>&nbsp;&nbsp;
                        @endif
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
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>S/N</th>
                                            <th>Action</th>
                                            <th>Name</th>
                                            <th>Date of Birth</th>
                                            <th>Gender</th>
                                            <th>Account Id</th>
                                            <th>Status</th>
                                            <th>Learning Location</th>
                                            <th>Remarks</th>
                                            <th>Last Login Date/Time </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($users->count())
                                        @php
                                        $i=0;
                                        @endphp
                                        @foreach($users as $key => $item)
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
                                                <a href="{{ route('customer-account.show', $item->id) }}"
                                                    class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="Listing"><i class="fas fa-eye"></i></a>

                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td>
                                                {{ $item->dob ?? '' }}
                                            </td>
                                            <td>
                                                {{ ($item->gender==1) ?'Male':'Female' }}
                                            </td>
                                            <td>
                                                {{ $item->account_id ?? '' }}
                                            </td>
                                            <td>@if($item->approve_status == 1) Active @elseif($item->approve_status == 2) Inactive @else Pending @endif</td>
                                            <td>
                                                {{ $item->learning_locations ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->remarks ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->last_login ?? '' }}
                                            </td>
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
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
