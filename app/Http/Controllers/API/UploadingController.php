<?php

namespace App\Http\Controllers\API;


use App\Imports\ItemsImport;
use Illuminate\Http\Request;
use App\gc_item_log_available;
use App\Imports\FilenameImport;
use App\Imports\ItemCategoryImport;
use App\Imports\PriceChangedImport;
use App\Imports\PriceHistoryImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UploadingController extends Controller
{

    public function uploaditem(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimes:csv,txt,'
        ]);
        (new ItemsImport)->import($request->file);
    }
    public function uploadprice(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimes:csv,txt,'
        ]);
        (new PriceHistoryImport)->import($request->file);
        (new PriceChangedImport)->import($request->file);
    }

    public function uploadItemDisable(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,txt'
        ]);
        $file = file($request->file->getRealPath());
        $remove_header = array_slice($file, 1);
        $data =  array_map('str_getcsv', $remove_header);

        foreach ($data as $row) {

            $check = gc_item_log_available::where('itemcode', '=', intval($row[0]))->where('store', '=', Auth::user()->bunit_code)->exists();

            if ($check) {

                $delete_item =  gc_item_log_available::where('itemcode', '=', intval($row[0]))->where('store', '=', Auth::user()->bunit_code);

                $delete_item->delete();
            } else {

                $items = array(
                    'itemcode'      => intval($row[0]),
                    'store'           => Auth::user()->bunit_code,
                    'tag_by'          => Auth::user()->name,

                );
                gc_item_log_available::insert($items);
            }
        }
    }

    public function uploadcategory(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,txt,'
        ]);
        (new ItemCategoryImport)->import($request->file);
    }

    public function uploaditemfilename(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,txt,'
        ]);

        (new FilenameImport)->import($request->file);
    }
    public function multipleImage(Request $request)
    {
        $this->validate($request, ['file' => 'image|mimes:jpeg,png,jpg,gif,svg',]);
        $imageName = $request->file->getClientOriginalName();
        $path = public_path() . '/ITEM-IMAGES/';
        // $path = '../admins.alturush.com/ITEM-IMAGES/';
        // $path2 = 'https://admins.alturush.com/ITEM-IMAGES/'; 
        if (file_exists($path . $imageName)) {
            @unlink($path . $imageName);
        }
            $request->file->move($path, $imageName);
        $url = "/ITEM-IMAGES/".$imageName;
        return $url;
    }
}
