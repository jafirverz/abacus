@extends('admin.layout.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $title }} <small class="text-muted">{{ $secondary_title }}</small></h1>
        @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_users_account')])
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @include('admin.inc.messages')
                <div class="card">
                    <div class="card-header">
                        
                        <a href="{{ route('users.destroy', 'users') }}" class="btn btn-danger d-none destroy mr-1" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                        <form id="destroy" action="{{ route('users.destroy', 'users') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="multiple_delete">
                        </form>
                        <h4></h4>
                        <div class="card-header-form form-inline">
                            <a href="{{ route('users.create') }}" class="btn btn-primary mr-1"><i
                                    class="fas fa-plus"></i> Create</a>
                            <form action="{{ route('users.search') }}" method="get">
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
                    <div class="card-body p-0">
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
                                        <th>Entity</th>
                                        <th>Staff Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Manager</th>
                                        <th>Training Admin</th>
                                        <th>HR Admin</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users_account->count())
                                    @foreach ($users_account as $key => $item)
                                    <tr>
                                        <td scope="row">
                                            <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td>{{ getEntity($item->entity)->entity_name }}</td>
                                        <td>{{ $item->staff_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ getDepartment($item->department)->department_name }}</td>
                                        <td>{{ getManager($item->manager) }}</td>
                                        <td>@if(getStaffType($item->id, 'training_admin')) Yes @else No @endif</td>
                                        <td>@if(getStaffType($item->id, 'hr_admin')) Yes @else No @endif</td>
                                        <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                        <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php /*?><div class="card-footer text-right">
                        {{ $users_account->links() }}
                    </div><?php */?>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
