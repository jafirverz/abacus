<table class="table table-md">
    <thead>
        <tr>
            <th>S no.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Order Name</th>
            <th>Amount</th>
            <th>Transaction ID</th>
            <th>Expiry Date</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @if($allOrders->count())
        @foreach ($allOrders as $key => $item)
        @php 
        $user = \App\User::where('id', $item->user_id)->first();
        $payment = \App\Payment::where('order_id', $item->order_id)->first();
        @endphp
        <tr>
            <td>{{ ($key+1) }}</td>
            <td>{{ $user->name ?? '' }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->amount }}</td>
            <td>{{ $payment->transaction_id }}</td>
            <td>{{ $item->expiry_date ?? '' }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->updated_at }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">{{ __('constant.NO_DATA_FOUND') }}</td>
        </tr>
        @endif
    </tbody>
</table>
