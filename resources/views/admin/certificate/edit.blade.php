@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">

                <a href="{{ route('certificate.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
           

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('certificate.update', $certificate->id) }}" method="post">

                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="" value="{{ old('title', $certificate->title) }}">

                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Subject</label>
                                    <input type="text" name="subject" class="form-control" id=""
                                        value="{{ old('subject', $certificate->subject) }}">
                                    @if ($errors->has('subject'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Content</label>
                                    <textarea name="content" class="form-control my-editor">{{ old('content', $certificate->content) }}</textarea>
                                    @if ($errors->has('content'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="grade_type_id">Certificate Type</label>
                                    <select name="certificate_type" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="survey" @if((old('certificate_type', $certificate->certification_type)) == 'survey') selected @endif >Survey</option>
                                        <option value="elementary_level" @if((old('certificate_type', $certificate->certification_type)) == 'elementary_level') selected @endif>Elementary Level</option>
                                        <option value="online_competition" @if((old('certificate_type', $certificate->certification_type)) == 'online_competition') selected @endif>Online Competition</option>
                                        <option value="grading_examination" @if((old('certificate_type', $certificate->certification_type)) == 'grading_examination') selected @endif>Grading Examination</option>
                                    </select>
                                    @if ($errors->has('certificate_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('certificate_type') }}</strong>

                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="grade_type_id">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if((old('status', $certificate->status)) == 1) selected @endif>Active</option>
                                        <option value="0" @if((old('status', $certificate->status)) == 0) selected @endif>In Active</option>
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>

                                    </span>
                                    @endif
                                </div>


                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $("input[name='title']").on("change", function () {
            var title = slugify($(this).val());
            $("input[name='slug']").val(title);
        });
    });

</script>
@endsection
