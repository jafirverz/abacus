@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            @include('inc.account-sidebar')
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="row title-wrap-1">
                    <div class="col-md-6 order-md-last mt-0 lastcol">
                        <a class="btn-1" href="#">Register for Grading Exam <i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                    <div class="col-md-6 order-md-first mt-767-20">
                        <h1 class="title-3">Grading Examinations</h1>
                    </div>
                </div>
                <div class="box-1">
                    <h2 class="title-4">Registered Student's List</h2>
                    <div><strong>Exam Title: 15th 3G Abacus Mental- Arithmetic Internation Grading Examination</strong></div>
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
                                <tr>
                                    <td><em>001</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="#">Exam Pass</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-2">Approved</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>002</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="be-teacher-dashboard-grading-details.html">Edit</a> <a href="be-achievements.html">View</a> <a href="#">Delete</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-3">Pending</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>003</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="#">Exam Pass</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-2">Approved</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>004</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="be-teacher-dashboard-grading-details.html">Edit</a> <a href="be-achievements.html">View</a> <a href="#">Delete</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-3">Pending</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>005</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="#">Exam Pass</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-2">Approved</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>006</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="be-teacher-dashboard-grading-details.html">Edit</a> <a href="be-achievements.html">View</a> <a href="#">Delete</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-3">Pending</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>007</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="#">Exam Pass</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-2">Approved</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>008</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="be-teacher-dashboard-grading-details.html">Edit</a> <a href="be-achievements.html">View</a> <a href="#">Delete</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-3">Pending</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>009</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="#">Exam Pass</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-2">Approved</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                                <tr>
                                    <td><em>010</em></td>
                                    <td>
                                        <em>Timothy Yu</em>
                                        <div class="tbactions"><a href="be-teacher-dashboard-grading-details.html">Edit</a> <a href="be-achievements.html">View</a> <a href="#">Delete</a></div>
                                    </td>
                                    <td><em>Super Degree</em></td>
                                    <td><em>Lorem ipsum dolor sit amet, consetetur</em></td>
                                    <td><em class="status-3">Pending</em></td>
                                    <td><em>Lorem ipsum </em></td>
                                    <td><em>Lorem ipsum </em></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><div id="mCSB_1_scrollbar_horizontal" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_horizontal" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_horizontal" class="mCSB_dragger" style="position: absolute; min-width: 30px; width: 0px; left: 0px;"><div class="mCSB_dragger_bar"></div><div class="mCSB_draggerRail"></div></div></div></div></div></div>
                    <ul class="page-numbers mt-30">
                        <li><a class="prev" href="#">prev</a></li>
                        <li><a href="#">1</a></li>
                        <li><a class="current" href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a class="next" href="#">next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
