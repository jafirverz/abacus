<div class="tempt-2-content">
    <h1 class="title-3">My Overview</h1>
    <div class="box-1">
        <h2 class="title-4">Allocated Level</h2>
        <div class="row grid-1 sp-col-xl-25">

            @foreach($levels as $level)
            <div class="col-xl-4 col-sm-6 sp-col">
                <div class="inner" style="background: #2D44B6;">
                    <figure>
                        <img src="{{ asset($level->image) }}" alt="" />
                    </figure>
                    <div class="descripts">
                        <h3>{{ $level->title }}</h3>
                        <div class="gactions">
                            @if(in_array($level->id, $levelArray))
                            <a href="{{ url('level/'.$level->slug) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                            @else
                            <a href="javascript::void(0);"><i class="icon-lock"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            


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
                           @if(isset($grading_exam->id))
                            <a href="{{ url('grading-overview/'.$grading_exam->id) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
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
                        <img src="images/tempt/img-level-7.jpg" alt="" />
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
                            <a href="{{ url('competition/'.$competitionId) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
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
                        <img src="images/tempt/img-level-8.jpg" alt="" />
                    </figure>
                    <div class="descripts">
                        <h3>Test/Survey</h3>
                        <div class="gactions">
                            @php
                            if($surveys){
                                $allocation = \App\Allocation::where('student_id', Auth::user()->id)->where('is_finished', null)->orderBy('id', 'desc')->first();
                                if(!$allocation){
                                    $url = 'javascript::void(0)'; 
                                }else{
                                    $url = url('/survey-form');
                                }
                                
                            }else{
                                $url = 'javascript::void(0)'; 
                            }
                            @endphp
                            <a href="{{ $url }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
