<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingType;

class TypeShowResource extends JsonResource
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
            'record' => TrainingType::pageShowResourceMap($request, $this),

            /**
             * link available on current page
             */
            'features' => TrainingType::pageShowFeatures($request, $this),

            /**
             * link available on current page
             */
            'links' => TrainingType::pageLinks($request),
            
            /**
             * setup combos on current page
             */
            'setups' => [
                'combos' => TrainingType::pageCombos($request, $this)
            ],
        ];
    }
}
