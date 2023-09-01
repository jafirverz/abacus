<?php

namespace App\Http\Controllers;

use App\StandalonePage;
use App\StandaloneQuestions;
use Illuminate\Http\Request;

class GuestUserController extends Controller
{
    //
    public function aboutUs(){
        $slug = 'about-us';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }
    public function privacy(){
        $slug = 'privacy-policy';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }
    public function faq(){
        $slug = 'faqs';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }
    public function termsofuse(){
        $slug = 'terms-of-use';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }

    public function standalonepage(){
        $slug = 'standalonepage';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        $standalonePage = StandalonePage::with('questionsPage')->where('status', 1)->first();
        return view('standalone', compact('page', 'standalonePage'));
    }

    public function standalonepageresult(Request $request){
        $totalMarks = 0;
        $correctMarks = 0;
        foreach($request->answer as $key=>$value){
            $getMarks = StandaloneQuestions::where('id', $key)->first();
            $totalMarks+= $getMarks->marks;
            if($getMarks->answer == $value){
                $correctMarks+= $getMarks->marks;
            }
        }
        $values = $request->answer;
        $standalonePage = StandalonePage::with('questionsPage')->where('status', 1)->first();
        return view('standaloneresult', compact('standalonePage', 'values', 'totalMarks', 'correctMarks'));
    }
}
