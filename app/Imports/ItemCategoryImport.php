<?php

namespace App\Imports;

use App\gc_product_item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ItemCategoryImport implements ToCollection, WithHeadingRow,WithBatchInserts,WithChunkReading
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            gc_product_item::where('itemcode', '=', intval($row['code']))
                ->update([
                    'category_name' => $row['cat_name'],
                    'category_no'   => intval($row['cat_code']),
                ]);
            // dd($rows);
        }
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }

    
}
