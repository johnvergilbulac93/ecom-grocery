<?php

namespace App\Imports;

use App\gc_product_item;
use App\gc_product_price;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ItemsImport implements ToCollection,WithHeadingRow
{
    use Importable;
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $check_price =  gc_product_price::where('itemcode','=',intval($row['no']))->where('UOM','=',$row['uom'])->exists();

            gc_product_item::updateOrCreate([
                'itemcode'      => intval($row['no']),
            ],[
                'product_name'  => $row['description'],
                'category_name' => $row['category'],
                'category_no'   => intval($row['category_no']),
                'itemcode'      => intval($row['no']),
                'status'        => 'active'
            ]);

           if(!$check_price)
           {
               $data_price = array(
                    'itemcode'        => intval($row['no']),
                    'UOM'             => $row['uom'],
                    'price'           => $row['retail'],
                    'price_with_vat'  => $row['retail']
               );
               gc_product_price::create($data_price);
           }

            
        }

    }
}
