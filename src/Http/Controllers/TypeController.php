<?php

namespace Module\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Training\Http\Resources\TypeCollection;
use Module\Training\Http\Resources\TypeShowResource;
use Module\Training\Models\TrainingType;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', TrainingType::class);

        return new TypeCollection(
            TrainingType::applyMode($request->mode)
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
        $this->authorize('create', TrainingType::class);

        $this->validate($request, []);

        return TrainingType::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingType  $trainingType
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingType $trainingType)
    {
        $this->authorize('show', $trainingType);

        return new TypeShowResource($trainingType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Module\Training\Models\TrainingType  $trainingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingType $trainingType)
    {
        $this->authorize('update', $trainingType);

        $this->validate($request, []);

        return TrainingType::updateRecord($request, $trainingType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingType  $trainingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingType $trainingType)
    {
        $this->authorize('delete', $trainingType);

        return TrainingType::deleteRecord($trainingType);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingType  $trainingType
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingType $trainingType)
    {
        $this->authorize('restore', $trainingType);

        return TrainingType::restoreRecord($trainingType);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingType  $trainingType
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingType $trainingType)
    {
        $this->authorize('destroy', $trainingType);

        return TrainingType::destroyRecord($trainingType);
    }
}
