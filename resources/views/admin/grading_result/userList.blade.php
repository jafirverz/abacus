@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('g-results.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1> GE Student List > {{ $competition->title ?? '-' }}</h1>

{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank')])--}}

        </div>
        <br />

        @if($competition->competition_type == 'online')
        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <form method="get" action="{{ route('studentResultDownload2', $competitionId) }}">
                    @csrf
                    <input type="hidden" name="competitionId" value="{{ $competitionId }}">
                    <button type="submit" class="btn btn-primary"> Download Result</button>
                </form>

                </div>
            </div>
        @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <a href="{{ route('g-results.destroy', 'grading') }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('g-results.destroy', 'grading') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-header-form form-inline">
                                <form action="{{ route('g-userresults.search') }}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search by user name"
                                            value="{{ $_GET['search'] ?? '' }}">
                                        <input type="hidden" name="competitionId" value="{{ $competitionId }}">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                            <th>Account Id</th>
                                            <th>User Name</th>
                                            <th>DOB</th>
                                            <th>Instructor Id</th>
                                            <th>Instructor</th>
                                            <th>Learning Location</th>
                                            <th>Type</th>
                                            <th>Mental Grade</th>
                                            <th>Mental Marks</th>
                                            <th>Mental Result Pass/Fail</th>
                                            <th>Abacus Grade</th>
                                            <th>Abacus Marks</th>
                                            <th>Abacus Result Pass/Fail</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($userList->count())
                                        @foreach ($userList as $key => $item)
                                        <tr>

                                            <td>
                                              <a href="{{ route('results-user.edit', $item->id) }}"
                                                class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                                data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ $item->user->account_id }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->user->dob }}</td>
                                            <td>{{ $item->user->instructor->account_id }}</td>
                                            <td>{{ $item->user->instructor->name }}</td>
                                            <td>{{ $item->user->location->title ?? '' }}</td>
                                            <td>{{ getUserTypes($item->user->user_type_id) ?? '' }}</td>
                                            <td>{{ $item->mental_grade }}</td>
                                            <td>{{ $item->mental_results }}</td>
                                            <td>{{ $item->mental_result_passfail }}</td>
                                            <td>{{ $item->abacus_grade }}</td>
                                            <td>{{ $item->abacus_marks }}</td>
                                            <td>{{ $item->abacus_result_passfail }}</td>

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
                            {{ $userList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
