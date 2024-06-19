@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('worksheet.create') }}" class="btn btn-primary">Add New</a>
            </div>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank')])--}}

        </div>
        <br />

        <div class="section-body">
            @include('admin.inc.messages')

            <form action="{{ route('worksheet.search') }}" method="get" id="formreport">
                @csrf
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-4"><label>Question Template:</label>
                            <select name="qId" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($questionTemplate as $questionT)
                                <option value="{{ $questionT->id }}" @if(isset($_REQUEST['qId']) && $_REQUEST['qId']==$questionT->id) selected="selected"
                                    @endif>{{$questionT->title}}</option>
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
                <div class="col-12">
                    <div class="card">

                        

                        <div class="card-header">
                            <a href="{{ route('worksheet.destroy', 'worksheet') }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('worksheet.destroy', 'worksheet') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-header-form form-inline">
                                <form action="{{ route('worksheet.search') }}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search"
                                            value="{{ $_GET['search'] ?? '' }}">
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
                                            <th>Title</th>
                                            <th>Level Allocated</th>
                                            <th>Question Template</th>
                                            <th>Free/Premium</th>
                                            <th>Status</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($worksheet->count())
                                        @foreach ($worksheet as $key => $item)
                                        @php 
                                        $levelId = $item->leveTopic->pluck('level_id')->toArray();
                                        $levels = \App\Level::whereIn('id', $levelId)->pluck('title')->toArray();
                                        $worksheetSubmit = \App\WorksheetSubmitted::where('worksheet_id', $item->id)->first();
                                        @endphp
                                        
                                        <tr>
                                            @if(!$worksheetSubmit)
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            @else
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> </div>
                                            </td>
                                            @endif
                                            <td>
                                                <a href="{{ route('worksheet.show', $item->id) }}"
                                                    class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="View"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('worksheet.edit', $item->id) }}"
                                                    class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('worksheet.questions', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="List"><i class="fas fa-bars"></i></a>
                                            </td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ implode(', ', $levels) }}</td>
                                            <td>{{ $item->questionsTemp->title ?? '' }}</td>
                                            <td>@if($item->type == 1) Free @else Premium @endif</td>
                                            <td>
                                                @if(getActiveStatus())
                                                <div class="badge @if ($item->status==1) badge-success @else badge-danger @endif">{{ getActiveStatus($item->status) }}</div>
                                                @endif
                                            </td>
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
                            {{ $worksheet->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
