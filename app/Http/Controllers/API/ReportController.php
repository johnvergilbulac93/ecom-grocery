<?php

namespace App\Http\Controllers\API;

use App\Ticket;
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

        if ($filter === 'all') {
            $filename = 'item_masterfile.xlsx';
            Excel::store(new ItemsExport($filter),  $filename);

            $file = Storage::get($filename);
            if ($file) {
                $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }
            return response()->json([
                'success' => true,
                'data' => $fileLink,
            ], 200);
        }

        if ($filter === 'available') {

            $filename = 'available_items.xlsx';
            Excel::store(new ItemsExport($filter),  $filename);

            $file = Storage::get($filename);
            if ($file) {
                $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }

            return response()->json([
                'success' => true,
                'data' => $fileLink,
            ], 200);
        }

        if ($filter === 'unavailable') {

            $filename = 'unavailable_items.xlsx';
            Excel::store(new ItemsExport($filter),  $filename);
            $file = Storage::get($filename);
            if ($file) {
                $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }

            return response()->json([
                'success' => true,
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

        if ($filter === 'all') {
            $filename = 'item_masterfile.xlsx';
            Excel::store(new ItemsExportStore($filter, $store),  $filename);

            $file = Storage::get($filename);
            if ($file) {
                $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }
            return response()->json([
                'success' => true,
                'data' => $fileLink,
            ], 200);
        }

        if ($filter === 'available') {

            $filename = 'available_items.xlsx';
            Excel::store(new ItemsExportStore($filter, $store),  $filename);

            $file = Storage::get($filename);
            if ($file) {
                $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }
            return response()->json([
                'success' => true,
                'data' => $fileLink,
            ], 200);
        }

        if ($filter === 'unavailable') {
            $filename = 'unavailable_items.xlsx';
            Excel::store(new ItemsExportStore($filter, $store), $filename);
            $file = Storage::get($filename);
            if ($file) {
                $fileLink = 'data:application/vnd.ms-excel;base64,' . base64_encode($file);
            }
            return response()->json([
                'success' => true,
                'data' => $fileLink,
            ], 200);
        }
    }

    public function getLiquidation(Request $request)
    {

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
            ->whereBetween('gc_order_statuses.order_pickup', [$dateFrom, $dateTo])
            ->orderBy('gc_order_statuses.order_pickup')
            ->get()
            ->groupBy('bunit_code');

        $result['b_unit'] = $getBU;
        $result['cashier_details'] = $cashier;
        return $result;
    }

    public function getAccountability(Request $request)
    {
        $buId = $request->get('store');
        $dateFrom = Carbon::parse($request->get('dateFrom'))->toDateString();
        // $dateTo = Carbon::parse($request->get('dateTo'))->toDateString();
        $dateTo = Carbon::parse($request->get('dateTo'))->toDateTimeString();
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        $data = Ticket::with(['finalOrders', 'finalOrderStatus', 'discountAmount', 'customerBill', 'CashierMonitoring'])
            ->selectRaw('CONCAT(customer_delivery_infos.firstname ," " ,customer_delivery_infos.lastname) AS customer,
            emp_no,
            name as picker_name,
            tickets.*,
            receipt,
            gc_transactions.status
            ')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', '=', 'tickets.id')
            ->JOIN('barangays', 'barangays.brgy_id', '=', 'customer_delivery_infos.barangay_id')
            ->JOIN('towns', 'towns.town_id', '=', 'barangays.town_id')
            ->JOIN('province', 'province.prov_id', '=', 'towns.prov_id')
            ->JOIN('gc_picker_taggings', 'gc_picker_taggings.ticket_id', '=', 'tickets.id')
            ->JOIN('gc_pickers', 'gc_pickers.id', '=', 'gc_picker_taggings.picker_id')
            ->JOIN('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'tickets.id')
            ->JOIN('gc_transactions', 'gc_transactions.ticket_id', '=', 'ticket')
            ->where('gc_order_statuses.paid_status', true)
            ->where('gc_order_statuses.bu_id', '=', $buId)
            // ->whereDate('gc_order_statuses.order_pickup', $date)
            ->whereBetween('gc_order_statuses.order_pickup', [$dateFrom, $dateTo])
            ->orderBy('gc_order_statuses.order_pickup')
            ->get();

        // $result['cashier_details'] = auth()->user();
        $result['b_unit'] = $getBU;
        $result['data'] = $data;
        return $result;
    }
}
