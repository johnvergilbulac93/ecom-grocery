<?php

namespace App\Imports;

use App\gc_product_item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FilenameImport implements ToCollection, WithChunkReading
{
    use Importable;
//     public function  __construct($sample,$sample2)
//     {
//         $this->sample= $sample;
//         $this->sample2 = $sample2;
// 
//     }
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $filename = array(
                'image' =>  $row[0]
            );
            gc_product_item::where('itemcode','=', intval($row[1]))->update($filename);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
