<?php

namespace App\Http\Controllers;

use App\StandalonePage;
use App\StandaloneQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StandalonePageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->student_id = Auth::user()->id;
            $this->previous = url()->previous();
            return $next($request);

        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $standalonePage = StandalonePage::with('questionsPage')->where('status', 1)->first();
        return view('standalone.index', compact('standalonePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function result(Request $request){
        //dd("aa");
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
        return view('standalone.result', compact('standalonePage', 'values', 'totalMarks', 'correctMarks'));
    }
}
