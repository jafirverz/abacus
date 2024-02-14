@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
           <div class="section-header-button">
                <a href="{{ route('customer-account.create') }}" class="btn btn-primary">Add New</a>
               <a href="{{ route('customer.pendingRequest') }}" class="btn btn-primary">Profile Update Request</a>
        </div>
        @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('customer_account')])
    </div>
    <form action="{{ route('customer-account.search') }}" method="get">
        @csrf

        <div class="section-body">

            <div class="row">
                <div class="col-lg-4">
                    <label>Filter by</label>
                    <input type="text" class="form-control" name="search" value="@if(isset($_GET['search']) && isset($_GET['country']) && $_GET['search']!='') {{ $_GET['search'] }}  @endif" placeholder="">
                </div>
                <div class="col-lg-4">
                    <label>Country </label>
                    <select name="country" class="form-control">
                        <option value="">-- All --</option>
                        @foreach ($country as $key => $value)
                        <option @if(isset($_GET['country']) && $_GET['country']==$value->id) selected="selected" @elseif(!isset($_GET['country']) && $value->id==192) selected="selected"
                            @endif value="{{$value->id}}">{{$value->country}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4"><label>Status:</label>
                    <select name="status" class="form-control">
                      <option value="">-- All --</option>
                      <option @if(isset($_GET['status']) && $_GET['status']==1) selected="selected" @else  selected="selected"
                          @endif value="1">Active</option>
                      <option @if(isset($_GET['status']) && $_GET['status']==0) selected="selected"
                          @endif value="0">Pending</option>
                      <option @if(isset($_GET['status']) && $_GET['status']==2) selected="selected"
                          @endif value="2">Inactive</option>
                  </select>
                  </div>
            </div>
            <br />
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                    @if(request()->get('_token'))
                    <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                    @else
                    <button type="reset" class="btn btn-primary">Clear All</button>
                    @endif

                </div>
            </div>

        </div>

    </form>
    <div class="row">
        <div class="col-12">
            <div class="card" style="float:right;">
                <div class="card-header">
                                <div class="card-header-form">
                                    <form action="{{ route('customer-account.search') }}" method="get">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search" value="{{ $_GET['search'] ?? '' }}">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                            &emsp;
                                                @if(request()->get('_token'))
                                                <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                                                @else
                                                <button type="reset" class="btn btn-primary">Clear All</button>
                                                @endif
                                        </div>
                                    </form>
                                </div>
                </div>
            </div>
        </div>
    </div>
<div class="section-body">
    @include('admin.inc.messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('customer-account.destroy', 'customer-account') }}"
                        class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?"
                        data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                        data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                            class="badge badge-transparent">0</span></a>
                    <form id="destroy" action="{{ route('customer-account.destroy', 'customer-account') }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="multiple_delete">
                    </form>
                    <h4></h4>


                        <br />

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-md">
                            <thead>
                                <tr>
                                    <th width="10%">
                                        @if(isset($_GET['_token']))
                                        Total: {{ $customer->count() }}
                                        @else
                                        <strong>Total: {{ $total_count }}</strong>
                                        @endif
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Action</th>
                                    <th>Full Name</th>
                                    <th>DOB</th>
                                    <th>Instructor</th>
                                    <th>Type</th>
                                    <th>Learning Location</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($customer->count())
                                @foreach($customer as $key => $item)
                                <tr>
                                    <td scope="row">
                                        <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                data-checkboxes="mygroup" class="custom-control-input"
                                                id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                for="checkbox-{{ ($key+1) }}"
                                                class="custom-control-label">&nbsp;</label></div>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer-account.show', $item->id) }}"
                                            class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                            data-original-title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('customer-account.edit', $item->id) }}"
                                            class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                            data-original-title="View">
                                            <i aria-hidden="true" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $item->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->dob ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->instructor->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ getUserTypes($item->user_type_id) ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->location->title ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->country->country ?? '' }}
                                    </td>
                                    <td>

                                        @if($item->approve_status==1)
                                        Active
                                        @elseif($item->approve_status==2)
                                        Inactive
                                        @else
                                        Pending
                                        @endif
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
                    {{ $customer->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection
