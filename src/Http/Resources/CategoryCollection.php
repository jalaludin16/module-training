<?php

namespace Module\Training\Http\Resources;

use App\Models\PageInfo;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Module\Training\Models\TrainingCategory;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return CategoryResource::collection($this->collection);
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
                'combos' => TrainingCategory::pageCombos($request),

                /** the page data mode */
                /** default | nested | single | trashed */
                'mode' => $request->mode,

                /** the page enable fitur */
                'features' => TrainingCategory::pageFeatures($request),

                /** the page data filter */
                'filters' => TrainingCategory::pageFilters(),

                /** the table header */
                'headers' => TrainingCategory::pageHeaders($request),

                /** the page icon */
                'icon' => PageInfo::getIcon('training-category'),

                /** the record key */
                'key' => 'id',

                /** the page default */
                'record_base' => TrainingCategory::pageRecordMap($request),

                /** the page title */
                'title' => PageInfo::getTitle('training-category'),
            ]
        ];
    }
}
