<?php

namespace Module\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Training\Http\Resources\ClusterCollection;
use Module\Training\Http\Resources\ClusterShowResource;
use Module\Training\Models\TrainingCluster;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', TrainingCluster::class);

        return new ClusterCollection(
            TrainingCluster::applyMode($request->mode)
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
        $this->authorize('create', TrainingCluster::class);

        $this->validate($request, []);

        return TrainingCluster::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingCluster $trainingCluster)
    {
        $this->authorize('show', $trainingCluster);

        return new ClusterShowResource($trainingCluster);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingCluster $trainingCluster)
    {
        $this->authorize('update', $trainingCluster);

        $this->validate($request, []);

        return TrainingCluster::updateRecord($request, $trainingCluster);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingCluster $trainingCluster)
    {
        $this->authorize('delete', $trainingCluster);

        return TrainingCluster::deleteRecord($trainingCluster);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingCluster $trainingCluster)
    {
        $this->authorize('restore', $trainingCluster);

        return TrainingCluster::restoreRecord($trainingCluster);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingCluster $trainingCluster)
    {
        $this->authorize('destroy', $trainingCluster);

        return TrainingCluster::destroyRecord($trainingCluster);
    }
}
