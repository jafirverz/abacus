<table class="table table-md">
    <thead>
        <tr>
            <th>Instructor Account ID</th>
            <th>Instructor Display Name</th>
            <th>Instructor Full Name</th>
            <th>Email Address</th>
            <th>Contact number</th>
            <th>Status </th>
            <th>Date Created</th>
            <th>Last Active Date / Time</th>
        </tr>
    </thead>
    <tbody>
        @if($allUsers->count())
        @foreach ($allUsers as $key => $item)
        <tr>
            <td>{{ $item->account_id ?? '' }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->instructor_full_name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->mobile }}</td>
            <td>@if($item->approve_status == 1) Active @elseif($item->approve_status == 2) Deactivated @else Pending @endif</td>


            <td>{{ $item->created_at }}</td>
            <td>{{ $item->last_login }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
        </tr>
        @endif
    </tbody>
</table>
