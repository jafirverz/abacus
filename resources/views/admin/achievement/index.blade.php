@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">

                <a href="{{ route('achievement.create') }}" class="btn btn-primary">Add New</a>
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_achievement')])


        </div>
        <br />

        <div class="section-body">
            @include('admin.inc.messages')

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        {{-- <div class="card-header">


                            <div class="card-header-form form-inline">

                                <form action="{{ route('achievement.search') }}" method="get">

                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search" value="{{ $_GET['search'] ?? '' }}">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                        &emsp;
                                            @if(request()->get('_token'))
                                               <a href="{{ url()->current() }}" class="btn btn-primary">Clear All</a>
                                            @else
                                               <button type="reset" class="btn btn-primary">Clear All</button>
                                            @endif
                                    </div>
                                </form>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>

                                        <th>Action</th>
                                        <th>Student Name</th>
                                        <th>Instructor Name</th>
                                        <th>Learning Location</th>
                                        <th>DOB</th>
                                        <th>Year</th>
                                        <th>Events</th>
                                        <th>Results</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($achievements) && count($achievements)>0)
                                        @foreach($achievements as $key => $paperSubmited)
                                        <tr>

                                            <td>

                                                <a href="{{ route('achievement.edit2', [$paperSubmited->id]) }}"
                                                    class="btn btn-info mr-1 mt-1"  data-toggle="tooltip"
                                                    data-original-title="Edit">
                                                    <i aria-hidden="true" class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('achievement.delete2', [$paperSubmited->id]) }}"
                                                    class="btn btn-info mr-1 mt-1"  data-toggle="tooltip"
                                                    data-original-title="Edit" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i aria-hidden="true" class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        <td>{{ $paperSubmited->user->name ?? '' }}</td>
                                        <td>{{ getInstructor($paperSubmited->user->instructor_id)->name ?? '' }}</td>
                                        <td>{{ getLearningLocation($paperSubmited->user->learning_locations)->name ?? '' }}</td>
                                        <td>{{ $paperSubmited->user->dob ?? '' }}</td>
                                        <td>{{ $paperSubmited->competition_date ?? '' }}</td>
                                        <td>{{ $paperSubmited->title ?? '' }}</td>
                                        <td>{{ $paperSubmited->result ?? '' }}</td>

                                        </tr>
                                        @endforeach
                                        @endif


                                    </tbody>
                                    </table>


                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $achievements->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
