@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('results.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}, {{ $competition->title }}</h1>
            
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank')])--}}

        </div>
        <br />

        @if($competition->competition_type == 'online')
        <div class="section-body">
            @include('admin.inc.messages')

            <form action="{{ route('results.competition', ['id'=>$competitionId]) }}" method="get" id="formreport">
                @csrf
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-4"><label>Category:</label>
                            <select name="catId" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($competitionCategory as $cate)
                                <option value="{{ $cate->category_id }}" @if(isset($_REQUEST['catId']) && $_REQUEST['catId']==$cate->category_id) selected="selected"
                                    @endif>{{$cate->category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-primary"> Filter</button>
                        </div>
                    </div>
                </div>
            </form><br />
            
            <div class="row">
                <form method="get" action="{{ route('studentResultDownload', $competitionId) }}">
                    @csrf
                    <input type="hidden" name="competitionId" value="{{ $competitionId }}">
                    <button type="submit" class="btn btn-primary"> Download Result</button>
                </form>
                
                </div>
            </div>
        @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <a href="{{ route('results-user.destroy', ['id'=>$competitionId]) }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('results-user.destroy', ['id'=>$competitionId]) }}" method="post">
                                @csrf
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-header-form form-inline">
                                <form action="{{ route('userresults.search') }}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search by user name"
                                            value="{{ $_GET['search'] ?? '' }}">
                                        <input type="hidden" name="competitionId" value="{{ $competitionId }}">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                            <th>Action</th>
                                            <th>User Name</th>
                                            <th>DOB</th>
                                            <th>Category</th>
                                            <th>Total Marks</th>
                                            <th>Prize</th>
                                            <th>Instructor</th>
                                            <th>Learning Location</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($userList->count())
                                        @foreach ($userList as $key => $item)
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            
                                            <td>
                                              <a href="{{ route('results-user.edit', $item->id) }}"
                                                class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                                data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->user->dob }}</td>
                                            <td>{{ $item->category->category_name }}</td>
                                            <td>{{ $item->total_marks }}</td>
                                            <td>{{ $item->prize }}</td>
                                            <td>{{ getInstructor($item->user->instructor_id)->name }}</td>
                                            <td>{{ getLearningLocation($item->user->learning_locations)->title ?? '' }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $userList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
