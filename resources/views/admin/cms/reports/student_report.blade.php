@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>



        </div>
        <form action="{{ route('reports-student.search') }}" method="get" id="formreport">
            @csrf
            <div class="section-body">

                <div class="row">

                    <!-- <div class="col-lg-4"><label>Student Name:</label><input type="text" name="name" class="form-control"
                            id="title" @if(isset($_GET['name']) && $_GET['name']!="" ) value="{{ $_GET['name'] }}"
                            @endif> </div> -->
                    <div class="col-lg-4">
                        <label>Instructor</label>
                        <select name="instructor[]" class="form-control selectpicker" multiple data-live-search="true">
                            <option value="">-- Select --</option>
                            @foreach ($instructor as $key => $value)
                            <option @if(isset($_GET['instructor']) && in_array($value->id, $_GET['instructor'])) selected="selected"
                                @endif value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                      <label>Student Type</label>
                      <select name="user_type" class="form-control">
                          <option value="">-- Select --</option>
                          @foreach ($userType as $key => $value)
                          <option @if(isset($_GET['user_type']) && $_GET['user_type']==$value->id) selected="selected"
                              @endif value="{{$value->id}}">{{$value->name}}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-lg-4"><label>Status:</label>
                    <select name="status" class="form-control">
                      <option value="" selected>-- Select --</option>
                      <option @if(isset($_GET['status']) && $_GET['status']==1) selected="selected"
                          @endif value="1">Active</option>
                      <!-- <option @if(isset($_GET['status']) && $_GET['status']==0) selected="selected"
                          @endif value="0">In Active</option> -->
                      <option @if(isset($_GET['status']) && $_GET['status']==2) selected="selected"
                          @endif value="2">Rejected</option>
                  </select>
                  </div>

                </div>
                
                <br />
                <input type="hidden" name="downloadexcel" value="" id="downloadexcel">
                <div class="row">
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-primary" onclick="formsubmitsearch();"> Search</button>&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" onclick="formsubmit();"> Download</button>&nbsp;&nbsp;
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
                                            <th>Action</th>
                                            <th>Account ID</th>
            <th>Full Name</th>
            <th>Date of Birth</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Student Type</th>
            <th>Levels Allocated</th>
            <th>Learning Location</th>
            <th>Status </th>
            <th>Last Updated</th>
            <th>Last Login</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($users->count())
                                        @php
                                        $i=0;
                                        @endphp
                                        @foreach($users as $key => $item)
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
                                                <a href="{{ route('customer-account.show', $item->id) }}"
                                                    class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="Listing"><i class="fas fa-eye"></i></a>

                                            </td>
                                            <td>{{ $item->account_id ?? '' }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->dob }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->email }}</td>

            <td>@if($item->user_type_id == 1) Normal Student @elseif($item->user_type_id == 2) Premium Student @elseif($item->user_type_id == 3) Online Student @elseif($item->user_type_id == 4) Event Only Student @endif</td>
            @if(isset($item->level_id))
            @php
            $allocatedLevel = $item->level_id;
            if($allocatedLevel){
                $decoded = json_decode($item->level_id);
                if(isset($decoded))
                {
                $level = \App\Level::whereIn('id', $decoded)->pluck('title')->toArray();

                $allLevel = implode(',', $level);
                //dd($allLevel);
                }
                else {
                    $allLevel='';
                }
            }
            else
            {
                $allLevel='';
            }


            @endphp
            @endif

            <td>{{ $allLevel ?? '' }}</td>
            <td>@if(is_numeric($item->learning_locations)){{ $item->location->title ?? ''}} @endif </td>
            <td>@if($item->approve_status == 1) Active @elseif($item->approve_status == 2) Deactivated @else Pending @endif</td>



            <td>{{ $item->updated_at }}</td>
            <td>
                {{ $item->last_login ?? '' }}
            </td>
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
                            {{ $users->links() }}
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
    function formsubmitsearch(){
        $("#downloadexcel").val(0);
        $('form#formreport').submit();
    }
  </script>
@endsection
