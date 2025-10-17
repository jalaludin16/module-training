<?php

namespace Module\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Training\Http\Resources\CategoryCollection;
use Module\Training\Http\Resources\CategoryShowResource;
use Module\Training\Models\TrainingCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', TrainingCategory::class);

        return new CategoryCollection(
            TrainingCategory::applyMode($request->mode)
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy, $request->sortDesc)
                ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', TrainingCategory::class);

        $this->validate($request, []);

        return TrainingCategory::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingCategory  $trainingCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingCategory $trainingCategory)
    {
        $this->authorize('show', $trainingCategory);

        return new CategoryShowResource($trainingCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Module\Training\Models\TrainingCategory  $trainingCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingCategory $trainingCategory)
    {
        $this->authorize('update', $trainingCategory);

        $this->validate($request, []);

        return TrainingCategory::updateRecord($request, $trainingCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingCategory  $trainingCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingCategory $trainingCategory)
    {
        $this->authorize('delete', $trainingCategory);

        return TrainingCategory::deleteRecord($trainingCategory);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingCategory  $trainingCategory
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingCategory $trainingCategory)
    {
        $this->authorize('restore', $trainingCategory);

        return TrainingCategory::restoreRecord($trainingCategory);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingCategory  $trainingCategory
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingCategory $trainingCategory)
    {
        $this->authorize('destroy', $trainingCategory);

        return TrainingCategory::destroyRecord($trainingCategory);
    }
}
