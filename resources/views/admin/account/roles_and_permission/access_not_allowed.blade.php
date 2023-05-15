@extends('admin.layout.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
        </div>

        <div class="section-body">.
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2>Sorry! You do not have rights to access the page.</h2>
                            <a href="{{ route('admin.profile') }}" class="btn btn-primary"><i class="fa fa-user"
                                    aria-hidden="true"></i> Goto Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
