@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('grading-paper.index') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('grading_paper_crud', 'Show',
            route('grading-paper.show', $paper->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="">Title</label>
                                <input readonly="readonly" type="text" name="title" class="form-control" value="{{ old('title', $paper->title) }}">

                            </div>



                            <div class="form-group">
                                <label for="question_type">Type</label>
                                <select disabled="disabled"  id="question_type" class="form-control"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    <option value="">-- Select --</option>
                                    @if ($templates)
                                    @foreach ($templates as $item)
                                    <option value="<?php echo url('/'); ?>/admin/grading-paper/{{ $paper->id }}/edit?question-type={{ $item->id }}" @if(old('question_type', $paper->question_type)==$item->id) selected @endif> {{ $item->title }} </option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>

                            @if($paper->question_type==4 || $paper->question_type==5)
                                <label for="" class=" control-label">{{ getQuestionTemplate($paper->question_type) }}</label>
                                @php
                                    $json_question=json_decode($paper->json_question);
                                    for($i=0;$i<count($json_question->input_1);$i++)
                                    {

                                @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-4">
                                                <input readonly="readonly" class="form-control" required value="{{ $json_question->input_1[$i] }}" name="input_1[]" placeholder="Number 1" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <input readonly="readonly" class="form-control" required value="{{ $json_question->input_2[$i] }}" name="input_2[]" placeholder="Number 2" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <input readonly="readonly" class="form-control" required value="{{ $json_question->input_3[$i] }}" name="input_3[]" placeholder="= Answer" type="text">
                                            </div>
                                        </div>

                                    </div>
                                @php } @endphp


                                @elseif($paper->question_type==2)
                                <label for="" class=" control-label">{{ getQuestionTemplate($paper->question_type) }}</label>
                                @php
                                $json_question=json_decode($paper->json_question);
                                for($i=0;$i<count($json_question->input_1);$i++)
                                {

                                    @endphp

                                        <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-4">
                                                    <input readonly="readonly" class="form-control"  value="{{ $json_question->input_1[$i] }}" name="input_1_old[]" type="hidden">
                                                    <a href="{{ url('/') }}/upload-file/{{ $json_question->input_1[$i] }}" target="_blank"> {{ $json_question->input_1[$i] }} </a>
                                                </div>
                                                <div class="col-md-4">
                                                    <input readonly="readonly" class="form-control" required value="{{ $json_question->input_2[$i] }}" name="input_2[]" placeholder="Answer" type="text">
                                                </div>
                                            </div>

                                        </div>
                                    @php } @endphp

                                    @elseif($paper->question_type==4)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($paper->question_type) }}</label>
                                    @php
                                    $json_question=json_decode($paper->json_question);
                                    for($i=0;$i<count($json_question->input_1);$i++)
                                    {

                                        @endphp

                                            <div class="form-group">
                                                <div class="row" style="margin-bottom:30px;">
                                                    <div class="col-md-4">
                                                        <textarea readonly rows="5" cols="40">{{ $json_question->input_1[$i] }}</textarea>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <input readonly="readonly" class="form-control" required value="{{ $json_question->input_2[$i] }}" name="input_2[]" placeholder="Answer" type="text">
                                                    </div>
                                                </div>

                                            </div>
                                        @php } @endphp

                                @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
