<?php

namespace App\Http\Controllers;

use App\Models\SurveyOption;
use Illuminate\Http\Request;

class SurveyOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\SurveyOption  $surveyOption
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyOption $surveyOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SurveyOption  $surveyOption
     * @return \Illuminate\Http\Response
     */
    public function edit(SurveyOption $surveyOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SurveyOption  $surveyOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyOption $surveyOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveyOption  $surveyOption
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = SurveyOption::where('id', $id)->where('user_id', auth()->id())->first();
        if (!is_null($survey)) $survey->delete();
        return response()->json(['message' => 'Opção excluída']);
    }
}
