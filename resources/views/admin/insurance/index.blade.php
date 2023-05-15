@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            <div class="section-header-button">
                {{--<a href="{{ route('insurance.create') }}" class="btn btn-primary">Add New</a>--}}
            </div>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_insurance')])
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
						<form action="{{ route('insurance.search') }}" method="get">
            @csrf
            <div class="card-body">

                <div class="row">

                    <div class="col-lg-6">
                    <label>Name:</label><input type="text" name="main_driver_full_name" class="form-control"
                            id="main_driver_full_name" @if(isset($_GET['main_driver_full_name']) && $_GET['main_driver_full_name']!="" ) value="{{ $_GET['main_driver_full_name'] }}"
                            @endif> 
                    </div>
                    <div class="col-lg-6">
                        <label>Email</label>
                        <input type="text" name="main_driver_email" class="form-control"
                            id="main_driver_email" @if(isset($_GET['main_driver_email']) && $_GET['main_driver_email']!="" ) value="{{ $_GET['main_driver_email'] }}"
                            @endif> 
                    </div>

                </div>
                <div class="row">
                   <div class="col-lg-6">
                        <label>NRIC</label>
                        <input type="text" name="main_driver_nric" class="form-control"
                            id="main_driver_nric" @if(isset($_GET['main_driver_nric']) && $_GET['main_driver_nric']!="" ) value="{{ $_GET['main_driver_nric'] }}"
                            @endif> 
                    </div>
                    <div class="col-lg-6"><label>Status:</label>
                        <select name="status" class="form-control">
                            <option value="">-- Select --</option>
                            @if(getInsuranceStatus())
                            @foreach (getInsuranceStatus() as $key => $item)
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
        </form>
                    </div>
                   </div>
                </div>
            </div>
        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('insurance.destroy', 'insurance') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('insurance.destroy', 'insurance') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            
                            <a href="{{route('connect.docusign.insurance')}}" class="btn btn-warning ml-2">Connect Docusign</a>
                            
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
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Action</th>
                                            <th>S/N</th>
                                            <th>Driver name</th>
                                            <th>NRIC</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($insurance->count())

                                            @php
                                            if(request()->get('page') && request()->get('page')>=2)
                                            {
                                                $i=$insurance->perPage() * ($insurance->currentPage() - 1);
                                            }
                                            else
                                            {
                                                 $i=0;
                                            }
                                            @endphp

                                        @foreach ($insurance as $key => $item)
                                        @php  $i++;@endphp
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ ($key+1) }}" value="{{ $item->id }}"> <label for="checkbox-{{ ($key+1) }}" class="custom-control-label">&nbsp;</label></div>
                                            </td>
                                            <td>
                                                <a href="{{ route('insurance.show', $item->id) }}" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                                @if(($item->partner_id==NULL || $item->partner_id==Auth::user()->id) && Auth::user()->admin_role==__('constant.USER_PARTNER'))
                                                <a href="{{ route('insurance.edit', $item->id) }}" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                @endif
                                                
                                                @if(isset($item->insuracne_new_pdf) && !empty($item->insuracne_new_pdf))
                                                <a class="btn btn-light mr-1 mt-1" target="_blank" href="{{asset('insurance_form/'.$item->insuracne_new_pdf)}}"><i class="fas fa-file-download mr-1"></i></a>
                                               @endif
                                                
                                               @if(isset($item->insurance_pdf))
                                                <a class="btn btn-light mr-1 mt-1" target="_blank" href="{{asset('insurance_form/'.$item->insurance_pdf)}}"><i class="fas fa-file-download mr-1"></i></a>
                                               @endif
                                            </td>
                                            <td>{{ $i }}</td>
                                            <td>{{ $item->main_driver_full_name }}</td>
                                            <td>{{ $item->main_driver_nric }}</td>
                                            <td>{{ $item->main_driver_email }}</td>
                                            <td>@if($item->status==1) Completed @elseif($item->status==2) Processing @else - @endif</td>
                                            <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                        @if(request()->get('_token'))
                            {{ $insurance->appends(['_token' => request()->get('_token'),'main_driver_full_name' => request()->get('main_driver_full_name'),'main_driver_email' => request()->get('main_driver_email'),'main_driver_nric' => request()->get('main_driver_nric'),'status' => request()->get('status') ])->links() }}
                        @else
                            {{ $insurance->links() }}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
