@extends('admin.layout.auth')

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Register</h4>
                    </div>

                    <div class="card-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin_register')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input id="firstname" type="text" class="form-control" name="firstname" tabindex="1"  >
                                @if ($errors->has('firstname'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input id="lastname" type="text" class="form-control" name="lastname" tabindex="2"  >
                                @if ($errors->has('lastname'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" tabindex="3"  >
                                @if ($errors->has('email'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" tabindex="4"  >
                                @if ($errors->has('password'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" tabindex="5"  >
                                @if ($errors->has('password_confirmation'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="6">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
