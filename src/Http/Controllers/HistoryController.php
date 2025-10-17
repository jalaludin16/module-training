<?php

namespace Module\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Training\Http\Resources\HistoryCollection;
use Module\Training\Http\Resources\HistoryShowResource;
use Module\Training\Models\TrainingHistory;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', TrainingHistory::class);

        return new HistoryCollection(
            TrainingHistory::applyMode($request->mode)
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
        $this->authorize('create', TrainingHistory::class);

        $this->validate($request, []);

        return TrainingHistory::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingHistory $trainingHistory)
    {
        $this->authorize('show', $trainingHistory);

        return new HistoryShowResource($trainingHistory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingHistory $trainingHistory)
    {
        $this->authorize('update', $trainingHistory);

        $this->validate($request, []);

        return TrainingHistory::updateRecord($request, $trainingHistory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingHistory $trainingHistory)
    {
        $this->authorize('delete', $trainingHistory);

        return TrainingHistory::deleteRecord($trainingHistory);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingHistory $trainingHistory)
    {
        $this->authorize('restore', $trainingHistory);

        return TrainingHistory::restoreRecord($trainingHistory);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingHistory $trainingHistory)
    {
        $this->authorize('destroy', $trainingHistory);

        return TrainingHistory::destroyRecord($trainingHistory);
    }
}
