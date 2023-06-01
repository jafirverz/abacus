@extends('admin.layout.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="main-content">
    <section class="section">
    <!-- Content Header (Page header) -->
    <div class="section-header">
        <h1>{{ $page_title }}</h1>

    @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_home')])
    </div>
    <!-- Main content -->
    <div class="section-body">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <h4>Sorry! You do not have rights to access the page.</h4>
                        <a href="{{ url('/admin/profile/edit') }}" class="btn btn-primary"><i class="fa fa-user" aria-hidden="true"></i> Go to Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div>
    <!-- /.content -->
  </section>
</div>
<!-- /.content-wrapper -->
@endsection
