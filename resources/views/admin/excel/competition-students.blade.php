<table class="table table-md">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Student Name</th>
            <th>Student DOB</th>
            <th>Contact Number</th>
            <th>Instructor Name</th>
            <th>Learning Location </th>
            <th>Country </th>
            <th>Competition Category </th>
            <th>Paper </th>
            <th>Total Marks </th>
            <th>Prize </th>
        </tr>
    </thead>
    <tbody>
        @if($allItems->count())
        @foreach ($allItems as $key => $item)

        @php
//dd($item);
        @endphp
        <tr>
            <td>{{ ($key+1) }}</td>
            <td>
                {{ $item->student->name  ?? ''}}
            </td>
            <td>
                {{ $item->student->dob  ?? ''}}
            </td>
            <td>
                {{ $item->student->country_code_phone.$item->student->mobile  ?? ''}}
            </td>
            <td>
                {{ $item->teacher->name  ?? ''}}
            </td>
            <td>{{ $item->location->title ?? '' }}</td>
            <td>{{ getCountry($item->student->country_code) ?? '' }}</td>
            <td>{{ getCategory($item->category_id)->category_name ?? '' }}</td>
            @php
            $abc = getPaper($item->competition_controller_id, $item->category_id, $item->user_id);
            if(!empty($abc)){
                $paperResult = implode(',  ', $abc);
            }
            @endphp
            <td>{{ $paperResult ?? '' }}</td>
            <td>{{ getTotalPaperMarks($item->competition_controller_id, $item->category_id, $item->user_id) }}</td>

            <td>{{ getPrize($item->competition_controller_id, $item->category_id, $item->user_id) }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
        </tr>
        @endif
    </tbody>
</table>
