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
                <div class="row title-wrap-2 mt-30">
                    <div class="col-lg-4 mt-20">
                        <h1 class="title-3">My Students</h1>
                    </div>
                    <div class="col-lg-8 mt-20 lastcol">
                        <div class="row input-group">
                            <div class="col-md-3 col-sm mt-767-15">
                                <div class="ggroup">
                                    <label for="filter">Filter By:</label>
                                    <div class="selectwrap">
                                        <select data-live-search="true" class="selectpicker"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"> @if($locations)
                                            <option value="">Select Location</option>
                                        @foreach($locations as $item)
                                        <option @if(isset($_GET['learning_locations']) && $_GET['learning_locations']==$item->id) selected @endif  value="?learning_locations={{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm mt-767-15">
                                <div class="ggroup">
                                    <div class="selectwrap">
                                        <select data-live-search="true" class="selectpicker"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                <option value="">Select Level</option>
                                                @foreach($levels as $level)
                                                <option @if(isset($_GET['level_id']) && $_GET['level_id']==$level->id) selected @endif value="?level_id={{ $level->id }}">{{ $level->title }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-sm mt-767-15">
                                <div class="ggroup">
                                    <div class="selectwrap">
                                        <select class="selectpicker"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                <option value="">Select Status</option>

                                                <option @if(isset($_GET['status']) && $_GET['status']==1) selected @endif value="?status=1">Activated</option>
                                                <option @if(isset($_GET['status']) && $_GET['status']==2) selected @endif value="?status=2">Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-auto mt-767-15">
                                <a class="btn-1" href="{{ route('instructor.add-students') }}">Add New Student <i class="fa-solid fa-arrow-right-long"></i></a>
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
                                    <th>PHONE</th>
                                    <th>Date of <br/>Birth</th>
                                    <th>Learning <br/>Location</th>
                                    <!-- <th>Learning Updates</th> -->
                                    <th>Level <br/>Access</th>
                                    <th>Account <br/>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($students->count() > 0)
                                @foreach($students as $student)
                                <tr>
                                    <td>
                                        <em>{{ $student->account_id }}</em>
                                        <div class="tbactions">
                                            <a href="{{route('instructor.students.view', $student->id)}}">Profile</a>
                                            <a href="{{route('normal.my-achievements', $student->id)}}">Achievements</a>
                                            @if(check_approve_changes($student->id)!=Null)
                                            <a href="{{route('instructor.students.approve', $student->id)}}">Approve Changes</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap"><em>{{ $student->name }}</em></td>
                                    <td class="text-nowrap"><em>{{ $student->country_code_phone }} {{ $student->mobile }}</em></td>
                                    <td><em>{{ $student->dob }}</em></td>
                                    <td><em>{{ $student->location->title ?? '' }}</em></td>
                                    <!-- <td>
                                        <div class="hasaction bot">
                                            <em>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</em>
                                            <a class="link-1" href="#"><i class="icon-edit"></i></a>
                                        </div>
                                    </td> -->
                                    @php
                                    $level = json_decode($student->level_id);
                                    $levelarry = array();
                                    if(!empty($level) && sizeof($level) > 0){
                                        foreach($level as $levelname){
                                            $levelsdetails = \App\Level::where('id', $levelname)->first();
                                            $title = $levelsdetails->title;
                                            array_push($levelarry, $title);

                                        }
                                    }else{
                                        $levelarry = '';
                                    }
                                    if(!empty($levelarry) && sizeof($levelarry) > 0){
                                        $levelarry = implode(", ",$levelarry);
                                    }else{
                                        $levelarry = 'NA';
                                    }
                                    @endphp
                                    <td>
                                        <div class="hasaction">
                                            <em>{{ $levelarry }}</em>
                                            <a class="link-1" href="{{route('instructor.add-students.edit', $student->id)}}"><i class="icon-edit"></i></a>
                                        </div>
                                    </td>
                                    <td>@if($student->approve_status == 1) <em class="status-6">Approved</em><br><em class="status-7 mt-5px">Activated</em> @elseif($student->approve_status == 2) <em class="status-3">not approved</em> @else <em class="status-3">Pending</em> @endif</td>
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

@endsection
