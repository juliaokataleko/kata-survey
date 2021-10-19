<?php

namespace App\Http\Resources;

use App\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // survey answers
        $survey_answers = Answer::where('user_id', auth()->id())
            ->where('survey_id', $this->survey_id)
            ->get();

        $percents = Answer::where('user_id', auth()->id())
            ->where('survey_id', $this->survey_id)
            ->where('option_id', $this->id)
            ->get();

        if(count($percents) == 0 || count($survey_answers) == 0) {
            $percent = number_format((float)0, 2, '.', '');
        } else {
            $percent = (count($percents) * 100) / count($survey_answers);
            $percent = number_format((float)$percent, 2, '.', '');
        }

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'percent' => (float) $percent,
            'votes' => count($percents),
            'total_votes' => count($survey_answers),
        ];
    }
}
