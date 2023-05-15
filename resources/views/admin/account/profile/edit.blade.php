@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_profile')])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.profile.update') }}" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                @method('POST')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" class="form-control" id=""
                                            value="{{ $admin->firstname }}">
                                        @if ($errors->has('firstname'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname" class="form-control" id=""
                                            value="{{ $admin->lastname }}">
                                        @if ($errors->has('lastname'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Profile <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ fileReadText(['jpg', 'png', 'gif'], '5MB', '60x60') }}"></i></label>
                                        <input name="profile" type="file" class="form-control" id="" placeholder="">
                                        @if($admin->profile) <br />
                                        <img src="{{ asset($admin->profile) }}" class="img-responsive" width="100px" />
                                        @endif
                                        <p class="help-block"></p>
                                    </div>
                                    @if($admin->profile)
                                    <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input value="1" type="checkbox" name="delete_picture" class="custom-control-input" tabindex="3" id="delete_picture">
                                    <label class="custom-control-label" for="delete_picture">Remove Picture</label>
                                </div>
                            </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" class="form-control" id=""
                                            value="{{ $admin->email }}">
                                        @if ($errors->has('email'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" name="old_password" class="form-control" id="" value="">
                                        @if ($errors->has('old_password'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="" value="">
                                        <div class="text-muted">Password should be minimum 8 characters long.</div>
                                        @if ($errors->has('password'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" id=""
                                            value="">
                                        @if ($errors->has('password_confirmation'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                        Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
