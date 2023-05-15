@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            {{--
            <div class="section-header-button">
                <a href="{{ route('quoterequest.create') }}" class="btn btn-primary">Add New</a>
            </div>
            --}}
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_quote_request')])
        </div>

        <div class="section-body">
        @php $statusArr = ['0'=>'', '1'=>'Processing', '2'=>'Approved']; @endphp
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('quoterequest.destroy', 'quoterequest') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('quoterequest.destroy', 'quoterequest') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-body">
                                <form id="search-form" action="{{ route('quoterequest.search') }}" method="get">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>Search:</label>
                                            <input type="text" name="search" class="form-control" id="search"
                                                @if (isset($_GET['search']) && $_GET['search'] != '') value="{{ $_GET['search'] }}" @endif>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Status</label>
                                            <select name="status" class="form-control" id="">
                                                <option value="">-- Select --</option>
                                                @for($j=1; $j<=2; $j++)
                                                <option value="{{ $j }}" @if(isset($_GET['status']) && $_GET['status'] == $j) selected @endif>{{ $statusArr[$j] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>&nbsp;</div>
                                            <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                                            @if (request()->get('_token'))
                                                <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                                            @else
                                                <button type="reset" class="btn btn-primary">Clear All</button>
                                            @endif
                                        </div>
                                    </div>
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
                                            <th>Seller Email</th>
                                            <th>Contact Number</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($quote_requests->count())
                                        @foreach ($quote_requests as $key => $item)
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                <a href="{{ route('quoterequest.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('quoterequest.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ $item->vehicle_number }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->country.$item->contact_number }}</td>
                                            <td>
                                                <div class="">{{ $statusArr[$item->status] }}</div>
                                            </td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
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
                            {{ $quote_requests->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() }}
                            @else
                            {{ $quote_requests->links() }}
                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
