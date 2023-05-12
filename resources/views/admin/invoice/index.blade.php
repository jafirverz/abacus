@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('invoice.create') }}" class="btn btn-primary">Add New</a>
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_invoice')])
        </div>

        <div class="section-body">
            @php 
            $statusArr = ['0'=>'', '1'=>'Pending', '2'=>'Paid'];
            $invoiceTypesArr = ['1' => 'Deposit', '2' => 'Balance Payment', '3' => 'STA Inspection'];
            @endphp
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('invoice.destroy', 'invoice') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('invoice.destroy', 'invoice') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-body">
                                <form id="search-form" action="{{ route('invoice.search') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Search:</label>
                                        <input type="text" name="search" class="form-control" id="search"
                                            @if (isset($_GET['search']) && $_GET['search'] != '') value="{{ $_GET['search'] }}" @endif>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Invoice Type</label>
                                        <select name="invoice_type" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            @foreach($invoiceTypesArr as $key=>$value)
                                            <option value="{{ $key }}" @if(isset($_GET['invoice_type']) && $_GET['invoice_type'] == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            @for($j=1; $j<=2; $j++)
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
                                            <th>Invoice No</th>
                                            <th>Invoice Type</th>
                                            <th>Vehicle Number</th>
                                            <th>Seller Name</th>
                                            <th>Buyer Name</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($invoices->count())
                                        @foreach ($invoices as $key => $item)
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                <a href="{{ route('invoice.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('invoice.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ $item->invoice_no }}</td>
                                            <td>{{ $invoiceTypesArr[$item->invoice_type] }}</td>
                                            <td>{{ $item->vehicle_number }}</td>
                                            <td>@php $user = get_user_detail($item->seller_id); echo $user['name']; @endphp</td>
                                            <td>@php $user = get_user_detail($item->buyer_id); echo $user['name']; @endphp</td>
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
                            {{ $invoices->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() }}
                            @else
                            {{ $invoices->links() }}
                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
