@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('user-account.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('user_account_crud', 'Edit', route('user-account.edit', $admin->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('user-account.update', $admin->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input type="text" name="firstname" class="form-control" value="{{ old('firstname', $admin->firstname) }}">
                                    @if ($errors->has('firstname'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $admin->lastname) }}">
                                    @if ($errors->has('lastname'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email', $admin->email) }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control">
                                    @if ($errors->has('password'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="admin_role">Admin Role</label>
                                        <select name="admin_role" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            <option value="1" @if(old('admin_role', $admin->admin_role)==1) selected @endif>Super Admin</option>
                                            <option value="2" @if(old('admin_role', $admin->admin_role)==2) selected @endif>Franchise Admin</option>
                                        </select>
                                    @if ($errors->has('admin_role'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('admin_role') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="admin_role">Country</label>
                                    <select name="countrry" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @foreach($countries as $countryy)
                                        <option value="{{ $countryy->id }}" @if(old('countrry', $admin->country_id)==$countryy->id) selected @endif>{{ $countryy->country }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('countrry'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('countrry') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status', $admin->status)==$key) selected @elseif($key==1) selected @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
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
            </div>
        </div>
    </section>
</div>
@endsection
