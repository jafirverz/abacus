@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('invoice.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_invoice_crud', 'Show', route('invoice.show', $invoice->id))])
        </div>

        <div class="section-body">
            @php 
                $statusArr = ['0'=>'', '1'=>'Pending', '2'=>'Paid'];
                $invoiceTypesArr = ['1' => 'Deposit', '2' => 'Balance Payment', '3' => 'STA Inspection']; 
                $feeDiscTypesArr = ['1' => 'Percentage', '2' => 'Fixed Value']
            @endphp
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Invoice No</strong>: {{ $invoice->invoice_no }}
                            </div>
                            <div class="form-group">
                                <strong>Invoice Type</strong>: {{ $invoiceTypesArr[$invoice->invoice_type] }}
                            </div>
                            <div class="form-group">
                                <strong>Vehicle Number</strong>: {{ $invoice->vehicle_number }}
                            </div>
                            
                            <div class="form-group">
                                <strong>Seller Name</strong>: @php $user = get_user_detail($invoice->seller_id); echo $user['name']; @endphp
                            </div>
                            <div class="form-group">
                                <strong>Seller Logo:</strong>
                                <ul>
                                    <li><a href="{{ url($invoice->seller_logo) }}">{{ $invoice->seller_logo }}</a></li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <strong>Seller Address</strong>: {{ $invoice->seller_address }}
                            </div>
                            <div class="form-group">
                                <strong>Seller Email</strong>: {{ $invoice->seller_email }}
                            </div>
                            <div class="form-group">
                                <strong>Seller Phone</strong>: {{ "+65".$invoice->seller_phone }}
                            </div>
                            <div class="form-group">
                                <strong>Buyer Name</strong>: @php $user = get_user_detail($invoice->buyer_id); echo $user['name']; @endphp
                            </div>
                            <div class="form-group">
                                <strong>Buyer Email</strong>: {{ $invoice->buyer_email }}
                            </div>
                            <div class="form-group">
                                <strong>Buyer Phone</strong>: {{ "+65".$invoice->buyer_phone }}
                            </div>
                            <div class="form-group">
                                <strong>Note to customer</strong>: {{ $invoice->note_to_customer }}
                            </div>
                            <div class="form-group">
                                <strong>Terms & Conditions</strong>: {{ $invoice->terms_conditions }}
                            </div>
                            <div class="form-group">
                                <strong>Additional fee type</strong>: {{ $feeDiscTypesArr[$invoice->additional_fee_type] }}
                            </div>
                            <div class="form-group">
                                <strong>Additional fee value</strong>: {{ $invoice->additional_fee_value }}
                            </div>
                            <div class="form-group">
                                <strong>Discount type</strong>: {{ $feeDiscTypesArr[$invoice->discount_type] }}
                            </div>
                            <div class="form-group">
                                <strong>Discount value</strong>: {{ $invoice->discount_value }}
                            </div>

                            <div class="form-group">
                                <strong>Status</strong>: {{ $statusArr[$invoice->status] }}
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Invoice Item(s)
                                <hr/>
                            </h5>
                            <div class="form-group">
                                <div id="item_price_group">
                                    @php $invoiceItems = get_invoice_items($invoice->id); @endphp
                                    @if(isset($invoiceItems))
                                    @foreach($invoiceItems as $key=>$item)
                                    <div class="item_price_row row">
                                        <div class="col-lg-5">
                                            <strong>Item name: </strong>{{ $item->item_name }}
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>Price: </strong>{{ $item->price }}
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
