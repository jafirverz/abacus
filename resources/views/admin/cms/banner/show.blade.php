@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('banner.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_banner_crud', 'Show',
            route('banner.show', $banner->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="page_id">Page</label>
                                <select name="page_id" class="form-control" id=""
                                    style="font-family: 'FontAwesome', 'Helvetica';">
                                    <option value="">-- Select --</option>
                                    {!! getDropdownPageList($pages, $banner->page_id, $parent_id = 0) !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="section-title">Banner Image</div>
                                @if(isset($banner->banner_image))
                                <div class="d-block">
                                    <a href="{{ asset($banner->banner_image) }}" target="_blank"><img
                                            src="{{ asset($banner->banner_image) }}" alt="" width="200px"></a>
                                </div>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="">-- Select --</option>
                                    @if(getActiveStatus())
                                    @foreach (getActiveStatus() as $key => $item)
                                    <option value="{{ $key }}" @if($banner->status==$key) selected @elseif($key==1)
                                        selected
                                        @endif>{{ $item }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("input, textarea, select").attr("disabled", true);
    });
</script>
@endsection