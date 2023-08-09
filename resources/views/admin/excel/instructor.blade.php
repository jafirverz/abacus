<table class="table table-md">
    <thead>
        <tr>
            <th>S no.</th>
            <th>Account Id</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Phone</th>
            <th>DOB</th>
            <th>Address</th>
            <th>Approval</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @if($allUsers->count())
        @foreach ($allUsers as $key => $item)
        <tr>
            <td>{{ ($key+1) }}</td>
            <td>{{ $item->account_id ?? '' }}</td>
            <td>{{ $item->name }}</td>
            <td>@if($item->gender == 1) Male @else Female @endif</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->dob }}</td>
            <td>{{ $item->address }}</td>
            <td>@if($item->approve_status == 1) Approved @elseif($item->approve_status == 2) Rejected @else Pending @endif</td>
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
