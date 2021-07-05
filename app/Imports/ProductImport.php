<?php

namespace App\Imports;

use App\Models\Back\Catalog\Product\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection/*, WithCustomCsvSettings*/, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        return $collection;
    }

    public function batchSize(): int
    {
        return 10;
    }

    public function chunkSize(): int
    {
        return 10;
    }

    /*public function getCsvSettings(): array
    {
        return [
            'delimiter' => '|',
            'escape_character' => '|',
        ];
    }*/
}
