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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_invoice_crud', 'Edit', route('invoice.edit', $invoice->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('invoice.update', $invoice->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @php 
                            $invoiceTypesArr = ['1' => 'Deposit', '2' => 'Balance Payment', '3' => 'STA Inspection']; 
                            $feeDiscTypesArr = ['1' => 'Percentage', '2' => 'Fixed Value']
                        @endphp
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="vehicle_number">Vehicle Number</label>
                                    <input type="text" name="vehicle_number" class="form-control" id="" value="{{ $invoice->vehicle_number }}">
                                    @if ($errors->has('vehicle_number'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('vehicle_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="seller_id">Seller User</label>
                                    <!-- <input type="text" name="seller_id" class="form-control" id="" value=""> -->
                                    <div>
                                        <select name="seller_id" class="form-control">
                                            <option value="">Select seller user</option>
                                            @if(getAllUsers())
                                            @foreach(getAllUsers() as $key=>$value)
                                            <option value="{{ $value->id }}" @if($invoice->seller_id == $value->id) selected @endif>{{ $value->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('seller_id'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('seller_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="buyer_id">Buyer User</label>
                                    <div>
                                        <select name="buyer_id" class="form-control">
                                            <option value="">Select buyer user</option>
                                            @if(getAllUsers())
                                            @foreach(getAllUsers() as $key=>$value)
                                            <option value="{{ $value->id }}" @if($invoice->buyer_id == $value->id) selected @endif>{{ $value->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('buyer_id'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('buyer_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Seller Address: </div>
                                    <textarea class="form-control" name="seller_address" id="seller_address">{{ $invoice->seller_address }}</textarea>
                                    @if ($errors->has('seller_address'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('seller_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Seller Logo: </div>
                                    <div class="col-lg-12 mt-20">
                                        <div class="file-box">
                                            <a href="{{ url($invoice->seller_logo) }}">{{ $invoice->seller_logo }}</a><br>
                                        </div>
                                        <div class="attach-box">
                                            <div class="file-wrap mt-10">
                                                <input class="" type="file" id="seller_logo" name="seller_logo">
                                            </div>
                                        </div>
                                        @if ($errors->has('seller_logo'))
                                            <span class="text-danger">&nbsp;{{ $errors->first('seller_logo') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="seller_email">Seller Email</label>
                                    <input type="text" name="seller_email" class="form-control" id="" value="{{ $invoice->seller_email }}">
                                    @if ($errors->has('seller_email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('seller_email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="seller_phone">Seller Phone</label>
                                    +65 <input type="text" name="seller_phone" class="form-control" id="" value="{{ $invoice->seller_phone }}">
                                    @if ($errors->has('seller_phone'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('seller_phone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="buyer_email">Buyer Email</label>
                                    <input type="text" name="buyer_email" class="form-control" id="" value="{{ $invoice->buyer_email }}">
                                    @if ($errors->has('buyer_email'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('buyer_email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="buyer_phone">Buyer Phone</label>
                                    +65 <input type="text" name="buyer_phone" class="form-control" id="" value="{{ $invoice->buyer_phone }}">
                                    @if ($errors->has('buyer_phone'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('buyer_phone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="control-label" for="invoice_type">Invoice Type</div>
                                    <div class="">
                                        <select name="invoice_type" class="form-control" id="">
                                            <option value="">-- Select --</option>
                                            @foreach($invoiceTypesArr as $key=>$value)
                                            <option value="{{ $key }}" @if($invoice->invoice_type == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('invoice_type'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('invoice_type') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Note to customer: </div>
                                    <textarea class="form-control" name="note_to_customer" id="note_to_customer">{{ $invoice->note_to_customer }}</textarea>
                                    @if ($errors->has('note_to_customer'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('note_to_customer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Terms & conditions: </div>
                                    <textarea class="form-control" name="terms_conditions" id="terms_conditions">{{ $invoice->terms_conditions }}</textarea>
                                    @if ($errors->has('terms_conditions'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('terms_conditions') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label" for="additional_fee_type">Additional fee type</div>
                                    <div class="">
                                        <select name="additional_fee_type" class="form-control" id="">
                                            @foreach($feeDiscTypesArr as $key=>$value)
                                            <option value="{{ $key }}" @if($invoice->additional_fee_type == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('additional_fee_type'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('additional_fee_type') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="additional_fee_value">Additional fee value</label>
                                    <input type="text" name="additional_fee_value" class="form-control" id="" value="{{ $invoice->additional_fee_value }}">
                                    @if ($errors->has('additional_fee_value'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('additional_fee_value') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="control-label" for="discount_type">Discount type</div>
                                    <div class="">
                                        <select name="discount_type" class="form-control" id="">
                                            @foreach($feeDiscTypesArr as $key=>$value)
                                            <option value="{{ $key }}" @if($invoice->discount_type == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('discount_type'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('discount_type') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="discount_value">Discount value</label>
                                    <input type="text" name="discount_value" class="form-control" id="" value="{{ $invoice->discount_value }}">
                                    @if ($errors->has('additional_fee_value'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('discount_value') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="control-label" for="status">Status</div>
                                    <div class="">
                                        <select name="status" class="form-control" tabindex="-98">
                                            @php $statusArr = ['1'=>'Pending', '2'=>'Paid']; @endphp
                                            @for ($i=1; $i<=2; $i++)
                                                <option value="{{ $i }}" @if($invoice->status == $i) selected @endif>{{ $statusArr[$i] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    @if ($errors->has('status'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('status') }}</span>
                                    @endif
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
                                                    <label for="">Item name</label>
                                                    <input type="text" name="item[]" value="{{ $item->item_name }}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="">Price</label>
                                                    <input type="text" name="price[]" value="{{ $item->price }}">
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="col-lg-12 text-right">
                                            <a href="javascript:void(0)" rel="button" class="btn add_more_item">Add More +</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
$('.add_more_item').click(function() {
    var rowHtml = '<div class="item_price_row row"><div class="col-lg-5"><label for="">Item name</label> <input type="text" value="" name="item[]"></div><div class="col-lg-4"><label for="">Price</label> <input type="text" value="" name="price[]"></div></div>';
    $('#item_price_group').append(rowHtml);
});
</script>
@endsection