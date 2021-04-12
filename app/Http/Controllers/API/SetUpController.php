<?php

namespace App\Http\Controllers\API;

use App\gc_picker;
use App\Bu_time_setup;
use Illuminate\Http\Request;
use App\gc_setup_business_rule;
use Illuminate\Support\Facades\DB;
use App\gc_customer_pickup_cuttoff;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\gc_allowed_maximum_time_picker;
use App\gc_delivery_charge;
use App\gc_department;
use App\gc_minimum_order_delivery;
use App\gc_tenant;

class SetUpController extends Controller
{

    public function min_order_amount(Request $request)
    {

        $this->validate($request, [
            'min_amount'            => 'required|numeric'
        ]);

        $min_amount_data = array(
            'minimum_order_amount' => $request->get('min_amount')
        );

        gc_setup_business_rule::whereId($request->id)->update($min_amount_data);
    }

    public function pickup_charge(Request $request)
    {

        $this->validate($request, [
            'pickup_charge'      => 'required|numeric'
        ]);

        $pickup_charge_data = array(
            'pickup_charge'         => $request->get('pickup_charge')
        );

        gc_setup_business_rule::whereId($request->id)->update($pickup_charge_data);
    }

    public function order_time_cutoff(Request $request)
    {

        $this->validate($request, [
            'order_time_cutoff_start'     => 'required',
            'order_time_cutoff_end'      => 'required|after:order_time_cutoff_start',
        ]);

        $ordering_cutoff_time_data = array(
            'ordering_cutoff_time_start'  => $request->get('order_time_cutoff_start'),
            'ordering_cutoff_time_end'  => $request->get('order_time_cutoff_end')

        );

        gc_setup_business_rule::whereId($request->id)->update($ordering_cutoff_time_data);
    }
    public function max_order(Request $request)
    {
        $this->validate($request, [
            'max_no_order' => 'required',
        ]);

        $max_order_data = array(
            'maximum_no_of_orders'    => $request->get('max_no_order'),

        );

        gc_setup_business_rule::whereId($request->id)->update($max_order_data);
    }

    public function serving_time(Request $request)
    {

        $this->validate($request, [
            'time_start_cutoff' => 'required|date_format:h:i:s',
            'time_end_cutoff' => 'required|after:time_start_cutoff',

        ]);

        $serving_time_data = array(

            'serving_time_start'    => $request->get('time_start_cutoff'),
            'serving_time_end'      => $request->get('time_end_cutoff')

        );
        gc_setup_business_rule::whereId($request->id)->update($serving_time_data);
    }
    public function customer_pickup_time(Request $request)
    {

        $customer_pickup_time_data = array(

            'cutoff_pickup_time_customer' => $request->get('customer_pickup_time'),

        );

        gc_setup_business_rule::whereId($request->id)->update($customer_pickup_time_data);
    }

    public function setup_rules()
    {

        return gc_setup_business_rule::all();
    }

    public function pickers()
    {

        return gc_picker::all();
    }
    public function pickercreate(Request $request)
    {

        $this->validate($request, [
            'picker'        => 'required|unique:gc_allowed_maximum_time_pickers,picker',
            'time_start'    => 'required|date_format:h:i',
            'time_end'      => 'required|after:time_start',

        ]);

        $picker_time_data = array(

            'picker'        => $request->get('picker'),
            'time_start'    => $request->get('time_start'),
            'time_end'      => $request->get('time_end'),
            'setup_by'      => auth()->user()->name,

        );

        gc_allowed_maximum_time_picker::create($picker_time_data);
    }

    public function getpicker()
    {

        return gc_allowed_maximum_time_picker::paginate(1);
    }

    public function pickeredit(Request $request, $id)
    {

        $picker = gc_allowed_maximum_time_picker::findOrFail($id);

        $this->validate($request, [
            'picker'        => 'required|unique:gc_allowed_maximum_time_pickers,picker,' . $picker->id,
            'time_start'    => 'required',
            'time_end'      => 'required|after:time_start',
        ]);

        $picker_time_data = array(
            'picker'        => $request->get('picker'),
            'time_start'    => $request->get('time_start'),
            'time_end'      => $request->get('time_end'),
        );
        $picker->update($picker_time_data);
    }

    public function deletepicker($id)
    {
        $picker = gc_allowed_maximum_time_picker::findOrFail($id);
        $picker->delete();
    }

