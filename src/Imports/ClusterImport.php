<?php

namespace Module\Training\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Module\Training\Models\TrainingCluster;

class ClusterImport implements ToCollection, WithHeadingRow
{
    /**
     * the module has role table
     */
    protected $command;

    /**
     * Undocumented function
     *
     * @param [type] $command
     * @param string $mode
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $this->command->info('clusters_table');
        $this->command->getOutput()->progressStart(count($rows));

        foreach ($rows as $row) {
            $this->command->getOutput()->progressAdvance();

            $source = (object) $row->toArray();

            $model = new TrainingCluster();
            $model->name = $source->name;
            $model->slug = sha1(str($source->name)->slug()->toString());
            $model->save();
        }

        $this->command->getOutput()->progressFinish();
    }
}
