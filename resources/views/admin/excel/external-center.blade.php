<table class="table table-md">
    <thead>
        <tr>
            <th>S no.</th>
            <th>Name</th>
                                            <th>Date of Birth</th>
                                            <th>Gender</th>
                                            <th>Account Id</th>
                                            <th>Status</th>
                                            <th>Learning Location</th>
                                            <th>Remarks</th>
                                            <th>Last Login Date/Time </th>
        </tr>
    </thead>
    <tbody>
        @if($allUsers->count())
        @foreach ($allUsers as $key => $item)
        <tr>
            <td>{{ ($key+1) }}</td>

            <td>{{ $item->name }}</td>
            <td>
                {{ $item->dob ?? '' }}
            </td>
            <td>@if($item->gender == 1) Male @else Female @endif</td>
            <td>{{ $item->account_id ?? '' }}</td>
            <td>@if($item->approve_status == 1) Active @elseif($item->approve_status == 2) Inactive @else Pending @endif</td>
            <td>
                {{ $item->learning_locations ?? '' }}
            </td>
            <td>
                {{ $item->remarks ?? '' }}
            </td>
            <td>
                {{ $item->last_login ?? '' }}
            </td>

        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
        </tr>
        @endif
    </tbody>
</table>
