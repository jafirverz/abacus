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
                            <div class="col-md">
                                <input class="form-control" type="text" placeholder="Search By" />
                            </div>
                            <div class="col-md-auto col-sm mt-767-15">
                                <div class="ggroup">
                                    <label for="filter">Filter By:</label>
                                    <div class="selectwrap">
                                        <select class="selectpicker">
                                            @foreach($levels as $level)
                                                <option>{{ $level->title }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto col-sm-auto mt-767-15">
                                <a class="btn-1" href="{{ route('instructor.add-students') }}">Add New Student <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
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
                                @foreach($students as $student)
                                <tr>
                                    <td>
                                        <em>{{ $student->account_id }}</em>
                                        <div class="tbactions"><a href="#">Profile</a> <a href="#">Achievements</a></div>
                                    </td>
                                    <td class="text-nowrap"><em>{{ $student->name }}</em></td>
                                    <td class="text-nowrap"><em>{{ $student->country_code_phone }} {{ $student->mobile }}</em></td>
                                    <td><em>{{ $student->dob }}</em></td>
                                    <td><em></em></td>
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
                                    <td><em class="status-6">@if($student->approve_status == 1) Approved @else Not Approved @endif</em> <br/></td>
                                </tr>
                                @endforeach
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
