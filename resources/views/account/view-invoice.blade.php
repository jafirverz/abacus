@extends('layouts.app')
@section('content')
<div class="main-wrap">
  <div class="bn-inner bg-get-image">
    @include('inc.banner')
  </div>
  <div class="container main-inner">
    <div class="invoice-wrapper">
      <div class="invoice-head" style="background:#F5F8FC;">
        <div class="row">
          <div class="col-xs-12 col-lg-12">
            <div class="invoice-title">
              <div class="invoice-logo"><img src="{{ asset($invoice[0]->seller_logo) }}"
                  alt="@php $user = get_user_detail($invoice[0]->seller_id); echo $user['name']; @endphp" /></div>
              <div class="text-right">
                <p>Invoice #{{$invoice[0]->invoice_no}}</p>
                <p>Invoice Type: {{ getInvoiceTypes($invoice[0]->invoice_type) }}</p>
                <p>Issued On: {{ date( 'd M Y', strtotime($invoice[0]->created_at) ) }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-lg-6">

              </div>
              <div class="col-lg-6 text-right">
                <h2 id="amountPay"></h2>
                @if($invoice[0]->status == 2)
                <div class="pain-img"><img src="{{ asset('images/paid.png') }}" alt="Paid" /></div>
                @endif
              </div>
            </div>

          </div>

        </div>
      </div>
      <div class="invoice-bill-to">
        <div class="row">
          <div class="col-xs-12 col-lg-12">
            <address>
              <strong>Bill To</strong>
              <h5><strong>@php $user = get_user_detail($invoice[0]->buyer_id); echo $user['name']; @endphp</strong></h5>
              <p>{{ $invoice[0]->seller_address }}</p>
            </address>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h5 class="panel-title"><strong>Items</strong></h5>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-condensed">

                  <tbody>
                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                    @if(isset($invoice[0]->items))
                    @php $sub_total = 0; @endphp
                    @foreach($invoice[0]->items as $key=>$item)
                    @php $sub_total += str_replace(',','',$item->price); @endphp
                    <tr>
                      <td>
                        <h5>{{ $item->item_name }}</h5>
                      </td>
                      <td class="text-right"><strong>${{ $item->price }}</strong></td>
                    </tr>
                    @endforeach
                    @endif

                    <tr class="nobr">
                      <td class="thick-line">Subtotal</td>
                      <td class="thick-line text-right">${{ number_format($sub_total) }}</td>
                    </tr>
                    <tr class="nobr">
                      @php  $addnl_fee =
                        calculateAddnlDiscFee($invoice[0]->additional_fee_type, $invoice[0]->additional_fee_value,
                        $sub_total); @endphp
                      <td class="thick-line">Additional Fee</td>
                      @php 
                      if(!empty($addnl_fee)){
                        $addnl_fee = str_replace(',','', $addnl_fee);
                        $addnl_fee = number_format($addnl_fee);
                      }else{
                        $addnl_fee = '';
                      }
                      @endphp
                      <td class="thick-line text-right">${{$addnl_fee}}</td>
                    </tr>
                    <tr class="nobr">
                      <td class="thick-line">Discount</td>
                      <td class="thick-line text-right">$@php echo $discount =
                        calculateAddnlDiscFee($invoice[0]->discount_type, $invoice[0]->discount_value, $sub_total);
                        @endphp</td>
                    </tr>

                    <tr class="nobr">

                      <td class="thick-line"><strong>Total</strong></td>
                      @php 
                      $addnl_fee = str_replace(',','',$addnl_fee);
                      $totals = $sub_total + $addnl_fee;
                      @endphp
                      <td class="thick-line text-right" id="totalAmount"><strong>${{ number_format($totals -
                        $discount) }}</strong></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="cs-note">
              <h5>Note to customer</h5>
              <p>{{ $invoice[0]->note_to_customer }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    var totalAmount = $("#totalAmount").html();
    $("#amountPay").html(totalAmount);
  });
</script>
@endsection