@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            <div class="menu-aside">
                @include('inc.intructor-account-sidebar')

            </div>
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <h1 class="title-3">Teaching Materials</h1>
                <div class="box-1">
                    <div class="d-flex mb-20 justify-content-end">
                        <a class="link-1 lico" href="#"><i class="icon-edit"></i> Edit</a>
                    </div>
                    <article class="document">
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est</p>
                    </article>
                </div>
                <div class="row title-wrap-2 mt-30">
                    <div class="col-lg-4 mt-20">
                        <h1 class="title-3">Material List</h1>
                    </div>
                    <div class="col-lg-8 mt-20 lastcol">
                        <div class="row input-group">
                            <div class="col-md">
                                <input class="form-control" type="text" placeholder="Search By" />
                            </div>
                            <div class="col-md-auto col-sm mt-767-15">
                                <div class="ggroup">
                                    <label for="filter">Filter By:</label>
                                    <div class="selectwrap">
                                        <select class="selectpicker">
                                            <option>File Type</option>
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                            <option>Option 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto col-sm-auto mt-767-15">
                                <a class="btn-1" href="#">Upload New Material <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-1">
                    <div class="xscrollbar">
                        <table class="tb-2 tbtype-4">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>Material Title</th>
                                    <th>File Type</th>
                                    <th>Description</th>
                                    <th>Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($materials->count())
                                        @foreach ($materials as $material)
                                        @php
                                        $uploaded_files = end(preg_split('/-/', $material->uploaded_files));
                                        @endphp
                                <tr>
                                    <td>
                                        <em>{{ $material->title }}</em>
                                        <div class="tbactions"><a href="{{ asset($material->uploaded_files) }}">View</a> <a href="{{ asset($material->uploaded_files) }}">Download</a></div>
                                    </td>
                                    <td><em>pdf</em></td>
                                    <td><em>{{ $material->description }}</em></td>
                                    <td><em>{{  $uploaded_files }}</em></td>
                                </tr>
                                        @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
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
            $('#disablegender').hide();
            $('#enablegender').show();
            $('#disablephone').hide();
            $('#enablephone').show();
            $('#disablecountry').hide();
            $('#enablecountry').show();
            $('#updateprofile').val(1);
            // $('#profileform').hide();
            // $('#profileformedit').show();

        });
    </script>
@endsection
