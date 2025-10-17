<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingCluster;

class ClusterShowResource extends JsonResource
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
            'record' => TrainingCluster::pageShowResourceMap($request, $this),

            /**
             * link available on current page
             */
            'features' => TrainingCluster::pageShowFeatures($request, $this),

            /**
             * link available on current page
             */
            'links' => TrainingCluster::pageLinks($request),
            
            /**
             * setup combos on current page
             */
            'setups' => [
                'combos' => TrainingCluster::pageCombos($request, $this)
            ],
        ];
    }
}
