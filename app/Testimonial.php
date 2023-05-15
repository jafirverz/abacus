<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;


class Testimonial extends Model
{
    //
	use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function scopeSearch($query, $search_term)
    {
        $query->where('testimonials.name', 'like', '%'.$search_term->search.'%');
		$query->orwhere('testimonials.content', 'like', '%'.$search_term->search.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(testimonials.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term->search.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(testimonials.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term->search.'%');
        return $query;
    }

    
}
