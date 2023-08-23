@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ $title ?? '-' }}</h1>
      <div class="section-header-button">
        <a href="{{ route('images.create') }}" class="btn btn-primary">Add New</a>
      </div>

    </div>


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
                          <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                            class="custom-control-input" id="checkbox-all">
                          <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                        </div>
                      </th>
                      <th>S/N</th>
                      <th>Image</th>
                      <th>Path</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($images)
                    @foreach($images as $key=>$data)
                    @php 
                    $image = url(asset($data->image));
                    @endphp
                    <tr>
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="text-center"><img src="{{ asset($data->image) }}" width="100px"></td>
                      <td class="text-center">{{ $image }}</td>
                      <td class="text-center">{{ $data->created_at }}</td>
                      <td class="text-center">{{ $data->updated_at }}</td>
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
              {{ $images->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection