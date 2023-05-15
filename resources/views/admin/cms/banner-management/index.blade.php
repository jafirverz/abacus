@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_banner_management')])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Action</th>
                                            <th>Banner Management</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <td>
                                                <a href="{{ url('admin/slider') }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-bars"></i></a>
                                            </td>
                                            <td>Home Banners</td>
                                            
                                        </tr>
                                        <tr>
                                            
                                            <td>
                                                <a href="{{ url('admin/banner') }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-bars"></i></a>
                                            </td>
                                            <td>Page Banners</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