    public function gettimepickup()
    {

        return gc_customer_pickup_cuttoff::where('bunit_code', '=', Auth::user()->bunit_code)->get();
    }
    public function pickuptime_edit(Request $request, $id)
    {

        $pickuptimeid = gc_customer_pickup_cuttoff::findOrFail($id);

        $this->validate($request, [
            'customer_pickup_time_start'    => 'required',
            'customer_pickup_time_end'      => 'required|after:customer_pickup_time_start',
        ]);

        $pickup_time_data = array(
            'start'    => $request->get('customer_pickup_time_start'),
            'end'      => $request->get('customer_pickup_time_end'),
        );

        $pickuptimeid->update($pickup_time_data);
    }
    public function business_time()
    {
        $query =  DB::table('bu_time_setups')
            ->join('locate_business_units', 'bu_time_setups.bunit_code', '=', 'locate_business_units.bunit_code')
            ->select('*')
            ->get();

        return $query;
    }
    public function add_business_time(Request $request)
    {
        $this->validate($request, [
            'store'        => 'required|unique:bu_time_setups,bunit_code',
            'opening_time'    => 'required|date_format:h:i',
            'closing_time'      => 'required|after:opening_time',
        ]);

        $data = array(
            'bunit_code'    => $request->get('store'),
            'time_in'    => $request->get('opening_time'),
            'time_out'    => $request->get('closing_time'),
        );
        Bu_time_setup::create($data);
    }
    public function edit_business_time(Request $request, $id)
    {
        $this->validate($request, [
            'store'        => 'required',
            'opening_time'    => 'required',
            'closing_time'      => 'required|after:opening_time',
        ]);

        $data = array(
            'bunit_code'    => $request->get('store'),
            'time_in'    => $request->get('opening_time'),
            'time_out'    => $request->get('closing_time'),
        );
        Bu_time_setup::findOrFail($id)->update($data);
    }

