<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $table = 'vehicle_quote_requests';
    protected $fillable = ['seller_id', 'full_name', 'email', 'country', 'contact_number', 'gender', 'vehicle_number', 'nric', 'mileage', 'handing_over_date', 'seller_remarks', 'upload_file', 'quote_price', 'status'];
}
