<?php

namespace Module\Training\Http\Resources;

use App\Models\PageInfo;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Module\Training\Models\TrainingRegister;

class RegisterCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RegisterResource::collection($this->collection);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        if (!$request->has('initialized')) {
            return [];
        }

        return [
            'setups' => [
                /** the page combo */
                'combos' => TrainingRegister::pageCombos($request),

                /** the page data mode */
                /** default | nested | single | trashed */
                'mode' => $request->mode,

                /** the page enable fitur */
                'features' => TrainingRegister::pageFeatures($request),

                /** the page data filter */
                'filters' => TrainingRegister::pageFilters(),

                /** the table header */
                'headers' => TrainingRegister::pageHeaders($request),

                /** the page icon */
                'icon' => PageInfo::getIcon('training-register'),

                /** the record key */
                'key' => 'id',

                /** the page default */
                'record_base' => TrainingRegister::pageRecordMap($request),

                /** the page title */
                'title' => PageInfo::getTitle('training-register'),
            ]
        ];
    }
}
