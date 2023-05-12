@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                <a href="{{ route('pages.create') }}" class="btn btn-primary">Add New</a>
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_pages')])

        </div>
        <form action="{{ route('pages.search') }}" method="get">
            @csrf
            <div class="section-body">

                <div class="row">

                    <div class="col-lg-6"><label>Title:</label><input type="text" name="title" class="form-control"
                            id="title" @if(isset($_GET['title']) && $_GET['title']!="" ) value="{{ $_GET['title'] }}"
                            @endif> </div>
                    <div class="col-lg-6">
                        <label>Parent Page</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="0">-- Root --</option>
                            @foreach (getParentPages() as $key => $value)
                            <option @if(isset($_GET['parent_id']) && $_GET['parent_id']==$value->id) selected="selected"
                                @endif value="{{$value->id}}">{{$value->title}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6"><label>Status:</label>
                        <select name="status" class="form-control">
                            <option value="">-- Select --</option>
                            @if(getActiveStatus())
                            @foreach (getActiveStatus() as $key => $item)
                            <option value="{{ $key }}" @if(request()->get('status')==$key) selected @endif>{{ $item }}
                            </option>
                            @endforeach
                            @endif

                        </select>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary"> Search</button>&nbsp;&nbsp;
                        @if(request()->get('_token'))
                        <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                        @else
                        <button type="reset" class="btn btn-primary">Clear All</button>
                        @endif

                    </div>
                </div>


            </div>
        </form><br />

        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <a href="{{ route('pages.destroy', 'pages') }}" class="btn btn-danger d-none destroy"
                                data-confirm="Do you want to continue?"
                                data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();"
                                data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span
                                    class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('pages.destroy', 'pages') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>S/N</th>
                                            <th>Action</th>
                                            <th>Title</th>
                                            <th>View Order</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //Nikunj session created for page listing
                                        session(['page_key' => []]);
                                        if(isset($_GET['parent_id']) && $_GET['parent_id']!=""){
                                        $parent_id=[$_GET['parent_id']];
                                        }else{
                                            $parentIds = $pages->sortBy('parent')->pluck('parent')->unique()->values()->all();
                                            $parent_id = [0];
                                            if(count($parentIds)){
                                                $parent_id = $parentIds;
                                            }
                                        }
                                        ?>
                                        @if($pages->count())
                                        {!! getPageList($pages, $parent_id) !!}
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                        <?php  Session::forget('page_key');  ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php /*?>@if(request()->get('_token'))
                            {{ $pages->appends(['_token' => request()->get('_token'),'title' => request()->get('title'),'parent_id' => request()->get('parent_id'),'status' => request()->get('status') ])->links() }}
                            @else
                            {{ $pages->links() }}
                            @endif<?php */?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection