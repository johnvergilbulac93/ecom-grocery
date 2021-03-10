<?php

namespace App\Http\Controllers\API;

use App\gc_product_item;
use App\gc_product_price;
use App\gc_product_uom;
use App\gc_item_log_available;
use App\gc_product_price_history;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ItemController extends Controller
{

    public function edit_item(Request $request)
    {


        $this->validate($request, [
            'itemcode' => 'required|numeric',
            'product_name' => 'required',
            'status' => 'required'
        ]);
        $update_data = array(
            'itemcode'      => $request->get('itemcode'),
            'product_name'  => strtoupper($request->get('product_name')),
            'status'        => $request->get('status')
        );
        gc_product_item::where('product_id', '=', $request->product_id)->update($update_data);
    }

    public function getItem(Request $request)
    {
        $columns = ['product_id', 'itemcode', 'product_name', 'category_name', 'product_id'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');

        // dd($categoryValue);

        $query = gc_product_item::with(['items'])->where('status', 'active')->orderBy($columns[$column], $dir);

        if ($searchValue) {

            $query->where(function ($query) use ($searchValue) {
                $query->where('itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_name', 'like', '%' . $searchValue . '%');    
            });
        }

        if ($categoryValue) {
            $query->where(function ($query) use ($categoryValue) {
                $query->where('category_name', 'like', '%' . $categoryValue . '%');   
            });
        }

        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
    public function getCentralItem(Request $request)
    {

        $columns = ['product_id', 'itemcode', 'product_name', 'category_name', 'product_id'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = gc_product_item::with(['item_price'])->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('category_name', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
    public function countItem()
    {
        return gc_product_item::count();
    }
    public function countPrice()
    {
        return gc_product_price::count();
    }
    public function countUOM()
    {
        return gc_product_uom::count();
    }
    public function create_item(Request $request)
    {

        $this->validate($request, [
            'itemcode' => 'required|numeric',
            'product_name' => 'required',
            'status' => 'required'
        ]);

        $items_data = array(
            'itemcode'      => $request->get('itemcode'),
            'product_name'  =>   strtoupper($request->get('product_name')),
            'quantity'       => $request->get('quantity'),
            'status'        => $request->get('status'),

        );

        gc_product_item::create($items_data);

        $itemcode = array(
            'itemcode'  => $request->get('itemcode')
        );
        gc_product_uom::create($itemcode);
    }
    public function delete_item($id)
    {
        $item = gc_product_item::where('product_id', '=', $id);
        $item->delete();
    }
    public function create_uom(Request $request)
    {
        $this->validate($request, [
            'itemcode_uom'      => 'required|numeric',
            'uom'               => 'required',
            'quantity_uom'      => 'required'

        ]);
        $update_data = array(
            'itemcode'          => $request->get('itemcode_uom'),
            'uom'               => strtoupper($request->get('uom')),
            'qty_per_uom'       => $request->get('quantity_uom'),

        );
        gc_product_uom::where('uom_id', '=', $request->uom_id)->update($update_data);
    }
    public function delete_uom($id)
    {
        $uom = gc_product_uom::where('uom_id', '=', $id);
        $uom->delete();
    }

    public function itemavailability()
    {
        return DB::table('gc_item_log_availables')
            ->join('gc_product_items', 'gc_product_items.itemcode', '=', 'gc_item_log_availables.itemcode')
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_item_log_availables.store')
            ->select('*')
            ->where('gc_product_items.status', '=', 'active')
            ->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code)
            ->paginate();
    }
    public function item_available_all()
    {
        return DB::table('gc_item_log_availables')
            ->join('gc_product_items', 'gc_product_items.itemcode', '=', 'gc_item_log_availables.itemcode')
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_item_log_availables.store')
            ->select('*')
            ->get();
    }
    public function tag_item_disable(Request $request)
    {

        $tag_data = array(
            'itemcode'       => $request->get('itemcode'),
            'store'          => Auth::user()->bunit_code,
            'tag_by'         => Auth::user()->name,
        );
        gc_item_log_available::insert($tag_data);
    }

    public function tag_item_enable($id)
    {
        gc_item_log_available::where('store', '=', Auth::user()->bunit_code)
            ->where('itemcode', '=', $id)
            ->delete();
    }

    public function item_Active($id)
    {

        $active_data = array(
            'status'       => 'inactive',
        );

        gc_product_item::where('itemcode', '=', $id)->update($active_data);
    }

    public function item_Inactive($id)
    {

        $inactive_data = array(
            'status'       => 'active',
        );
        gc_product_item::where('itemcode', '=', $id)->update($inactive_data);
    }

    public function imageitem(Request $request, $id)
    {

        $this->validate($request, [
            'image'      => 'required',
        ]);

        $exploded = explode(',', $request->image);

        $decoded = base64_decode($exploded[1]);

        $imageName = $id . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];

        $path = public_path() . '/ITEM-IMAGES/' . $imageName;


        if (file_exists($path)) {
            @unlink($path);
        }

        file_put_contents($path, $decoded);

        $item_images  = array(
            'image' => $imageName
        );
        gc_product_item::where('itemcode', '=', $id)->update($item_images);
    }

    public function disable_tagging_uom(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
            ->where('gc_product_prices.status', '=', 1)
            ->select('*')
            ->orderBy('price_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_prices.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_prices.UOM', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
    public function disable_per_uom(Request $request)
    {
        $ids = $request->get('itemIds');
        $data = array(
            'status' => 0
        );
        gc_product_price::whereIn('price_id', $ids)->update($data);
    }
    public function enable_per_uom(Request $request)
    {
        $ids = $request->get('itemIds');
        $data = array(
            'status' => 1
        );
        gc_product_price::whereIn('price_id', $ids)->update($data);
    }
    public function enable_tagging_uom(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
            ->where('gc_product_prices.status', '=', 0)
            ->select('*')
            ->orderBy('price_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_prices.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_prices.UOM', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
    public function price_count_changed()
    {

        $query =  DB::table('gc_product_items')
            ->join('gc_product_price_histories', 'gc_product_items.itemcode', '=', 'gc_product_price_histories.itemcode')
            ->whereDate('gc_product_price_histories.update_at', Carbon::today()->toDateString())
            ->select('*')
            ->whereIn('gc_product_items.itemcode', function ($query) {
                $query->select('gc_product_price_histories.itemcode')->from('gc_product_price_histories');
            })
            ->count();
        return $query;
    }

    public function price_count_changed_info(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_price_histories', 'gc_product_items.itemcode', '=', 'gc_product_price_histories.itemcode')
            ->whereDate('gc_product_price_histories.update_at', Carbon::today()->toDateString())
            ->select('*')
            ->whereIn('gc_product_items.itemcode', function ($query) {
                $query->select('gc_product_price_histories.itemcode')->from('gc_product_price_histories');
            })
            ->orderBy('product_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_items.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

    public function store_available_item(Request $request)
    {
        $store = $request->get('store_id');
        return gc_product_item::with(['item_price'])
            ->where('status', 'active')
            ->whereNotIn('gc_product_items.itemcode', function ($query) use ($store) {
                $query->select('gc_item_log_availables.itemcode')
                    ->from('gc_item_log_availables')
                    ->where('gc_item_log_availables.store', '=', $store);
            })->paginate();
    }

    public function count_per_category()
    {
        $data = DB::table('gc_product_items')
            ->select('category_name', DB::raw('COUNT(category_no) as count'))
            ->orderBy('count', 'desc')
            ->groupBy('category_name')
            ->get();
        return $data;
    }
    public function disabled_selected_item(Request $request)
    {
        $itemcode = $request->get('itemIds');
        // dd($itemcode);
        $count = 0;
        foreach ($itemcode as $key => $code) {
            $checking =  gc_item_log_available::where('itemcode', $code)->where('store', Auth::user()->bunit_code)->exists();

            if ($checking) {
                $count++;
            } else {
                $data = array(
                    'itemcode'       => $code,
                    'store'          => Auth::user()->bunit_code,
                    'tag_by'         => Auth::user()->name,
                );
                gc_item_log_available::insert($data);
            }
        }
        // return $count;
    }

    public function enabled_selected_item(Request $request)
    {
        $itemcode = $request->get('itemIds');
        foreach ($itemcode as $key => $code) { 
            gc_item_log_available::where('itemcode', $code)->where('store',Auth::user()->bunit_code)->delete();            
        }
    }
}
