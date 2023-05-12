@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_activitylog')])
        </div>

        <div class="section-body">
        @include('admin.inc.messages')
        <form action="{{ route('activitylog.search') }}" method="get">
                @csrf

                <div class="row">

                    <div class="col-lg-4"><label>Page Name:</label><input type="text" name="page_name"
                            class="form-control" id="page_name" @if(isset($_GET['page_name']) &&
                            $_GET['page_name']!="" ) value="{{ $_GET['page_name'] }}" @endif> </div>
                    <div class="col-lg-4"><label>First Name:</label><input type="text" name="firstname"
                            class="form-control" id="" @if(isset($_GET['firstname']) &&
                            $_GET['firstname']!="" ) value="{{ $_GET['firstname'] }}" @else value="" @endif> </div>        
                    <div class="col-lg-4"><label>Last Name:</label><input type="text" name="lastname"
                            class="form-control" id="lastname" @if(isset($_GET['lastname']) &&
                            $_GET['lastname']!="" ) value="{{ $_GET['lastname'] }}" @endif> </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-6"><label>Fields Updated:</label><input type="text" name="fields_updated"
                            class="form-control" id="" @if(isset($_GET['fields_updated']) &&
                            $_GET['fields_updated']!="" ) value="{{ $_GET['fields_updated'] }}" @else value="" @endif> </div>
                    
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                          @if(request()->get('_token'))
                          <a href="{{ route('activitylog.index') }}" class="btn btn-primary">Clear All</a>
                          @else
                          <input value="Clear All" type="reset" class="btn btn-primary">
                          @endif

                </div>
                </div>



            </form><br />
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        <a href="{{ route('activitylog.destroy', 'activitylog') }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('activitylog.destroy', 'activitylog') }}" method="post">
                                @csrf
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                           <th><div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div></th>
                                            <th>S/N</th>
                                            <th>Action</th>
                                            <th>Page Name</th>
                                            <th>Updated By</th>
                                            <th>Updated At</th>
                                            <th>Fields Updated</th>
                                            <th>View Action</th>
                                            <th>IP address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($activity_log->count())
                                        @php $i=0;@endphp
                                        @foreach($activity_log as $item)
                                        @php
                                        $i++;
                                        $subject_type = '';
                                        if($item->subject_type)
                                        {
                                        $subject_type = explode('\\', $item->subject_type);
                                        }
                                        if($item->properties)
                                        {
                                        $properties = json_decode($item->properties);
                                        }
                                        @endphp
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($i+1) }}" value="{{ $item->acid }}"> <label for="checkbox-{{ ($i+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td row="scope">{{ $item->acid }}</td>
                                            <td>
                                                <a href="{{ route('activity-log.show', $item->acid) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>
                                            </td>
                                            <td>{{ $subject_type[1] }}</td>
                                            <td>{{ $item->firstname . ' ' . $item->lastname }}</td>
                                            <td>{{ date('d M, Y h:i A', strtotime($item->activity_log_updated)) }}
                                            </td>
                                            <td>
                                                @foreach($properties->attributes as $key => $val)
                                                {{ $key.', ' }}
                                                @endforeach
                                            </td>
                                            <td>{{ ucfirst($item->description) ?? '' }}</td>
                                            <td>{{ getCauserIp($item->causer_id) }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('constant.NO_DATA_FOUND') }}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $activity_log->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
