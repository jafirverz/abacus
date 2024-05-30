@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('instructor-account.create') }}" class="btn btn-primary">Add New</a>
        </div>
        @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('instructor_account')])
</div>

<div class="section-body">
    @include('admin.inc.messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('instructor-account.destroy', 'instructor-account') }}"
                        class="btn btn-danger d-none destroy" @if(Auth::user()->admin_role==1) data-confirm="Do you want to permanently delete this record?" @else data-confirm="Do you want to continue?" @endif
                        data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                        data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                            class="badge badge-transparent">0</span></a>
                    <form id="destroy" action="{{ route('instructor-account.destroy', 'instructor-account') }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="multiple_delete">
                    </form>
                    <h4></h4>
                    <div class="card-header-form form-inline">
                        <form action="{{ route('instructor-account.search') }}" method="get">
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
                    </div>
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
                                    <th>Action</th>
                                    <th>Display Name</th>

                                    <th>Instructor's Full Name</th>
                                    <th>Account ID</th>
                                    <th>Country</th>
                                    <th>Qualified in Year</th>
                                    <th>Highest Mental</th>
                                    <th>Highest Abacus</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($customer->count())
                                @foreach($customer as $key => $item)
                                <tr>
                                    <td scope="row">
                                        <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                data-checkboxes="mygroup" class="custom-control-input"
                                                id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                for="checkbox-{{ ($key+1) }}"
                                                class="custom-control-label">&nbsp;</label></div>
                                    </td>
                                    <td>
                                        <a href="{{ route('instructor-account.show', $item->id) }}"
                                            class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                            data-original-title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('instructor-account.edit', $item->id) }}"
                                            class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                            data-original-title="View">
                                            <i aria-hidden="true" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->instructor_full_name }}
                                    </td>
                                    <td>
                                        {{ $item->account_id }}
                                    </td>
                                    <td>
                                        {{ $item->country->country ?? ''}}
                                    </td>
                                    <td>
                                        {{  $item->year_attained_qualified_instructor }}
                                    </td>
                                    <td>
                                        {{ $item->highest_mental_grade ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->highest_abacus_grade ?? '' }}
                                    </td>
                                    <td>

                                        @if($item->approve_status==1)
                                        Active
                                        @elseif($item->approve_status==2)
                                        Deactivated
                                        @else
                                        -
                                        @endif
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
                    {{ $customer->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection
