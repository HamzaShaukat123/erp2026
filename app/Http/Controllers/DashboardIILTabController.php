<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pur2_company_wise_item_group_wise;
use App\Models\dash_tsale_by_item_group_customer;
use App\Models\dash_chart_for_item_group;
use Illuminate\Support\Facades\DB;

class DashboardIILTabController extends Controller
{
    public function IIL(Request $request)
    {
        $month = $request->month;

        $dash_chart_for_item_group_for_donut = dash_chart_for_item_group::where('dat2',$request->month)
        ->where('ac_group_cod',5)
        ->get();

        $dash_chart_for_item_group = dash_chart_for_item_group::where('ac_group_cod',5)->get();

        $item_group_name = dash_chart_for_item_group::where('ac_group_cod', 5)
        ->select('item_group_name')
        ->distinct()
        ->get();

        $crc = pur2_company_wise_item_group_wise::where('dat', $month)
            ->where('item_group_cod', 1)
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']); // Only select the necessary fields

        $hrs = pur2_company_wise_item_group_wise::where('dat', $month)
            ->where('item_group_cod', 2)
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']);

        $eco = pur2_company_wise_item_group_wise::where('dat', $month)
            ->where('item_group_cod', 5)
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']);

        $cosmo = pur2_company_wise_item_group_wise::where('dat', $month)
            ->where('item_group_cod', 6)
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']);


       $crc_sale = dash_tsale_by_item_group_customer::where('dat', $month)
            ->whereIn('item_group_code', [1])
            ->select('ac_name as company_name', DB::raw('SUM(weight) as ttl_weight'))
            ->groupBy('ac_name')
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']);
            
        $hrs_sale = dash_tsale_by_item_group_customer::where('dat', $month)
            ->whereIn('item_group_code', [2]) // Filter for item group codes
            ->select('ac_name as company_name', DB::raw('SUM(weight) as ttl_weight'))
            ->groupBy('ac_name')
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']);   

        $eco_sale = dash_tsale_by_item_group_customer::where('dat', $month)
            ->whereIn('item_group_code', [5]) // Filter for item group codes
            ->select('ac_name as company_name', DB::raw('SUM(weight) as ttl_weight'))
            ->groupBy('ac_name')
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']);

        $cosmo_sale = dash_tsale_by_item_group_customer::where('dat', $month)
            ->whereIn('item_group_code', [6]) // Filter for item group codes
            ->select('ac_name as company_name', DB::raw('SUM(weight) as ttl_weight'))
            ->groupBy('ac_name')
            ->orderBy('ttl_weight', 'desc')
            ->get(['company_name', 'ttl_weight']);
            
            

        return response()->json([
            'dash_chart_for_item_group_for_donut' => $dash_chart_for_item_group_for_donut,
            'dash_chart_for_item_group' => $dash_chart_for_item_group,
            'CRC' => $crc,
            'HRS' => $hrs,
            'ECO' => $eco,
            'COSMO' => $cosmo,
            'item_group_name' => $item_group_name,
            'CRC_SALE' => $crc_sale,
            'HRS_SALE' => $hrs_sale,
            'ECO_SALE' => $eco_sale,
            'COSMO_SALE' => $cosmo_sale
        ]);
    }
}