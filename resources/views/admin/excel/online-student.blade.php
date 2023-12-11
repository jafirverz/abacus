<table class="table table-md">
  <thead>
    <tr>
      <th>S/N</th>
      <th>Lesson Title</th>
      <th>Lesson Status</th>
      <th>Completion Date/Time</th>
      <th>Survey Status</th>
      <th>Certificate Issued on</th>
      <th>Last Login</th>
    </tr>
  </thead>
  <tbody>
    @if($allItems->count())
    @foreach ($allItems as $key => $value)

    <tr>
      <td>{{ $key + 1 }}</td>
      <td>{{ $value->course->title ?? '' }}</td>
    <td>@if(isset($value->submitted->is_submitted) && $value->submitted->is_submitted==1) Submitted @elseif(isset($value->submitted->is_submitted) && $value->submitted->is_submitted==2) In-progress @else - @endif</td>
    <td>@if(isset($value->submitted->updated_at)){{ date('j F,Y H:i:s',strtotime($value->submitted->updated_at)) }}@endif</td>
    <td></td>
    <td>@if(isset($value->submitted->certificate_issued_on)){{ date('j F,Y',strtotime($value->submitted->certificate_issued_on)) }}@endif</td>
    <td>{{ $value->user->last_login }}</td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
    </tr>
    @endif
  </tbody>
</table>
