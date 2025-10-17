<?php

namespace Module\Training\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToCollection, WithHeadingRow
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
        $this->command->info('models_table');
        $this->command->getOutput()->progressStart(count($rows));

        foreach ($rows as $row) {
            $this->command->getOutput()->progressAdvance();

            $model = new Model();
            $model->name = $row['name'];
            $model->save();
        }

        $this->command->getOutput()->progressFinish();
    }
}
