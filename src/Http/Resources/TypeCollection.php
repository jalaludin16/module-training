<?php

namespace Module\Training\Http\Resources;

use App\Models\PageInfo;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Module\Training\Models\TrainingType;

class TypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TypeResource::collection($this->collection);
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
                'combos' => TrainingType::pageCombos($request),

                /** the page data mode */
                /** default | nested | single | trashed */
                'mode' => $request->mode,

                /** the page enable fitur */
                'features' => TrainingType::pageFeatures($request),

                /** the page data filter */
                'filters' => TrainingType::pageFilters(),

                /** the table header */
                'headers' => TrainingType::pageHeaders($request),

                /** the page icon */
                'icon' => PageInfo::getIcon('training-type'),

                /** the record key */
                'key' => 'id',

                /** the page default */
                'record_base' => TrainingType::pageRecordMap($request),

                /** the page title */
                'title' => PageInfo::getTitle('training-type'),
            ]
        ];
    }
}
