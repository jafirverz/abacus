@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>

        </div>
        <br />

        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">

                            <a href="{{ route('grading-students.destroy', 'grading-students') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('grading-students.destroy', 'grading-students') }}" method="post">

                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-header-form form-inline">

                                <form action="{{ route('grading-students.search') }}" method="get">

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
                                            <th>Action</th>
                                            <th>Student Name</th>
                                            <th>Grading Title</th>
                                            <th>Teacher Name</th>
                                            <th>Mental Grade</th>
                                            <th>Abacus Grades</th>
                                            <th>Status</th>
                                            <th>Result</th>
                                            <th>Rank</th>
                                            <th>Pass/Fail</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if($grading->count())
                                        @foreach ($grading as $key => $item)
                                           <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                <a href="{{ route('grading-students.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>

                                            <td>{{ $item->student->name  ?? ''}}</td>
                                            <td>{{ $item->event->title  ?? ''}}</td>
                                            <td>{{ $item->teacher->name  ?? ''}}</td>
                                            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->student->id)->mental_grade ?? '-'}}</td>
                                            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->student->id)->abacus_grade ?? '-'}}</td>
                                            <td>{{ ($item->approve_status==1)?'Approved':'Pending' }}</td>
                                            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->student->id)->result ?? '-'}}</td>
                                            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->student->id)->rank ?? '-'}}</td>
                                            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->student->id)->remark_grade ?? '-'}}</td>
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
                            {{ $grading->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() }}
                            @else
                            {{ $grading->links() }}

                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
