<table class="table table-md">
  <thead>
    <tr>
      <th>S/N</th>
      
      <th>Name</th>
      <th>Paper Name</th>
      <th>Grades</th>
      <th>Paper Type</th>
      <th>Account Id</th>
      <th>Student Name</th>
      <th>DOB</th>
      <th>Instructor Id</th>
      <th>Instructor Name</th>
      <th>Learning Location</th>
      <th>Total Marks</th>
      <th>User Marks</th>
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
        {{ $item->grade->title ?? '' }}
      </td>
      <td>
        {{ $item->paper->title ?? '' }}
      </td>
      <td>
        {{ $item->gcategory->category_name ?? '' }}
      </td>
      <td>
        {{ $item->paper_type ?? ''}}
      </td>
      <td>
        {{ getStudent($item->user_id)->account_id ?? '' }}
      </td>
      <td>
        {{ getStudent($item->user_id)->name ?? '' }}
      </td>
      <td>
        {{ getStudent($item->user_id)->dob ?? '' }}
      </td>
      <td>
        {{ getInstructor($instructorId->instructor_id)->account_id ?? '' }}
      </td>
      <td>
        {{ getInstructor($instructorId->instructor_id)->name ?? '' }}
      </td>
      <td>
        {{ getStudent($item->user_id)->learning_location ?? '' }}
      </td>
      <td>
        {{ $item->total_marks ?? ''}}
      </td>
      <td>
        {{ $item->user_marks ?? ''}}
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
