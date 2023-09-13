<table class="table table-md">
  <thead>
    <tr>
      <th>S/N</th>
      <th>Competition Name</th>
      <th>Paper Name</th>
      <th>Category</th>
      <th>Paper Type</th>
      <th>Student Name</th>
      <th>Total Marks</th>
      <th>User Marks</th>
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
        {{ getCompetition($item->competition_id)->title ?? '' }}
      </td>
      <td>
        {{ getCompetitionPaperName($item->competition_paper_id)->title ?? '' }}
      </td>
      <td>
        {{ getCategory($item->category_id)->category_name ?? '' }}
      </td>
      <td>
        {{ $item->paper_type ?? ''}}
      </td>
      <td>
        {{ getStudent($item->user_id)->name ?? '' }}
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