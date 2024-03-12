<div class="tempt-2-content">
    <h1 class="title-3">My Overview</h1>
    <div class="box-1">
        <h2 class="title-4">Allocated Level</h2>
        <div class="row grid-1 sp-col-xl-25">
            @php
            $levelIdActive = '';
            $levelIdActive = Session::get('levelIdActive');
            $i = 1;
            @endphp
            @foreach($levels as $level)
            @php
            if($i == 1){
                $backColor = '#2D44B6';
                $lockClass = '';
            }elseif($i == 2){
                $backColor = '#3AB9C0';
                $lockClass = '';
            }elseif($i == 3){
                $backColor = '#FD728A';
                $lockClass = 'lock';
            }elseif($i == 4){
                $backColor = '#F2996F';
                $lockClass = 'lock';
            }elseif($i == 5){
                $backColor = '#F1BACD';
                $lockClass = 'lock';
            }
            @endphp
            <div class="col-xl-4 col-sm-6 sp-col">
                <div class="inner {{ $lockClass }}" style="background: {{ $backColor }}">
                    <figure>
                        <img src="{{ asset($level->image) }}" alt="" />
                    </figure>
                    <div class="descripts">
                        <h3>{{ $level->title }}</h3>
                        <div class="gactions">
                            @if(Auth::user()->approve_status == 1)
                                @if(in_array($level->id, $levelArray))
                                <a href="{{ url('level/'.$level->slug) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                @else
                                <a href="javascript::void(0);"><i class="icon-lock"></i></a>
                                @endif
                            @elseif(isset($levelIdActive) && in_array($level->id, $levelIdActive))
                            <a href="{{ url('level/'.$level->slug) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                            @else
                                <a href="javascript::void(0);"><i class="icon-lock"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @php
            $i++;
            @endphp
            @endforeach



        </div>
        <div class="row grid-1 sp-col-xl-25">
            <div class="col-xl-4 col-sm-6 sp-col">
                <div class="inner" style="background: #879FF9;">
                    <figure>
                        <img src="{{ config('system_settings')->grading_icon ?? '' }}" alt="" />
                    </figure>
                    <div class="descripts">
                        <h3>Grading Examination</h3>
                        <div class="gactions">
                           @if(isset($grading_exam->id))
                                @if(Auth::user()->approve_status == 1)
                                <a href="{{ url('grading/'.$grading_exam->id) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                @else
                                <a href="javascript::void(0)">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                @endif
                           @else
                            <a href="javascript::void(0)">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                           @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 sp-col">
                <div class="inner" style="background: #F2BC00;">
                    <figure>
                        <img src="{{ config('system_settings')->competition_icon ?? '' }}" alt="" />
                    </figure>
                    <div class="descripts">
                        <h3>Competition</h3>
                        <div class="gactions">

                            @php
                            if(isset($competition) && !empty($competition)){
                                $competitionId = $competition->id;
                                $compStu = \App\CompetitionStudent::where('user_id', Auth::user()->id)->where('competition_controller_id', $competition->id)->where('approve_status', 1)->first();
                                if($compStu){
                                    $url = 1;
                                }else{
                                    $url = '0';
                                }
                            }else{
                                $url = '0';
                            }
                            @endphp
                            @if(!empty($url))
                                @if(Auth::user()->approve_status == 1)
                                <a href="{{ url('competition/'.$competitionId) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                @else
                                <a href="javascript::void();">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                @endif
                            @else
                            <a href="javascript::void();">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 sp-col">
                <div class="inner" style="background: #8900FD;">
                    <figure>
                        <img src="{{ config('system_settings')->test_survey_icon ?? '' }}" alt="" />
                    </figure>
                    <div class="descripts">
                        <h3>Test/Survey</h3>
                        <div class="gactions">
                            @if(isset($test))
                                @php
                                //dd($test);
                                $url=route('test.detail',$test->id);
                                $is_submitted = \App\TestSubmission::where('user_id', Auth::user()->id)->where('test_id', $test->id)->count();
                                @endphp
                            @else
                                @php
                                //dd($test);
                                if($surveys){
                                    $allocation = \App\Allocation::where('student_id', Auth::user()->id)->where('type', 2)->where('is_finished', null)->orderBy('id', 'desc')->first();
                                    if(!$allocation){
                                        $url = 'javascript::void(0)';
                                    }else{
                                        $url = url('/survey-form');
                                    }

                                }else{
                                    $url = 'javascript::void(0)';
                                }
                                @endphp
                            @endif
                            @if(Auth::user()->approve_status == 1)

                                @if(isset($is_submitted) && $is_submitted>0)
                                <a href="javascript::void(0)">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                @else
                                <a href="{{ $url }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                                @endif
                            @else
                            <a href="javascript::void();">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="title-1 mt-30">My Certificates</h2>
            <div class="box-1">
                <div class="row grid-6">
                    @if($gradingCertificate)
                    @foreach($gradingCertificate as $certificate)
                    <div class="col-md-6">
                        <a class="item" href="{{ url('download-grading-certificate', $certificate->id) }}">{{ $certificate->grade->title ?? '' }}</a>
                    </div>
                    @endforeach
                    @endif

                    @if($competitionCertificate)
                    @foreach($competitionCertificate as $certificate)
                    <div class="col-md-6">
                        <a class="item" href="{{ route('download.competition.certificate', $certificate->id) }}">{{ $certificate->competition->title ?? '' }}</a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
</div>
