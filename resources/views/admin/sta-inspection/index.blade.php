@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            {{-- <div class="section-header-button">
                <a href="{{ route('sta-inspection.create') }}" class="btn btn-primary">Add New</a>
            </div> --}}
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_sta_inspection')])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('sta-inspection.destroy', 'partner') }}" class="btn btn-danger d-none destroy" data-confirm="Do you want to continue?" data-confirm-yes="event.preventDefault();document.getElementById('destroy').submit();" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> <span class="badge badge-transparent">0</span></a>
                            <form id="destroy" action="{{ route('sta-inspection.destroy', 'partner') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="multiple_delete">
                            </form>
                            <h4></h4>
                            <div class="card-header-form form-inline">
                                <form action="{{ route('sta-inspection.search') }}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="daterange" class="form-control" placeholder="Search by sta inspection date" value="{{ $_GET['search'] ?? '' }}">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                         &emsp;
                                            @if(request()->get('_token'))
                                               <a href="{{ url()->current() }}" class="btn btn-primary">Clear</a>
                                            @else
                                               <button type="reset" class="btn btn-primary">Clear</button>
                                            @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>S/N</th>
                                            <th>Vehicle Number</th>
                                            <th>Make / Model</th>
                                            <th>Buyer Name</th>
                                            <th>Seller Name</th>
                                            <th>STA Inspection<br />Date</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($chat->count())

                                            @php
                                            if(request()->get('page') && request()->get('page')>=2)
                                            {
                                                $i=$chat->perPage() * ($chat->currentPage() - 1);
                                            }
                                            else
                                            {
                                                 $i=0;
                                            }
                                            @endphp

                                        @foreach ($chat as $key => $item)
                                        @php  $i++;@endphp
                                        <tr>

                                            <td>
                                                @if($item->approved_by_admin==2 || $item->approved_by_admin==NULL)
                                                <a href="{{ url('admin/sta-inspection/change-status/'.$item->id.'/1') }}"  data-toggle="tooltip" data-original-title="Accept"><div class="badge badge-success">Accept</div></a>
                                                @endif
                                                @if($item->approved_by_admin==1 || $item->approved_by_admin==NULL)
                                                <a href="{{ url('admin/sta-inspection/change-status/'.$item->id.'/2') }}"  data-toggle="tooltip" data-original-title="Reject"><div class="badge badge-danger">Reject</div></a>
                                                @endif
                                            </td>
                                            <td>{{ $i }}</td>
                                            <td>{{ $item->vehicle_detail->vehicle_number ?? '' }}</td>
                                            <td>{{ $item->vehicle_detail->vehicle_make ?? '' }} / {{ $item->vehicle_detail->vehicle_model ?? '' }}</td>
                                            <td>{{ $item->user->name ?? '' }}</td>
                                            <td>{{ $item->seller->name ?? '' }}</td>
                                            <td>{{ date('d M, Y h:i A',strtotime($item->sta_inspection_date)) }}</td>
                                            <td>
                                                @if($item->approved_by_admin==1)
                                                <div class="badge badge-success">Accepted</div>
                                                @elseif($item->approved_by_admin==2)
                                                <div class="badge badge-danger">Rejected</div>
                                                @else
                                                <div class="badge badge-warning">Pending</div>
                                                @endif

                                            </td>
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
                            {{ $chat->appends(['_token' => request()->get('_token'),'search' => request()->get('search') ])->links() }}
                        @else
                            {{ $chat->links() }}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY/MM/DD',
                }
            });
        });
</script>
@endsection
