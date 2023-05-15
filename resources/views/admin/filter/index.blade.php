@extends('admin.layout.app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title ?? '-' }}</h1>
                <div class="section-header-button">
                   <a href="{{ route('filter.create') }}" class="btn btn-primary">Add New</a>

                </div>
                @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_filter')])

            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('filter.search') }}" method="get">
                                @csrf
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Title:</label>
                                            <input type="text" name="title" class="form-control" id="title"
                                                @if (isset($_GET['title']) && $_GET['title'] != '') value="{{ $_GET['title'] }}" @endif>
                                        </div>

                                        <div class="col-lg-6">
                                            <label>Type </label>
                                            <select name="type" class="form-control" id="">
                                                <option value="">-- Select --</option>
                                                @if (getFilterType())
                                                    @foreach (getFilterType() as $key => $item)
                                                        <option value="{{ $key }}" @if (isset($_GET['type']) && $_GET['type'] == $key) selected @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    <br />
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                                            @if (request()->get('_token'))
                                                <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                                            @else
                                                <button type="reset" class="btn btn-primary">Clear All</button>
                                            @endif

                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                @include('admin.inc.messages')

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <a href="{{ route('filter.destroy', 'filter') }}" class="btn btn-danger d-none destroy"
                                    data-confirm="Do you want to continue?"
                                    data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                    data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                        class="badge badge-transparent">0</span></a>
                                <form id="destroy" action="{{ route('filter.destroy', 'filter') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="multiple_delete">
                                </form>
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
                                                        <label for="checkbox-all"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>Action</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>View Order</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($filter->count())
                                                @foreach ($filter as $key => $item)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="custom-checkbox custom-control"> <input
                                                                    type="checkbox" data-checkboxes="mygroup"
                                                                    class="custom-control-input"
                                                                    id="checkbox-{{ $key + 1 }}"
                                                                    value="{{ $item->id }}"> <label
                                                                    for="checkbox-{{ $key + 1 }}"
                                                                    class="custom-control-label">&nbsp;</label></div>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('filter.show', $item->id) }}"
                                                                class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                                                data-original-title="View"><i
                                                                    class="fas fa-eye"></i></a>
                                                            <a href="{{ route('filter.edit', $item->id) }}"
                                                                class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                                                data-original-title="Edit"><i
                                                                    class="fas fa-edit"></i></a>
                                                        </td>
                                                        <td>{{ $item->title }}</td>
                                                        <td>{{ getFilterType($item->type) }}</td>
                                                        <td>{{ $item->view_order }} </td>
                                                        <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                                        <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        {{ __('constant.NO_DATA_FOUND') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if (request()->get('_token'))
                                    {{ $filter->appends(['_token' => request()->get('_token'), 'title' => request()->get('title'), 'type' => request()->get('type')])->links() }}
                                @else
                                    {{ $filter->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
