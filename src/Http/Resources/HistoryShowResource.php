<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingHistory;

class HistoryShowResource extends JsonResource
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
            'record' => TrainingHistory::pageShowResourceMap($request, $this),

            /**
             * link available on current page
             */
            'features' => TrainingHistory::pageShowFeatures($request, $this),

            /**
             * link available on current page
             */
            'links' => TrainingHistory::pageLinks($request),
            
            /**
             * setup combos on current page
             */
            'setups' => [
                'combos' => TrainingHistory::pageCombos($request, $this)
            ],
        ];
    }
}
