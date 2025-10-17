<?php

namespace Module\Training\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Module\Training\Models\TrainingRegister;

class RegisterImport implements ToCollection, WithHeadingRow
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
        $this->command->info('registers_table');
        $this->command->getOutput()->progressStart(count($rows));

        foreach ($rows as $row) {
            $this->command->getOutput()->progressAdvance();

            $source = (object) $row->toArray();

            $model = new TrainingRegister();
            $model->name = str($source->name)->upper()->trim()->toString();
            $model->slug = sha1(str($source->name)->slug()->toString());
            $model->type_id = $source->type_id;
            $model->datamap = optional($source)->datamap ?: null;
            $model->save();
        }

        $this->command->getOutput()->progressFinish();
    }
}
