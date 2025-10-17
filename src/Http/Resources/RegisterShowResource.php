<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingRegister;

class RegisterShowResource extends JsonResource
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
            'record' => TrainingRegister::pageShowResourceMap($request, $this),

            /**
             * link available on current page
             */
            'features' => TrainingRegister::pageShowFeatures($request, $this),

            /**
             * link available on current page
             */
            'links' => TrainingRegister::pageLinks($request),
            
            /**
             * setup combos on current page
             */
            'setups' => [
                'combos' => TrainingRegister::pageCombos($request, $this)
            ],
        ];
    }
}
