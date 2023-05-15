@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('filter.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_filter_crud', 'Edit', route('filter.edit', $filter->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('filter.update', $filter->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select disabled="disabled" name="type" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getFilterType())
                                        @foreach (getFilterType() as $key => $item)
                                        <option value="{{ $key }}" @if(old('type', $filter->type)==$key) selected @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                   </div>
                                   <div class="form-group" id="make_list">
                                    @if(old('type',$filter->type) && old('type',$filter->type)==6)
                                    <label for="type">Type</label>
                                    <select class='form-control' name='make_val'>
                                        @foreach(getFilterValByType(5) as $key => $val)
                                        <option value='{{ $val->title }}'>{{ $val->title }}</option>
                                        @endforeach;
                                    </select>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="" value="{{ old('title', $filter->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                   @if(in_array($filter->type,[1,2,7,8]))
                                    <div class="form-group">
                                        <label for="from_value">From Value</label>
                                        <input type="text" name="from_value" class="form-control" id=""
                                            value="{{ old('from_value', $filter->from_value) }}">
                                        @if ($errors->has('from_value'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('from_value') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="to_value">To Value</label>
                                        <input type="text" name="to_value" class="form-control" id=""
                                            value="{{ old('to_value', $filter->to_value) }}">
                                        @if ($errors->has('to_value'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('to_value') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                  @endif
                                    @if($filter->type==4)
                                        <div class="form-group">
                                            <label for="content">Content</label>
                                            <textarea name="content" class="form-control">{{ old('content',$filter->content) }}</textarea>
                                            @if ($errors->has('content'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    @endif
                                <div class="form-group">
                                    <label for="view_order">View Order</label>
                                    <input type="number" name="view_order" class="form-control" id="" value="{{ old('view_order', $filter->view_order) }}" min="0">
                                    @if ($errors->has('view_order'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('view_order') }}</strong>
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
    $('select[name=type]').change(function() {
        var val=this.value;
        if(this.value==1 || this.value==2 || this.value==7 || this.value==8)
        {
            $(".range").removeClass("d-none");
        }
        else
        {
            $(".range").addClass("d-none");
            if(this.value==6)
            {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var res=$(this);
                    $.ajax({
                        method: 'post',
                        url: '{{ url("admin/filter/get-make") }}',
                        data: {
                            make: val
                        },
                        cache: false,
                        async: true,
                        success: function(data){
                            $("#make_list").html(data);
                        }
                    });
            }
            else
            {
                            $("#make_list").html('');
            }
        }
    });
    });
</script>
<style>
    .d-none{display:none;}
</style>
@endsection
