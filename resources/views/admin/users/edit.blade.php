@extends('admin.layout.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $title }} <small class="text-muted">{{ $secondary_title }}</small></h1>
        @include('admin.inc.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('admin_pages_crud', 'Edit',
        route('users-account.edit', $users_account->id))])
    </div>

    <div class="section-body">
        <div class="card">
            <form action="{{ route('users-account.update', $users_account->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="{{ route('users-account.index') }}" class="btn btn-primary"><i
                                class="fas fa-long-arrow-alt-left    "></i> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Profile</label>
                        <input type="file" name="profile" id="" class="form-control">
                        <small class="text-muted">
                            Profile size should be 200*200 for better resolution. Only png, jpg, and gif files upto 5mb are accepted.
                        </small>
                        @if($users_account->profile && file_exists($users_account->profile))
                        <img src="{{ asset($users_account->profile) }}" class="d-block" alt="" width="200px">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="entity">Entity</label>
                        <select name="entity" class="form-control">
                            <option value="">-- Select --</option>
                            @if ($entity)
                            @foreach ($entity as $item)
                            <option value="{{ $item->id }}" @if(old('entity', $users_account->entity)==$item->id)
                                selected
                                @endif>{{ $item->entity_name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('entity'))
                        <span class="help-block">
                            <strong>{{ $errors->first('entity') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" class="form-control" id="" value="{{ old('firstname', $users_account->firstname) }}">
                        @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" class="form-control" id="" value="{{ old('lastname', $users_account->lastname) }}">
                        @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select name="department" class="form-control">
                            <option value="">-- Select --</option>
                        </select>
                        <input type="hidden" name="selected_department" value="{{ old('department', $users_account->department) }}">
                        @if ($errors->has('department'))
                        <span class="help-block">
                            <strong>{{ $errors->first('department') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="manager">Manager</label>
                        <select name="manager" class="form-control">
                            <option value="">-- Select --</option>
                            @if ($manager)
                            @foreach ($manager as $item)
                            <option value="{{ $item->id }}" @if(old('manager', $users_account->manager)==$item->id)
                                selected
                                @endif>{{ $item->staff_name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('manager'))
                        <span class="help-block">
                            <strong>{{ $errors->first('manager') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="it_admin">IT Admin</label>
                        <select name="it_admin" class="form-control">
                            <option value="">-- Select --</option>
                            @if ($manager)
                            @foreach ($manager as $item)
                            <option value="{{ $item->id }}" @if(old('it_admin', $users_account->it_admin)==$item->id)
                                selected
                                @endif>{{ $item->staff_name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('it_admin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('it_admin') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="office_admin">Office Admin</label>
                        <select name="office_admin" class="form-control">
                            <option value="">-- Select --</option>
                            @if ($manager)
                            @foreach ($manager as $item)
                            <option value="{{ $item->id }}" @if(old('office_admin', $users_account->office_admin)==$item->id)
                                selected
                                @endif>{{ $item->staff_name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('office_admin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('office_admin') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="section-title">CMS License Holder</div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" name="cms_license_holder"
                                class="custom-control-input" value="0" @if($users_account->cms_license_holder==0)
                            checked @else
                            checked @endif>
                            <label class="custom-control-label" for="customRadioInline1">No</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" name="cms_license_holder"
                                class="custom-control-input" value="1" @if($users_account->cms_license_holder==1)
                            checked @endif>
                            <label class="custom-control-label" for="customRadioInline2">Yes</label>
                        </div>
                        @if ($errors->has('cms_license_holder'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cms_license_holder') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="section-title">Type</div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="training_admin" @if(getStaffType($users_account->id, 'training_admin')) checked @endif class="custom-control-input" id="customCheck2" value="1">
                            <label class="custom-control-label" for="customCheck2">Training Admin</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="hr_admin" @if(getStaffType($users_account->id, 'hr_admin')) checked @endif class="custom-control-input" id="customCheck3" value="1">
                            <label class="custom-control-label" for="customCheck3">HR Admin</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date of Joining</label>
                        <input type="text" name="date_of_joining" class="form-control datepicker" value="{{ $users_account->date_of_joining }}">
                        @if ($errors->has('date_of_joining'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_of_joining') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="did_no">DID No.</label>
                        <input type="text" name="did_no" class="form-control" id="" value="{{ old('did_no', $users_account->did_no) }}">
                        @if ($errors->has('did_no'))
                        <span class="help-block">
                            <strong>{{ $errors->first('did_no') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="contents">Contents</label>
                        <input type="text" name="contents" class="form-control" id="" value="{{ old('contents', $users_account->contents) }}">
                        @if ($errors->has('contents'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contents') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" class="form-control" id="" value="{{ old('mobile', $users_account->mobile) }}">
                        @if ($errors->has('mobile'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" id="" value="{{ old('email', $users_account->email) }}">
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="" value="">
                        <div class="text-muted">Password should be minimum 8 characters long.</div>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $("body").on("change", "select[name='entity']", function () {
            var ref = $(this);
            var entity = ref.val();
            var selected_department = $("input[name='selected_department']").val();
            $.ajax({
                method: "POST",
                url: '{{ route("get-entity-department") }}',
                data: {
                    entity: entity,
                    selected_department: selected_department,
                    _token: CSRF_TOKEN,
                },
                cache: false,
                async: false,
                success: function (data) {
                    $("select[name='department']").html(data);
                    $('.selectpicker').selectpicker('refresh');
                }
            });
        });

        $("select[name='entity']").trigger("change");
    });
</script>
@endsection
