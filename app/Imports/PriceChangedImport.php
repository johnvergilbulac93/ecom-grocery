<?php

namespace App\Imports;

use App\gc_product_uom;
use App\gc_product_price;
use Illuminate\Support\Arr;
use App\gc_product_price_history;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;


class PriceChangedImport implements ToCollection
{
    use Importable;
    
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        {
            $check_price_uom_data =  gc_product_price::where('itemcode','=',intval($row[0]))->where('UOM','=',$row[2])->exists();
        
            if(!$check_price_uom_data)
            {
                $price_data_create = array(
                    'itemcode'          =>  intval($row[0]),
                    'UOM'               =>  $row[2], 
                    'price'             =>  floatval(str_replace(',','',$row[5])),
                    'price_with_vat'    =>  floatval(str_replace(',','',$row[5])), 
                    'status'            =>  1
                );  
                gc_product_price::insert($price_data_create);  

            }
            if($check_price_uom_data)
            { 
                $price_data_update = array(

                    'price'             =>  floatval(str_replace(',','',$row[5])),
                    'price_with_vat'    =>  floatval(str_replace(',','',$row[5])),
        
                );
                gc_product_price::where('itemcode','=',intval($row[0]))->where('UOM','=',$row[2])->update($price_data_update);  
                
            }


        }

    }
}