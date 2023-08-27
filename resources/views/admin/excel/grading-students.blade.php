<table class="table table-md">
    <thead>
        <tr>
            <th>S/N</th>
                                            <th>Event Name</th>
                                            <th>Student Name</th>
                                            <th>Student Email</th>
                                            <th>Student DOB</th>
                                            <th>Student Number</th>
                                            <th>Instructor Name</th>
                                            <th>Franchise Country Name</th>
                                            <th>Registered <br>Mental Grade</th>
                                            <th>Registered <br>Abacus Grades</th>
                                            <th>Learning Location </th>
                                            <th>Status </th>
                                            <th>Remark </th>
                                            <th>Result</th>
                                            <th>Pass/Fail</th>
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
                {{ $item->event->title ?? '' }}
            </td>
            <td>
                {{ $item->student->name  ?? ''}}
            </td>
            <td>
                {{ $item->student->email  ?? ''}}
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
                {{ getCountry($item->teacher->country_code) ?? '' }}
            </td>
            <td>
                {{ $item->mental->title ?? '' }}
            </td>
            <td>
                {{ $item->abacus->title ?? '' }}
            </td>
            <td>
                {{ $item->location->title ?? '' }}
            </td>
            <td>
                {{ ($item->approve_status==1)?'Approved':'Pending' }}
            </td>
            <td>{{ $item->remarks ?? ''}}</td>
            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->user_id )->result ?? '-'}}</td>
            <td>{{ getGradingStudentResult($item->grading_exam_id,$item->user_id )->remark_grade ?? '-'}}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
        </tr>
        @endif
    </tbody>
</table>
