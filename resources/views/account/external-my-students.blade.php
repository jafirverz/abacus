@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            <div class="menu-aside">
                @include('inc.account-sidebar-external')
            </div>
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="row title-wrap-2 mt-30">
                    <div class="col-lg-4 mt-20">
                        <h1 class="title-3">My Students</h1>
                    </div>
                    <div class="col-lg-8 mt-20 lastcol">
                        <div class="row input-group">


                            <div class="col-md-auto col-sm mt-767-15">
                                <div class="ggroup">
                                    <div class="selectwrap">
                                        <select class="selectpicker"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                <option value="">Select Status</option>

                                                <option @if(isset($_GET['status']) && $_GET['status']==1) selected @endif value="?status=1">Active</option>
                                                <option @if(isset($_GET['status']) && $_GET['status']==2) selected @endif value="?status=2">Inactive</option>
                                                <option @if(isset($_GET['status']) && $_GET['status']==0) selected @endif value="?status=0">Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <form method="get" action="{{ url('external-profile/my-students') }}">
                                    <input class="form-control" name="keyword" type="text" value="@if(isset($_GET['keyword']) && $_GET['keyword']!='') {{ $_GET['keyword'] }} @endif" placeholder="Search By Nmae">
                                </form>
                            </div>
                            <div class="col-md-auto col-sm-auto mt-767-15">
                                <a class="btn-1" href="{{ route('external-profile.add-students') }}">Add New Student <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
                @include('inc.messages')
                <div class="box-1">
                    <div class="xscrollbar">
                        <table class="tb-2 tbtype-4">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>Account <br/>ID</th>
                                    <th>Student <br/>Name</th>
                                    <th>Date of <br/>Birth</th>
                                    <th>Learning Location</th>
                                    <th>Remarks</th>
                                    <th>Access</th>
                                    <th>Account <br/>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($students)
                                    @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <em>{{ $student->account_id ?? '' }}</em>
                                        </td>
                                        <td class="text-nowrap"><em>{{ $student->name ?? '' }}</em></td>
                                        <td><em>{{ $student->dob ?? '' }}</em></td>
                                        <td><em>{{ $student->location->title ?? '' }}</em></td>
                                        <td><em>{{ $student->remarks ?? '' }}</em></td>
                                        <td>
                                            <a class="link-1" href="{{route('external-profile.add-students.edit', $student->id)}}"><i class="icon-edit"></i></a>
                                            <a class="link-1" href="{{route('external-profile.students.view', $student->id)}}">view</i></a>
                                            <a onclick="return confirm('Are you sure want to delete this?');" href="{{route('external-profile.add-students.delete', $student->id)}}">delete</a>
                                        </td>
                                        <td>
                                            @if($student->approve_status==1)
                                            <em class="status-2">Active</em>
                                            @else
                                            <em class="status-3">Not Approved</em>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <ul class="page-numbers mt-30">
                        {{ $students->links() }}
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
