@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
           <div class="section-header-button">
             
        </div>
        @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('customer_account')])
    </div>

<div class="section-body">
    @include('admin.inc.messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('student-feedback.destroy', 'student-feedback') }}"
                        class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?"
                        data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                        data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                            class="badge badge-transparent">0</span></a>
                    <form id="destroy" action="{{ route('student-feedback.destroy', 'student-feedback') }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="multiple_delete">
                    </form>
                    <h4></h4>
                    {{--<div class="card-header-form form-inline">
                        <form action="{{ route('student-feedback.search') }}" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search"
                                    value="{{ $_GET['search'] ?? '' }}">
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
                    </div>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-md">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Full Name</th>
                                    <th>Email Address</th>
                                    <th>Enquiry Type</th>
                                    <th>Message</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($feedback->count())
                                @foreach($feedback as $key => $item)
                                <tr>
                                  <td scope="row">
                                    <div class="custom-checkbox custom-control"> <input type="checkbox"
                                            data-checkboxes="mygroup" class="custom-control-input"
                                            id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                            for="checkbox-{{ ($key+1) }}"
                                            class="custom-control-label">&nbsp;</label></div>
                                </td>
                                    <td>
                                        {{ $item->user->name }}
                                    </td>
                                    <td>
                                        {{ $item->user->email }}
                                    </td>
                                    <td>
                                      {{ $item->enquiry }}
                                    </td>
                                    <td>
                                        {{ $item->message ?? '' }}
                                    </td>
                                   
                                    <td>
                                        {{ $item->created_at->format('d M, Y h:i A') }}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $feedback->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection
