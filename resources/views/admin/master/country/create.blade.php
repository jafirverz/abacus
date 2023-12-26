@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('country.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
           @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_country_crud', 'Create', route('country.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('country.store') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" class="form-control" id=""
                                        value="{{ old('country') }}">
                                    @if ($errors->has('country'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="phonecode">Phone Code</label>
                                    <input type="text" name="phonecode" class="form-control" id=""
                                        value="{{ old('phonecode') }}">
                                    @if ($errors->has('phonecode'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('phonecode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
