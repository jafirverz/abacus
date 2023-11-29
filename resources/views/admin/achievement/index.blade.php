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
                                        <th>Year</th>
                                        <th>Events</th>
                                        <th>Results</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($achievements) && count($achievements)>0)
                                        @foreach($achievements as $key => $paperSubmited)

                                            @if(isset($paperSubmited->grading_id))
                                                @php $type=1; @endphp
                                            @else
                                                @php $type=2; @endphp
                                            @endif
                                        <tr>

                                            <td>

                                                <a href="{{ route('achievement.edit2', [$paperSubmited->id,$type]) }}"
                                                    class="btn btn-info mr-1 mt-1"  data-toggle="tooltip"
                                                    data-original-title="Edit">
                                                    <i aria-hidden="true" class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('achievement.delete2', [$paperSubmited->id,$type]) }}"
                                                    class="btn btn-info mr-1 mt-1"  data-toggle="tooltip"
                                                    data-original-title="Edit" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i aria-hidden="true" class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        <td><strong class="type-1">@if(isset($paperSubmited->grading_id)) {{ $paperSubmited->grading->exam_date }} @else {{ $paperSubmited->competition->date_of_competition }} @endif

                                        </strong></td>
                                        <td>@if(isset($paperSubmited->grading_id)) {{ $paperSubmited->grading->title }} @else {{ $paperSubmited->competition->title }} @endif</td>
                                        <td>
                                            @if(isset($paperSubmited->grading_id))
                                            @if(!empty($paperSubmited->abacus_grade && $paperSubmited->mental_grade))
                                            Mental Grade 70:  <strong class="type-1">{{ $paperSubmited->mental_grade }}</strong><br/>
                                            Abacus Grade 80:  <strong class="type-1">{{ $paperSubmited->abacus_grade }}</strong></td>
                                            @endif
                                            @else
                                            {{ $paperSubmited->category->category_name }} : {{ $paperSubmited->rank ?? '' }}
                                            @if(!empty($paperSubmited->abacus_grade && $paperSubmited->mental_grade))
                                            Mental Grade 70:  <strong class="type-1">{{ $paperSubmited->mental_grade }}</strong><br/>
                                            Abacus Grade 80:  <strong class="type-1">{{ $paperSubmited->abacus_grade }}</strong></td>
                                            @endif
                                            @endif

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
