<table class="table table-md">
  <thead>
    <tr>
      <th>S/N</th>
      <th>Competition Name</th>
      <th>Student Name</th>
      <th>Account ID</th>
      <th>Instructor Name</th>
      <th>Instructor ID</th>
      <th>Learning Location</th>
      <th>Category</th>
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
        {{ getCompetition($item->competition_controller_id)->title ?? '' }}
      </td>
      <td>
        {{ getStudent($item->user_id)->name ?? '' }}
      </td>
      <td>
        {{ getStudent($item->user_id)->account_id ?? '' }}
      </td>
      <td>
        {{ getInstructor($instructorId->instructor_id)->name ?? '' }}
      </td>
      <td>
        {{ getInstructor($instructorId->instructor_id)->account_id ?? '' }}
      </td>
      <td>
        {{ getLearningLocation(getStudent($item->user_id)->learning_location ?? '') ?? '' }}
      </td>
      <td>
        {{ $item->category->category_name ?? '' }}
      </td>
      <td>
        {{ getUserTypes($item->userlist->user_type_id) }}
      </td>
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