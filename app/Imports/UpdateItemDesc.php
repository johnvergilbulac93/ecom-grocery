<?php

namespace App\Imports;

use App\gc_product_item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UpdateItemDesc implements ToCollection,WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            gc_product_item::where('itemcode',intval($row['itemcode']))->update([
                'product_name'  => $row['item_description']
            ]);  
        }
    }
}
