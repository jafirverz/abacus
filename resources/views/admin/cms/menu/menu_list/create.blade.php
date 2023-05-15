@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('menu-list.index', $menu) }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_menu_list_crud', $menu,
            'Create', route('menu.create', $menu))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('menu-list.store', $menu) }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="page_id">Page</label>
                                    <select name="page_id" class="form-control" id="page_id" @if(old('new_tab')==1)
                                        disabled="disabled" @endif>
                                        <option value="">-- Select --</option>
                                        @if($pages->count())
                                        @foreach ($pages as $item)
                                        <option value="{{ $item->id }}" @if(old('page_id')==$item->id) selected
                                            @endif>{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('page_id'))
                                    <span class="text-danger help-block">
                                        <strong>{{ $errors->first('page_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                {{-- <div class="form-group">
                                    <div class="section-title">Open in New Tab</div>
                                    <div class="custom-control custom-checkbox my-4">
                                        <input name="new_tab" type="checkbox" class="custom-control-input" value="1"
                                            id="customCheck1" @if(old('new_tab')==1) checked @endif>
                                        <label class="custom-control-label" for="customCheck1"> Open External
                                            Link</label>

                                    </div>
                                    <div id="external_link" class="@if(old('new_tab')==1) show @else hide @endif">
                                        @if(old('new_tab')==1)
                                        <input class="form-control" value="{{ old('external_link') }}"
                                            name="external_link" type="text">
                                        @else
                                        <input class="form-control" value="" name="external_link" type="text">
                                        @endif
                                        <small class="text-muted">eg: http://example.com</small>
                                    </div>
                                    @if ($errors->has('external_link'))
                                    <span class="text-danger help-block">
                                        <strong>{{ $errors->first('external_link') }}</strong>
                                    </span>
                                    @endif
                                </div> --}}
                                <div class="form-group">
                                    <label for="view_order">View Order</label>
                                    <input type="number" name="view_order" class="form-control" id=""
                                        value="{{ old('view_order', 0) }}" min="0">
                                    @if ($errors->has('view_order'))
                                    <span class="text-danger help-block">
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
                                        <option value="{{ $key }}" @if(old('status')==$key) selected @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger help-block">
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
    $(document).ready(function() {
    //set initial state.

    $('#customCheck1').change(function() {
        if($(this).is(":checked")) {
           $("#external_link").removeClass('hide');
           $("option:selected").removeAttr("selected").trigger('change');
           $("option:selected").prop("selected", false).trigger('change');
		   $("#page_id").prop("disabled", true);
        }
		else
		{
			$("#external_link").removeClass('show');
			$("#external_link").addClass('hide');
			$("#page_id").prop("disabled", false);
		}
              
    });
});
</script>
@endsection