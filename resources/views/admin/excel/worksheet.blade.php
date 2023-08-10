<table class="table table-md">
    <thead>
        <tr>
            <th>S no.</th>
            <th>Level</th>
            <th>Worksheet</th>
            <th>Student Name</th>
            <th>Total Marks</th>
            <th>Marks</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @if($allOrders->count())
        @foreach ($allOrders as $key => $item)
        <tr>
            <td>{{ ($key+1) }}</td>
            <td>{{ $item->level->title ?? '' }}</td>
            <td>{{ $item->worksheet->title }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->total_marks }}</td>
            <td>{{ $item->user_marks }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->updated_at }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
        </tr>
        @endif
    </tbody>
</table>
