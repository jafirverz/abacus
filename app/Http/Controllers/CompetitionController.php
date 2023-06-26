<?php

namespace App\Http\Controllers;

use App\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    //
    public function index($id){
        $competition = Competition::where('id', $id)->first();
        if($competition){
            if($competition->competition_type == 'physical'){
                return view('competition_physical', compact("competition"));
            }else{
                return view('competition_online', compact("competition"));
            }
        }else{
            return abort(404);
        }
    }
}
