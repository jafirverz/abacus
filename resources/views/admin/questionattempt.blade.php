@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ $title ?? '-' }}</h1>



    </div>
    @php 
          if(!empty($_GET['quesTemp'])){
            $quesTempp = $_GET['quesTemp'];
          }else{
            $quesTempp = '';
          }

          if(!empty($_GET['searchname'])){
            $sname = $_GET['searchname'];
          }else{
            $sname = '';
          }

          
          @endphp
    <form action="{{ route('question-attempt.search') }}" method="get">
      @csrf
      <div class="section-body">

        <div class="row">
          
          <div class="col-lg-4"><label>Question Template:</label>
            <select name="quesTemp" class="form-control" required>
              <option value="">--Please Select--</option>
              @foreach($quesTemp as $ques)
              <option value="{{ $ques->id }}" @if($quesTempp ==  $ques->id) selected @endif>{{ $ques->title }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-lg-4"><label>Search:</label>
            <input type="text" class="form-control" name="searchname" value="{{ $sname }}" placeholder="Search by User name"> 
          </div>




        </div>

        <br />
        <div class="row">
          <div class="col-lg-4">
            <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
            

          </div>

          

        </div>


      </div>
    </form><br />

    <div class="section-body">
      @include('admin.inc.messages')

      <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-md">
                  <thead>
                    <tr>
                      
                      <th>S/N</th>
                      <th>Level</th>
                      <th>Student Name</th>
                      <th>Attempt</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(isset($allWorksheetSubmitted) && count($allWorksheetSubmitted) > 0)
                    @php 
                    $i = 1;
                    @endphp
                    @foreach($allWorksheetSubmitted as $value)
                    
                    @php 
                    
                    $users = \App\User::where('id', $value->user_id)->first();
                    $level = \App\Level::where('id', $value->level_id)->first();
                    @endphp
                    <tr>
                        
                        <td>{{ ($i) }}</td>
                        <td>{{ ($level->title) }}</td>
                        <td>{{ $users->name }}</td>
                        <td>{{ $value->total ?? '' }}</td>

                        
                    </tr>
                    @php
                        $i++;
                    @endphp
                    
                    @endforeach
                    @else
                    <tr>
                        <td colspan="27" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                    </tr>
                    @endif
                </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection