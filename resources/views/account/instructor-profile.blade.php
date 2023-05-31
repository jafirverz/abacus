@extends('layouts.app')
@section('content')
<main class="main-wrap">	
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            <div class="menu-aside">
                <h3>My Dashboard</h3>
                <ul>
                    <li>
                        <a href="be-teacher-dashboard-overview.html">
                            <span><img src="images/tempt/ico-overview.png" alt="Overview icon" /></span>
                            <strong>Overview</strong>
                        </a>
                    </li>
                    <li class="active">
                        <a href="be-teacher-dashboard-profile.html">
                            <span><img src="images/tempt/ico-profile.png" alt="Profile icon" /></span>
                            <strong>My Profile</strong>
                        </a>
                    </li>
                    <li>
                        <a href="be-teacher-dashboard-students.html">
                            <span><img src="images/tempt/ico-students.png" alt="Students icon" /></span>
                            <strong>My Students</strong>
                        </a>
                    </li>
                    <li>
                        <a href="be-teacher-dashboard-teaching.html">
                            <span><img src="images/tempt/ico-teaching.png" alt="Teaching icon" /></span>
                            <strong>Teaching Materials</strong>
                        </a>
                    </li>
                    <li>
                        <a href="be-teacher-dashboard-grading.html">
                            <span><img src="images/tempt/ico-grading.png" alt="Grading icon" /></span>
                            <strong>Grading Examinations</strong>
                        </a>
                    </li>
                    <li>
                        <a href="be-teacher-dashboard-competitions.html">
                            <span><img src="images/tempt/ico-competitions.png" alt="Competitions icon" /></span>
                            <strong>Competitions</strong>
                        </a>
                    </li>
                    <li>
                        <a href="be-teacher-dashboard-allocation.html">
                            <span><img src="images/tempt/ico-allocation.png" alt="Allocation icon" /></span>
                            <strong>Test and Survey Allocation</strong>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">	
                <h1 class="title-3">My Profile</h1>							
                <div class="box-1">
                    <div class="row align-items-center title-type">
                        <div class="col-md">
                            <h2 class="title-2">Personal Information</h2>
                        </div>
                        <div class="col-md-auto mt-767-10">
                            <a class="link-1" href="#">Edit My Information</a>
                        </div>
                    </div>
                    <div class="mt-20"><label>Account ID:</label> ID3GAB123456</div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input class="form-control" type="text" value="Michelle Tan" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Email <span class="required">*</span></label>
                            <input class="form-control" type="text" value="michelletan@3gabacus.edu.sg" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Password <span class="required">*</span></label>
                            <input class="form-control" type="password" placeholder="*****" disabled />
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Date of Birth <span class="required">*</span></label>
                            <div class="date-wrap disabled">
                                <i class="fa-solid fa-calendar-days ico"></i>
                                <input class="form-control" type="text" value="31/12/1994" disabled />
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Phone <span class="required">*</span></label>
                            <div class="row sp-col-10">
                                <div class="col-auto sp-col">
                                    <select class="selectpicker" disabled>
                                        <option>+ 65</option>
                                        <option>+ 84</option>
                                    </select>
                                </div>
                                <div class="col sp-col">
                                    <input class="form-control" type="text" value="+65 1234 5678" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Gender <span class="required">*</span></label>
                            <select class="selectpicker" disabled>
                                <option>Please Select</option>
                                <option selected>Female</option>
                                <option>Male</option>
                            </select>
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Country <span class="required">*</span></label>
                            <select class="selectpicker" disabled>
                                <option selected>Singapore</option>
                                <option>Vietnam</option>
                            </select>
                        </div>
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Address</label>
                            <input class="form-control" type="text" value="134 Jurong Gateway Road #04-307A Singapore 600134" disabled />
                        </div>
                    </div>
                    <h2 class="title-2 mt-50">Academic Information</h2>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Year Attained Qualified Instructor Certification</label>
                            <input class="form-control" type="text" value="2011-2017" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Year Attained Senior Instructor Certification</label>
                            <input class="form-control" type="text" value="2017-2020" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Highest Abacus Grade Attained</label>
                            <input class="form-control" type="text" placeholder="Singapore" disabled />
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Highest Mental Grade Attained</label>
                            <input class="form-control" type="text" value="2020" disabled />
                        </div>
                    </div>
                    <label class="lb-1">Awards:</label>
                    <div class="txtwrap">
                        <ul>
                            <li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet</li>
                            <li>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</li>
                            <li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</li>
                            <li>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet</li>
                        </ul>									
                    </div>
                    <div class="output-2">
                        <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
                <div class="row sp-col-20 grid-9">
                    <div class="col-sm-6 sp-col">
                        <div class="inner">
                            <h4>My Students' Best Grading Examination Achievement</h4>
                            <h5>Student Name</h5>
                            <p>Jonathan Lee Than</p>
                            <h5>Year</h5>
                            <p>Grade 7</p>
                            <h5>Highest Grade (mental)</h5>
                            <p>Super Degree</p>
                            <h5>Highest Grade (Abacus)</h5>
                            <p>Grade 1</p>
                        </div>
                    </div>
                    <div class="col-sm-6 sp-col">
                        <div class="inner">
                            <h4>My Students' Best Competition Achievement</h4>
                            <h5>Student Name</h5>
                            <p>Jonathan Lee Than</p>
                            <h5>Year</h5>
                            <p>Grade 7</p>
                            <h5>Competition</h5>
                            <p>Super Degree</p>
                            <h5>Price</h5>
                            <p>1st</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</main
@endsection
