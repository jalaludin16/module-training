<?php

namespace Module\Training\Imports;

use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataImport implements WithMultipleSheets, WithChunkReading
{
    /**
     * Undocumented function
     *
     * @param [type] $command
     * @param string $mode
     */
    public function __construct(protected $command, protected array $sheets = [])
    {
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function sheets(): array
    {
        if ($this->sheets && count($this->sheets) > 0) {
            return $this->sheets;
        }

        return [
            'types' => new TypeImport($this->command),
            'clusters' => new ClusterImport($this->command),
            'registers' => new RegisterImport($this->command),
        ];
    }
}
