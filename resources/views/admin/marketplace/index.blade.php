@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('marketplace.create') }}" class="btn btn-primary">Add New</a>
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_marketplace')])
        </div>

        <div class="section-body">
        @php $statusArr = ['0'=>'', '1'=>'Processing', '2'=>'Reserved', '3'=>'Sold', '4'=>'Cancelled', '5'=>'Published']; @endphp
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="align-items: end;">
                            
                            
                            <div class="card-body">
                                <form id="search-form" action="{{ route('marketplace.search') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Search:</label>
                                        <input type="text" name="search" class="form-control" id="search"
                                            @if (isset($_GET['search']) && $_GET['search'] != '') value="{{ $_GET['search'] }}" @endif>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Vehicle Type</label>
                                        <select name="type" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            @if(getFilterValByType(__('constant.VEHICLE_TYPE')))
                                            @foreach(getFilterValByType(__('constant.VEHICLE_TYPE')) as $key=>$value)
                                            <option value="{{ $value->title }}" @if(isset($_GET['type']) && $_GET['type'] == $value->title) selected @endif>{{ $value->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Vehicle Make</label>
                                        <select name="make" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            @if(getFilterValByType(__('constant.MAKE')))
                                            @foreach(getFilterValByType(__('constant.MAKE')) as $key=>$value)
                                            <option value="{{ $value->title }}" @if(isset($_GET['make']) && $_GET['make'] == $value->title) selected @endif>{{ $value->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Vehicle Model</label>
                                        <select name="model" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            @if(getFilterValByType(__('constant.MODEL')))
                                            @foreach(getFilterValByType(__('constant.MODEL')) as $key=>$value)
                                            <option value="{{ $value->title }}" @if(isset($_GET['model']) && $_GET['model'] == $value->title) selected @endif>{{ $value->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            @for($j=1; $j<=5; $j++)
                                            <option value="{{ $j }}" @if(isset($_GET['status']) && $_GET['status'] == $j) selected @endif>{{ $statusArr[$j] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <br />
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                                        @if (request()->get('_token'))
                                            <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                                        @else
                                            <button type="reset" class="btn btn-primary">Clear All</button>
                                        @endif

                                    </div>
                                </div>
                                </form>

                                <a href="{{ route('marketplace.destroy', 'marketplace') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('marketplace.destroy', 'marketplace') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            </div>
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
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Action</th>
                                            <th>Vehicle Number</th>
                                            <th>Seller Name</th>
                                            <th>Make - Model</th>
                                            <th>Registration Date</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($cars->count())
                                        @foreach ($cars as $key => $item)
                                            @php if(isset($item->detail)){
                                                $vehicle_number = $item->detail['vehicle_number'];
                                                $make = $item->detail['vehicle_make'] ?? '';
                                                $model = $item->detail['vehicle_model'] ?? '';
                                                $makeModel = $make .'- '. $model;
                                            }else{
                                                $vehicle_number = $item->vehicle_number;
                                                $make = $item->vehicle_make ?? '';
                                                $model =  $item->vehicle_model ?? '';
                                                $makeModel =  $make .'- '. $model;
                                            }

                                            if(isset($item->vehicle_id)){
                                                $vehicle_id = $item->vehicle_id;
                                            }else{
                                                $vehicle_id = $item->id;
                                            }
                                            @endphp
                                            
                                            @php 
                                            //dd($item->orig_reg_date);
                                            if(!empty($item->detail['orig_reg_date'])){
                                                $ord = date('d-m-Y', strtotime($item->detail['orig_reg_date']));
                                                if($ord == '01-01-1970'){
                                                    $ord = date('d-m-Y');
                                                }
                                            }else{
                                                if(!empty($item->orig_reg_date)){
                                                    $ord = date('d-m-Y', strtotime($item->orig_reg_date));
                                                }else{
                                                    $ord = date('d-m-Y');
                                                }
                                                
                                            }
                                            @endphp
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                <a href="{{ route('marketplace.show', $vehicle_id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('marketplace.edit', $vehicle_id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ $vehicle_number }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $makeModel ?? '' }}</td>
                                            <td>{{ $ord }}</td>
                                            <td>
                                                <div class="">{{ $statusArr[$item->status] }}</div>
                                            </td>
                                            <td>@if(!empty($item->created_at)){{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y h:i A') }} @endif</td>
                                            <td>@if(!empty($item->updated_at)){{  \Carbon\Carbon::parse($item->updated_at)->format('d M, Y h:i A')  }}  @endif</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if(request()->get('_token'))
                            {{ $cars->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() }}
                            @else
                            {{ $cars->links() }}
                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
