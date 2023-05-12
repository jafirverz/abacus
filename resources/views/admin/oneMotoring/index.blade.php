@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('oneMotoring.create') }}" class="btn btn-primary">Add New</a>
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_oneMotoring')])
        </div>
<form action="{{ route('oneMotoring.search') }}" method="get">
            @csrf
            <div class="section-body">

                <div class="row">

                    <div class="col-lg-6"><label>Title:</label><input type="text" name="title" class="form-control"
                            id="title" @if(isset($_GET['title']) && $_GET['title']!="" ) value="{{ $_GET['title'] }}"
                            @endif> </div>
                    <div class="col-lg-6">
                        <label>Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select --</option>
                            @if($categories)
                            @foreach ($categories as $key => $item)
                            <option value="{{ $item->id }}" @if(old('category_id')==$item->id) selected  @endif>{{ $item->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6"><label>Status:</label>
                        <select name="status" class="form-control">
                            <option value="">-- Select --</option>
                            @if(getActiveStatus())
                            @foreach (getActiveStatus() as $key => $item)
                            <option value="{{ $key }}" @if(request()->get('status')==$key) selected @endif>{{ $item }}
                            </option>
                            @endforeach
                            @endif

                        </select>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                        @if(request()->get('_token'))
                        <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                        @else
                        <button type="reset" class="btn btn-primary">Clear All</button>
                        @endif

                    </div>
                </div>


            </div>
        </form><br />
        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('oneMotoring.destroy', 'oneMotoring') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('oneMotoring.destroy', 'oneMotoring') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Action</th>
                                            <th>S/N</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>View Order</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($OneMotoring->count())
                                        
                                            @php 
                                            if(request()->get('page') && request()->get('page')>=2)
                                            {
                                                $i=$OneMotoring->perPage() * ($OneMotoring->currentPage() - 1);
                                            }
                                            else
                                            {
                                                 $i=0;
                                            }
                                            @endphp
                                        
                                        @foreach ($OneMotoring as $key => $item)
                                        @php  $i++;@endphp
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                <a href="{{ route('oneMotoring.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('oneMotoring.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ $i }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->category }}</td>
                                            <td>{{ $item->view_order }}</td>
                                            <td>
                                                @if(getActiveStatus())
                                                <div class="badge @if ($item->status==1) badge-success @else badge-danger @endif">{{ getActiveStatus($item->status) }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
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
                        <div class="card-footer">
                        @if(request()->get('_token'))
                            {{ $OneMotoring->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() }}
                        @else
                            {{ $OneMotoring->links() }}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
