@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>



        </div>
        <form action="{{ route('reports-grading-examination.search') }}" method="post">
            @csrf
            <div class="section-body">

                <div class="row">

                    <div class="col-lg-4"><label>Student Name:</label><input type="text" name="name" class="form-control"
                            id="title" @if(isset($_GET['name']) && $_GET['name']!="" ) value="{{ $_GET['name'] }}"
                            @endif> </div>
                    <div class="col-lg-4">
                        <label>Instructor</label>
                        <select name="instructor[]" class="form-control" multiple>
                            <option value="">-- Select --</option>
                            @foreach ($instructor as $key => $value)
                            <option @if(isset($_GET['instructor_id']) && $_GET['instructor_id']==$value->id) selected="selected"
                                @endif value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                      <label>Event</label>
                      <select name="event" class="form-control">
                        <option value="">-- Select --</option>
                        @foreach ($grading_exam as $key => $value)
                        <option @if(isset($_GET['event']) && $_GET['event']==$value->id) selected="selected"
                            @endif value="{{$value->id}}">{{$value->title}}</option>
                        @endforeach
                    </select>
                  </div>

                </div>
                <div class="row">
                    <div class="col-lg-4"><label>Status:</label>
                      <select name="status" class="form-control">
                        <option value="">-- Select --</option>
                        <option @if(isset($_GET['status']) && $_GET['status']==1) selected="selected"
                            @endif value="1">Approved</option>
                        <option @if(isset($_GET['status']) && $_GET['status']==2) selected="selected"
                            @endif value="2">Pending</option>

                    </select>
                    </div>
                    <!-- <div class="col-lg-4"><label>End Date:</label>
                      <input type="text" name="enddate" class="form-control datepicker1"
                      id="title" @if(isset($_GET['enddate']) && $_GET['enddate']!="" ) value="{{ $_GET['enddate'] }}"
                      @endif>
                    </div> -->
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary"> Export</button>&nbsp;&nbsp;
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
                                            <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>S/N</th>
                                            <th>Event Name</th>
                                            <th>Student Name</th>
                                            <th>Student Email</th>
                                            <th>Student DOB</th>
                                            <th>Student Number</th>
                                            <th>Instructor Name</th>
                                            <th>Franchise Country Name</th>
                                            <th>Registered <br>Mental Grade</th>
                                            <th>Registered <br>Abacus Grades</th>
                                            <th>Learning Location </th>
                                            <th>Status </th>
                                            <th>Remark </th>
                                            <th>Result</th>
                                            <th>Pass/Fail</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($grading_students->count())
                                        @php
                                        $i=0;
                                        @endphp
                                        @foreach($grading_students as $key => $item)
                                        @php
                                        $i++;
                                        @endphp
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                {{ $i }}
                                            </td>
                                            <td>
                                                {{ $item->event->title ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->student->name  ?? ''}}
                                            </td>
                                            <td>
                                                {{ $item->student->email  ?? ''}}
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
                                            <td>
                                                {{ getCountry($item->teacher->country_code) ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->mental->title ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->abacus->title ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->location->title ?? '' }}
                                            </td>
                                            <td>
                                                {{ ($item->approve_status==1)?'Approved':'Pending' }}
                                            </td>
                                            <td>{{ $item->remarks ?? ''}}</td>
                                            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->user_id )->result ?? '-'}}</td>
                                            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->user_id )->remark_grade ?? '-'}}</td>
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
                            {{ $grading_students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
