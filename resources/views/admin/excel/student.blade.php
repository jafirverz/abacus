<table class="table table-md">
    <thead>
        <tr>
            <th>Account ID</th>
            <th>Full Name</th>
            <th>Date of Birth</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Student Type</th>
            <th>Levels Allocated</th>
            <th>Learning Location</th>
            <th>Status </th>
            <th>Last Updated</th>
            <th>Last Login</th>

        </tr>
    </thead>
    <tbody>
        @if($allUsers->count())
        @foreach ($allUsers as $key => $item)
        <tr>
            <td>{{ $item->account_id ?? '' }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->dob }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->email }}</td>

            <td>@if($item->user_type_id == 1) Normal Student @elseif($item->user_type_id == 2) Premium Student @elseif($item->user_type_id == 3) Online Student @elseif($item->user_type_id == 4) Event Only Student @endif</td>
            @if(isset($item->level_id))
            @php
            $allocatedLevel = $item->level_id;
            if($allocatedLevel){
                $decoded = json_decode($item->level_id);
                if(isset($decoded))
                {
                $level = \App\Level::whereIn('id', $decoded)->pluck('title')->toArray();

                $allLevel = implode(',', $level);
                //dd($allLevel);
                }
                else {
                    $allLevel='';
                }
            }
            else
            {
                $allLevel='';
            }


            @endphp
            @endif

            <td>{{ $allLevel ?? '' }}</td>
            <td>@if(is_numeric($item->learning_locations)){{ $item->location->title ?? ''}} @endif </td>
            <td>@if($item->approve_status == 1) Active @elseif($item->approve_status == 2) Deactivated @else Pending @endif</td>
            <td>{{ $item->updated_at }}</td>
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
