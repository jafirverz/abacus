<?php

namespace App\Http\Controllers;

use App\Level;
use App\LevelTopic;
use App\QuestionTemplate;
use App\Worksheet;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //
    public function index($slug = null){
        $checkSlug = Level::where('slug', $slug)->first();
        if($checkSlug){
            $levelId = $checkSlug->id;
            $levelTitle = $checkSlug->title;
            $levelDescription = $checkSlug->description;
            $levelTopics = LevelTopic::where('level_id', $levelId)->pluck('worksheet_id')->toArray();
            $worksheetsQuestionTemplate = Worksheet::whereIn('id', $levelTopics)->pluck('question_template_id')->toArray();
            $worksheets = Worksheet::whereHas('questions')->whereIn('id', $levelTopics)->get();
            $qestionTemplate = QuestionTemplate::whereIn('id', $worksheetsQuestionTemplate)->get();
            return view('account.level_details', compact("qestionTemplate", 'checkSlug', 'worksheets'));
        }else{
            return abort(404);
        }
    }
}
