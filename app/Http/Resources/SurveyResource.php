<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $options = SurveyOptionResource::collection($this->survey_options)->sortBy('percent');

        // $result = array_map(function ($object) {
        //     return (array) $object;
        // }, $options);

        // usort($result, function ($a, $b) {
        //     return $a['percent'] <=> $b['percent'];
        // });

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'about' => $this->about,
            'options' => $options,
            'open' => false,
        ];
    }
}
