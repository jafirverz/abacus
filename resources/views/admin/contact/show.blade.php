@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('contact.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_contact_crud', 'Show',
            route('contact.show', $contact->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label for="inputEmail3" class=" col-sm-2  col-form-label">Name</label>
                                <div class=" col-sm-10  ">
                                    <p>{{ $contact->full_name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label for="inputEmail3" class=" col-sm-2  col-form-label">Email Address</label>
                                <div class=" col-sm-10  ">
                                    <p>{{$contact->email_id}}</p>
                                </div>
                            </div>

                            
                            <div class="row">
                                <label for="inputEmail3" class=" col-sm-2  col-form-label">Contact number</label>
                                <div class=" col-sm-10  ">
                                    <p>{{ $contact->country_code.$contact->contact_number }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label for="inputEmail3" class=" col-sm-2  col-form-label">Message</label>
                                <div class=" col-sm-10  ">
                                    <p>{{ $contact->message }}</p>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <label for="inputEmail3" class=" col-sm-2  col-form-label">Submission Date</label>
                                <div class=" col-sm-10  ">
                                    <p>{{ $contact->created_at->format('d M, Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label for="inputEmail3" class=" col-sm-2  col-form-label">Updated At</label>
                                <div class=" col-sm-10  ">
                                    <p>{{ $contact->updated_at->format('d M, Y h:i A') }}</p>
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