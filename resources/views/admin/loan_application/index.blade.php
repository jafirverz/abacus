@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                {{--<a href="{{ route('loan-application.create') }}" class="btn btn-primary">Add New</a>--}}
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_loan')])

        </div>
        <br />

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('loan-application.search') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>User Details</label>
                                        <input type="text" name="search1" class="form-control" value="{{ $_GET['search1'] ?? '' }}" placeholder="Applicant Name/Email/Mobile">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Vehicle Details</label>
                                        <input type="text" name="search2" class="form-control" value="{{ $_GET['search2'] ?? '' }}" placeholder="Vehicle Reg No/NRIC/Loan Purchase Amount/Loan Amount">
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Bank</label>
                                        <input type="text" name="search3" class="form-control" value="{{ $_GET['search3'] ?? '' }}" placeholder="Bank">
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">-- Select --</option>
                                            @if(getLoanStatus())
                                            @foreach (getLoanStatus() as $key => $item)
                                                <option value="{{ $key }}" @if(isset($_GET['status'])) @if($_GET['status']==$key) selected @endif @endif>{{ $item }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a href="{{ url()->current() }}" class="btn btn-primary ml-3">Clear All</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <a href="{{ route('loan-application.destroy', 'loan-application') }}"
                                class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('loan-application.destroy', 'loan-application') }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                                @if(empty(Session::get('docusign_auth_code')))
                            <a href="{{route('loanapplication.connect')}}" class="btn btn-warning ml-2">Connect Docusign</a>
                            @else 
                            <a href="javascript::void();" class="btn btn-warning ml-2">Docusign Connected</a>
                            @endif
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
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Applicant Name</th>
                                            <th>Applicant Email</th>
                                            <th>Applicant Mobile</th>
                                            <th>Vehicle Registration No</th>
                                            <th>NRIC/Company Registration No</th>
                                            <th>Loan Purchase Amount</th>
                                            <th>Loan Amount</th>
                                            <th>Bank</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($loan_application->count())
                                        @foreach ($loan_application as $key => $item)
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                <a href="{{ route('loan-application.show', $item->id) }}"
                                                    class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('loan-application.edit', $item->id) }}"
                                                    class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ getLoanStatus($item->status) }}</td>
                                            <td>{{ $item->user->name ?? '' }}</td>
                                            <td>{{ $item->user->email ?? '' }}</td>
                                            <td>{{ $item->user->mobile ?? '' }}</td>
                                            <td>{{ $item->vehicle_registration_no ?? '' }}</td>
                                            <td>{{ $item->nric_company_registration_no ?? '' }}</td>
                                            <td>{{ '$'.$item->loan_purchase_price ?? 0 }}</td>
                                            <td>{{ '$'.$item->loan_amount ?? 0 }}</td>
                                            <td>{{ $item->bank->title ?? '' }}</td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $loan_application->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
