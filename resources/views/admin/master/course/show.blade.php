@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('course.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
           @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('course_crud', 'Show',
            route('course.show', $course->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Level</label>: {{ $course->level->title ?? '' }}
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>: {{ $course->title ?? '' }}
                            </div>

                            <div class="form-group">
                                <label for="title">Content</label>: {{ $course->content ?? '' }}
                            </div>

                            <div class="form-group">
                                <label for="title">Paper</label>: {{ $course->paper->title ?? '' }}
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>: {{ getActiveStatus($course->status) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
