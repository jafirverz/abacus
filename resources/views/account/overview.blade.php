@extends('layouts.app')
@section('content')
<main class="main-wrap">	
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            <div class="menu-aside">
                <h3>My Dashboard</h3>
                <ul>
                    <li class="active">
                        <a href="be-teacher-dashboard-overview.html">
                            <span><img src="images/tempt/ico-overview.png" alt="Overview icon" /></span>
                            <strong>Overview</strong>
                        </a>
                    </li>
                    <li>
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
                <h1 class="title-3">Good Morning Teacher Christine,</h1>
                <div class="box-1">
                    <h2 class="title-2">Announcements</h2>
                    <div class="accordion acctype mt-20">
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#course-1" aria-expanded="false" aria-controls="course-1"><strong>Announcement</strong> <span>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod ...</span><em>31/02/2022</em></button>
                            </h3>
                            <div id="course-1" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <figure class="imgwrap-2">
                                        <img src="images/tempt/img-2.jpg" alt="" />
                                    </figure>
                                    <article class="document">
                                        <h3>Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</h3>
                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                                        <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                                        <p>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea</p>
                                    </article>
                                    <hr/>
                                    <div>Attachments:</div>
                                    <ul class="list-3">
                                        <li><a href="example.pdf" target="_blank">pdfattachements2022.pdf</a></li>
                                        <li><a href="example.pdf" target="_blank">pdfattachements2022.pdf</a></li>
                                        <li><a href="example.pdf" target="_blank">pdfattachements2022.pdf</a></li>
                                    </ul>
                                    <div class="mt-15">
                                        <a class="link-3" href="#">Download All Attachements</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#course-2" aria-expanded="false" aria-controls="course-2"><strong>Announcement</strong> <span>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore</span><em>31/02/2022</em></button>
                            </h3>
                            <div id="course-2" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <figure class="imgwrap-2">
                                        <img src="images/tempt/img-2.jpg" alt="" />
                                    </figure>
                                    <article class="document">
                                        <h3>Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</h3>
                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                                        <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                                        <p>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea</p>
                                    </article>
                                    <hr/>
                                    <div>Attachments:</div>
                                    <ul class="list-3">
                                        <li><a href="example.pdf" target="_blank">pdfattachements2022.pdf</a></li>
                                        <li><a href="example.pdf" target="_blank">pdfattachements2022.pdf</a></li>
                                        <li><a href="example.pdf" target="_blank">pdfattachements2022.pdf</a></li>
                                    </ul>
                                    <div class="mt-15">
                                        <a class="link-3" href="#">Download All Attachements</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sp-col-20 grid-10">
                    <div class="col-xl-7 sp-col order-xl-last">
                        <div class="box-1">
                            <h3 class="title-7 text-center">Calendar</h3>
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="col-xl-5 sp-col order-xl-first">
                        <div class="box-1">
                            <h2 class="title-2">My Calendar</h2>
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input class="form-control" type="text" placeholder="e.g. Michelle Tan" />
                            <label class="lb-1">Date &amp; Time <span class="required">*</span></label>
                            <div class="row sp-col-10 break-424">
                                <div class="col-6 sp-col">
                                    <div class="date-wrap">
                                        <i class="fa-solid fa-calendar-days ico"></i>
                                        <input class="form-control" type="text" placeholder="Select Date" />
                                    </div>
                                </div>
                                <div class="col-6 sp-col mt-474-10">
                                    <div class="time-wrap sp-col">
                                        <i class="icon-clock ico"></i>
                                        <input class="form-control" type="text" placeholder="Select Time" />
                                    </div>
                                </div>
                            </div>
                            <label class="lb-1">Note <span class="required">*</span></label>
                            <textarea cols="30" rows="9" class="form-control" placeholder="What is your Note?"></textarea>
                            <div class="row mt-20">
                                <div class="col-auto">Set Reminder ? <span class="required">*</span></div>
                                <div class="col chooselist-1">
                                    <div class="radiotype">
                                        <input id="yes" type="radio" name="reminder" checked />
                                        <label for="yes">Yes</label>
                                    </div>
                                    <div class="radiotype">
                                        <input id="no" type="radio" name="reminder" />
                                        <label for="no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="output-1">
                                <button class="btn-1" type="submit">Add <i class="fa-solid fa-arrow-right-long"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</main>
   
@endsection
