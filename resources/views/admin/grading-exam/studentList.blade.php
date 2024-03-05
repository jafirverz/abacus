@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('grading-exam.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $grading_exam->title }} >> {{ $title ?? '-' }}</h1>

{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank')])--}}

        </div>
        <br />

        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <form method="post" action="{{ route('grading.student.excel', ['id'=>$grading_exam->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary"> Download Student List</button>
                        </form>

                        <div class="card-header">
                            <a href="{{ route('grading-exam.student.destroy', 'competition') }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('grading-exam.student.destroy', 'competition') }}" method="post">
                                @csrf
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-header-form form-inline">
                                <form action="{{ route('grading-exam.search') }}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search"
                                            value="{{ $_GET['search'] ?? '' }}">
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
                                            <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Account ID</th>
                                            <th>Student Name</th>
                                            <th>Date of Birth</th>
                                            <th>Instructor</th>
                                            <th>Mental Grade</th>
                                            <th>Abacus Grade</th>
                                            <th>Learning Location</th>
                                            <th>Student Type</th>
                                            <th>Created At</th>
                                            <th>Approve Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($studentList->count())
                                        @foreach ($studentList as $key => $item)
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td>

                                            <td>{{ $item->userlist->account_id }}</td>
                                            <td>{{ $item->userlist->name }}</td>
                                            <td>{{ $item->userlist->dob }}</td>
                                            <td>{{ getInstructor($item->userlist->instructor_id)->name ?? '' }}</td>
                                            <td>{{ $item->mental->title ?? '' }}</td>
                                            <td>{{ $item->abacus->title ?? '' }}</td>
                                            <td>{{ $item->userlist->location->title ?? '' }}</td>

                                            <td>{{ getUserTypes($item->userlist->user_type_id) }}</td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>
                                              @if($item->approve_status == 1)
                                              <div class="btn mr-1 mt-1">Approved</div>
                                              @elseif($item->approve_status == 2)
                                                <div class="btn btn-danger mr-1 mt-1">Rejected</div>
                                              @else
                                                <a href="{{ route('grading-exam.student.edit', $item->id) }}"
                                                  class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                                  data-original-title="Approve" data-confirm="Do you want to continue?"
                                                  data-confirm-yes="event.preventDefault();document.getElementById('approve{{$item->id}}').submit();">Approve</a>
                                                  <form id="approve{{ $item->id }}" action="{{ route('grading-exam.student.approve', $item->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="approve_user" value="{{ $item->id }}">
                                                </form>
                                                <a href="{{ route('grading-exam.student.edit', $item->id) }}"
                                                    class="btn btn-danger mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="Reject" data-confirm="Do you want to continue?"
                                                    data-confirm-yes="event.preventDefault();document.getElementById('reject{{$item->id}}').submit();">Reject</a>
                                                <form id="reject{{$item->id}}" action="{{ route('grading-exam.student.reject', $item->id) }}" method="post">
                                                      @csrf
                                                      <input type="hidden" name="reject_user" value="{{ $item->id }}">
                                                  </form>
                                              @endif
                                            </td>
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
                            {{ $studentList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
