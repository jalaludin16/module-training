<?php

namespace Module\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Training\Http\Resources\RegisterCollection;
use Module\Training\Http\Resources\RegisterShowResource;
use Module\Training\Models\TrainingRegister;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', TrainingRegister::class);

        return new RegisterCollection(
            TrainingRegister::applyMode($request->mode)
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
        $this->authorize('create', TrainingRegister::class);

        $this->validate($request, []);

        return TrainingRegister::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingRegister $trainingRegister)
    {
        $this->authorize('show', $trainingRegister);

        return new RegisterShowResource($trainingRegister);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingRegister $trainingRegister)
    {
        $this->authorize('update', $trainingRegister);

        $this->validate($request, []);

        return TrainingRegister::updateRecord($request, $trainingRegister);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingRegister $trainingRegister)
    {
        $this->authorize('delete', $trainingRegister);

        return TrainingRegister::deleteRecord($trainingRegister);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingRegister $trainingRegister)
    {
        $this->authorize('restore', $trainingRegister);

        return TrainingRegister::restoreRecord($trainingRegister);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingRegister $trainingRegister)
    {
        $this->authorize('destroy', $trainingRegister);

        return TrainingRegister::destroyRecord($trainingRegister);
    }
}
