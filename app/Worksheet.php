<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worksheet extends Model
{
    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('worksheets.title', 'like', '%'.$search_term.'%');
//            $query->orWhere('users.email', 'like', '%'.$search_term.'%');
//            $query->orWhere('users.mobile', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(worksheets.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(worksheets.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }

    public function questions(){
        return $this->hasMany('App\Question', 'worksheet_id', 'id');
    }

    public function questionsTemp(){
        return $this->belongsTo('App\QuestionTemplate', 'question_template_id', 'id');
    }

    public function leveTopic(){
        return $this->hasMany('App\LevelTopic', 'worksheet_id', 'id');
    }
}
