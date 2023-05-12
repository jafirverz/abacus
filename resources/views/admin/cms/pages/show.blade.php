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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_pages_crud', 'Show',
            route('pages.show', $page->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $page->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Slug</strong>: {{ $page->slug }}
                                </div>
                                <div class="form-group">
                                    <strong>Parent</strong>: {!! getChildPage($pages, $page->id) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Content</strong>: {!! $page->content !!}
                                </div>
                                @if(in_array($page->id,[ __('constant.HOME_PAGE_ID')]))
                                <?php
									$content = [];
									if($page->json_content){
										$content = json_decode($page->json_content, true);
									}
								   
								?>
                                <div class="form-group">
                                    <strong>Marketplace Title</strong>: {{ $content['marketplace_title'] ?? '' }}
                                </div>
                                <div class="form-group">
                                    <strong>Marketplace Link</strong>: {{ $content['marketplace_link'] ?? '' }}
                                </div>
                                <div class="form-group">
                                    <strong>Marketplace Content</strong>: {{ $content['marketplace_content'] ?? '' }}
                                </div>
                                @endif
                                <div class="form-group">
                                    <strong>View Order</strong>: {{ $page->view_order }}
                                </div>
                                <div class="form-group">
                                    <strong>New Tab</strong>: @if($page->new_tab==1) Yes @else No @endif
                                </div>
                                <div class="form-group">
                                    <strong>Status</strong>: {{ getActiveStatus($page->status) }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $page->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $page->updated_at->format('d M, Y h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
