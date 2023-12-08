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
    @foreach ($allItems as $key => $item)

    <tr>
      <td>{{ $key + 1 }}</td>
      <td>{{ $item->course->title }}</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>{{ $item->user->last_login }}</td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
    </tr>
    @endif
  </tbody>
</table>