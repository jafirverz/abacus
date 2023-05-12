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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_pages_crud', 'Edit',
            route('pages.edit', $page->id))])
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('pages.update', $page->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group ">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title', $page->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group non-external">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" class="form-control" id=""
                                        value="{{ old('slug', $page->slug) }}">
                                    @if ($errors->has('slug'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="section-title">SEO Section</div>
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" id="" value="{{ old('meta_title', $page->meta_title) }}">
                                    @if ($errors->has('meta_title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('meta_title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" class="form-control " id="" cols="30"
                                        rows="5">{!! old('meta_description', $page->meta_description) !!}</textarea>
                                    
                                    @if ($errors->has('meta_description'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('meta_description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta keywords</label>
                                    <textarea name="meta_keywords" class="form-control " id="" cols="30"
                                        rows="5">{!! old('meta_keywords', $page->meta_keywords) !!}</textarea>
                                    
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
                                        <option value="0" @if($page->parent==0) selected @endif>-- Root --</option>
                                        {!! getDropdownPageList($pages, old('parent', $page->parent), $parent_id = 0)
                                        !!}
                                    </select>
                                    @if ($errors->has('parent'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if(!in_array($page->id,[ __('constant.HOME_PAGE_ID'), __('constant.ABOUT_PAGE_ID')]))
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox my-4">
                                        <input name="external_link" type="checkbox" class="custom-control-input"
                                            value="1" id="external_link" @if((!count(old()) &&
                                            ($page->external_link==0)) || (count(old()) &&
                                        is_null(old('external_link')) )) ggrgrg @elseif( (count(old()) &&
                                        !is_null(old('external_link'))) || $page->external_link==1)
                                        checked @endif>
                                        <label class="custom-control-label" for="external_link">External
                                            Link</label>

                                    </div>
                                    <div id="external_link_value" class=" external">
                                        <input class="form-control"
                                            value="{{ old('external_link_value',$page->external_link_value) }}"
                                            name="external_link_value" type="text">

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
                                        <option value="{{ $key }}" @if(old('target',$page->target)==$key) selected
                                            @endif>{{ $item }}
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

                                <?php /*?><div class="form-group non-external">
                                    <div class="section-title">Content Details</div>
                                    <label for="header">Header</label>
                                    <input type="text" name="header" class="form-control" id=""
                                        value="{{ old("header",$page->header) }}">
                                    @if ($errors->has('header'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('header') }}</strong>
                                    </span>
                                    @endif
                                </div><?php */?>
                                
                                @endif
								<div class="form-group non-external">
                                    <label for="content">Content</label>
                                    <textarea name="content" class="form-control my-editor" id="" cols="30"
                                        rows="10">{!! old('content', $page->content) !!}</textarea>
                                    @if ($errors->has('content'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{-- Start fix content section  --}}

                                @if(in_array($page->id,[ __('constant.HOME_PAGE_ID')]))
                                @include('admin.cms.pages.inc.home')
                                @elseif(in_array($page->id,[ __('constant.ABOUT_PAGE_ID')]))
                                @include('admin.cms.pages.inc.about')
                                @elseif(in_array($page->id,[ __('constant.INSURANCE_PAGE_ID')]))
                                @include('admin.cms.pages.inc.insurance')
                                @elseif(in_array($page->id,[ __('constant.LOAN_PAGE_ID')]))
                                @include('admin.cms.pages.inc.loan')
                                @endif
                                

                               {{--  End fix content Section --}}

                                <div class="form-group">
                                    <label for="view_order">View Order</label>
                                    <input type="number" name="view_order" class="form-control" id=""
                                        value="{{ old('view_order', $page->view_order) }}" min="0"
                                        @if(in_array($page->id,[ __('constant.HOME_PAGE_ID'),
                                    __('constant.ABOUT_PAGE_ID')]))
                                    readonly="readonly" @endif>
                                    @if ($errors->has('view_order'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('view_order') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="" @if(in_array($page->id,[
                                        __('constant.HOME_PAGE_ID'),__('constant.ABOUT_PAGE_ID')])) disabled="disabled" @endif>
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status', $page->status)==$key) selected
                                            @elseif($key==1) selected
                                            @endif>{{ $item }}
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
    other_content(<?=$page->id?>);
    $(document).ready(function () {
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
    
	function other_content(id)
	{
	 	if(id==3)
		{
			$('#content_1').css('display','block');	
			$('#content_2').css('display','block');	
		}	
    }
    
</script>
@endsection