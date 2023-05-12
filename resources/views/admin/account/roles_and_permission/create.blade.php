@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('roles-and-permission.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('roles_and_permission_crud', 'Create', route('roles-and-permission.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('roles-and-permission.store') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Role Name</label>
                                    <input type="text" name="role_name" class="form-control">
                                    @if ($errors->has('role_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('role_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="btn-group mb-3 btn-group-sm" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary all_yes">All Yes</button>
                                        <button type="button" class="btn btn-primary all_no">All No</button>
                                    </div>
                                </div>
                                @php $i = 0; @endphp
                                @foreach($modules as $module)
                                <div class="table-responsive">
                                    <table class="table table-md">
                                        <tbody>
                                            <tr>
                                                <input type="hidden" name="module[<?php echo $i; ?>][name][]" value="<?php echo $module; ?>">
                                                <th colspan="2" style="border:0;"><?php echo str_replace('_', ' ', $module); ?></th>
                                            </tr>
                                            <tr>
                                                <td>View
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input checked="checked" type="radio" id="customRadio{{ $i.'1' }}" name="module[{{ $i }}][view][]" value="1" {{ get_permission_access_value('views', $module, 1) }} class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio{{ $i.'1' }}">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio{{ $i.'2' }}" name="module[{{ $i }}][view][]" value="0" {{ get_permission_access_value('views', $module, 0) }} class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio{{ $i.'2' }}">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Create</td>
                                                <td>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input checked="checked" type="radio" id="customRadio{{ $i.'3' }}" name="module[{{ $i }}][create][]" value="1" {{ get_permission_access_value('creates', $module, 1) }} class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio{{ $i.'3' }}">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio{{ $i.'4' }}" name="module[{{ $i }}][create][]" value="0" {{ get_permission_access_value('creates', $module, 0) }} class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio{{ $i.'4' }}">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Edit</td>
                                                <td>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input checked="checked" type="radio" id="customRadio{{ $i.'5' }}" name="module[{{ $i }}][edit][]" value="1" {{ get_permission_access_value('edits', $module, 1) }} class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio{{ $i.'5' }}">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio{{ $i.'6' }}" name="module[{{ $i }}][edit][]" value="0" {{ get_permission_access_value('edits', $module, 0) }} class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio{{ $i.'6' }}">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Delete
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input checked="checked" type="radio" id="customRadio{{ $i.'7' }}" name="module[{{ $i }}][delete][]" value="1" {{ get_permission_access_value('deletes', $module, 1) }} class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio{{ $i.'7' }}">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio{{ $i.'8' }}" name="module[{{ $i }}][delete][]" value="0" {{ get_permission_access_value('deletes', $module, 0) }} class="custom-control-input">
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
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("button.all_yes").on("click", function() {
            $("input[value='1']").prop("checked", true);
            $("input[value='0']").prop("checked", false);
        });
        $("button.all_no").on("click", function() {
            $("input[value='0']").prop("checked", true);
            $("input[value='1']").prop("checked", false);
        });
    });
</script>
@endsection
