@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
          <div class="section-header-back">
            <a href="{{ route('grading-paper.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
            <h1>{{ $title ?? '-' }}</h1>
            @if($questemplate==7 || count($competitionPaper) <= 0)
            <div class="section-header-button">
                <a href="{{ route('grading-paper.questions.create', ['pId'=> $pId, 'qId' => $questemplate]) }}" class="btn btn-primary">Add New</a>
            </div>
            @endif
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank')])--}}

        </div>
        <br />

        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <a href="{{ route('grade-questions.destroy', 'comp-questions') }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('grade-questions.destroy', 'comp-questions') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <!-- <div class="card-header-form form-inline">
                                <form action="{{ route('grade-questions.search') }}" method="get">
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
                            </div> -->
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
                                            <th>Action</th>
                                            <th>Title</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($competitionPaper->count())
                                        @foreach ($competitionPaper as $key => $item)
                                        <tr>
                                            <!-- <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox"
                                                        data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label
                                                        for="checkbox-{{ ($key+1) }}"
                                                        class="custom-control-label">&nbsp;</label></div>
                                            </td> -->
                                            <td>

                                                @php
                                                $checkPaper = \App\GradingSubmitted::where('paper_id', $pId)->first();
                                                if($questemplate==7)
                                                {
                                                  $template='?template='.$item->template.'&paper_detail_id='.$item->paper_detail_id;
                                                }
                                                else
                                                {
                                                  $template='';
                                                }
                                                @endphp
                                                <a href="{{ route('grading-paper.question.show', ['pId'=> $pId, 'qId' => $questemplate]).$template }}"
                                                    class="btn btn-info mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="View"><i class="fas fa-eye"></i></a>
                                                @if(!$checkPaper)
                                                <a href="{{ route('grading-paper.question.edit', ['pId'=> $pId, 'qId' => $questemplate]).$template }}"
                                                    class="btn btn-light mr-1 mt-1" data-toggle="tooltip"
                                                    data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                @endif
                                            </td>

                                            <td>{{ $item->ques_template->title }}</td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
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
                            {{ $competitionPaper->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
