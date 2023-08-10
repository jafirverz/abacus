<div class="tempt-2-content">
    <h1 class="title-3">My Overview</h1>
    <div class="box-1">

        <div class="row grid-1 sp-col-xl-25">
            <div class="col-xl-4 col-sm-6 sp-col">
                <div class="inner" style="background: #879FF9;">
                    <figure>
                        <img src="images/tempt/img-level-6.jpg" alt="" />
                    </figure>
                    <div class="descripts">
                        <h3>Grading Examination</h3>
                        <div class="gactions">
                            @if($grading_exam)
                            <a href="{{ route('grading-overview',$grading_exam->id) }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
                            @else
                            <a href="{{ url('grading-exam') }}">View More <i class="fa-solid fa-arrow-right-long"></i></a>
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
                                $compStu = \App\CompetitionStudent::where('user_id', Auth::user()->id)->where('competition_controller_id', $competition->id)->first();
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

        </div>
    </div>
</div>
