<table class="table table-md">
  <thead>
    <tr>
      <th>S/N</th>
      <th>Grading Exam Name</th>
      <th>Account ID</th>
      <th>Student Name</th>
      <th>Student DOB</th>
      <th>Instructor Name</th>
      <th>Mental Grade</th>
      <th>Abacus Grade</th>
      <th>Learning Location</th>
      <th>Student Type</th>
      <th>Approve Status</th>
    </tr>
  </thead>
  <tbody>
    @if($allItems->count())
    @foreach ($allItems as $key => $item)

    @php
    //dd($item);
    $instructorId = \App\User::where('id', $item->user_id)->first();
    @endphp
    <tr>
      <td>{{ ($key+1) }}</td>
      <td>
        {{ getExamName($item->grading_exam_id) ?? '' }}
      </td>
      <td>{{ $item->userlist->account_id }}</td>
      <td>{{ $item->userlist->name }}</td>
      <td>{{ $item->userlist->dob }}</td>
      <td>{{ getInstructor($item->userlist->instructor_id)->name ?? '' }}</td>
      <td>{{ $item->mental->title ?? '' }}</td>
      <td>{{ $item->abacus->title ?? '' }}</td>
      <td>{{ $item->userlist->location->title ?? '' }}</td>

      <td>{{ getUserTypes($item->userlist->user_type_id) }}</td>
      <td>
        @if($item->approve_status == 1) Approved @elseif($item->approve_status == 2) Rejected @else Not Approved @endif
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
