<table class="table table-md">
    <thead>
        <tr>

                                            <th>Student Full Name</th>
                                            <th>Date of Birth</th>
                                            <th>Contact Number</th>
                                            <th>Instructor Display Name</th>
                                            <th>Learning Location</th>
                                            <th>Mental Grade</th>
                                            <th>Mental Result</th>
                                            <th>Mental Result Pass/Fail</th>
                                            <th>Abacus Grade</th>
                                            <th>Abacus Paper 1 Result </th>
                                            <th>Abacus Result Pass/Fail</th>
        </tr>
    </thead>
    <tbody>
        @if($allItems->count())
        @foreach ($allItems as $key => $item)

        @php
//dd($item);
        @endphp
        <tr>

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
            <td>
                {{ $item->location->title ?? '' }}
            </td>

            <td>
                {{ $item->mental_grade ?? '' }}
            </td>
            <td>{{ $item->mental_results ?? '' }}</td>
            <td>{{ $item->mental_result_passfail ?? '' }}</td>

            <td>
                {{ $item->abacus_grade ?? '' }}
            </td>
            <td>
                {{ $item->result ?? '' }}
            </td>
            <td>
                {{ $item->abacus_result_passfail ?? '' }}
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
