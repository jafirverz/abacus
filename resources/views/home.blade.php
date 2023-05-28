@extends('layouts.app')

@section('content')
    <main class="main-wrap">
        <div class="row sp-col-0 tempt-2">
            <div class="col-lg-3 sp-col tempt-2-aside">
                <div class="menu-aside">
                    <h3>My Dashboard</h3>
                    <ul>
                        <li class="active">
                            <a href="be-overview.html">
                                <span><img src="images/tempt/ico-overview.png" alt="Overview icon" /></span>
                                <strong>Overview</strong>
                            </a>
                        </li>
                        <li>
                            <a href="be-achievements.html">
                                <span><img src="images/tempt/ico-achievements.png" alt="Achievements icon" /></span>
                                <strong>My Achievements</strong>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('my-profile')}}">
                                <span><img src="images/tempt/ico-profile.png" alt="Profile icon" /></span>
                                <strong>My Profile</strong>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 sp-col tempt-2-inner">
                <div class="tempt-2-content">
                    <h1 class="title-3">My Overview</h1>
                    <div class="box-1">
                        <h2 class="title-4">Allocated Level</h2>
                        <div class="row grid-1 sp-col-xl-25">
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner" style="background: #2D44B6;">
                                    <figure>
                                        <img src="images/tempt/img-level-1.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Preparatory Level</h3>
                                        <div class="gactions">
                                            <a href="be-overview-preparatory.html">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner" style="background: #3AB9C0;">
                                    <figure>
                                        <img src="images/tempt/img-level-2.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Elementary Level</h3>
                                        <div class="gactions">
                                            <a href="be-overview-elementary.html">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner lock" style="background: #FD728A;">
                                    <figure>
                                        <img src="images/tempt/img-level-3.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Intermediate Level</h3>
                                        <div class="gactions">
                                            <a href="#"><i class="icon-lock"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner lock" style="background: #F2996F;">
                                    <figure>
                                        <img src="images/tempt/img-level-4.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Advanced Level</h3>
                                        <div class="gactions">
                                            <a href="#"><i class="icon-lock"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner lock" style="background: #F1BACD;">
                                    <figure>
                                        <img src="images/tempt/img-level-5.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Post Advanced Level</h3>
                                        <div class="gactions">
                                            <a href="#"><i class="icon-lock"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row grid-1 sp-col-xl-25">
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner" style="background: #879FF9;">
                                    <figure>
                                        <img src="images/tempt/img-level-6.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Grading Examination</h3>
                                        <div class="gactions">
                                            <a href="be-overview-grading.html">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner" style="background: #F2BC00;">
                                    <figure>
                                        <img src="images/tempt/img-level-7.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Competition</h3>
                                        <div class="gactions">
                                            <a href="be-overview-competition.html">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 sp-col">
                                <div class="inner" style="background: #8900FD;">
                                    <figure>
                                        <img src="images/tempt/img-level-8.jpg" alt="" />
                                    </figure>
                                    <div class="descripts">
                                        <h3>Test/Survey</h3>
                                        <div class="gactions">
                                            <a href="#">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
