@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('template.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_template_crud', 'Create', route('template.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('template.store') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" class="form-control">
                                    @if ($errors->has('image'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="announcement_date">Date</label>
                                    <input type="text" name="announcement_date" class="form-control" id=""
                                        value="{{ old('announcement_date') }}">
                                    @if ($errors->has('announcement_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('announcement_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="function">Function</label>
                                    <textarea name="function" class="form-control" id="">{{ old('function') }}</textarea>
                                    @if ($errors->has('function'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('function') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="teacher_id">Teacher</label>
                                    <select name="teacher_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($instructors)
                                        @foreach ($instructors as $item)
                                        <option value="{{ $item->id }}" @if(old('teacher_id')==$item->id)
                                            selected
                                            @endif>{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('teacher_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('teacher_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Submit</button>
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
