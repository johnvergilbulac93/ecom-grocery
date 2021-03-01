<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Exports\ItemsExport;
use App\GcCashierMonitoring;
use Illuminate\Http\Request;
use App\Exports\ItemsExportStore;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'by'      => 'required',
        ]);
        
        $filter = $request->input('by');

        if($filter === 'all')
        {
            $filename = 'item_masterfile.xlsx'; 
            Excel::store(new ItemsExport($filter),  $filename);

            $file = Storage::get($filename);
            if ($file) {
            $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }
            return response()->json([
                'success'=> true,
                'data' => $fileLink,
            ], 200);
        }
        
        if($filter === 'available')
        {

            $filename = 'available_items.xlsx'; 
            Excel::store(new ItemsExport($filter),  $filename);

            $file = Storage::get($filename);
            if ($file) {
            $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }

            return response()->json([
                'success'=> true,
                'data' => $fileLink,
            ], 200);
        }
        
        if($filter === 'unavailable')
        {

            $filename = 'unavailable_items.xlsx'; 
            Excel::store(new ItemsExport($filter),  $filename);
            $file = Storage::get($filename);
            if ($file) {
            $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);

            }

            return response()->json([
                'success'=> true,
                'data' => $fileLink,
            ], 200);

        }

    }

    public function store_item(Request $request)
    {
        $this->validate($request, [
            'by'      => 'required',    
            'store'   => 'required'
        ]);

        $filter = $request->get('by');
        $store = $request->get('store');
        
        if($filter === 'all')
        {
            $filename = 'item_masterfile.xlsx'; 
            Excel::store(new ItemsExportStore($filter,$store),  $filename);

            $file = Storage::get($filename);
            if ($file) {
            $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }
            return response()->json([
                'success'=> true,
                'data' => $fileLink,
            ], 200);
        }
        if($filter === 'available')
        {

            $filename = 'available_items.xlsx'; 
            Excel::store(new ItemsExportStore($filter,$store),  $filename);

            $file = Storage::get($filename);
            if ($file) {
            $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);

            }

            return response()->json([
                'success'=> true,
                'data' => $fileLink,
            ], 200);
        }

        if($filter === 'unavailable')
        {

            $filename = 'unavailable_items.xlsx'; 
            Excel::store(new ItemsExportStore($filter,$store),  $filename);
            $file = Storage::get($filename);
            if ($file) {
            $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }
            return response()->json([
                'success'=> true,
                'data' => $fileLink,
            ], 200);

        }
        
    }

    public function getLiquidation(Request $request)
    {
        // $this->validate($request, [
        //     'store'         => 'required',
        //     'dateFrom'      => 'required',    
        //     'dateTo'   => 'required'
        // ]);

        $buId = $request->get('store');
        $dateFrom = Carbon::parse($request->get('dateFrom'))->toDateString();
        // $dateTo = Carbon::parse($request->get('dateTo'))->toDateString();
        $dateTo = Carbon::parse($request->get('dateTo'))->toDateTimeString();
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        $cashier = GcCashierMonitoring::with(['finalOrderStatus', 'finalOrders', 'discountAmount', 'customerBill', 'tickets'])
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_cashier_monitoring.bu_id')
            ->join('gc_users', 'gc_users.id', '=', 'gc_cashier_monitoring.cashier_id')
            ->join('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'gc_cashier_monitoring.ticket_id')
            ->where('gc_order_statuses.paid_status', true)
            ->where('gc_order_statuses.bu_id', '=', $buId)
            ->whereBetween('gc_order_statuses.order_pickup', [ $dateFrom, $dateTo])
            ->orderBy('gc_order_statuses.order_pickup')
            ->get()
            ->groupBy('bunit_code');

            $result['b_unit'] = $getBU;
            $result['cashier_details'] = $cashier;
            // $result['data'] = $data;
            return $result;

    }


}
