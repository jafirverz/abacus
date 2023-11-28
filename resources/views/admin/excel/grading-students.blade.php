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
                                            <th>Abacus Paper 2 Result </th>
                                            <th>Abacus Paper 3 Result </th>
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
                {{ $item->student->email  ?? ''}}
            </td>

            <td>
                {{ $item->location->title ?? '' }}
            </td>
            <td>
                {{ $item->mental->title ?? '' }}
            </td>
            <td></td>
            <td></td>
            <td>
                {{ $item->abacus->title ?? '' }}
            </td>
            <td></td>
            <td></td>
            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->user_id )->result ?? '-'}}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
        </tr>
        @endif
    </tbody>
</table>
