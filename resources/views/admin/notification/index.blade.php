@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_notification')])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('notification.search') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Message</label>
                                        <input type="text" name="search1" class="form-control" value="{{ $_GET['search1'] ?? '' }}" placeholder="Message..">
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">-- Select --</option>
                                            @if(notificationStatus())
                                            @foreach (notificationStatus() as $key => $item)
                                                <option value="{{ $key }}" @if(isset($_GET['status'])) @if($_GET['status']==$key) selected @endif @endif>{{ $item }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a href="{{ url()->current() }}" class="btn btn-primary ml-3">Clear All</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($message_template->count())
                                        @foreach ($message_template as $key => $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('notification.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                            </td>
                                            <td>{{ $item->message ?? '' }}</td>
                                            <td>@if($item->status==1) <span class="text-danger">Unread</span> @else <span class="text-success">Read</span> @endif</td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if(request()->get('_token'))
                            {{ $message_template->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() 								}}
                            @else
                            {{ $message_template->links() }}
                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