    public function add_tenant(Request $request)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'    => 'required',
            'status'      => 'required',
        ]);
        $checking_data =  gc_tenant::where('bunit_code', $request->get('store'))
            ->where('dept_id', $request->get('department'))
            ->exists();
        if (!$checking_data) {
            $data = array(
                'bunit_code'    => $request->get('store'),
                'dept_id'    => $request->get('department'),
                'status'    => $request->get('status'),
            );

            gc_tenant::create($data);

            return response()->json([
                'error' => false,
            ], 200);
        } else {
            return response()->json([
                'error' => true,
            ], 200);
        }
    }

    public function tenants()
    {
        $query =  DB::table('gc_tenants')
            ->join('locate_business_units', 'gc_tenants.bunit_code', '=', 'locate_business_units.bunit_code')
            ->join('gc_departments', 'gc_tenants.dept_id', '=', 'gc_departments.dept_id')
            ->select('locate_business_units.business_unit', 'gc_departments.name', 'gc_tenants.tenant_id', 'gc_tenants.status', 'gc_tenants.bunit_code', 'gc_tenants.dept_id')
            ->paginate();
        return $query;
    }

    public function edit_tenant(Request $request, $id)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'       => 'required',
            'status'       => 'required',
        ]);

        $data = array(
            'bunit_code'    => $request->get('store'),
            'dept_id'    => $request->get('department'),
            'status'    => $request->get('status'),
        );
        gc_tenant::where('tenant_id', '=', $id)->update($data);
    }
    public function delete_tenant($id)
    {
        $tenant = gc_tenant::where('tenant_id', '=', $id);
        $tenant->delete();
    }

    public function departments()
    {
        return gc_department::all();
    }
    public function create_minimum(Request $request)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'    => 'required',
            'amount'      => 'required',
        ]);

        $data = array(
            'bunit_code'    => $request->get('store'),
            'department_id' => $request->get('department'),
            'amount'        => floatval($request->get('amount'))
        );

        gc_minimum_order_delivery::create($data);
    }
    public function amounts()
    {
        $query =  DB::table('gc_minimum_order_deliveries')
            ->join('locate_business_units', 'gc_minimum_order_deliveries.bunit_code', '=', 'locate_business_units.bunit_code')
            ->join('gc_departments', 'gc_minimum_order_deliveries.department_id', '=', 'gc_departments.dept_id')
            ->select('*')
            ->paginate();

        return $query;
    }
    public function edit_minimum(Request $request, $id)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'    => 'required',
            'amount'      => 'required',
        ]);

        $data = array(
            'bunit_code'    => $request->get('store'),
            'department_id' => $request->get('department'),
            'amount'        => floatval($request->get('amount'))
        );
        gc_minimum_order_delivery::where('min_id', $id)->update($data);
    }
    public function delete_minimum($id)
    {
        $data = gc_minimum_order_delivery::where('min_id', '=', $id);
        $data->delete();
    }
    public function province()
    {
        return  DB::table('province')->get();
    }
    public function town(Request $request)
    {
        $province =   $request->get('province');
        return  DB::table('towns')->where('prov_id', $province)->get();
    }
    public function barangay(Request $request)
    {
        $town =   $request->get('town');
        return  DB::table('barangays')->where('town_id', $town)->get();
    }
    public function transportation()
    {
        return  DB::table('gc_transportations')->get();
    }
    public function filter_town()
    {
        return  DB::table('towns')->where('prov_id', 1)->get();
    }
    public function show_town()
    {
        return  DB::table('towns')->get();
    }
    public function show_brgy()
    {
        return  DB::table('barangays')->get();
    }
    public function view_by_id_charges($id)
    {
        return gc_delivery_charge::where('chrg_id', $id)->first();
    }
    public function update_charge(Request $request)
    {

        $chrg_id = $request->get('id');
        $this->validate($request, [
            'province'        => 'required',
            'town'    => 'required',
            // 'barangay'      => 'required',create_charge
            'transportation'      => 'required',
            'charge_amount'      => 'required',
            'rider_shared'      => 'required',
        ]);
        $data_charge = array(
            'prov_id'       => $request->get('province'),
            'town_id'       => $request->get('town'),
            'brgy_id'       => $request->get('barangay'),
            'transpo_id'    => $request->get('transportation'),
            'charge_amt'    => floatval($request->get('charge_amount')),
            'rider_shared'    => floatval($request->get('rider_shared'))
        );
        gc_delivery_charge::where('chrg_id', $chrg_id)->update($data_charge);
    }
    public function show_charge(Request $request)
    {
        $columns = ['chrg_id', 'prov_id', 'town_id', 'brgy_id', 'transpo_id', 'chrg_id', 'chrg_id'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $town = $request->input('town');
        $province = $request->input('province');
        $transpo = $request->input('transpo');

        $query = gc_delivery_charge::with(['brgy'])
            ->join('province', 'gc_delivery_charges.prov_id', '=', 'province.prov_id')
            ->join('towns', 'gc_delivery_charges.town_id', '=', 'towns.town_id')
            ->join('gc_transportations', 'gc_delivery_charges.transpo_id', '=', 'gc_transportations.id')
            ->select('*')
            ->orderBy('gc_delivery_charges.chrg_id', $dir);
            
        if ($town || $province || $transpo) {
            $query->where(function ($query) use ($town, $transpo, $province) {
                $query->where('towns.town_id', $town)
                    ->orWhere('transpo_id', $transpo)
                    ->orWhere('province.prov_id', $province);
            });
        }
        $projects = $query->paginate($length);

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
    public function create_charge(Request $request)
    {
        $this->validate($request, [
            'province'        => 'required',
            'town'    => 'required',
            // 'barangay'      => 'required',create_charge
            'transportation'      => 'required',
            'charge'      => 'required',
            'share'      => 'required',
        ]);

        if ($request->get('barangay')) {

            $checking_data =  gc_delivery_charge::where('town_id', $request->get('town'))
                ->where('brgy_id', $request->get('barangay'))
                ->where('transpo_id', $request->get('transportation'))
                ->exists();
        } else {
            $checking_data =  gc_delivery_charge::where('town_id', $request->get('town'))
                ->where('transpo_id', $request->get('transportation'))
                ->exists();
        }

        if (!$checking_data) {
            $data_charge = array(
                'prov_id'       => $request->get('province'),
                'town_id'       => $request->get('town'),
                'brgy_id'       => $request->get('barangay'),
                'transpo_id'    => $request->get('transportation'),
                'charge_amt'    => $request->get('charge'),
                'rider_shared'    => $request->get('share'),
            );
            gc_delivery_charge::create($data_charge);

            return response()->json([
                'error' => false,
            ], 200);
        } else {
            return response()->json([
                'error' => true,
            ], 200);
        }
    }
    public function delete_charges($id)
    {
        $charge = gc_delivery_charge::where('chrg_id', '=', $id);
        $charge->delete();
    }
}
