@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('pages.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_pages_crud', 'Create',
            route('pages.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('pages.store') }}" method="post">
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
                                <div class="form-group non-external">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" class="form-control" id="slug"
                                        value="{{ old('slug') }}">
                                    @if ($errors->has('slug'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="section-title">SEO Section</div>
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" id=""
                                        value="{{ old('meta_title') }}">
                                    @if ($errors->has('meta_title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('meta_title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" class="form-control " id="" cols="30"
                                        rows="5">{!! old('meta_description') !!}</textarea>
                                    @if ($errors->has('meta_description'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('meta_description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta keywords</label>
                                    <textarea name="meta_keywords" class="form-control " id="" cols="30"
                                        rows="5">{!! old('meta_keywords') !!}</textarea>
                                    @if ($errors->has('meta_keywords'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('meta_keywords') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="parent">Parent</label>
                                    <select name="parent" class="form-control" id=""
                                        style="font-family: 'FontAwesome', 'Helvetica';">
                                        <option value="">-- Select --</option>
                                        <option value="0" @if(old('parent')==0) selected @endif>-- Root --</option>
                                        {!! getDropdownPageList($pages, old('parent'), $parent_id = 0) !!}
                                    </select>
                                    @if ($errors->has('parent'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox my-4">
                                        <input name="external_link" type="checkbox" class="custom-control-input"
                                            value="1" id="external_link" @if(old('external_link')==1) checked @endif>
                                        <label class="custom-control-label" for="external_link">External
                                            Link</label>

                                    </div>
                                    <div id="external_link_value"
                                        class=" external @if(old('external_link')==1) show @else hide @endif">
                                        @if(old('external_link')==1)
                                        <input class="form-control" value="{{ old('external_link_value') }}"
                                            name="external_link_value" type="text">
                                        @else
                                        <input class="form-control" value="" name="external_link_value" type="text">
                                        @endif
                                        <small class="text-muted">Eg: http://www.example.com</small>
                                    </div>
                                    @if ($errors->has('external_link_value'))
                                    <span class="text-danger help-block">
                                        <strong>{{ $errors->first('external_link_value') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="target">Target</label>
                                    <select name="target" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getLinkTarget())
                                        @foreach (getLinkTarget() as $key => $item)
                                        <option value="{{ $key }}" @if(old('target')==$key) selected
                                            @elseif($key=="_self" ) selected @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('target'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('target') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="form-group non-external">
                                    <label for="content">Content</label>
                                    <textarea name="content" class="form-control my-editor" id="" cols="30"
                                        rows="10">{!! old('content') !!}</textarea>
                                    @if ($errors->has('content'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group non-external">
                                    <label for="content">Instruction</label>
                                    <textarea name="instruction" class="form-control my-editor" id="" cols="30"
                                        rows="10">{!! old('instruction') !!}</textarea>
                                    @if ($errors->has('instruction'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('instruction') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="view_order">View Order</label>
                                    <input type="number" name="view_order" class="form-control" id=""
                                        value="{{ old('view_order', 0) }}" min="0">
                                    @if ($errors->has('view_order'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('view_order') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status')==$key) selected @elseif($key==1)
                                            selected @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
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
        // CREATE SLUG
        function slugify(text)
        {
        return text.toString().toLowerCase()
        .replace(/\s+/g, '-') // Replace spaces with -
        .replace(/[^\w\-]+/g, '') // Remove all non-word chars
        .replace(/\-\-+/g, '-') // Replace multiple - with single -
        .replace(/^-+/, '') // Trim - from start of text
        .replace(/-+$/, ''); // Trim - from end of text
        }
        if($("#external_link").is(":checked")) {
           $("#external_link_value").removeClass('d-none');
           $(".non-external").addClass('d-none');
           $("#slug").val('');
        }
		else
		{
			$("#external_link_value").addClass('d-none');
			$(".non-external").removeClass('d-none');
		}
        $("input[name='title']").on("change", function () {
            var title = slugify($(this).val());
            $("input[name='slug']").val(title);
            $("input[name='meta_title']").val($(this).val());
        });

        $('#external_link').change(function() {
        if($(this).is(":checked")) {
           $("#external_link_value").removeClass('d-none');
           $(".non-external").addClass('d-none');
           $("#slug").val('');
        }
		else
		{
			$("#external_link_value").addClass('d-none');
			$(".non-external").removeClass('d-none');
		}
              
    });
    });

</script>
@endsection