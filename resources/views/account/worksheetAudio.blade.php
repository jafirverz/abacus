@extends('layouts.app')
@section('content')

<main class="main-wrap">	
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 1)
        @include('inc.account-sidebar')
      @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="be-overview-preparatory.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('home') }}">Overview</a></li>
          <li><a href="{{ url('') }}">Preparatory Level</a></li>
          <li><strong>{{ $worksheet->title }}</strong></li> 
        </ul>
        <div class="box-1">
          {{ $worksheet->description }}
        </div>
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="#">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <div class="row grid-4">
          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q1</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-1">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q2</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-2">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q3</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-3">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q4</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-4">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q5</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-5">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q1</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-6">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q2</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-7">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q3</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-8">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q4</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-9">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q5</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-10">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q1</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-11">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q2</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-12">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q3</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-13">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q4</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-14">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q5</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-15">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q1</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-16">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q2</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-17">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q3</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-18">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q4</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-19">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q5</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-20">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q1</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-21">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q2</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-22">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q3</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-23">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q4</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-24">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q5</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-25">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q1</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-26">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q2</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-27">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q3</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-28">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q4</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-29">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q5</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-30">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="output-1">
          <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
        </div>
      </div>
    </div>
  </div>	
</main>
@endsection