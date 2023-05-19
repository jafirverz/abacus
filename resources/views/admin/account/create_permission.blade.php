@extends('admin.layout.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="main-content">
    <!-- Content Header (Page header) -->
    <section class="section">
        <div class="section-header">
        <h1>{{ $page_title }}</h1>
        @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('roles-and-permission')])
        </div>
    </section>
    <!-- Main content -->
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form name="filter" method="post" action="{{ url('/admin/roles-and-permission/store')}}">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Role Name</label>
                            <input type="text" name="role_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="modules" class="col-sm-2 control-label">Modules</label>
                            <div class="col-sm-10">
                                @php $i = 0; @endphp
                                @foreach($modules as $module)
                                <div class="table-responsive">
                                    <table class="table table-md">
                                    <tbody>
                                        <tr>
                                            <input type="hidden" name="module[<?php echo $i; ?>][name][]" value="<?php echo $module; ?>">
                                            <th colspan="2" style="border:0;"><?php echo $module; ?></th>
                                        </tr>
                                        <tr>
                                            <td>View
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" type="radio" id="customRadio{{ $i.'1' }}" name="module[<?php echo $i; ?>][view][]" value="1" {{ get_permission_access_value('views', $module, 1) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'1' }}">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" type="radio" id="customRadio{{ $i.'2' }}" name="module[<?php echo $i; ?>][view][]" value="0" {{ get_permission_access_value('views', $module, 0) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'2' }}">No</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Create</td>
                                            <td>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" id="customRadio{{ $i.'3' }}" type="radio" name="module[<?php echo $i; ?>][create][]" value="1" {{ get_permission_access_value('creates', $module, 1) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'3' }}">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" id="customRadio{{ $i.'4' }}" type="radio" name="module[<?php echo $i; ?>][create][]" value="0" {{ get_permission_access_value('creates', $module, 0) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'4' }}">No</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Edit</td>
                                            <td>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" id="customRadio{{ $i.'5' }}" type="radio" name="module[<?php echo $i; ?>][edit][]" value="1" {{ get_permission_access_value('edits', $module, 1) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'5' }}">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" id="customRadio{{ $i.'6' }}" type="radio" name="module[<?php echo $i; ?>][edit][]" value="0" {{ get_permission_access_value('edits', $module, 0) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'6' }}">No</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Delete
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" id="customRadio{{ $i.'7' }}" type="radio" name="module[<?php echo $i; ?>][delete][]" value="1"  {{ get_permission_access_value('deletes', $module, 1) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'7' }}">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="custom-control-input" id="customRadio{{ $i.'8' }}" type="radio" name="module[<?php echo $i; ?>][delete][]" value="0" {{ get_permission_access_value('deletes', $module, 0) }}>
                                                    <label class="custom-control-label" for="customRadio{{ $i.'8' }}">No</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                @php $i++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-default" href="{{ url('/admin/roles-and-permission') }}">
                            Cancel
                        </a>
                        <button class="btn btn-primary pull-right" type="submit">
                        <i aria-hidden="true" class="fa fa-floppy-o">
                        </i>
                        Submit
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row (main row) -->
<!-- /.content -->
<!-- /.content-wrapper -->
@endsection
