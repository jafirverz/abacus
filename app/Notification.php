<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{
    //
	
	protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
}
