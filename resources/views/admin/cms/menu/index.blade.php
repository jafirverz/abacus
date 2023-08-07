@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('menu.create') }}" class="btn btn-primary">Add New</a>
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_menu')])
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
                                            
                                            <th style="width:10%">Action</th>
                                            <th>Title</th>
                                            {{-- <th>View Order</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($menu->count())
                                        @foreach ($menu as $key => $item)
                                        <tr>
                                            
                                            <td>
                                               {{--  <a href="{{ route('menu.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                 --}}
                                                 <a href="{{ route('menu-list.index', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Menu List"><i class="fas fa-bars"></i></a>
                                            </td>
                                            <td>{{ $item->title }}</td>
                                            {{-- <td>{{ $item->view_order }}</td>
                                            <td>
                                                @if(getActiveStatus())
                                                <div class="badge @if ($item->status==1) badge-success @else badge-danger @endif">{{ getActiveStatus($item->status) }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td> --}}
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
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
