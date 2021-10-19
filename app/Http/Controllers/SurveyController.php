<?php

namespace App\Http\Controllers;

use App\Http\Resources\SurveyResource;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\SurveyOption;
use Illuminate\Http\Request;
use PhpOption\Option;
use Ramsey\Uuid\Uuid;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Survey::query();
        $surveys = $query->where('user_id', 
        auth()->id())
        ->orderBy('id', 'desc')
        ->get();
        return SurveyResource::collection($surveys);
        return response()->json($surveys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'about' => 'required'
        ]);

        $data['user_id'] = auth()->id();
        $data['uuid'] = Uuid::uuid4();

        // create survey
        $survey = Survey::create($data);

        $options = $request->options;
        
        foreach ($options as $key => $option) {
            $option['user_id'] = auth()->id();
            $option['survey_id'] = $survey->id;
            $option['uuid'] = Uuid::uuid4();

            // save the option
            $option = SurveyOption::create($option);

            // adicionar respostas aleatórias...
            $values = rand(1, 5);

            for ($i=0; $i < $values; $i++) { 
                Answer::create([
                    'user_id' => auth()->id(),
                    'survey_id' => $survey->id,
                    'option_id' => $option->id,
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::where('uuid', $id)->get();
        return SurveyResource::collection($survey);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        $data = $request->validate([
            'title' => 'required',
            'about' => 'required'
        ]);

        // create survey
        $survey->update($data);

        $options = $request->options;

        foreach ($options as $key => $option) {

            if(isset($option['id']) AND $option['id']) {
                $dataOption['user_id'] = auth()->id();
                $dataOption['survey_id'] = $survey->id;
                $dataOption['title'] = $option['title'];
                $option = SurveyOption::find($option['id']);
                $option->update($dataOption);
            } else {
                $dataOption['user_id'] = auth()->id();
                $dataOption['survey_id'] = $survey->id;
                $dataOption['user_id'] = auth()->id();
                $dataOption['uuid'] = Uuid::uuid4();
                $dataOption['title'] = $option['title'];
                $dataOption['number'] = $option['number'];
                $option = SurveyOption::create($dataOption);
            }
  
            // adicionar respostas aleatórias...
            $values = rand(1, 5);

            for ($i = 0; $i < $values; $i++) {
                Answer::create([
                    'user_id' => auth()->id(),
                    'survey_id' => $survey->id,
                    'option_id' => $option->id,
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = Survey::where('id', $id)->where('user_id', auth()->id())->first();
        if(!is_null($survey)) $survey->delete();
        return response()->json(['message' => 'Enquete excluída']);
    }
}
