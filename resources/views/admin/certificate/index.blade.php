@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">

                <a href="{{ route('certificate.create') }}" class="btn btn-primary">Add New</a>
            </div>
            


        </div>
        <br />

        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">

                            <a href="{{ route('certificate.destroy', 'certificate') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('certificate.destroy', 'certificate') }}" method="post">

                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <!-- <div class="card-header-form form-inline">

                                <form action="{{ route('certificate.search') }}" method="get">

                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search" value="{{ $_GET['search'] ?? '' }}">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                        &emsp;
                                            @if(request()->get('_token'))
                                               <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                                            @else
                                               <button type="reset" class="btn btn-primary">Clear All</button>
                                            @endif
                                    </div>
                                </form>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <!-- <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th> -->
                                            <th>Action</th>
                                            <th>Title</th>

                                            <th>Certificate Type</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if($certificates->count())
                                        @foreach ($certificates as $key => $item)
                                           <tr>
                                            <!-- <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td> -->
                                            <td>
                                                <a href="{{ route('certificate.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('certificate.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->certification_type }}  </td>

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
                            {{ $certificates->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() }}
                            @else
                            {{ $certificates->links() }}

                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
