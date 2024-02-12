@extends('admin.layout.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="main-content">
    <!-- Content Header (Page header) -->
    <section class="section">
        <div class="section-header">
        <h1>{{ $page_title }}</h1>
        @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('create-roles-and-permission')])
        </div>
    </section>
    <!-- Main content -->
    <div class="section-body">
        @include('admin.inc.messages')
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ url('admin/roles-and-permission/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered" id="datatable_rolespermission" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Modules</th>
                                    <th>Role Access</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($roles->count())
                                @foreach($roles as $role)
                                <tr>
                                    <td>
                                        {{ isset($role->name) ? $role->name : '' }}
                                    </td>
                                    <td>
                                        {{ implode(", ", getModules()) }}
                                    </td>
                                    <td>
                                        {{ 'view, create, edit, delete' }}
                                    </td>
                                    <td>
                                        <table class="action-table">
                                            <tr>
                                                <td>
                                                    <a href="{{ url('admin/roles-and-permission/edit/' . $role->id) }}"
                                                       class="btn btn-primary btn-sm" title="Edit">
                                                        <i aria-hidden="true" class="fa fa-pencil-square"></i>
                                                    </a>

                                                </td>
                                                <td>
                                                    @if($role->id!=2)
                                                    <form action="{{ url('admin/roles-and-permission/delete') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $role->id }}">
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete permission?');" class="btn btn-danger btn-sm" title="Delete">
                                                            <i aria-hidden="true" class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ url('admin/roles/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Permission</th>
                                    <th>Country</th>
                                    <th>Email</th>
                                    <th>Date of Account Creation</th>
                                    <th>Last Login</th>
                                    <th>Last Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($admins->count())
                                @foreach($admins as $admin)
                                <tr>
                                    <td>
                                        {{ isset($admin->admin_name) ? $admin->admin_name : '-' }}
                                    </td>
                                    <td>
                                        {{ isset($admin->role_name) ? $admin->role_name : '-' }}
                                    </td>
                                    <td>
                                        {{ getCountryByID($admin->country_id)->country ?? '' }}
                                    </td>
                                    <td>
                                        {{ isset($admin->email) ? $admin->email : '-' }}
                                    </td>
                                    <td data-order="{{ $admin->admin_created_at }}">
                                        {{ isset($admin->admin_created_at) ? date('d M, Y h:i A', strtotime($admin->admin_created_at)) : '-' }}
                                    </td>
                                    <td>
                                        {{ admin_last_login($admin->admins_id) ?? '-' }}
                                    </td>
                                    <td data-order="{{ $admin->admin_updated_at }}">
                                        {{ isset($admin->admin_updated_at) ? date('d M, Y h:i A', strtotime($admin->admin_updated_at)) : '-' }}
                                    </td>
                                    <td>
                                <table class="action-table">
                                    <tr>
                                        <td>
                                            <a href="{{ url('admin/roles/edit/' . $admin->admins_id) }}"
                                               class="btn btn-primary btn-sm" title="Edit">
                                                <i aria-hidden="true" class="fa fa-pencil-square"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if($admin->admins_id!=1)
                                                <form action="{{ url('admin/roles/delete') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $admin->admins_id }}">
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete role?');" class="btn btn-danger btn-sm" title="Delete">
                                                        <i aria-hidden="true" class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.row (main row) -->
<!-- /.content -->
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
        $('#datatable_rolespermission').dataTable( {
            'order': [0, 'desc'],
        });

        $('.datatable').dataTable( {
            'order': [4, 'desc'],
        });
    });

</script>
@endsection
