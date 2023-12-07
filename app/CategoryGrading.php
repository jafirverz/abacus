<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryGrading extends Model
{
    //

    public function category(){
        return $this->belongsTo('App\GradingCategory', 'category_id', 'id');
    }
}
