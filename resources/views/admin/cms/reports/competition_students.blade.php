@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>



        </div>
        <form action="{{ route('reports-competition.search') }}" method="get" id="formreport">
            @csrf
            <div class="section-body">

                <div class="row">

                        <div class="col-lg-4"><label>Learning Location:</label>
                          <select name="learning_location" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach($learningLocation as $locat)
                            <option @if(isset($_REQUEST['learning_location']) && $_REQUEST['learning_location']==$locat->id) selected="selected"
                                @endif value="{{ $locat->id }}">{{ $locat->title }}</option>
                            @endforeach
                        </select>
                        </div>
                        <!-- <div class="col-lg-4"><label>End Date:</label>
                          <input type="text" name="enddate" class="form-control datepicker1"
                          id="title" @if(isset($_GET['enddate']) && $_GET['enddate']!="" ) value="{{ $_GET['enddate'] }}"
                          @endif>
                        </div> -->
                    <div class="col-lg-4">
                        <label>Instructor</label>
                        <select name="instructor" class="form-control" >
                            <option value="">-- Select --</option>
                            @foreach ($instructor as $key => $value)
                            <option @if(isset($_REQUEST['instructor']) && $_REQUEST['instructor']==$value->id) selected="selected"
                                @endif value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Event</label>
                        <select name="event" class="form-control">
                          <option value="">-- Select --</option>
                          @foreach ($competitions as $key => $value)
                          <option @if(isset($_REQUEST['event']) && $_REQUEST['event']==$value->id) selected="selected"
                              @endif value="{{$value->id}}">{{$value->title}}</option>
                          @endforeach
                      </select>
                  </div>

                </div>
                <div class="row">
                    <div class="col-lg-4"><label>Country:</label>
                      <select name="country" class="form-control">
                        <option value="">-- Select --</option>
                        @foreach($countries as $country)
                        <option @if(isset($_REQUEST['country']) && $_REQUEST['country']==$country->id) selected="selected"
                            @endif value="{{ $country->id }}">{{ $country->country }}</option>
                        @endforeach
                    </select>
                    </div>
                    <!-- <div class="col-lg-4"><label>End Date:</label>
                      <input type="text" name="enddate" class="form-control datepicker1"
                      id="title" @if(isset($_GET['enddate']) && $_GET['enddate']!="" ) value="{{ $_GET['enddate'] }}"
                      @endif>
                    </div> -->
                </div>
                <br />
                <input type="hidden" name="downloadexcel" value="" id="downloadexcel">
                <div class="row">
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary" > Search</button>
                        <button type="button" class="btn btn-primary" onclick="formsubmit();"> Export</button>&nbsp;&nbsp;
                        @if(request()->get('_token'))
                        <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                        @else
                        <button type="reset" class="btn btn-primary">Clear All</button>
                        @endif

                    </div>
                </div>


            </div>
        </form><br />

        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <a href="{{ route('pages.destroy', 'pages') }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('pages.destroy', 'pages') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <!-- <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th> -->
                                            <th>S/N</th>
                                            <th>Student Name</th>
                                            <th>Student DOB</th>
                                            <th>Contact Number</th>
                                            <th>Instructor Name</th>
                                            <th>Learning Location </th>
                                            <th>Country </th>
                                            <th>Competition Category </th>
                                            <th>Paper </th>
                                            <th>Total Marks </th>
                                            <th>Prize </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($compStudents->count())
                                        @php
                                        $i=0;
                                        @endphp
                                        @foreach($compStudents as $key => $item)
                                        @php
                                        $i++;
                                        @endphp
                                        <tr>
                                            <!-- <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td> -->
                                            <td>
                                                {{ $i }}
                                            </td>
                                            
                                            <td>
                                                {{ $item->student->name  ?? ''}}
                                            </td>
                                            <td>
                                                {{ $item->student->dob  ?? ''}}
                                            </td>
                                            <td>
                                                {{ $item->student->country_code_phone.$item->student->mobile  ?? ''}}
                                            </td>
                                            <td>
                                                {{ $item->teacher->name  ?? ''}}
                                            </td>
                                            
                                            <td>{{ $item->location->title ?? '' }}</td>
                                            <td>{{ getCountry($item->student->country_code) ?? '' }}</td>
                                            <td>{{ getCategory($item->category_id)->category_name ?? '' }}</td>
                                            @php
                                            $abc = getPaper($item->competition_controller_id, $item->category_id, $item->user_id);
                                            if(!empty($abc)){
                                                $paperResult = implode(',  ', $abc);
                                            }
                                            @endphp
                                            <td>{{ $paperResult ?? '' }}</td>
                                            <td>{{ getTotalPaperMarks($item->competition_controller_id, $item->category_id, $item->user_id) }}</td>

                                            <td>{{ getPrize($item->competition_controller_id, $item->category_id, $item->user_id) }}</td>
                                            
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer">
                            {{ $compStudents->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function formsubmit(){
        $("#downloadexcel").val(1);
        $('form#formreport').submit();
    }
</script>
@endsection
