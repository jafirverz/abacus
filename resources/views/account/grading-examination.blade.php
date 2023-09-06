@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            <div class="menu-aside">
            @if(Auth::user()->user_type_id == 6)

             @include('inc.account-sidebar-external')

            @else
            @include('inc.intructor-account-sidebar')
            @endif
            </div>
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="row title-wrap-1">
                    <div class="col-md-6 order-md-last mt-0 lastcol">
                        <a class="btn-1" href="{{ url('register-grading-examination',$gradingExam->id) }}">Register for Grading Exam <i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                    <div class="col-md-6 order-md-first mt-767-20">
                        <h1 class="title-3">Grading Examinations</h1>
                    </div>

                </div>
                @include('inc.messages')
                <div class="box-1">
                    <h2 class="title-4">Registered Student's List</h2>
                    <div><strong>Exam Title: {{ $gradingExam->title ?? '' }}</strong></div>
                    <div class="xscrollbar mt-30 mCustomScrollbar _mCS_1 mCS_no_scrollbar" style="width: 959px;"><div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_horizontal mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container mCS_x_hidden mCS_no_scrollbar_x" style="position: relative; top: 0px; left: 0px; width: 100%;" dir="ltr">
                        <table class="tb-2 tbtype-4">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>NO.</th>
                                    <th>Student Name</th>
                                    <th>Registered <br>Mental Grade</th>
                                    <th>Registered <br>Abacus Grades</th>
                                    <th>Status <button type="button" class="btn-tooltip ml-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="For Pending instructor cal still change the grade. Once Approved, instructor cannot chanage grade, only superadmin can change."><i class="icon-info"></i></button></th>
                                    <th>Remark <button type="button" class="btn-tooltip ml-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lorem ipsum dolor sit amet consetetur"><i class="icon-info"></i></button></th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($grading)
                                @php $i=0; @endphp
                                @foreach($grading as $grade)
                                @php $i++; @endphp
                                <tr>
                                    <td><em>{{ $i }}</em></td>
                                    <td>
                                        <em>{{ $grade->student->name  ?? ''}}</em>
                                        @if($grade->approve_status==1)
                                        <div class="tbactions"><a href="{{ route('grading-examination.view',$grade->user_id) }}">View</a> <a href="{{ route('grading-examination.delete',$grade->id) }}"  onclick="return confirm('Are you sure want to delete this?');">Delete</a></div>
                                        @else
                                        <div class="tbactions"><a href="{{ route('grading-examination.edit',$grade->id) }}">Edit</a> <a href="{{ route('grading-examination.view',$grade->user_id) }}">View</a> <a href="{{ route('grading-examination.delete',$grade->id) }}"  onclick="return confirm('Are you sure want to delete this?');">Delete</a></div>
                                        @endif
                                    </td>
                                    <td><em>{{ $grade->mental->title ?? '' }}</em></td>
                                    <td><em>{{ $grade->abacus->title ?? '' }}</em></td>
                                    <td><em class="status-3">{{ ($grade->approve_status==1)?'Approved':'Pending' }}</em></td>
                                    <td><em>{{ $grade->remarks ?? ''}}</em></td>
                                    <td><em>{{ getGradingStudentResult($grade->grading_exam_id,$grade->user_id )->result ?? '-'}} </em></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div><div id="mCSB_1_scrollbar_horizontal" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_horizontal" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_horizontal" class="mCSB_dragger" style="position: absolute; min-width: 30px; width: 0px; left: 0px;"><div class="mCSB_dragger_bar"></div><div class="mCSB_draggerRail"></div></div></div></div></div></div>
                    <ul class="page-numbers mt-30">
                        {{ $grading->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
