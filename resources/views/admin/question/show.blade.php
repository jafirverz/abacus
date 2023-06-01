@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('question.index') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('question_crud', 'Show',
            route('question.show', $question->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="">Title</label>
                                <input readonly="readonly" type="text" name="title" class="form-control" value="{{ old('title', $question->title) }}">

                            </div>

                            <div class="form-group">
                                <label for="worksheet">Worksheet</label>
                                <select disabled="disabled"  id="worksheet_id" class="form-control"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    <option value="">-- Select --</option>
                                    @if ($worksheets)
                                    @foreach ($worksheets as $item)
                                    <option value="<?php echo url('/'); ?>/admin/question/{{ $question->id }}/edit?question-type={{ $item->question_type }}" @if(old('worksheet_id', $question->worksheet_id)==$item->id) selected @endif> {{ $item->title }} </option>
                                    @endforeach
                                    @endif
                                </select>


                            </div>
                            @if($question->question_type==1)
                                <label for="" class=" control-label">{{ getQuestionTemplate($question->question_type) }}</label>
                                @php
                                    $json_question=json_decode($question->json_question);
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


                                @elseif($question->question_type==2)
                                <label for="" class=" control-label">{{ getQuestionTemplate($question->question_type) }}</label>
                                @php
                                $json_question=json_decode($question->json_question);
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

                                    @elseif($question->question_type==4)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($question->question_type) }}</label>
                                    @php
                                    $json_question=json_decode($question->json_question);
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
