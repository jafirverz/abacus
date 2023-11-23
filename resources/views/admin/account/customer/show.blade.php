@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('customer-account.index') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('customer_account_crud', 'Show',
            route('customer-account.show', $customer->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Account ID</label>: {{ $customer->account_id ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>: {{ $customer->name ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>: {{ $customer->email ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Date Of Birth</label>: {{ $customer->dob ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>: {{ $customer->mobile ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Gender</label>:
                                @if($customer->gender=='1') Male
                                @elseif($customer->gender == '2') Female
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Address</label>: {{ $customer->address ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Country</label>: {{ getCountry($customer->country_code) ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Instructor</label>: {{ $instructors->name ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">Levels Allocated</label>:
                                <?php $level_id= json_decode($customer->level_id);
                                if(isset($level_id))
                                {
                                    foreach($level_id as $id)
                                    {
                                    $item = \App\Level::where('id', $id)->first();
                                    echo $item->title.'<br>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="">Learning Location</label>: {{ $customer->location->title ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="">User Type</label>: {{ getUserTypes($customer->user_type_id) ?? ''  }}
                            </div>
                            <div class="form-group">
                                <label for="">Created At</label>: {{ $customer->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <label for="">Updated At</label>: {{ $customer->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
        <div class="section-header">

            <h1>Acheivements</h1>

        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <table class="tb-1">
                        <thead>
                            <tr>
                            <th>&nbsp;</th>
                            <th>Year</th>
                            <th>Events</th>
                            <th>Results</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($merged) && count($merged)>0)
                            @foreach($merged as $paperSubmited)
                            <tr>
                            <td class="tbico-1"><img src="images/tempt/ico-award.png" alt="awrad" /></td>
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

                        @if(isset($merged) && count($merged)>0)
                        <ul class="page-numbers mt-30">
                        {{ $merged->links() ?? '' }}
                        </ul>
                        @endif
                    </div>


                </div>


            </div>
        </div>

    </section>
</div>
@endsection
