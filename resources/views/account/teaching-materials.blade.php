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
                <h1 class="title-3">{{ $page->title ?? '' }}</h1>
                @include('inc.messages')
                <div class="box-1">
                    <div class="d-flex mb-20 justify-content-end">
                        <a class="link-1 lico" href="?edit=1"><i class="icon-edit"></i> Edit</a>
                    </div>
                    <article class="document">
                        @if(isset($_GET['edit']) && $_GET['edit']==1)
                        <form action="{{ route('instructor-content.update') }}" method="post">
                        @csrf
                        <textarea name="instructor_content" class="form-control">{{ Auth::user()->instructor_content ?? '' }}</textarea>
                        <div class="output-2">
                            <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
                        </div>
                       </form>
                        @else
                        {{ Auth::user()->instructor_content ?? '' }}
                        @endif
                    </article>
                </div>
                <div class="row title-wrap-2 mt-30">
                    <div class="col-lg-4 mt-20">
                        <h1 class="title-3">Material List</h1>
                    </div>
                    <form method="get" name="material_search" id="material_search" enctype="multipart/form-data" action="">
                    @csrf
                    <div class="col-lg-8 mt-20 lastcol">
                        <div class="row input-group">
                            <div class="col-md">
                                <input class="form-control" name="keyword" type="text" placeholder="Search By" />
                            </div>
                            <div class="col-md-auto col-sm mt-767-15">
                                <div class="ggroup">
                                    <label for="filter">Filter By:</label>
                                    <div class="selectwrap">
                                        @php
                                            if(isset($_GET['file_type']))
                                            {
                                                $file_type=$_GET['file_type'];
                                            }
                                            else
                                            {
                                                $file_type='';
                                            }
                                        @endphp
                                        <select name="sub_heading" class="selectpicker"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                            <option>Sub Heading</option>
                                            @foreach ($subHeading as $key => $value)
                                            <option value="{{ url('teaching-materials?file_type='.$file_type.'&sub_heading='.$value->id) }}">{{ $value->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="selectwrap">
                                        <select name="file_type" class="selectpicker"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                            <option>File Type</option>
                                            <option value="{{ url('teaching-materials?file_type=pdf') }}">PDF</option>
                                            <option value="{{ url('teaching-materials?file_type=docx') }}">DOCX</option>
                                            <option value="{{ url('teaching-materials?file_type=doc') }}">DOC</option>
                                            <option value="{{ url('teaching-materials?file_type=ppt') }}">PPT</option>
                                            <option value="{{ url('teaching-materials?file_type=mp4') }}">MP4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto col-sm-auto mt-767-15">
                                <a class="btn-1" href="{{ route('instructor.add-material') }}">Upload New Material <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    </form>
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
                                        $uploaded_files = explode('.', $material->uploaded_files);
                                        $filename = explode('/', $material->uploaded_files);
                                        $filename =end($filename);
                                        $extension=end($uploaded_files);
                                        $file_name = explode('_', $filename);
                                        @endphp
                                <tr>
                                    <td>
                                        <em>{{ $material->title }}</em>
                                        <div class="tbactions"><a target="_blank" href="{{ asset($material->uploaded_files) }}">View</a>
                                            @if(!in_array($material->file_type,['mp4','ppt']))
                                            {{-- <a target="_blank" href="{{ asset($material->uploaded_files) }}">Download</a> --}}
                                            @endif
                                        </div>
                                    </td>
                                    <td><em>{{ $material->file_type ?? ''}}</em></td>
                                    <td><em>{{ $material->description }}</em></td>
                                    <td><em>{{ end($file_name)}}</em></td>
                                </tr>
                                        @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <ul class="page-numbers mt-30">
                        {{ $materials->links() }}
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
