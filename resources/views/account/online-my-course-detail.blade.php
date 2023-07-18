@extends('layouts.app')
@section('content')
<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
        @include('inc.account-sidebar-online')
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
        <div class="tempt-2-content">
            <div class="mb-20">
                <a class="link-1 lico" href="#"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>
            <ul class="breadcrumb bctype">
                <li><a href="{{ url('online-student/my-course')}}">My Courses</a></li>
                <li><strong>{{ $course->level->title}}</strong></li> 
            </ul>
            <div class="box-1">
                <h2 class="title-2">{{ $course->title}}</h2>
                <article class="document mt-20">
                    {!! $course->content !!}
                </article>
            </div>
            <div class="row sp-col-30 grid-7">
                <div class="col-lg-6 sp-col videowrap">
                    <video width="400" controls>
                        <source src="video/mov.mp4" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="col-lg-6 sp-col countwrap">
                    <img src="images/tempt/count.jpg" alt="" />
                </div>
            </div>
            <div class="xscrollbar mt-50">
                <table class="tb-2 tbtype-2">
                    <thead>
                        <tr>
                            <th class="text-center">1</th>
                            <th class="text-center">2</th>
                            <th class="text-center">3</th>
                            <th class="text-center">4</th>
                            <th class="text-center">5</th>
                            <th class="text-center">6</th>
                            <th class="text-center">7</th>
                            <th class="text-center">8</th>
                            <th class="text-center">9</th>
                            <th class="text-center">10</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">9</td>
                            <td class="text-center">6</td>
                            <td class="text-center">7</td>
                            <td class="text-center">8</td>
                            <td class="text-center">5</td>
                            <td class="text-center">8</td>
                            <td class="text-center">6</td>
                            <td class="text-center">7</td>
                            <td class="text-center">1</td>
                            <td class="text-center">4</td>
                        </tr>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">4</td>
                            <td class="text-center">3</td>
                            <td class="text-center">2</td>
                            <td class="text-center">5</td>
                            <td class="text-center">4</td>
                            <td class="text-center">7</td>
                            <td class="text-center">5</td>
                            <td class="text-center">9</td>
                            <td class="text-center">6</td>
                        </tr>
                        <tr>
                            <td class="text-center">9</td>
                            <td class="text-center">22</td>
                            <td class="text-center">4</td>
                            <td class="text-center">7</td>
                            <td class="text-center">4</td>
                            <td class="text-center">-2</td>
                            <td class="text-center">-3</td>
                            <td class="text-center">-8</td>
                            <td class="text-center">-5</td>
                            <td class="text-center">-1</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                            <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="output-1">
                <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
        </div>
  </div>
</main>
@endsection
