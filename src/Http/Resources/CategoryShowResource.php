<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingCategory;

class CategoryShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            /**
             * link available on current page
             */
            'record' => TrainingCategory::pageShowResourceMap($request, $this),

            /**
             * link available on current page
             */
            'features' => TrainingCategory::pageShowFeatures($request, $this),

            /**
             * link available on current page
             */
            'links' => TrainingCategory::pageLinks($request),
            
            /**
             * setup combos on current page
             */
            'setups' => [
                'combos' => TrainingCategory::pageCombos($request, $this)
            ],
        ];
    }
}
