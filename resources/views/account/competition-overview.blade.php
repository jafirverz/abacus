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
                        <a class="link-1 lico" href="be-overview.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
                    </div>
                    <h1 class="title-3">My Overview</h1>
                    <div class="box-1">
                        <div class="row grid-2 sp-col-15">
                            <div class="col-xl-3 col-sm-5 sp-col gcol-1">
                                <img class="image" src="images/tempt/img-level-6-big.jpg" alt="" />
                            </div>
                            <div class="col-xl-9 col-sm-7 sp-col gcol-2 mt-574-30">
                                <h2 class="title-4">Competition</h2>
                                <div class="row sp-col-15">
                                    <div class="col-lg-12 sp-col gincol-1">
                                        <div class="inrow">
                                            <strong>Title:</strong> {{ $competetion->title ?? ''  }}
                                        </div>
                                        <div class="inrow">
                                            <strong>Date:</strong> @if(isset($competetion)) {{ date('j F, Y',strtotime($competetion->date_of_competition)) }} @endif
                                        </div>
                                        <div class="inrow">
                                            <strong>Allocated Competition Time:</strong> @if(isset($competetion)) SGT {{ date('g:i A',strtotime($competetion->start_time_of_competition.':00')) }} @endif
                                        </div>
                                        <div class="inrow">
                                            <strong>Registered Category:</strong> _Category a (5 &amp; 6 year old)
                                        </div>
                                        <div class="inrow">
                                            <strong>Venu:</strong> XXXX
                                        </div>
                                    </div>
                                    <div class="col-lg-12 sp-col gincol-2">
                                        <div class="inrow">
                                            <strong>Result:</strong> <span class="status-1">2nd Prize</span>
                                        </div>
                                        <div class="inrow">
                                            <strong>Competition Type:</strong> <span class="status-1">{{ $competetion->competition_type ?? '' }}</span>
                                        </div>
                                        <div class="inrow">
                                            <a class="btn-1" href="#">Download Competition Pass <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-30">
                            <h4 class="title-6">Important Note</h4>
                            {!! $competetion->description ?? ''  !!}
                        </div>
                        <div class="accordion mt-30">
                            @if($competetion->compCate)
                            @php $k=0; @endphp
                            @foreach($competetion->compCate as $cate)
                            @php $k++; @endphp
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button @if($k!=1) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $k }}" aria-expanded="false" aria-controls="faq-{{ $k }}">{{ $cate->category->category_name }}</button>
                                </h3>
                                <div id="faq-{{ $k }}" class="accordion-collapse collapse @if($k==1) show @endif">
                                    <div class="accordion-body">
                                        <div class="row break-1500">
                                            @if(get_category_paper_list($competetion->id,$cate->category->id))
                                             @foreach(get_category_paper_list($competetion->id,$cate->category->id) as $value)
                                            <div class="col-xl-6 sp-col">
                                                <div class="box-2">
                                                    @if($value->compQues)
                                                    @foreach($value->compQues as $q)
                                                    <div class="bxrow">
                                                        <div class="checkbxtype nocheck">
                                                            <label><span>Category A - Practice 1</span></label>
                                                        </div>
                                                        <a class="lnk btn-2" href="#">Download</a>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="output-2 mt-0">
                                            <a class="btn-1" href="#">Add to Cart <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @if($errors->any())
        <script>
                $("#profileform").find("input, select, textarea").attr("disabled", false);
                $('#instructor').attr('disabled', true);
                $('#disablephone').hide();
                $('#enablephone').show();
                $('#disablegender').hide();
                $('#enablegender').show();
                $('#disablecountry').hide();
                $('#enablecountry').show();
                //$('#disableinstructor').hide();
                //$('#enableinstructor').show();
                $('#updateprofile').val(1);
                // $('#profileform').hide();
                // $('#profileformedit').show();

        </script>
    @endif
<script>
    function myFunction(id) {
        var x = document.getElementById(id);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    $('#removeimage').click(function() {
        $("#preview").hide();
        // $('#preview').removeAttr("src").hide();
    });
    $('#chooseimage').click(function() {
        alert("aa");
        //$("#preview").attr("src", "");
        $('#preview').show();
    });
    $('#removeimage1').click(function() {
        $("#preview1").hide();
        // $('#preview').removeAttr("src").hide();
    });
    $('#chooseimage1').click(function() {
        alert("aa");
        //$("#preview").attr("src", "");
        $('#preview1').show();
    });
    $('#editinformation').click(function () {
        $("#profileform").find("input, select, textarea").attr("disabled", false);
        $('#instructor').attr('disabled', true);
        $('#disablephone').hide();
        $('#enablephone').show();
        $('#disablegender').hide();
        $('#enablegender').show();
        $('#disablecountry').hide();
        $('#enablecountry').show();
        //$('#disableinstructor').hide();
        //$('#enableinstructor').show();
        $('#updateprofile').val(1);
        // $('#profileform').hide();
        // $('#profileformedit').show();

    });
</script>
@endsection
