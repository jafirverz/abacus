@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('user-account.create') }}" class="btn btn-primary">Add New</a>
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('user_account')])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('user-account.destroy', 'user-account') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('user-account.destroy', 'user-account') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-header-form form-inline">
                                <form action="{{ route('user-account.search') }}" method="get">
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
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>Email</th>
                                            <th>Permission</th>
                                            <th>Date of Account Creation</th>
                                            <th>Last Login</th>
                                            <th>Status</th>
                                            <th>Last Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($admins->count())
                                        @foreach($admins as $key => $item)
                                        <tr>
                                            <td scope="row">
                                                @if($item->id<>__('constant.FIXED_SUPER_ADMIN'))
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('user-account.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                @if($item->id<>__('constant.FIXED_SUPER_ADMIN'))
                                                {{-- <a href="{{ route('user-account.edit', $item->id) }}"
                                                    class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit">
                                                    <i aria-hidden="true" class="fa fa-edit"></i>
                                                </a> --}}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->fullname }}
                                            </td>
                                            <td>
                                                {{ $item->country->country ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->email }}
                                            </td>
                                            <td>
                                                {{ $item->roles->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $item->created_at->format('d M, Y h:i A') }}
                                            </td>
                                            <td>
                                                @if($item->lastLoginAt()) {{ $item->lastLoginAt()->diffForHumans() }} @else - @endif
                                            </td>
                                            <td>
                                                @if(getActiveStatus())
                                                <div class="badge @if ($item->status==1) badge-success @else badge-danger @endif">{{ getActiveStatus($item->status) }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->updated_at->format('d M, Y h:i A') }}
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
                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
